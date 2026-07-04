<!DOCTYPE html>
<html>
<head>
    <title>Variations Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #1E3A5F; color: #fff; }
        h2 { color: #1E3A5F; }
    </style>
</head>
<body>
    <h2>Variations Report</h2>
    <table>
        <thead>
            <tr>
                <th>Project</th>
                <th>Variation #</th>
                <th>Title</th>
                <th>Estimated Cost</th>
                <th>Approved Cost</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $variation)
            <tr>
                <td>{{ $variation->project->name ?? 'N/A' }}</td>
                <td>{{ $variation->variation_number }}</td>
                <td>{{ $variation->title }}</td>
                <td>${{ number_format($variation->estimated_cost, 2) }}</td>
                <td>${{ number_format($variation->approved_cost, 2) }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $variation->status)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>