@extends('layouts.app')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="relative overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm">
        <div class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full bg-cyan-200/35 blur-3xl dark:bg-cyan-500/10"></div>
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Meetings</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Centralized meeting schedule for project coordination and decision tracking.</p>
            </div>
            <a href="{{ route('tasks.calendar') }}" class="rounded-full border border-cyan-300 dark:border-cyan-500/50 bg-cyan-50 dark:bg-cyan-500/10 px-4 py-2 text-sm font-semibold text-cyan-700 dark:text-cyan-400 hover:bg-cyan-100 dark:hover:bg-cyan-500/20 transition">Open Calendar</a>
        </div>
    </div>

    @if (session('success'))
        <div class="rounded-xl border border-green-200 dark:border-green-500/40 bg-green-50 dark:bg-green-500/10 px-4 py-3 text-green-700 dark:text-green-400 font-medium">
            {{ session('success') }}
        </div>
    @endif

    {{-- Add Meeting Form --}}
    @if(auth()->user() && in_array((string) data_get(auth()->user(), 'role', ''), ['manager', 'admin'], true))
        <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm">
            <h2 class="mb-4 text-lg font-bold text-slate-800 dark:text-white">Add Meeting</h2>
            <form method="POST" action="{{ route('meetings.store') }}" class="grid grid-cols-1 gap-3 md:grid-cols-3">
                @csrf
                <input type="text" name="title" required placeholder="Meeting title"
                    class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <input type="date" name="meeting_date" required
                    class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <input type="text" name="location" placeholder="Location / Platform"
                    class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <input type="time" name="start_time"
                    class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <input type="time" name="end_time"
                    class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <button type="submit" class="rounded-lg bg-cyan-600 hover:bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow transition hover:scale-105">Save Meeting</button>
                <textarea name="description" rows="2" placeholder="Description / Agenda"
                    class="md:col-span-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400"></textarea>
            </form>
        </div>
    @endif

    {{-- Meetings Table --}}
    <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
            <thead class="bg-slate-100 dark:bg-slate-700/60 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                <tr>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Time</th>
                    <th class="px-4 py-3">Location</th>
                    <th class="px-4 py-3">Created By</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                @forelse($meetings as $idx => $meeting)
                    @php
                        $isPast = $meeting->meeting_date && $meeting->meeting_date->isPast();
                        $isToday = $meeting->meeting_date && $meeting->meeting_date->isToday();
                        $rowClass = $isToday
                            ? 'bg-cyan-50 dark:bg-cyan-500/10'
                            : ($idx === 0 ? 'bg-blue-50/40 dark:bg-blue-500/5' : 'hover:bg-slate-50 dark:hover:bg-slate-700/40');
                        $dateClass = $isToday
                            ? 'inline-flex rounded-full bg-cyan-500 text-white px-2 py-0.5 text-xs font-bold'
                            : ($isPast
                                ? 'inline-flex rounded-full bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 px-2 py-0.5 text-xs font-semibold'
                                : 'inline-flex rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 px-2 py-0.5 text-xs font-bold');
                    @endphp
                    <tr class="transition-colors {{ $rowClass }}">
                        <td class="px-4 py-3">
                            <span class="{{ $dateClass }}">{{ $meeting->meeting_date?->format('M d, Y') }}</span>
                            @if($isToday)<span class="ml-1 text-[10px] font-bold text-cyan-600 dark:text-cyan-400">TODAY</span>@endif
                        </td>
                        <td class="px-4 py-3 font-bold text-slate-800 dark:text-white">{{ $meeting->title }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-md bg-slate-100 dark:bg-slate-700 px-2 py-0.5 text-xs font-semibold text-slate-700 dark:text-slate-200">
                                {{ $meeting->start_time ?: '-' }}{{ $meeting->end_time ? ' - '.$meeting->end_time : '' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-medium text-slate-700 dark:text-slate-300">{{ $meeting->location ?: '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 rounded-full bg-purple-100 dark:bg-purple-500/20 px-2 py-0.5 text-xs font-semibold text-purple-700 dark:text-purple-300">
                                {{ $meeting->creator?->name ?: '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if(auth()->user() && in_array((string) data_get(auth()->user(), 'role', ''), ['manager', 'admin'], true))
                                <form method="POST" action="{{ route('meetings.destroy', $meeting) }}" class="inline" onsubmit="return confirm('Delete this meeting?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-red-300 dark:border-red-500/40 bg-red-50 dark:bg-red-500/10 px-3 py-1 text-xs font-bold text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-500/20 transition">Delete</button>
                                </form>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-slate-500 dark:text-slate-400">No meetings scheduled.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
