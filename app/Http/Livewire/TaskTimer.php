<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Modules\Tasks\Models\Task;
use App\Modules\Tasks\Models\TaskTimeLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskTimer extends Component
{
    public $taskId;
    public $activeLog;
    public $duration = 0;
    public $running = false;

    protected $listeners = ['refreshTimer' => 'fetchActiveLog'];

    public function mount($taskId)
    {
        $this->taskId = $taskId;
        $this->fetchActiveLog();
    }

    public function fetchActiveLog()
    {
        $this->activeLog = TaskTimeLog::where('task_id', $this->taskId)
            ->where('user_id', Auth::id())
            ->whereNull('stopped_at')
            ->first();
        $this->running = !!$this->activeLog;
        if ($this->running) {
            $this->duration = Carbon::now()->diffInSeconds(Carbon::parse($this->activeLog->started_at));
        } else {
            $lastLog = TaskTimeLog::where('task_id', $this->taskId)
                ->where('user_id', Auth::id())
                ->orderByDesc('started_at')
                ->first();
            $this->duration = $lastLog ? $lastLog->total_seconds : 0;
        }
    }

    public function startTimer()
    {
        // Stop any other active timer
        TaskTimeLog::where('user_id', Auth::id())
            ->whereNull('stopped_at')
            ->update(['stopped_at' => Carbon::now(), 'total_seconds' => Carbon::now()->diffInSeconds('started_at')]);
        $this->activeLog = TaskTimeLog::create([
            'task_id' => $this->taskId,
            'user_id' => Auth::id(),
            'started_at' => Carbon::now(),
        ]);
        $this->running = true;
        $this->duration = 0;
        $this->emit('refreshTimer');
    }

    public function stopTimer()
    {
        if ($this->activeLog) {
            $this->activeLog->stopped_at = Carbon::now();
            $this->activeLog->total_seconds = Carbon::now()->diffInSeconds(Carbon::parse($this->activeLog->started_at));
            $this->activeLog->save();
            $this->running = false;
            $this->duration = $this->activeLog->total_seconds;
            $this->emit('refreshTimer');
        }
    }

    public function render()
    {
        return view('livewire.task-timer', [
            'duration' => $this->duration,
            'running' => $this->running,
        ]);
    }
}
