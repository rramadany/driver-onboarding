<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Onboarding</title>
    @vite(['resources/js/app.js', 'resources/css/app.css']) 
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">

            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('drivers.index') }}">Drivers</a>
                    </li>
                    @can('manage-users')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users.index') }}">Manage Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.audit-logs.index') }}">Audit Log</a>
                        </li>
                    @endcan
                </ul>

                {{-- Right-aligned items --}}
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Notifications
                            @if($unreadNotifications->count() > 0)
                                <span class="badge bg-danger rounded-pill">{{ $unreadNotifications->count() }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            @forelse($unreadNotifications->take(10) as $notification)
                                <li>
                                    <a class="dropdown-item" href="{{ url($notification->data['url']) }}">
                                        <small>{{ $notification->created_at->diffForHumans() }}</small><br>
                                        {{ $notification->data['message'] }}
                                    </a>
                                </li>
                            @empty
                                <li><span class="dropdown-item">No new notifications.</span></li>
                            @endforelse
                        </ul>
                    </li>

                    <li class="nav-item">
                        <span class="nav-link disabled">{{ Auth::user()->name }}</span>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-flex">
                            @csrf
                            <button class="btn btn-link nav-link" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <main class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Whoops! Something went wrong.</h4>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>