@extends('layouts.app')

@section('content')
<div class="relative space-y-4">
    <div class="pointer-events-none absolute right-0 top-0 h-64 w-64 translate-x-1/3 -translate-y-1/3 rounded-full bg-blue-100/40 blur-3xl dark:hidden"></div>
    <div class="pointer-events-none absolute bottom-0 left-20 h-52 w-52 rounded-full bg-slate-200/30 blur-3xl dark:hidden"></div>

    <div class="relative overflow-hidden rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/90" style="border-left: 4px solid #2563eb;">
        <div class="pointer-events-none absolute -right-14 -top-12 h-44 w-44 rounded-full bg-blue-100/40 dark:bg-blue-500/15 blur-3xl"></div>
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Email Alerts</h1>
                <p class="text-xs text-slate-550 dark:text-slate-400 mt-0.5">View and manage your read and unread notification feed.</p>
            </div>
            <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 py-1.5 px-3 text-xs font-bold text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200 hover:-translate-y-0.5">Mark all as read</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-600 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/30">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-xl border border-slate-200/40 bg-white/90 shadow-sm dark:border-slate-800 dark:bg-slate-900/90 p-3">
        @if($notifications->isEmpty())
            <p class="py-6 text-center text-xs text-slate-500 dark:text-slate-400">No notifications yet.</p>
        @else
            <ul class="space-y-2">
                @foreach($notifications as $i => $notification)
                    @php
                        $message = $notification->data['message'] ?? $notification->data['body'] ?? '-';
                        $link = $notification->data['link'] ?? route('dashboard');
                        $isUnread = is_null($notification->read_at);
                        $isLatest = $i === 0;
                    @endphp
                    <li class="flex items-start justify-between gap-3 rounded-lg border px-3 py-2.5 text-xs
                        {{ $isLatest
                            ? 'border-blue-400 dark:border-blue-500 bg-blue-50/50 dark:bg-blue-950/20 shadow-sm'
                            : ($isUnread ? 'border-slate-200 dark:border-slate-800 bg-blue-50/30 dark:bg-blue-950/10' : 'border-slate-200 dark:border-slate-800 bg-slate-50/40 dark:bg-slate-900/40') }}">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                @if($isLatest)
                                    <span class="inline-flex items-center rounded-full bg-blue-500 px-2 py-0.5 text-[9px] font-bold text-white uppercase tracking-wide">Latest</span>
                                @endif
                                <a href="{{ $link }}" class="text-xs {{ $isUnread || $isLatest ? 'font-semibold text-slate-900 dark:text-white text-xs' : 'text-slate-600 dark:text-slate-400 text-xs' }} hover:text-blue-600 dark:hover:text-blue-400 hover:underline">
                                    {{ $message }}
                                </a>
                            </div>
                            <p class="mt-0.5 text-[10px] text-slate-500 dark:text-slate-405">{{ $notification->created_at?->diffForHumans() }}</p>
                        </div>

                        @if($isUnread)
                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1 rounded border border-blue-100 dark:border-blue-900/50 bg-blue-50/50 dark:bg-blue-950/40 px-2 py-1 text-[10px] font-bold text-blue-600 dark:text-blue-400 hover:bg-blue-100/80 dark:hover:bg-blue-900/50 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">Mark read</button>
                            </form>
                        @else
                            <span class="rounded bg-slate-100 dark:bg-slate-800 px-2 py-0.5 text-[10px] font-medium text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700">Read</span>
                        @endif
                    </li>
                @endforeach
            </ul>

            <div class="mt-4 flex flex-col items-center justify-between gap-3 sm:flex-row bg-slate-50/30 dark:bg-slate-900/30 p-3 rounded-lg border border-slate-200/55 dark:border-slate-800">
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
                    <input type="number" name="per_page" value="{{ $notifications->perPage() }}" min="1" max="100" 
                           class="w-12 rounded-lg border border-slate-300 dark:border-slate-700 bg-white/70 dark:bg-slate-900/50 py-1 px-1.5 text-center text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-150"
                           onchange="this.form.submit()">
                    <span>entries</span>
                </form>
                @if($notifications->hasPages())
                    <div>
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
