      
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dossier: {{ $driver->name }}</title>
</head>
<body>
    <h1>Driver Dossier</h1>
    <p>Generated on: {{ now()->format('M d, Y') }}</p>

    <div>
        <h2>Profile Information</h2>
        <p><strong>Name:</strong> {{ $driver->name ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $driver->email ?? 'N/A' }}</p>
        <p><strong>Phone Number:</strong> {{ $driver->phone_number ?? 'N/A' }}</p>
        <p><strong>License Number:</strong> {{ $driver->license_number ?? 'N/A' }}</p>
        <p><strong>License Expiry:</strong> {{ $driver->license_expiry_date?->format('M d, Y') ?? 'N/A' }}</p>
    </div>

    <div>
        <h2>System Information</h2>
        <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $driver->status)) }}</p>
        <p><strong>Profile Created By:</strong> {{ $driver->createdBy?->name ?? 'N/A' }} on {{ $driver->created_at->format('M d, Y') }}</p>
        @if($driver->reviewed_at)
            <p><strong>Reviewed By:</strong> {{ $driver->reviewedBy->name }} on {{ $driver->reviewed_at->format('M d, Y') }}</p>
        @endif
        @if($driver->status === 'rejected' && $driver->rejection_reason)
            <p><strong>Rejection Reason:</strong> {{ $driver->rejection_reason }}</p>
        @endif
    </div>

    <div>
        <h2>Document Checklist</h2>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Document Type</th>
                    <th>Status / Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documentMap as $key => $details)
                    <tr>
                        <td>{{ $details['label'] }}</td>
                        <td>
                            @if ($imagePaths[$key])
                                <strong>Uploaded</strong>
                                <br>
                                <img src="{{ $imagePaths[$key] }}" style="max-width: 400px; max-height: 400px; margin-top: 10px;">
                            @else
                                <strong>Missing</strong>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>