@extends('layouts.app')

@section('content')
    <h1>Edit User: {{ $user->name }}</h1>

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @method('PUT')
        @include('admin.users._form', ['submitButtonText' => 'Update User'])
    </form>
    
    <div class="mt-3">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Back to Users List</a>
    </div>
@endsection