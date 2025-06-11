@extends('layouts.app')

@section('content')
    <h1>Edit User: {{ $user->name }}</h1>

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @method('PUT')
        @include('admin.users._form', ['submitButtonText' => 'Update User'])
    </form>
    
    <br>
    <a href="{{ route('admin.users.index') }}">Back to Users List</a>
@endsection