@extends('layouts.app')

@section('content')
    <h1>Create New Driver Profile</h1>

    <form method="POST" action="{{ route('drivers.store') }}" enctype="multipart/form-data">
        @include('drivers._form', ['submitButtonText' => 'Create Profile'])
    </form>

    <div class="mt-3">
        <a href="{{ route('drivers.index') }}" class="btn btn-secondary btn-sm">Back to Drivers List</a>
    </div>
@endsection