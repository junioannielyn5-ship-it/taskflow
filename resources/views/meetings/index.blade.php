@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full bg-cyan-200/35 blur-3xl"></div>
        <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Meetings</h1>
            <p class="text-sm text-slate-500">Centralized meeting schedule for project coordination and decision tracking.</p>
        </div>
        <a href="{{ route('tasks.calendar') }}" class="rounded-full border border-cyan-300 bg-cyan-50 px-4 py-2 text-sm font-semibold text-cyan-700 hover:bg-cyan-100">Open Calendar</a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(auth()->user() && in_array((string) data_get(auth()->user(), 'role', ''), ['manager', 'admin'], true))
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="mb-3 text-lg font-semibold text-slate-800">Add Meeting</h2>
            <form method="POST" action="{{ route('meetings.store') }}" class="grid grid-cols-1 gap-3 md:grid-cols-3">
                @csrf
                <input type="text" name="title" required placeholder="Meeting title" class="rounded border border-slate-300 px-3 py-2 text-sm">
                <input type="date" name="meeting_date" required class="rounded border border-slate-300 px-3 py-2 text-sm">
                <input type="text" name="location" placeholder="Location / Platform" class="rounded border border-slate-300 px-3 py-2 text-sm">
                <input type="time" name="start_time" class="rounded border border-slate-300 px-3 py-2 text-sm">
                <input type="time" name="end_time" class="rounded border border-slate-300 px-3 py-2 text-sm">
                <button type="submit" class="rounded-lg bg-cyan-600 px-4 py-2 text-sm font-medium text-white hover:bg-cyan-700">Save Meeting</button>
                <textarea name="description" rows="2" placeholder="Description / Agenda" class="md:col-span-3 rounded border border-slate-300 px-3 py-2 text-sm"></textarea>
            </form>
        </div>
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">
                <tr>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Time</th>
                    <th class="px-4 py-3">Location</th>
                    <th class="px-4 py-3">Created By</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($meetings as $meeting)
                    <tr>
                        <td class="px-4 py-3">{{ $meeting->meeting_date?->format('M d, Y') }}</td>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $meeting->title }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $meeting->start_time ?: '-' }}{{ $meeting->end_time ? ' - '.$meeting->end_time : '' }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $meeting->location ?: '-' }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $meeting->creator?->name ?: '-' }}</td>
                        <td class="px-4 py-3 text-right">
                            @if(auth()->user() && in_array((string) data_get(auth()->user(), 'role', ''), ['manager', 'admin'], true))
                                <form method="POST" action="{{ route('meetings.destroy', $meeting) }}" class="inline" onsubmit="return confirm('Delete this meeting?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded border border-red-200 px-3 py-1 text-red-600 hover:bg-red-50">Delete</button>
                                </form>
                            @else
                                <span class="text-slate-300">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-slate-500">No meetings scheduled.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
