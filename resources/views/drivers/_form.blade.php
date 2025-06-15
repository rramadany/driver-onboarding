@csrf

<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" id="name" name="name" value="{{ old('name', $driver->name ?? '') }}" class="form-control @error('name') is-invalid @enderror">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" name="email" value="{{ old('email', $driver->email ?? '') }}" class="form-control @error('email') is-invalid @enderror">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="phone_number" class="form-label">Phone Number</label>
    <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $driver->phone_number ?? '') }}" class="form-control @error('phone_number') is-invalid @enderror">
    @error('phone_number')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="license_number" class="form-label">License Number</label>
    <input type="text" id="license_number" name="license_number" value="{{ old('license_number', $driver->license_number ?? '') }}" class="form-control @error('license_number') is-invalid @enderror">
    @error('license_number')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="license_expiry_date" class="form-label">License Expiry Date</label>
    <input type="date" id="license_expiry_date" name="license_expiry_date" value="{{ old('license_expiry_date', isset($driver->license_expiry_date) ? $driver->license_expiry_date->format('Y-m-d') : '') }}" class="form-control @error('license_expiry_date') is-invalid @enderror">
     @error('license_expiry_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@foreach ($documentMap as $key => $details)
    <div class="mb-3">
        <label for="{{ $key }}" class="form-label">{{ $details['label'] }}</label>
        @if (isset($driver))
            @if ($driver->{$details['column']})
                <div class="mb-2">
                    <a href="{{ route('drivers.document.show', ['driver' => $driver, 'type' => $key]) }}" target="_blank" class="btn btn-secondary btn-sm">View Current File</a>
                </div>
            @else
                <div class="mb-2">
                    <small class="text-muted">No file uploaded.</small>
                </div>
            @endif
        @endif
        <input type="file" id="{{ $key }}" name="{{ $key }}" class="form-control @error($key) is-invalid @enderror">
        @error($key)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
@endforeach

<div class="mt-4">
    <button type="submit" class="btn btn-primary">{{ $submitButtonText ?? 'Submit' }}</button>
</div>