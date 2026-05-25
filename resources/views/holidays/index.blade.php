@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <div class="relative overflow-hidden rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/90">
        <div class="pointer-events-none absolute -left-12 -top-12 h-44 w-44 rounded-full bg-emerald-200/35 blur-3xl"></div>
        <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Calendar Holidays</h1>
            <p class="text-xs text-slate-550 dark:text-slate-400 mt-0.5">Manage non-working days reflected on the calendar.</p>
        </div>
        <a href="{{ route('tasks.calendar') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-300 dark:border-emerald-800/80 bg-emerald-50/50 dark:bg-emerald-950/40 px-3 py-1.5 text-xs font-bold text-emerald-750 dark:text-emerald-400 shadow-sm hover:bg-emerald-100/80 dark:hover:bg-emerald-900/50 transition-all duration-200 hover:-translate-y-0.5">Open Calendar</a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded bg-emerald-50 p-4 text-sm text-emerald-600 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/30">
            {{ session('success') }}
        </div>
    @endif

    @if(auth()->user() && in_array((string) data_get(auth()->user(), 'role', ''), ['manager', 'admin'], true))
        <div class="rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/90">
            <h2 class="mb-3 text-sm font-bold text-slate-900 dark:text-white">Add Holiday</h2>
            <form method="POST" action="{{ route('holidays.store') }}" class="grid grid-cols-1 gap-3 md:grid-cols-3">
                @csrf
                <input type="text" name="name" required placeholder="Holiday name" class="rounded-lg border border-slate-300 bg-slate-50/70 py-1.5 px-3 text-xs focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-900/50 dark:text-white placeholder:text-slate-400">
                <input type="date" name="holiday_date" required class="rounded-lg border border-slate-300 bg-slate-50/70 py-1.5 px-3 text-xs focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-900/50 dark:text-white">
                <label class="inline-flex items-center gap-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50/70 px-3 py-1.5 text-xs text-slate-700 dark:text-slate-300 cursor-pointer hover:bg-emerald-50/50 dark:hover:bg-emerald-950/20 transition-all duration-200">
                    <input type="checkbox" name="is_recurring" value="1" class="accent-emerald-600">
                    Recurring yearly
                </label>
                <textarea name="description" rows="2" placeholder="Description" class="md:col-span-3 rounded-lg border border-slate-300 bg-slate-50/70 py-1.5 px-3 text-xs focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-900/50 dark:text-white placeholder:text-slate-400"></textarea>
                <button type="submit" class="md:col-span-3 rounded-lg bg-emerald-650 py-1.5 px-3.5 text-xs font-bold text-white hover:bg-emerald-700 shadow-sm transition-all duration-200 hover:-translate-y-0.5">Save Holiday</button>
            </form>
        </div>
    @endif

    <div class="rounded-xl border border-amber-200/50 dark:border-amber-900/30 bg-amber-50/50 dark:bg-amber-950/20 p-4 text-center text-amber-800 dark:text-amber-400 text-xs font-semibold">
        Holidays are now visible in the Calendar. The table is no longer shown here.
        <br>
        <a href="{{ route('tasks.calendar') }}" class="mt-2.5 inline-flex items-center gap-1.5 rounded-lg border border-emerald-300 dark:border-emerald-800/80 bg-emerald-50/50 dark:bg-emerald-950/40 px-3 py-1.5 text-xs font-bold text-emerald-750 dark:text-emerald-400 shadow-sm hover:bg-emerald-100/80 dark:hover:bg-emerald-900/50 transition-all duration-200 hover:-translate-y-0.5">Open Calendar</a>
    </div>
</div>
@endsection
