<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Admin\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController
{
    public function __construct(private AdminService $adminService) {}

    public function exportUsersCsv(Request $request): StreamedResponse
    {
        $this->authorizeAdmin();
        $users = $this->adminService->listUsers($request);
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users.csv"',
        ];
        $callback = function () use ($users) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Role', 'Active']);
            foreach ($users as $user) {
                fputcsv($handle, [$user->id, $user->name, $user->email, $user->role, $user->active ? 'Yes' : 'No']);
            }
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }

    private function authorizeAdmin()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Forbidden');
        }
    }
}
