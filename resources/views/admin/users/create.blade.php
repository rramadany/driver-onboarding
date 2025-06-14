@extends('layouts.app')

@section('content')
    <h1>Create New User</h1>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @include('admin.users._form', ['submitButtonText' => 'Create User'])
    </form>

    <div class="mt-3">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Back to Users List</a>
    </div>
@endsection