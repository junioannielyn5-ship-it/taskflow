<?php

namespace App\Modules\Workflow\Http\Controllers;

use App\Modules\Workflow\Models\Meeting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController
{
    public function index()
    {
        $meetings = Meeting::query()
            ->with('creator')
            ->orderBy('meeting_date')
            ->orderBy('start_time')
            ->get();

        return view('meetings.index', compact('meetings'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'meeting_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        Meeting::query()->create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);

        return back()->with('success', 'Meeting added.');
    }

    public function destroy(Meeting $meeting): RedirectResponse
    {
        $this->authorizeManager();

        $meeting->delete();

        return back()->with('success', 'Meeting deleted.');
    }

    public function update(Request $request, Meeting $meeting): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'meeting_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        $meeting->update($validated);

        return back()->with('success', 'Meeting updated.');
    }

    private function authorizeManager(): void
    {
        $user = Auth::user();

        if (!$user || !in_array((string) data_get($user, 'role', ''), ['manager', 'admin'], true)) {
            abort(403, 'Forbidden');
        }
    }
}
