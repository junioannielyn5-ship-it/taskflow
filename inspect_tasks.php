<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Modules\Tasks\Models\Task;

$t = Task::all();

echo "Total=" . $t->count() . "\n";
foreach ($t as $x) {
    echo $x->id . ' | status=' . $x->status . ' | team=' . ($x->team ?? 'NULL') . ' | team_in_charge=' . ($x->team_in_charge ?? 'NULL') . ' | project=' . ($x->project_id ?? 'NULL') . "\n";
}
