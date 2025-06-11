@csrf
<div>
    <label for="name">Name</label>
    <br>
    <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
</div>
<br>
<div>
    <label for="email">Email</label>
    <br>
    <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
</div>
<br>
<div>
    <label for="role">Role</label>
    <br>
    <select name="role" id="role" required>
        <option value="">-- Select Role --</option>
        <option value="hr" @selected(old('role', $user->role ?? '') == 'hr')>HR</option>
        <option value="supervisor" @selected(old('role', $user->role ?? '') == 'supervisor')>Supervisor</option>
    </select>
</div>
<br>
<div>
    <label for="password">Password</label>
    <br>
    <input type="password" id="password" name="password" @unless(isset($user)) required @endunless>
</div>
<br>
<div>
    <label for="password_confirmation">Confirm Password</label>
    <br>
    <input type="password" id="password_confirmation" name="password_confirmation" @unless(isset($user)) required @endunless>
    @if(isset($user))
    <br>
    <small><i>Leave blank to keep current password.</i></small>
    @endif
</div>
<br>
<div>
    <button type="submit">{{ $submitButtonText ?? 'Submit' }}</button>
</div>