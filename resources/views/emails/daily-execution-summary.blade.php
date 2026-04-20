<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movaflex Daily Execution Summary</title>
</head>
<body style="margin:0; padding:24px; font-family: Arial, sans-serif; background:#f8fafc; color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:720px; margin:0 auto; background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
        <tr>
            <td style="padding:20px; background:#0f172a; color:#ffffff;">
                <div style="font-size:20px; font-weight:700;">Movaflex Task Manager</div>
                <div style="font-size:13px; opacity:0.9;">Daily Execution Summary - {{ $reportDate }}</div>
            </td>
        </tr>
        <tr>
            <td style="padding:20px;">
                <p style="margin:0 0 12px;">Good Morning, {{ $notifiable->name ?? 'Manager' }}!</p>
                <p style="margin:0 0 16px;">Narito ang summary ng mga kailangang tutukan ngayong araw:</p>

                <h3 style="margin:0 0 8px; color:#b91c1c; font-size:15px;">🔴 DELAYED TASKS (Needs Urgent Attention)</h3>
                @if($delayedByTeam->isEmpty())
                    <p style="margin:0 0 14px; font-size:13px; color:#475569;">No delayed tasks found.</p>
                @else
                    <ul style="margin:0 0 14px; padding-left:20px; color:#334155;">
                        @foreach($delayedByTeam as $team => $tasks)
                            <li style="margin-bottom:6px; font-size:13px;">
                                <strong>{{ $team ?: 'Unassigned Team' }}:</strong>
                                {{ $tasks->count() }} task(s)
                                @if($tasks->isNotEmpty())
                                    (e.g., {{ $tasks->first()->company ?: 'N/A' }} - {{ $tasks->first()->title }})
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif

                <h3 style="margin:0 0 8px; color:#1d4ed8; font-size:15px;">🔵 ON-GOING TASKS</h3>
                <p style="margin:0 0 14px; font-size:13px; color:#334155;">Total: <strong>{{ $ongoingCount }}</strong> on-going task(s) · <strong>{{ $activeCount }}</strong> active task(s)</p>

                <h3 style="margin:0 0 8px; color:#b45309; font-size:15px;">🟠 DUE WITHIN 24 HOURS</h3>
                @if($upcomingWithin24Hours->isEmpty())
                    <p style="margin:0 0 14px; font-size:13px; color:#475569;">No tasks due within the next 24 hours.</p>
                @else
                    <ul style="margin:0 0 14px; padding-left:20px; color:#334155;">
                        @foreach($upcomingWithin24Hours->take(8) as $task)
                            <li style="margin-bottom:6px; font-size:13px;">
                                {{ $task->team_in_charge ?: 'Unassigned Team' }} - {{ $task->title }} ({{ $task->due_date ? $task->due_date->format('M d, Y') : '-' }})
                            </li>
                        @endforeach
                    </ul>
                @endif

                <h3 style="margin:0 0 8px; color:#0f766e; font-size:15px;">📅 TODAY'S DEADLINES</h3>
                @if($todayDeadlines->isEmpty())
                    <p style="margin:0 0 18px; font-size:13px; color:#475569;">No deadlines due today.</p>
                @else
                    <ul style="margin:0 0 18px; padding-left:20px; color:#334155;">
                        @foreach($todayDeadlines->take(8) as $task)
                            <li style="margin-bottom:6px; font-size:13px;">
                                {{ $task->task_process ?: 'General' }} - {{ $task->title }}
                            </li>
                        @endforeach
                    </ul>
                @endif

                <a href="{{ $dashboardUrl }}" style="display:inline-block; background:#0f172a; color:#ffffff; text-decoration:none; padding:10px 14px; border-radius:8px; font-size:14px;">OPEN MOVAFLEX DASHBOARD</a>
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
