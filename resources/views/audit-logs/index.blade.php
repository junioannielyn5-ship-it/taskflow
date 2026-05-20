@extends('layouts.app')

@section('content')
<div class="relative space-y-6">
    <div class="pointer-events-none absolute right-0 top-0 h-64 w-64 translate-x-1/3 -translate-y-1/3 rounded-full bg-blue-100/40 blur-3xl dark:hidden"></div>
    <div class="pointer-events-none absolute bottom-0 left-20 h-52 w-52 rounded-full bg-slate-200/30 blur-3xl dark:hidden"></div>

    {{-- Page Header --}}
    <div class="relative inline-flex w-fit overflow-hidden rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-5 py-2.5 shadow-md" style="border-left: 4px solid #2563eb;">
        <p class="text-2xl font-bold uppercase tracking-wide text-slate-800 dark:text-slate-100 md:text-3xl">Audit Log</p>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('audit-logs.index') }}">
        <div class="relative flex flex-wrap items-end gap-4 rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-6 py-4 shadow-md">
            <div>
            <label for="search" class="mb-1 block text-sm font-medium text-slate-600 dark:text-slate-300">Search</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500"
                    placeholder="User, task no...">
            </div>
            <div>
            <label for="action" class="mb-1 block text-sm font-medium text-slate-600 dark:text-slate-300">Action</label>
            <select id="action" name="action" class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All actions</option>
                    <option value="Created" {{ request('action') === 'Created' ? 'selected' : '' }}>Created</option>
                    <option value="Updated" {{ request('action') === 'Updated' ? 'selected' : '' }}>Updated</option>
                    <option value="Deleted" {{ request('action') === 'Deleted' ? 'selected' : '' }}>Deleted</option>
                    <option value="Restored" {{ request('action') === 'Restored' ? 'selected' : '' }}>Restored</option>
                </select>
            </div>
            <div>
                 <label for="model_type" class="mb-1 block text-sm font-medium text-slate-600 dark:text-slate-300">Type</label>
                 <select id="model_type" name="model_type" class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All types</option>
                    <option value="task" {{ request('model_type') === 'task' ? 'selected' : '' }}>Task</option>
                    <option value="project" {{ request('model_type') === 'project' ? 'selected' : '' }}>Project</option>
                </select>
            </div>
            <div>
                 <label for="user_id" class="mb-1 block text-sm font-medium text-slate-600 dark:text-slate-300">User</label>
                 <select id="user_id" name="user_id" class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="rounded-lg bg-teal-600 hover:bg-teal-700 px-4 py-2 text-sm font-semibold text-white shadow-sm">Apply</button>
                <a href="{{ route('audit-logs.index') }}" class="rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-600">Clear</a>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
            <h3 class="text-lg font-extrabold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                <span class="p-2 bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-300 rounded-lg border border-blue-200 dark:border-blue-400/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                Audit Log
            </h3>
            <span class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ $auditLogs->total() }} total entries</span>
        </div>

        @if($auditLogs->isEmpty())
            <div class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">
                No audit log entries found.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <tr class="divide-x divide-slate-200 dark:divide-slate-700">
                            <th class="px-6 py-3 font-semibold">User</th>
                            <th class="px-6 py-3 font-semibold">Action</th>
                            <th class="px-6 py-3 font-semibold">Type</th>
                            <th class="px-6 py-3 font-semibold">Reference</th>
                            <th class="px-6 py-3 font-semibold">Details</th>
                            <th class="px-6 py-3 font-semibold">Date</th>
                            <th class="px-6 py-3 font-semibold">IP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach($auditLogs as $log)
                        <tr class="divide-x divide-slate-100 dark:divide-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-3 font-semibold text-slate-800 dark:text-slate-100 whitespace-nowrap">
                                {{ $log->user->name ?? 'System' }}
                            </td>
                            <td class="px-6 py-3">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-bold
                                    @if($log->action === 'Created') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400
                                    @elseif($log->action === 'Updated') bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400
                                    @elseif($log->action === 'Restored') bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400
                                    @else bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400
                                    @endif
                                ">{{ $log->action }}</span>
                            </td>
                            <td class="px-6 py-3 text-slate-600 dark:text-slate-300">
                                {{ class_basename($log->model_type) }}
                            </td>
                            <td class="px-6 py-3">
                                <span class="font-mono bg-slate-100 dark:bg-white/10 px-2 py-0.5 rounded text-blue-600 dark:text-[#93C5FD] text-xs border border-slate-200 dark:border-white/15">{{ $log->model_label ?? '#' . $log->model_id }}</span>
                            </td>
                            <td class="px-6 py-3 text-xs text-slate-600 dark:text-slate-300 max-w-xs">
                                @if($log->action === 'Updated' && !empty($log->new_values))
                                    @foreach($log->new_values as $field => $newVal)
                                        @php
                                            $oldVal = $log->old_values[$field] ?? '—';
                                            $fieldLabel = ucwords(str_replace('_', ' ', $field));
                                        @endphp
                                        <div class="mb-1">
                                            <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $fieldLabel }}</span>:
                                            <span class="text-amber-600 dark:text-amber-300">"{{ \Illuminate\Support\Str::limit($oldVal, 40) }}"</span>
                                            → <span class="text-emerald-600 dark:text-emerald-300">"{{ \Illuminate\Support\Str::limit($newVal, 40) }}"</span>
                                        </div>
                                    @endforeach
                                @elseif($log->action === 'Created' && !empty($log->new_values))
                                    @php
                                        $showFields = array_intersect_key($log->new_values, array_flip(['title', 'task_no', 'name', 'status', 'priority']));
                                    @endphp
                                    @foreach($showFields as $field => $val)
                                        <span class="inline-flex items-center rounded-full bg-emerald-100 dark:bg-emerald-500/20 border border-emerald-300 dark:border-emerald-400/35 px-2 py-0.5 text-[11px] font-medium text-emerald-700 dark:text-emerald-300 mr-1 mb-1">
                                            {{ ucwords(str_replace('_', ' ', $field)) }}: {{ \Illuminate\Support\Str::limit($val, 30) }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-slate-500">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-slate-500 dark:text-slate-400 whitespace-nowrap text-xs">
                                {{ $log->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-6 py-3 text-slate-400 dark:text-slate-500 whitespace-nowrap text-xs font-mono">
                                {{ $log->ip_address ?? '—' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($auditLogs->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                    {{ $auditLogs->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
