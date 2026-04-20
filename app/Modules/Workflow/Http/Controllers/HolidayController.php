<?php

namespace App\Modules\Workflow\Http\Controllers;

use App\Modules\Workflow\Models\Holiday;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayController
{
    public function index()
    {
        $holidays = Holiday::query()
            ->with('creator')
            ->orderBy('holiday_date')
            ->get();

        return view('holidays.index', compact('holidays'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'holiday_date' => ['required', 'date'],
            'is_recurring' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        Holiday::query()->create([
            ...$validated,
            'is_recurring' => (bool) ($validated['is_recurring'] ?? false),
            'created_by' => Auth::id(),
        ]);

        return back()->with('success', 'Holiday added.');
    }

    public function destroy(Holiday $holiday): RedirectResponse
    {
        $this->authorizeManager();

        $holiday->delete();

        return back()->with('success', 'Holiday deleted.');
    }

    public function update(Request $request, Holiday $holiday): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'holiday_date' => ['required', 'date'],
            'is_recurring' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $holiday->update([
            ...$validated,
            'is_recurring' => (bool) ($validated['is_recurring'] ?? false),
        ]);

        return back()->with('success', 'Holiday updated.');
    }

    private function authorizeManager(): void
    {
        $user = Auth::user();

        if (!$user || !in_array((string) data_get($user, 'role', ''), ['manager', 'admin'], true)) {
            abort(403, 'Forbidden');
        }
    }
}
