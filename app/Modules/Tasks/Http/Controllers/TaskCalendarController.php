<?php

namespace App\Modules\Tasks\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tasks\Models\Task;
use App\Modules\Workflow\Models\Meeting;
use App\Modules\Workflow\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskCalendarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $monthInput = request('month');
        $panel = request('panel', 'all');
        $activity = request('activity', 'all');

        $month = $monthInput
            ? Carbon::createFromFormat('Y-m', $monthInput)->startOfMonth()
            : now()->startOfMonth();

        $startOfGrid = $month->copy()->startOfWeek();
        $endOfGrid = $month->copy()->endOfMonth()->endOfWeek();

        $tasksQuery = Task::query()
            ->with(['project'])
            ->whereNotNull('due_date')
            ->where('status', '!=', 'done')
            ->whereBetween('due_date', [$startOfGrid->toDateString(), $endOfGrid->toDateString()]);

        if (in_array($activity, ['sales', 'technical'], true)) {
            $tasksQuery->whereRaw('LOWER(team_in_charge) = ?', [$activity]);
        }

        $isAdmin = (string) data_get($user, 'role', '') === 'admin';

        if (!$isAdmin) {
            $tasksQuery->whereHas('project.members', function ($memberQuery) use ($user) {
                $memberQuery->where('user_id', $user->id);
            });
        }

        $tasksByDate = $tasksQuery
            ->orderBy('due_date')
            ->orderBy('priority')
            ->get()
            ->groupBy(fn (Task $task) => $task->due_date?->format('Y-m-d'));

        $meetingsByDate = Meeting::query()
            ->with('creator:id,name')
            ->whereBetween('meeting_date', [$startOfGrid->toDateString(), $endOfGrid->toDateString()])
            ->orderBy('meeting_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn (Meeting $meeting) => $meeting->meeting_date?->format('Y-m-d'));

        $holidaysByDate = Holiday::query()
            ->with('creator:id,name')
            ->whereBetween('holiday_date', [$startOfGrid->toDateString(), $endOfGrid->toDateString()])
            ->orderBy('holiday_date')
            ->get()
            ->groupBy(fn (Holiday $holiday) => $holiday->holiday_date?->format('Y-m-d'));

        return view('tasks.calendar', [
            'month' => $month,
            'prevMonth' => $month->copy()->subMonth()->format('Y-m'),
            'nextMonth' => $month->copy()->addMonth()->format('Y-m'),
            'startOfGrid' => $startOfGrid,
            'endOfGrid' => $endOfGrid,
            'tasksByDate' => $tasksByDate,
            'meetingsByDate' => $meetingsByDate,
            'holidaysByDate' => $holidaysByDate,
            'panel' => in_array($panel, ['all', 'events', 'tasks'], true) ? $panel : 'all',
            'activity' => in_array($activity, ['all', 'sales', 'technical'], true) ? $activity : 'all',
        ]);
    }
}
