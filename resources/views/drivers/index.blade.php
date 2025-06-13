@extends('layouts.app')

@section('content')
    <h1>All Drivers</h1>

    <a href="{{ route('reports.drivers.export.xlsx') }}">Export as XLSX</a>
    | <a href="{{ route('reports.drivers.export.csv') }}">Export as CSV</a>
    @can('manage-drivers')
    | <a href="{{ route('drivers.create') }}">Create New Driver</a>
    @endcan

    <hr>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($drivers as $driver)
                <tr>
                    <td>{{ $driver->id }}</td>
                    <td>{{ $driver->name }}</td>
                    <td>{{ $driver->email }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $driver->status)) }}</td>
                    <td>{{ $driver->createdBy->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('drivers.show', $driver) }}">View</a>
                        
                        @can('manage-drivers')
                            @if ($driver->isEditable())
                                | <a href="{{ route('drivers.edit', $driver) }}">Edit</a>
                            @endif
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No drivers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <br>
    
    {{ $drivers->links() }}
@endsection