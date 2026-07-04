<!DOCTYPE html>
<html>
<head>
    <title>Payments Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #1E3A5F; color: #fff; }
        h2 { color: #1E3A5F; }
    </style>
</head>
<body>
    <h2>Payments Report</h2>
    <table>
        <thead>
            <tr>
                <th>Project</th>
                <th>Invoice #</th>
                <th>Type</th>
                <th>Amount</th>
                <th>VAT</th>
                <th>Total</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $payment)
            <tr>
                <td>{{ $payment->project->name ?? 'N/A' }}</td>
                <td>{{ $payment->invoice_number }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $payment->type)) }}</td>
                <td>${{ number_format($payment->amount, 2) }}</td>
                <td>${{ number_format($payment->vat, 2) }}</td>
                <td>${{ number_format($payment->total_amount, 2) }}</td>
                <td>{{ $payment->due_date?->format('M d, Y') ?? '—' }}</td>
                <td>{{ $payment->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>