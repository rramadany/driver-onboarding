@extends('layouts.app')

@section('content')
    <h1>Edit Driver Profile: {{ $driver->name }}</h1>

    <form method="POST" action="{{ route('drivers.update', $driver) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('drivers._form', ['submitButtonText' => 'Update Profile'])
    </form>
    
    <div class="mt-3">
        <a href="{{ route('drivers.show', $driver) }}" class="btn btn-secondary btn-sm">Back to Driver Details</a>
    </div>
@endsection