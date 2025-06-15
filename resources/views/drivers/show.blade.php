@extends('layouts.app')

@section('content')
    <h1 class="mb-3">Driver Details: {{ $driver->name }}</h1>
    
    <div class="mb-4">
        <a href="{{ route('drivers.index') }}" class="btn btn-secondary btn-sm"> < Back to All Drivers</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Profile Information</h3>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $driver->name ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $driver->email ?? 'N/A' }}</p>
            <p><strong>Phone Number:</strong> {{ $driver->phone_number ?? 'N/A' }}</p>
            <p><strong>License Number:</strong> {{ $driver->license_number ?? 'N/A' }}</p>
            <p class="mb-0"><strong>License Expiry:</strong> {{ $driver->license_expiry_date?->format('M d, Y') ?? 'N/A' }}</p>
        </div>
    </div>


    <div class="card mb-4"> {{-- Add margin-bottom --}}
        <div class="card-header">
            <h3>Status Information</h3>
        </div>
        <div class="card-body">
            <p>
                <strong>Status:</strong>
                @php
                    $badgeClass = 'bg-secondary';
                    switch($driver->status) {
                        case 'draft': $badgeClass = 'bg-secondary'; break;
                        case 'pending_approval': $badgeClass = 'bg-warning text-dark'; break;
                        case 'approved': $badgeClass = 'bg-success'; break;
                        case 'rejected': $badgeClass = 'bg-danger'; break;
                    }
                @endphp
                <span class="badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $driver->status)) }}</span>
            </p>
            <p><strong>Created By:</strong> {{ $driver->createdBy?->name ?? 'N/A' }} on {{ $driver->created_at->format('M d, Y') }}</p>
            @if($driver->reviewed_at)
                <p class="mb-0"><strong>Reviewed By:</strong> {{ $driver->reviewedBy?->name ?? 'N/A' }} on {{ $driver->reviewed_at->format('M d, Y') }}</p>
            @endif

            @if($driver->status === 'rejected' && $driver->rejection_reason)
                <div class="mt-3 p-3 bg-light border rounded">
                    <p class="mb-0"><strong>Rejection Reason:</strong> {{ $driver->rejection_reason }}</p>
                </div>
            @endif
        </div>
    </div>


    <div class="card mb-4">
        <div class="card-header">
            <h3>Documents</h3>
        </div>
        <div class="card-body">
            @php
                $firstUploadedKey = null;
                foreach ($documentMap as $key => $details) {
                    if ($driver->{$details['column']} !== null) {
                        $firstUploadedKey = $key;
                            break;
                    }
                }
            @endphp
            <ul class="nav nav-tabs" id="documentTabs" role="tablist">
                @foreach ($documentMap as $key => $details)
                    @php
                        $isUploaded = $driver->{$details['column']} !== null;
                        $tabId = 'document-' . $key . '-tab';
                        $paneId = 'document-' . $key;
                        $isActive = $key === $firstUploadedKey ? 'active' : '';
                        $isDisabled = !$isUploaded ? 'disabled' : '';
                        $ariaSelected = $isActive !== '' ? 'true' : 'false';
                    @endphp
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $isActive }} {{ $isDisabled }}"
                                id="{{ $tabId }}"
                                data-bs-toggle="tab"
                                data-bs-target="#{{ $paneId }}"
                                type="button"
                                role="tab"
                                aria-controls="{{ $paneId }}"
                                aria-selected="{{ $ariaSelected }}">
                            {{ $details['label'] }}
                            @if (!$isUploaded)
                                <span class="badge bg-secondary ms-1">Missing</span>
                            @endif
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content mt-3" id="documentTabsContent">
                @foreach ($documentMap as $key => $details)
                    @php
                        $isUploaded = $driver->{$details['column']} !== null;
                        $paneId = 'document-' . $key;
                        $isActive = $key === $firstUploadedKey ? 'active show' : '';
                    @endphp
                    <div class="tab-pane fade {{ $isActive }}" id="{{ $paneId }}" role="tabpanel" aria-labelledby="document-{{ $key }}-tab">
                        @if ($isUploaded)
                            <img src="{{ route('drivers.document.show', ['driver' => $driver, 'type' => $key]) }}" class="img-fluid" alt="{{ $details['label'] }}">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="d-flex flex-wrap gap-2 mb-3">
            <a href="{{ route('drivers.export.pdf', $driver) }}" class="btn btn-secondary">Export Dossier as PDF</a>

            @can('manage-drivers')
                @if ($driver->isEditable())
                    <a href="{{ route('drivers.edit', $driver) }}" class="btn btn-warning">Edit Profile</a>
                @endif

                @if($driver->isSubmittable())
                    <form method="POST" action="{{ route('drivers.submit', $driver) }}" class="d-inline-block">
                        @csrf
                        <button type="submit" class="btn btn-info">Submit for Approval</button>
                    </form>
                @endif

                <form method="POST" action="{{ route('drivers.destroy', $driver) }}" onsubmit="return confirm('Are you sure you want to delete this profile?');" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Profile</button>
                </form>
            @endcan

            @can('approve-drivers')
                @if ($driver->isReviewable())
                    <form method="POST" action="{{ route('drivers.approve', $driver) }}" class="d-inline-block">
                        @csrf
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                @endif
            @endcan
        </div>

        @can('approve-drivers')
            @if ($driver->isReviewable())
                <div class="mt-3">
                    <form method="POST" action="{{ route('drivers.reject', $driver) }}">
                        @csrf
                        <div class="mb-2">
                            <label for="rejection_reason" class="form-label"><strong>Reason for Rejection:</strong></label>
                            <textarea name="rejection_reason" id="rejection_reason" rows="3" class="form-control @error('rejection_reason') is-invalid @enderror" required minlength="10">{{ old('rejection_reason') }}</textarea>
                            @error('rejection_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                </div>
            @endif
        @endcan
    </div>
@endsection