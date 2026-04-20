<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Modules\Identity\Models\User;
use App\Modules\Reporting\Http\Controllers\DashboardController;

$user = User::first();
$controller = new DashboardController();
$data = (new ReflectionClass(DashboardController::class))->getMethod('buildDashboardData');
$data->setAccessible(true);
$result = $data->invoke($controller, $user);

$projectProgressArr = $result['projectProgress']->map(function($p){
    return [
        'id' => $p['id'],
        'name' => $p['name'],
        'sales_total' => $p['sales']['total'],
        'technical_total' => $p['technical']['total'],
        'sales_tasks' => count($p['sales']['tasks']),
        'technical_tasks' => count($p['technical']['tasks']),
    ];
})->toArray();
print_r($projectProgressArr);

