<!DOCTYPE html>
<html>
<head>
    <title>Procurement Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #1E3A5F; color: #fff; }
        h2 { color: #1E3A5F; }
    </style>
</head>
<body>
    <h2>Procurement Report</h2>
    <table>
        <thead>
            <tr>
                <th>Project</th>
                <th>PO Number</th>
                <th>Supplier</th>
                <th>Description</th>
                <th>Total Cost</th>
                <th>Order Date</th>
                <th>Delivery Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $procurement)
            <tr>
                <td>{{ $procurement->project->name ?? 'N/A' }}</td>
                <td>{{ $procurement->po_number }}</td>
                <td>{{ $procurement->supplier->name ?? $procurement->supplier_name ?? '—' }}</td>
                <td>{{ $procurement->description ?? '—' }}</td>
                <td>${{ number_format($procurement->total_cost, 2) }}</td>
                <td>{{ $procurement->order_date?->format('M d, Y') ?? '—' }}</td>
                <td>{{ $procurement->delivery_date?->format('M d, Y') ?? '—' }}</td>
                <td>{{ ucfirst($procurement->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>