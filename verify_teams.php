<?php
// Quick verification script
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Modules\Tasks\Models\Task;

echo "\n=== TASK TEAM ASSIGNMENT CHECK ===\n\n";

$salesTasks = Task::where('team', 'sales')->count();
$technicalTasks = Task::where('team', 'technical')->count();

echo "Tasks with 'sales' team: " . $salesTasks . "\n";
echo "Tasks with 'technical' team: " . $technicalTasks . "\n";

if ($salesTasks > 0 || $technicalTasks > 0) {
    echo "\n✅ SUCCESS! Project Progress should now show data.\n";
} else {
    echo "\n⚠️  No tasks with team assignments yet.\n";
    echo "Go to Dashboard > Create Task and select 'Sales' or 'Technical' in the Team dropdown.\n";
}

echo "\n";
