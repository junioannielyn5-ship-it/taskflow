@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="mv-card rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm relative overflow-hidden p-6">
        <div class="pointer-events-none absolute -right-14 -top-16 h-48 w-48 rounded-full bg-indigo-200/35 dark:bg-indigo-900/20 blur-3xl"></div>
        <div class="flex flex-wrap items-center justify-between gap-3 relative z-10">
            <div>
                <span class="mv-badge rounded-full border border-indigo-200 dark:border-indigo-800 bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1 text-xs font-semibold text-indigo-700 dark:text-indigo-400">Insights and Exports</span>
                <h1 class="mv-heading mt-3 text-2xl font-extrabold text-slate-900 dark:text-white">Reports</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Export compliance and performance views for leadership and operations.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="rounded-full border border-indigo-300 dark:border-indigo-700 bg-indigo-50 dark:bg-indigo-900/30 px-4 py-2 text-sm font-semibold text-indigo-700 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/50">Open Dashboard</a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div class="mv-card rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-5">
            <h2 class="mb-3 text-lg font-semibold text-slate-800 dark:text-white">Overdue Report</h2>
            <p class="mb-4 text-sm text-slate-600 dark:text-slate-400">Export all overdue tasks visible to your role.</p>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('reports.export.overdue.csv') }}" class="rounded-lg bg-teal-600 dark:bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-700 dark:hover:bg-teal-600">Export CSV</a>
                <a href="{{ route('reports.export.overdue.pdf') }}" class="rounded border border-slate-300 dark:border-slate-600 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">Export PDF</a>
            </div>
        </div>

        <div class="mv-card rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-5">
            <h2 class="mb-3 text-lg font-semibold text-slate-800 dark:text-white">Completion Report</h2>
            <p class="mb-4 text-sm text-slate-600 dark:text-slate-400">Export completed tasks in the selected date range.</p>
            <div class="mb-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                <input id="completed-from" type="date" class="rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white px-3 py-2 text-sm" value="{{ now()->subMonth()->toDateString() }}">
                <input id="completed-to" type="date" class="rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white px-3 py-2 text-sm" value="{{ now()->toDateString() }}">
            </div>
            <div class="flex flex-wrap gap-2">
                <a id="completed-csv-link" href="{{ route('reports.export.completed.csv') }}" class="rounded-lg bg-teal-600 dark:bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-700 dark:hover:bg-teal-600">Export CSV</a>
                <a id="completed-pdf-link" href="{{ route('reports.export.completed.pdf') }}" class="rounded border border-slate-300 dark:border-slate-600 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">Export PDF</a>
            </div>
        </div>
    </div>

    <div class="mv-card rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm p-5">
        <h2 class="mb-3 text-lg font-semibold text-slate-800 dark:text-white">Overdue by Assignee</h2>
        <p class="mb-4 text-sm text-slate-600 dark:text-slate-400">Shows who currently owns the highest number of overdue tasks, including overdue tasks titled "Sample Task".</p>

        @if(collect($overdueByAssignee ?? [])->isEmpty())
            <p class="text-sm text-slate-500 dark:text-slate-400">No overdue tasks found for your current scope.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-3 py-3 font-medium">Assignee</th>
                            <th class="px-3 py-3 font-medium">Overdue Tasks</th>
                            <th class="px-3 py-3 font-medium">Overdue "Sample Task"</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach($overdueByAssignee as $row)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-3 py-3 font-medium text-slate-700 dark:text-slate-200">{{ $row->assignee_name }}</td>
                                <td class="px-3 py-3 text-slate-600 dark:text-slate-300">{{ $row->overdue_count }}</td>
                                <td class="px-3 py-3 text-slate-600 dark:text-slate-300">{{ $row->sample_task_overdue_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fromInput = document.getElementById('completed-from');
    const toInput = document.getElementById('completed-to');
    const csvLink = document.getElementById('completed-csv-link');
    const pdfLink = document.getElementById('completed-pdf-link');

    const syncLinks = () => {
        if (!fromInput || !toInput || !csvLink || !pdfLink) {
            return;
        }

        const params = new URLSearchParams({
            from: fromInput.value,
            to: toInput.value,
        });

        csvLink.href = `{{ route('reports.export.completed.csv') }}?${params.toString()}`;
        pdfLink.href = `{{ route('reports.export.completed.pdf') }}?${params.toString()}`;
    };

    fromInput?.addEventListener('change', syncLinks);
    toInput?.addEventListener('change', syncLinks);
    syncLinks();
});
</script>
@endsection
