<?php

namespace App\Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Client\Exports\ClientExport;
use App\Modules\Client\Imports\ClientImport;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $perPage = max(1, min(100, (int) $request->integer('per_page', 15)));
        $clients = $query->latest()->paginate($perPage)->withQueryString();
        
        return view('client.index', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'status' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'pricing' => 'nullable|string|max:255',
            'items_inclusions' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'position_dept' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:255',
            'quotation' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        Client::create($validated);

        return redirect()->route('client.index')->with('success', 'Client created successfully.');
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'status' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'pricing' => 'nullable|string|max:255',
            'items_inclusions' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'position_dept' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:255',
            'quotation' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        $client->update($validated);

        return redirect()->route('client.index')->with('success', 'Client updated successfully.');
    }

    public function updateStatus(Request $request, Client $client)
    {
        $request->validate(['status' => 'nullable|string|max:255']);
        $client->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('client.index')->with('success', 'Client deleted successfully.');
    }

    public function export()
    {
        return Excel::download(new ClientExport, 'clients.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new ClientImport, $request->file('file'));
            return redirect()->route('client.index')->with('success', 'Clients imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('client.index')->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
