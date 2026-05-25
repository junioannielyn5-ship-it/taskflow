@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <div class="mv-card rounded-xl border border-slate-200/40 bg-white/90 shadow-sm relative overflow-hidden p-4 dark:border-slate-800 dark:bg-slate-900/90">
        <div class="pointer-events-none absolute -right-14 -top-16 h-48 w-48 rounded-full bg-indigo-200/35 dark:bg-indigo-900/20 blur-3xl"></div>
        <div class="flex flex-wrap items-center justify-between gap-3 relative z-10">
            <div>
                <span class="mv-badge rounded-full border border-indigo-200 dark:border-indigo-800/80 bg-indigo-50/50 dark:bg-indigo-950/40 px-2 py-0.5 text-[10px] font-bold text-indigo-750 dark:text-indigo-400">Insights and Exports</span>
                <h1 class="mv-heading mt-2 text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Reports</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Export compliance and performance views for leadership and operations.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-indigo-300 dark:border-indigo-800/80 bg-indigo-50/50 dark:bg-indigo-950/40 px-3 py-1.5 text-xs font-bold text-indigo-750 dark:text-indigo-400 shadow-sm hover:bg-indigo-100/80 dark:hover:bg-indigo-900/50 transition-all duration-200 hover:-translate-y-0.5">Open Dashboard</a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:gap-4 md:grid-cols-2">
        <div class="mv-card rounded-xl border border-slate-200/40 bg-white/90 shadow-sm p-4 dark:border-slate-800 dark:bg-slate-900/90">
            <h2 class="mb-2 text-sm font-bold text-slate-900 dark:text-white">Overdue Report</h2>
            <p class="mb-3 text-xs text-slate-500 dark:text-slate-400">Export all overdue tasks visible to your role.</p>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('reports.export.overdue.csv') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-teal-600 px-3.5 py-1.5 text-xs font-bold text-white shadow-sm hover:bg-teal-700 transition-all duration-200 hover:-translate-y-0.5">Export CSV</a>
                <a href="{{ route('reports.export.overdue.pdf') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 py-1.5 px-3 text-xs font-bold text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200 hover:-translate-y-0.5">Export PDF</a>
            </div>
        </div>

        <div class="mv-card rounded-xl border border-slate-200/40 bg-white/90 shadow-sm p-4 dark:border-slate-800 dark:bg-slate-900/90">
            <h2 class="mb-2 text-sm font-bold text-slate-900 dark:text-white">Completion Report</h2>
            <p class="mb-3 text-xs text-slate-500 dark:text-slate-400">Export completed tasks in the selected date range.</p>
            <div class="mb-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
                <input id="completed-from" type="date" class="rounded-lg border border-slate-300 bg-slate-50/70 py-1.5 px-3 text-xs focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-900/50 dark:text-white" value="{{ now()->subMonth()->toDateString() }}">
                <input id="completed-to" type="date" class="rounded-lg border border-slate-300 bg-slate-50/70 py-1.5 px-3 text-xs focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-900/50 dark:text-white" value="{{ now()->toDateString() }}">
            </div>
            <div class="flex flex-wrap gap-2">
                <a id="completed-csv-link" href="{{ route('reports.export.completed.csv') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-teal-600 px-3.5 py-1.5 text-xs font-bold text-white shadow-sm hover:bg-teal-700 transition-all duration-200 hover:-translate-y-0.5">Export CSV</a>
                <a id="completed-pdf-link" href="{{ route('reports.export.completed.pdf') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 py-1.5 px-3 text-xs font-bold text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200 hover:-translate-y-0.5">Export PDF</a>
            </div>
        </div>
    </div>

    <div class="mv-card rounded-xl border border-slate-200/40 bg-white/90 shadow-sm p-4 dark:border-slate-800 dark:bg-slate-900/90">
        <h2 class="mb-2 text-sm font-bold text-slate-900 dark:text-white">Overdue by Assignee</h2>
        <p class="mb-3 text-xs text-slate-500 dark:text-slate-400">Shows who currently owns the highest number of overdue tasks, including overdue tasks titled "Sample Task".</p>

        @if(collect($overdueByAssignee ?? [])->isEmpty())
            <p class="text-xs text-slate-500 dark:text-slate-400">No overdue tasks found for your current scope.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-200/40 bg-slate-50/70 text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-900/50 dark:text-slate-400">
                        <tr>
                            <th class="px-3 py-2">Assignee</th>
                            <th class="px-3 py-2">Overdue Tasks</th>
                            <th class="px-3 py-2">Overdue "Sample Task"</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @foreach($overdueByAssignee as $row)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-3 py-2.5 text-xs font-semibold text-slate-900 dark:text-white">{{ $row->assignee_name }}</td>
                                <td class="px-3 py-2.5 text-xs text-slate-600 dark:text-slate-300">{{ $row->overdue_count }}</td>
                                <td class="px-3 py-2.5 text-xs text-slate-600 dark:text-slate-300">{{ $row->sample_task_overdue_count }}</td>
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
