@extends('layouts.app')

@section('content')
    <h1>System Audit Log</h1>

    <hr>

    <table class="table table-striped table-hover text-break">
        <thead>
            <tr>
                <th class="w-15">Timestamp</th>
                <th class="w-15">User</th>
                <th class="w-20">Action</th>
                <th class="w-50">Details</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($activities as $activity)
                @php
                    $properties = $activity->properties;
                    $subjectName = $activity->subject->name ?? $properties->get('old.name') ?? $properties->get('attributes.name');
                @endphp
                <tr>
                    <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $activity->causer->name ?? '[Deleted User]' }} <br> {{ 'ID: ' . $activity->causer_id }}</td>
                    <td>{{ $activity->description }}</td>
                    <td>
                        <p>
                            <strong>Subject:</strong>
                            {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                            @if($subjectName) ({{ $subjectName }}) @endif
                        </p>

                        @switch($activity->event)
                            @case('created')
                                <strong>Created Data:</strong>
                                <ul>
                                    @foreach($properties->get('attributes') as $key => $value)
                                        <li><strong>{{$key}}</strong> "{{ $value }}"</li>
                                    @endforeach
                                </ul>
                                @break

                            @case('updated')
                                <strong>Changes:</strong>
                                <ul>
                                    @foreach($properties->get('attributes') as $key => $value)
                                        @php $oldValue = $properties->get('old')[$key] ?? null; @endphp
                                        <li>
                                            <strong>{{$key}}:</strong>
                                            <span style="color: #dc3545; text-decoration: line-through;">"{{ $oldValue }}"</span>
                                            →
                                            <span style="color: #28a745;">"{{ $value }}"</span>
                                        </li>
                                    @endforeach
                                </ul>
                                @break

                            @case('deleted')
                                <strong>Deleted Snapshot:</strong>
                                <ul>
                                    @foreach($properties->get('old') as $key => $value)
                                        @if(in_array($key, ['name', 'email', 'status', 'license_number']))
                                            <li><strong>{{$key}}:</strong> "{{ $value ?? 'N/A' }}"</li>
                                        @endif
                                    @endforeach
                                </ul>
                                @break

                        @endswitch
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No activities logged yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br>

    {{ $activities->links() }}
@endsection