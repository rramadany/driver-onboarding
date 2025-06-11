@csrf
<div>
    <label for="name">Name</label>
    <br>
    <input type="text" id="name" name="name" value="{{ old('name', $driver->name ?? '') }}">
</div>
<br>
<div>
    <label for="email">Email</label>
    <br>
    <input type="email" id="email" name="email" value="{{ old('email', $driver->email ?? '') }}">
</div>
<br>
<div>
    <label for="phone_number">Phone Number</label>
    <br>
    <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $driver->phone_number ?? '') }}">
</div>
<br>
<div>
    <label for="license_number">License Number</label>
    <br>
    <input type="text" id="license_number" name="license_number" value="{{ old('license_number', $driver->license_number ?? '') }}">
</div>
<br>
<div>
    <label for="license_expiry_date">License Expiry Date</label>
    <br>
    <input type="date" id="license_expiry_date" name="license_expiry_date" value="{{ old('license_expiry_date', isset($driver->license_expiry_date) ? $driver->license_expiry_date->format('Y-m-d') : '') }}">
</div>
<br>
<div>
    <label for="photo">Driver Photo</label>
    <br>
    <input type="file" id="photo" name="photo">
</div>
<br>
<div>
    <button type="submit">{{ $submitButtonText ?? 'Submit' }}</button>
</div>