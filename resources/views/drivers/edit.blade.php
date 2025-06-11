@extends('layouts.app')

@section('content')
    <h1>Edit Driver Profile: {{ $driver->name }}</h1>

    <form method="POST" action="{{ route('drivers.update', $driver) }}">
        @method('PUT')
        @include('drivers._form', ['submitButtonText' => 'Update Profile'])
    </form>
    
    <br>
    <a href="{{ route('drivers.show', $driver) }}">Back to Driver Details</a>
@endsection