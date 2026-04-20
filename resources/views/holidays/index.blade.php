@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="pointer-events-none absolute -left-12 -top-12 h-44 w-44 rounded-full bg-emerald-200/35 blur-3xl"></div>
        <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Calendar Holidays</h1>
            <p class="text-sm text-slate-500">Manage non-working days reflected on the calendar.</p>
        </div>
        <a href="{{ route('tasks.calendar') }}" class="rounded-full border border-emerald-300 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-100">Open Calendar</a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(auth()->user() && in_array((string) data_get(auth()->user(), 'role', ''), ['manager', 'admin'], true))
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="mb-3 text-lg font-semibold text-slate-800">Add Holiday</h2>
            <form method="POST" action="{{ route('holidays.store') }}" class="grid grid-cols-1 gap-3 md:grid-cols-3">
                @csrf
                <input type="text" name="name" required placeholder="Holiday name" class="rounded border border-slate-300 px-3 py-2 text-sm">
                <input type="date" name="holiday_date" required class="rounded border border-slate-300 px-3 py-2 text-sm">
                <label class="inline-flex items-center gap-2 rounded border border-slate-300 px-3 py-2 text-sm text-slate-700">
                    <input type="checkbox" name="is_recurring" value="1">
                    Recurring yearly
                </label>
                <textarea name="description" rows="2" placeholder="Description" class="md:col-span-3 rounded border border-slate-300 px-3 py-2 text-sm"></textarea>
                <button type="submit" class="md:col-span-3 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">Save Holiday</button>
            </form>
        </div>
    @endif

    <div class="rounded-xl border border-amber-200 bg-amber-50 p-6 text-center text-amber-700 text-sm font-semibold">
        Holidays are now visible in the Calendar. The table is no longer shown here.
        <a href="{{ route('tasks.calendar') }}" class="mt-4 inline-block rounded-full border border-emerald-300 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-100">Open Calendar</a>
    </div>
</div>
@endsection
