<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Status Overview</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        h1 { font-size: 18px; margin: 0 0 6px; }
        p.meta { margin: 0 0 12px; color: #6b7280; }
        .summary { margin: 0 0 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #d1d5db; padding: 6px 8px; text-align: left; }
        th { background: #f3f4f6; font-weight: 700; }
    </style>
</head>
<body>
    <h1>Task Status Overview</h1>
    <p class="meta">Generated at: <?php echo e($generatedAt->format('Y-m-d H:i:s')); ?></p>
    <p class="summary">Done: <?php echo e($donePercentage); ?>% | In Progress: <?php echo e($inProgressPercentage); ?>%</p>

    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($row['status']); ?></td>
                    <td><?php echo e($row['count']); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\reports\exports\status-overview-pdf.blade.php ENDPATH**/ ?>