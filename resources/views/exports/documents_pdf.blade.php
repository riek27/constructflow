<!DOCTYPE html>
<html>
<head>
    <title>Documents Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #1E3A5F; color: #fff; }
        h2 { color: #1E3A5F; }
    </style>
</head>
<body>
    <h2>Documents Report</h2>
    <table>
        <thead>
            <tr>
                <th>Project</th>
                <th>Title</th>
                <th>Category</th>
                <th>Original Name</th>
                <th>Size (KB)</th>
                <th>Uploaded At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $document)
            <tr>
                <td>{{ $document->project->name ?? 'N/A' }}</td>
                <td>{{ $document->title }}</td>
                <td>{{ $document->category }}</td>
                <td>{{ $document->original_name }}</td>
                <td>{{ round($document->size / 1024, 1) }}</td>
                <td>{{ $document->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>