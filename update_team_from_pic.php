<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Modules\Tasks\Models\Task;

$sales = ['Lawrence Solee','Norman Reyes','Philip Borromeo','Vera Andino'];
$technical = ['Edcel Ching','Rupert Moreno','Ronnel Gusi','Samuel Tabuzo','Jobert Vallejos','Reuben Guevara','Jomer Delgado','Ryan Fallan','Carlo Roldan'];

Task::whereNull('team')->whereIn('team_in_charge', $sales)->update(['team' => 'sales']);
Task::whereNull('team')->whereIn('team_in_charge', $technical)->update(['team' => 'technical']);

echo "Sales team tasks: " . Task::where('team', 'sales')->count() . "\n";
echo "Technical team tasks: " . Task::where('team', 'technical')->count() . "\n";
