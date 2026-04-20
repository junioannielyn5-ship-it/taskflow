<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movaflex Task Assignment</title>
</head>
<body style="margin:0; padding:24px; font-family: Arial, sans-serif; background:#f8fafc; color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:640px; margin:0 auto; background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
        <tr>
            <td style="padding:20px; background:#1d4ed8; color:#ffffff;">
                <div style="font-size:20px; font-weight:700;">Movaflex Task Manager</div>
                <div style="font-size:13px; opacity:0.9;">New Task Assignment</div>
            </td>
        </tr>
        <tr>
            <td style="padding:20px;">
                <p style="margin:0 0 12px;">Hello {{ $notifiable->name ?? 'Team Member' }},</p>
                <p style="margin:0 0 12px;">You have been assigned a new task: <strong>{{ $task->title }}</strong>.</p>
                <p style="margin:0 0 8px;"><strong>Company Client:</strong> {{ $task->company ?: '-' }}</p>
                <p style="margin:0 0 8px;"><strong>Team In Charge:</strong> {{ $task->team_in_charge ?: '-' }}</p>
                <p style="margin:0 0 8px;"><strong>Target Deadline:</strong> {{ $task->due_date ? $task->due_date->format('M d, Y') : '-' }}</p>
                <p style="margin:0 0 16px;"><strong>Priority:</strong> {{ strtoupper($task->priority ?? '-') }}</p>
                <a href="{{ $taskUrl }}" style="display:inline-block; background:#1d4ed8; color:#ffffff; text-decoration:none; padding:10px 14px; border-radius:8px; font-size:14px;">Open Task</a>
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
