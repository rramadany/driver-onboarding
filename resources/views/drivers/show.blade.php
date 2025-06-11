@extends('layouts.app')

@section('content')
    <h1>Driver Details: {{ $driver->name }}</h1>
    
    <a href="{{ route('drivers.index') }}"> < Back to All Drivers</a>

    <hr>

    @if($driver->photo_path)
        <h3>Driver Photo</h3>
        <img src="{{ route('drivers.photo', ['driver' => $driver]) }}" alt="Driver photo" style="max-width: 200px; height: auto;">
        <hr>
    @endif
    
    <h3>Profile Information</h3>
    <p><strong>Name:</strong> {{ $driver->name }}</p>
    <p><strong>Email:</strong> {{ $driver->email }}</p>
    <p><strong>Phone Number:</strong> {{ $driver->phone_number }}</p>
    <p><strong>License Number:</strong> {{ $driver->license_number }}</p>
    <p><strong>License Expiry:</strong> {{ $driver->license_expiry_date->format('M d, Y') }}</p>

    <h3>Status Information</h3>
    <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $driver->status)) }}</p>
    <p><strong>Created By:</strong> {{ $driver->createdBy?->name ?? 'N/A' }} on {{ $driver->created_at->format('M d, Y') }}</p>
    @if($driver->reviewed_at)
        <p><strong>Reviewed By:</strong> {{ $driver->reviewedBy->name }} on {{ $driver->reviewed_at->format('M d, Y') }}</p>
    @endif

    @if($driver->status === 'rejected' && $driver->rejection_reason)
        <p><strong>Rejection Reason:</strong> {{ $driver->rejection_reason }}</p>
    @endif
    
    <hr>

    @can('manage-drivers')
        <h3>Actions</h3>
        @if ($driver->isEditable())
             <a href="{{ route('drivers.edit', $driver) }}">Edit Profile</a>
             <br><br>
        @endif
             <form method="POST" action="{{ route('drivers.destroy', $driver) }}" onsubmit="return confirm('Are you sure you want to delete this profile?');">
                @csrf
                @method('DELETE')
                <button type="submit">Delete Profile</button>
            </form>
    @endcan
@endsection