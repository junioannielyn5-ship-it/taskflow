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
    <p class="meta">Generated at: {{ $generatedAt->format('Y-m-d H:i:s') }}</p>
    <p class="summary">Done: {{ $donePercentage }}% | In Progress: {{ $inProgressPercentage }}%</p>

    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
                <tr>
                    <td>{{ $row['status'] }}</td>
                    <td>{{ $row['count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
