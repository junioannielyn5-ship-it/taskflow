<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Modules\Projects\Models\Project;

$projects = Project::query()
    ->with('tasks')
    ->withCount([
        'tasks as total_tasks_count',
        'tasks as done_tasks_count' => fn ($query) => $query->where('status', 'done'),
        'tasks as sales_tasks_count' => fn ($query) => $query->where('team', 'sales'),
        'tasks as sales_done_tasks_count' => fn ($query) => $query->where('team', 'sales')->where('status', 'done'),
        'tasks as technical_tasks_count' => fn ($query) => $query->where('team', 'technical'),
        'tasks as technical_done_tasks_count' => fn ($query) => $query->where('team', 'technical')->where('status', 'done'),
    ])
    ->orderBy('name')
    ->take(10)
    ->get();

if ($projects->isEmpty()) {
    echo "No project entries returned.\n";
    exit(0);
}

foreach ($projects as $p) {
    echo "Project {$p->id} {$p->name}\n";
    echo "  total_tasks_count={$p->total_tasks_count}\n";
    echo "  done_tasks_count={$p->done_tasks_count}\n";
    echo "  sales_tasks_count={$p->sales_tasks_count}\n";
    echo "  technical_tasks_count={$p->technical_tasks_count}\n";
    echo "  sales_done_tasks_count={$p->sales_done_tasks_count}\n";
    echo "  technical_done_tasks_count={$p->technical_done_tasks_count}\n";
    echo "  tasks list (team values):\n";
    foreach($p->tasks as $t) {
        echo "    t{$t->id} status={$t->status} team={$t->team} team_in_charge={$t->team_in_charge}\n";
    }
    echo "\n";
}
