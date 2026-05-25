@extends('layouts.app')

@section('content')
<div class="relative space-y-4">
    <!-- Dynamic Background Effects -->
    <div class="pointer-events-none absolute right-0 top-0 h-[500px] w-[500px] -translate-y-1/3 translate-x-1/3 rounded-full bg-gradient-to-br from-blue-500/10 to-purple-500/10 blur-[80px] dark:from-blue-600/10 dark:to-purple-600/10"></div>

    {{-- Page Header --}}
    <div class="mb-4 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
        <div>
            <div class="mb-1 inline-flex items-center rounded-full border border-blue-200/50 bg-white/70 px-2.5 py-0.5 text-[10px] font-semibold tracking-wide text-blue-700 shadow-sm backdrop-blur-md dark:border-slate-800 dark:bg-slate-900/70 dark:text-blue-300">
                <span class="mr-1.5 flex h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                System Logs
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                Audit <span class="text-blue-600 dark:text-blue-400">Log</span>
            </h1>
            <p class="text-xs text-slate-550 dark:text-slate-400 mt-0.5">Track system actions, changes, and event logs.</p>
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('audit-logs.index') }}">
        <div class="relative overflow-hidden rounded-xl border border-slate-200/40 bg-white/80 p-3 sm:p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/90 flex flex-wrap items-end gap-3 mb-4">
            <div class="w-full sm:w-auto flex-grow max-w-xs">
                <label for="search" class="mb-1 block text-[10px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Search Keywords</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5">
                        <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        class="block w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white/70 dark:bg-slate-900/50 py-1.5 pl-8 pr-3 text-xs font-semibold text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-500 placeholder:text-slate-400"
                        placeholder="User, task no...">
                </div>
            </div>
            <div class="w-full sm:w-auto">
                <label for="action" class="mb-1 block text-[10px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Action</label>
                <select id="action" name="action" class="block w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white/70 dark:bg-slate-900/50 py-1.5 px-3 text-xs font-semibold text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">All actions</option>
                    <option value="Created" {{ request('action') === 'Created' ? 'selected' : '' }}>Created</option>
                    <option value="Updated" {{ request('action') === 'Updated' ? 'selected' : '' }}>Updated</option>
                    <option value="Deleted" {{ request('action') === 'Deleted' ? 'selected' : '' }}>Deleted</option>
                    <option value="Restored" {{ request('action') === 'Restored' ? 'selected' : '' }}>Restored</option>
                </select>
            </div>
            <div class="w-full sm:w-auto">
                 <label for="model_type" class="mb-1 block text-[10px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Type</label>
                 <select id="model_type" name="model_type" class="block w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white/70 dark:bg-slate-900/50 py-1.5 px-3 text-xs font-semibold text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">All types</option>
                    <option value="task" {{ request('model_type') === 'task' ? 'selected' : '' }}>Task</option>
                    <option value="project" {{ request('model_type') === 'project' ? 'selected' : '' }}>Project</option>
                </select>
            </div>
            <div class="w-full sm:w-auto">
                 <label for="user_id" class="mb-1 block text-[10px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">User</label>
                 <select id="user_id" name="user_id" class="block w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white/70 dark:bg-slate-900/50 py-1.5 px-3 text-xs font-semibold text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="">All users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                 </select>
            </div>
            <div class="flex items-center gap-2 ml-auto">
                <a href="{{ route('audit-logs.index') }}" class="inline-flex items-center justify-center rounded-lg px-3.5 py-1.5 text-xs font-bold text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800/50">Clear</a>
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-blue-600 hover:bg-blue-700 px-3.5 py-1.5 text-xs font-bold text-white shadow-sm transition-all duration-200 hover:-translate-y-0.5">Apply</button>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="rounded-xl border border-slate-200/40 bg-white/90 shadow-sm dark:border-slate-800 dark:bg-slate-900/90 overflow-hidden">
        <div class="px-4 py-3 border-b border-slate-200/40 dark:border-slate-800 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                Audit Trail
            </h3>
            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-350 border border-slate-200 dark:border-slate-700">{{ $auditLogs->total() }} total entries</span>
        </div>

        @if($auditLogs->isEmpty())
            <div class="flex flex-col items-center justify-center px-4 py-8 text-center">
                <div class="mb-3 rounded-full bg-slate-100/50 p-3 dark:bg-slate-800/30">
                    <svg class="h-8 w-8 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">No audit entries found</h3>
                <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">There is no log data matching your current filters.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-200/40 bg-slate-50/70 text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-900/50 dark:text-slate-400">
                        <tr>
                            <th class="px-3 py-2">User</th>
                            <th class="px-3 py-2">Action</th>
                            <th class="px-3 py-2">Type</th>
                            <th class="px-3 py-2">Reference</th>
                            <th class="px-3 py-2">Details</th>
                            <th class="px-3 py-2">Date</th>
                            <th class="px-3 py-2">IP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-850">
                        @foreach($auditLogs as $log)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-850/50 transition-colors">
                            <td class="px-3 py-2.5 font-bold text-slate-900 dark:text-white text-xs whitespace-nowrap">
                                {{ $log->user->name ?? 'System' }}
                            </td>
                            <td class="px-3 py-2.5 text-xs whitespace-nowrap">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-bold
                                    @if($log->action === 'Created') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400
                                    @elseif($log->action === 'Updated') bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400
                                    @elseif($log->action === 'Restored') bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400
                                    @else bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400
                                    @endif
                                ">{{ $log->action }}</span>
                            </td>
                            <td class="px-3 py-2.5 text-xs font-semibold text-slate-600 dark:text-slate-350 whitespace-nowrap">
                                {{ class_basename($log->model_type) }}
                            </td>
                            <td class="px-3 py-2.5 text-xs whitespace-nowrap">
                                <span class="font-mono bg-slate-100 dark:bg-white/10 px-1.5 py-0.5 rounded text-blue-600 dark:text-[#93C5FD] text-[10px] border border-slate-200/40 dark:border-white/15">{{ $log->model_label ?? '#' . $log->model_id }}</span>
                            </td>
                            <td class="px-3 py-2.5 text-[11px] text-slate-600 dark:text-slate-350 max-w-xs leading-relaxed">
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
                                        <span class="inline-flex items-center rounded-full bg-emerald-100 dark:bg-emerald-500/20 border border-emerald-300 dark:border-emerald-400/35 px-2 py-0.5 text-[10px] font-medium text-emerald-700 dark:text-emerald-350 mr-1 mb-1">
                                            {{ ucwords(str_replace('_', ' ', $field)) }}: {{ \Illuminate\Support\Str::limit($val, 30) }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-slate-500">—</span>
                                @endif
                            </td>
                            <td class="px-3 py-2.5 text-slate-500 dark:text-slate-400 whitespace-nowrap text-xs font-medium">
                                {{ $log->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-3 py-2.5 text-slate-400 dark:text-slate-500 whitespace-nowrap text-xs font-mono">
                                {{ $log->ip_address ?? '—' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="border-t border-slate-200 dark:border-slate-850 p-3 sm:p-4 flex flex-col items-center justify-between gap-3 sm:flex-row bg-slate-50/50 dark:bg-slate-900/50 backdrop-blur-md">
                <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-1.5 text-xs text-slate-550 dark:text-slate-400">
                    @foreach(request()->except('per_page', 'page') as $key => $value)
                        @if(is_array($value))
                            @foreach($value as $k => $v)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <span>Show</span>
                    <input type="number" name="per_page" value="{{ $auditLogs->perPage() }}" min="1" max="100" 
                           class="w-12 rounded-lg border border-slate-300 dark:border-slate-700 bg-white/70 dark:bg-slate-900/50 py-1 px-1.5 text-center text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-150"
                           onchange="this.form.submit()">
                    <span>entries</span>
                </form>
                @if($auditLogs->hasPages())
                    <div>
                        {{ $auditLogs->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
</div>
@endsection
