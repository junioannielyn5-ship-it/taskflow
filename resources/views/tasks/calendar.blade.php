(@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="pointer-events-none absolute -left-16 -top-16 h-52 w-52 rounded-full bg-emerald-200/35 blur-3xl"></div>
        <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Company Calendar</h1>
            <p class="text-sm text-slate-500">Split view: Event Calendar and Tasks Calendar</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('tasks.calendar', ['month' => $month->format('Y-m'), 'panel' => 'all', 'activity' => ($activity ?? 'all')]) }}" class="rounded-full border px-3 py-1.5 text-sm {{ ($panel ?? 'all') === 'all' ? 'border-indigo-300 bg-indigo-100 text-indigo-900' : 'border-slate-300 text-slate-700 hover:bg-slate-50' }}">All</a>
            <a href="{{ route('tasks.calendar', ['month' => $month->format('Y-m'), 'panel' => 'events', 'activity' => ($activity ?? 'all')]) }}" class="rounded-full border px-3 py-1.5 text-sm {{ ($panel ?? 'all') === 'events' ? 'border-violet-300 bg-violet-100 text-violet-900' : 'border-slate-300 text-slate-700 hover:bg-slate-50' }}">Event Calendar</a>
            <a href="{{ route('tasks.calendar', ['month' => $month->format('Y-m'), 'panel' => 'tasks', 'activity' => ($activity ?? 'all')]) }}" class="rounded-full border px-3 py-1.5 text-sm {{ ($panel ?? 'all') === 'tasks' ? 'border-blue-300 bg-blue-100 text-blue-900' : 'border-slate-300 text-slate-700 hover:bg-slate-50' }}">Tasks Calendar</a>
            <a href="{{ route('tasks.calendar', ['month' => $month->format('Y-m'), 'panel' => ($panel ?? 'all'), 'activity' => 'all']) }}" class="rounded-full border px-3 py-1.5 text-sm {{ ($activity ?? 'all') === 'all' ? 'border-slate-400 bg-slate-100 text-slate-900' : 'border-slate-300 text-slate-700 hover:bg-slate-50' }}">All Activity</a>
            <a href="{{ route('tasks.calendar', ['month' => $month->format('Y-m'), 'panel' => ($panel ?? 'all'), 'activity' => 'sales']) }}" class="rounded-full border px-3 py-1.5 text-sm {{ ($activity ?? 'all') === 'sales' ? 'border-emerald-300 bg-emerald-100 text-emerald-900' : 'border-slate-300 text-slate-700 hover:bg-slate-50' }}">Sales Activity</a>
            <a href="{{ route('tasks.calendar', ['month' => $month->format('Y-m'), 'panel' => ($panel ?? 'all'), 'activity' => 'technical']) }}" class="rounded-full border px-3 py-1.5 text-sm {{ ($activity ?? 'all') === 'technical' ? 'border-cyan-300 bg-cyan-100 text-cyan-900' : 'border-slate-300 text-slate-700 hover:bg-slate-50' }}">Technical Activity</a>
            <a href="{{ route('meetings.index') }}" class="rounded-full border border-slate-300 px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50">Meetings</a>
            <a href="{{ route('holidays.index') }}" class="rounded-full border border-slate-300 px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50">Holidays</a>
            <a href="{{ route('tasks.calendar', ['month' => $prevMonth, 'panel' => ($panel ?? 'all'), 'activity' => ($activity ?? 'all')]) }}" class="rounded-full border border-slate-300 px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50">Previous</a>
            <span class="rounded-full bg-slate-100 px-3 py-1.5 text-sm font-semibold text-slate-700">{{ $month->format('F Y') }}</span>
            <a href="{{ route('tasks.calendar', ['month' => $nextMonth, 'panel' => ($panel ?? 'all'), 'activity' => ($activity ?? 'all')]) }}" class="rounded-full border border-slate-300 px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50">Next</a>
        </div>
        </div>
    </div>

    @if (($panel ?? 'all') !== 'tasks')
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="mb-3 flex items-center justify-between">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-violet-700">Event Calendar</h2>
            <p class="text-xs text-slate-500">Inputs are managed in Meetings and Holidays modules.</p>
        </div>
        <div class="mb-4 flex flex-wrap gap-2 text-xs">
            <span class="rounded-full bg-violet-100 px-2.5 py-1 font-medium text-violet-700">Meeting</span>
            <span class="rounded-full bg-amber-100 px-2.5 py-1 font-medium text-amber-700">Holiday</span>
        </div>
        <div class="space-y-2">
            @php
                $eventDays = collect($meetingsByDate->keys())
                    ->merge($holidaysByDate->keys())
                    ->unique()
                    ->sort()
                    ->values();
            @endphp
            @forelse($eventDays as $dayKey)
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                    <p class="mb-2 text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($dayKey)->format('M d, Y (D)') }}</p>
                    <div class="space-y-1">
                        @foreach(($holidaysByDate->get($dayKey, collect())) as $holiday)
                            <p class="text-xs text-amber-800">Holiday: {{ $holiday->name }}</p>
                        @endforeach
                        @foreach(($meetingsByDate->get($dayKey, collect())) as $meeting)
                            <p class="text-xs text-violet-800">Meeting: {{ $meeting->title }}</p>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-3 py-5 text-center text-sm text-slate-500">No events scheduled for this month.</p>
            @endforelse
        </div>
    </div>
    @endif

    @if (($panel ?? 'all') !== 'events')
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow">
        <div class="flex items-center justify-between border-b border-slate-200 bg-slate-50 px-4 py-3">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-blue-700">
                Tasks Calendar (Active Tasks Only)
                @if (($activity ?? 'all') === 'sales')
                    - Sales Activity
                @elseif (($activity ?? 'all') === 'technical')
                    - Technical Activity
                @endif
            </h2>
            <div class="flex flex-wrap gap-2 text-xs">
                <span class="rounded-full bg-blue-100 px-2.5 py-1 font-medium text-blue-700">Active Projects</span>
                <span class="rounded-full bg-amber-50 px-2.5 py-1 font-medium text-amber-700">My Tasks</span>
                <span class="rounded-full bg-orange-50 px-2.5 py-1 font-medium text-orange-700">Pending Review</span>
                <span class="rounded-full bg-rose-100 px-2.5 py-1 font-medium text-rose-700">Overdue</span>
                <span class="rounded-full bg-emerald-100 px-2.5 py-1 font-medium text-emerald-700">Done</span>
            </div>
        </div>
        <div class="grid grid-cols-7 border-b border-slate-200 bg-slate-50 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">
            <div class="px-2 py-3">Sun</div>
            <div class="px-2 py-3">Mon</div>
            <div class="px-2 py-3">Tue</div>
            <div class="px-2 py-3">Wed</div>
            <div class="px-2 py-3">Thu</div>
            <div class="px-2 py-3">Fri</div>
            <div class="px-2 py-3">Sat</div>
        </div>

        <div class="grid grid-cols-7">
            @foreach (\Carbon\CarbonPeriod::create($startOfGrid, '1 day', $endOfGrid) as $day)
                @php
                    $key = $day->format('Y-m-d');
                    $dayTasks = $tasksByDate->get($key, collect());
                    $isCurrentMonth = $day->month === $month->month;
                    $isToday = $day->isToday();
                @endphp
                <div class="min-h-36 border-b border-r border-slate-100 p-2 {{ $isCurrentMonth ? 'bg-white' : 'bg-slate-50/70' }}">
                    <div class="mb-2 flex items-center justify-between">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full text-xs font-semibold {{ $isToday ? 'bg-blue-600 text-white' : 'text-slate-600' }}">{{ $day->day }}</span>
                        @if ($dayTasks->isNotEmpty())
                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-medium text-slate-600">{{ $dayTasks->count() }}</span>
                        @endif
                    </div>

                    <div class="space-y-1.5">
                        @foreach ($dayTasks->take(4) as $task)
                            @php
                                $badge = $task->isOverdue() ? 'bg-rose-100 text-rose-700' : 'bg-blue-100 text-blue-700';
                            @endphp
                            <a href="{{ route('tasks.show', $task) }}" class="block rounded px-2 py-1 text-[11px] font-medium {{ $badge }} hover:opacity-90" title="{{ $task->title }}">
                                {{ \Illuminate\Support\Str::limit($task->title, 26) }}
                            </a>
                        @endforeach

                        @php
                            $overflowCount = max(0, $dayTasks->count() - 4);
                        @endphp

                        @if ($overflowCount > 0)
                            <p class="px-1 text-[11px] text-slate-500">+{{ $overflowCount }} more</p>
                        @endif

                        {{-- Holiday marker --}}
                        @if ($holidaysByDate && $holidaysByDate->has($key))
                            @foreach ($holidaysByDate->get($key, collect()) as $holiday)
                                <span class="block rounded px-2 py-1 text-[11px] font-medium bg-amber-100 text-amber-700" title="Holiday">
                                    🏖 {{ $holiday->name }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
