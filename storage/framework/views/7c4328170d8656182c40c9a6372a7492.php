<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delayed Task Alert</title>
</head>
<body style="margin:0; padding:24px; font-family: Arial, sans-serif; background:#f8fafc; color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:640px; margin:0 auto; background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
        <tr>
            <td style="padding:20px; background:#b91c1c; color:#ffffff;">
                <div style="font-size:20px; font-weight:700;">Movaflex Task Manager</div>
                <div style="font-size:13px; opacity:0.9;">Delayed Task Alert</div>
            </td>
        </tr>
        <tr>
            <td style="padding:20px;">
                <p style="margin:0 0 12px;">Hello <?php echo e($notifiable->name ?? 'Team Member'); ?>,</p>
                <p style="margin:0 0 12px;">The task below is now marked as <strong>Delayed</strong>:</p>
                <p style="margin:0 0 8px;"><strong><?php echo e($task->title); ?></strong></p>
                <p style="margin:0 0 8px;"><strong>Target Deadline:</strong> <?php echo e($task->due_date ? $task->due_date->format('M d, Y') : '-'); ?></p>
                <p style="margin:0 0 16px;"><strong>Status:</strong> <?php echo e(strtoupper(str_replace('_', ' ', $task->status ?? ''))); ?></p>
                <a href="<?php echo e($taskUrl); ?>" style="display:inline-block; background:#b91c1c; color:#ffffff; text-decoration:none; padding:10px 14px; border-radius:8px; font-size:14px;">Review Task</a>
            </td>
        </tr>
        <tr>
            <td style="padding:14px 20px; background:#f1f5f9; font-size:12px; color:#475569;">
                Movaflex Designs Unlimited Inc. CY 2026
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\emails\delayed-task-alert.blade.php ENDPATH**/ ?>