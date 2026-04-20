<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily Delayed Tasks Summary</title>
</head>
<body style="margin:0; padding:24px; font-family: Arial, sans-serif; background:#f8fafc; color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:680px; margin:0 auto; background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
        <tr>
            <td style="padding:20px; background:#0f172a; color:#ffffff;">
                <div style="font-size:20px; font-weight:700;">Movaflex Task Manager</div>
                <div style="font-size:13px; opacity:0.9;">Daily Delayed Tasks Summary</div>
            </td>
        </tr>
        <tr>
            <td style="padding:20px;">
                <p style="margin:0 0 12px;">Hello {{ $notifiable->name ?? 'Team Member' }},</p>
                <p style="margin:0 0 12px;">You currently have <strong>{{ $tasks->count() }}</strong> delayed task(s):</p>
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-bottom:16px;">
                    <thead>
                        <tr>
                            <th align="left" style="font-size:12px; color:#475569; border-bottom:1px solid #e2e8f0; padding:8px 0;">Task</th>
                            <th align="left" style="font-size:12px; color:#475569; border-bottom:1px solid #e2e8f0; padding:8px 0;">Company Client</th>
                            <th align="left" style="font-size:12px; color:#475569; border-bottom:1px solid #e2e8f0; padding:8px 0;">Deadline</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td style="font-size:13px; padding:8px 0; border-bottom:1px solid #f1f5f9;">{{ $task->title }}</td>
                                <td style="font-size:13px; padding:8px 0; border-bottom:1px solid #f1f5f9;">{{ $task->company ?: '-' }}</td>
                                <td style="font-size:13px; padding:8px 0; border-bottom:1px solid #f1f5f9;">{{ $task->due_date ? $task->due_date->format('M d, Y') : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ $tasksUrl }}" style="display:inline-block; background:#0f172a; color:#ffffff; text-decoration:none; padding:10px 14px; border-radius:8px; font-size:14px;">Open Task List</a>
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
