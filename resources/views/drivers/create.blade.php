@extends('layouts.app')

@section('content')
    <h1>Create New Driver Profile</h1>

    <form method="POST" action="{{ route('drivers.store') }}">
        @include('drivers._form', ['submitButtonText' => 'Create Profile'])
    </form>

    <br>
    <a href="{{ route('drivers.index') }}">Back to Drivers List</a>
@endsection