@extends('layouts.app')

@section('content')
    <h1 class="mb-4">All Drivers</h1>

    <div class="mb-3">
        <a href="{{ route('reports.drivers.export.xlsx') }}" class="btn btn-secondary btn-sm">Export as XLSX</a>
        <a href="{{ route('reports.drivers.export.csv') }}" class="btn btn-secondary btn-sm me-2">Export as CSV</a>
        @can('manage-drivers')
            <a href="{{ route('drivers.create') }}" class="btn btn-primary btn-sm">Create New Driver</a>
        @endcan
    </div>

    <table class="table table-striped table-hover border">
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
                    <td>
                        @php
                            $badgeClass = 'bg-secondary'; // Default color
                            switch($driver->status) {
                                case 'draft': $badgeClass = 'bg-secondary'; break;
                                case 'pending_approval': $badgeClass = 'bg-warning text-dark'; break; // text-dark for contrast on yellow
                                case 'approved': $badgeClass = 'bg-success'; break;
                                case 'rejected': $badgeClass = 'bg-danger'; break;
                            }
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $driver->status)) }}</span>
                    </td>
                    <td>{{ $driver->createdBy->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('drivers.show', $driver) }}" class="me-2">View</a>
                        @can('manage-drivers')
                            @if ($driver->isEditable())
                                <a href="{{ route('drivers.edit', $driver) }}">Edit</a>
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