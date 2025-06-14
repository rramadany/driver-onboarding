@extends('layouts.app')

@section('content')

    <h1 class="mb-4">User Management</h1>
    <div class="mb-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">Create New User</a>
    </div>
    <table class="table table-striped table-hover border">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        @if ($user->role !== 'admin')
                        <a href="{{ route('admin.users.edit', $user) }}" class="me-2">Edit</a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:none; border:none; padding:0; color:blue; text-decoration:underline; cursor:pointer;">Delete</button>
                            </form>
                        @endif

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <br>
    
    {{ $users->links() }}
@endsection