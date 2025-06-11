@extends('layouts.app')

@section('content')
    <h1>Create New User</h1>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @include('admin.users._form', ['submitButtonText' => 'Create User'])
    </form>

    <br>
    <a href="{{ route('admin.users.index') }}">Back to Users List</a>
@endsection