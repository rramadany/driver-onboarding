@extends('layouts.app')

@section('content')
    <h1>Dashboard</h1>
    <strong><p>Your Role: <strong>{{ Auth::user()->role }}</strong></p>
@endsection