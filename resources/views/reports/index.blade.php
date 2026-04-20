@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="mv-card relative overflow-hidden p-6">
        <div class="pointer-events-none absolute -right-14 -top-16 h-48 w-48 rounded-full bg-indigo-200/35 blur-3xl"></div>
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <span class="mv-badge">Insights and Exports</span>
                <h1 class="mv-heading mt-2 text-2xl font-extrabold text-slate-900">Reports</h1>
                <p class="text-sm text-slate-600">Export compliance and performance views for leadership and operations.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="rounded-full border border-indigo-300 bg-indigo-50 px-4 py-2 text-sm font-semibold text-indigo-700 hover:bg-indigo-100">Open Dashboard</a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div class="mv-card p-5">
            <h2 class="mb-3 text-lg font-semibold text-slate-800">Overdue Report</h2>
            <p class="mb-4 text-sm text-slate-600">Export all overdue tasks visible to your role.</p>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('reports.export.overdue.csv') }}" class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800">Export CSV</a>
                <a href="{{ route('reports.export.overdue.pdf') }}" class="rounded border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Export PDF</a>
            </div>
        </div>

        <div class="mv-card p-5">
            <h2 class="mb-3 text-lg font-semibold text-slate-800">Completion Report</h2>
            <p class="mb-4 text-sm text-slate-600">Export completed tasks in the selected date range.</p>
            <div class="mb-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                <input id="completed-from" type="date" class="rounded border border-slate-300 px-3 py-2 text-sm" value="{{ now()->subMonth()->toDateString() }}">
                <input id="completed-to" type="date" class="rounded border border-slate-300 px-3 py-2 text-sm" value="{{ now()->toDateString() }}">
            </div>
            <div class="flex flex-wrap gap-2">
                <a id="completed-csv-link" href="{{ route('reports.export.completed.csv') }}" class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800">Export CSV</a>
                <a id="completed-pdf-link" href="{{ route('reports.export.completed.pdf') }}" class="rounded border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Export PDF</a>
            </div>
        </div>
    </div>

    <div class="mv-card p-5">
        <h2 class="mb-3 text-lg font-semibold text-slate-800">Overdue by Assignee</h2>
        <p class="mb-4 text-sm text-slate-600">Shows who currently owns the highest number of overdue tasks, including overdue tasks titled "Sample Task".</p>

        @if(collect($overdueByAssignee ?? [])->isEmpty())
            <p class="text-sm text-slate-500">No overdue tasks found for your current scope.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-slate-500">
                        <tr>
                            <th class="px-3 py-2 font-medium">Assignee</th>
                            <th class="px-3 py-2 font-medium">Overdue Tasks</th>
                            <th class="px-3 py-2 font-medium">Overdue "Sample Task"</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($overdueByAssignee as $row)
                            <tr>
                                <td class="px-3 py-2 font-medium text-slate-700">{{ $row->assignee_name }}</td>
                                <td class="px-3 py-2 text-slate-600">{{ $row->overdue_count }}</td>
                                <td class="px-3 py-2 text-slate-600">{{ $row->sample_task_overdue_count }}</td>
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
