<!DOCTYPE html>
<html>
<head>
    <title>Projects Report</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #1E3A5F; color: #fff; }
    </style>
</head>
<body>
    <h2>Projects Report</h2>
    <table>
        <thead>
            <tr><th>Name</th><th>Client</th><th>Value</th><th>Status</th></tr>
        </thead>
        <tbody>
            @foreach($data as $project)
            <tr>
                <td>{{ $project->name }}</td>
                <td>{{ $project->client }}</td>
                <td>${{ number_format($project->contract_value, 2) }}</td>
                <td>{{ $project->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>