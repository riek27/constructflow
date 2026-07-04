<!DOCTYPE html>
<html>
<head>
    <title>Contracts Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #1E3A5F; color: #fff; }
        h2 { color: #1E3A5F; }
    </style>
</head>
<body>
    <h2>Contracts Report</h2>
    <table>
        <thead>
            <tr>
                <th>Project</th>
                <th>Contract #</th>
                <th>Client</th>
                <th>Value</th>
                <th>Status</th>
                <th>Start Date</th>
                <th>Completion Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $contract)
            <tr>
                <td>{{ $contract->project->name ?? 'N/A' }}</td>
                <td>{{ $contract->contract_number }}</td>
                <td>{{ $contract->client ?? '—' }}</td>
                <td>${{ number_format($contract->contract_value, 2) }}</td>
                <td>{{ $contract->status }}</td>
                <td>{{ $contract->start_date?->format('M d, Y') ?? '—' }}</td>
                <td>{{ $contract->completion_date?->format('M d, Y') ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>