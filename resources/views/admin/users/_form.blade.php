@csrf

<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control @error('email') is-invalid @enderror" required>
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="role" class="form-label">Role</label>
    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
        <option value="">-- Select Role --</option>
        <option value="hr" @selected(old('role', $user->role ?? '') == 'hr')>HR</option>
        <option value="supervisor" @selected(old('role', $user->role ?? '') == 'supervisor')>Supervisor</option>
    </select>
    @error('role')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" @unless(isset($user)) required @endunless>
    @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" @unless(isset($user)) required @endunless>
    @error('password_confirmation')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(isset($user))
        <small class="form-text text-muted"><i>Leave blank to keep current password.</i></small>
    @endif
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">{{ $submitButtonText ?? 'Submit' }}</button>
</div>