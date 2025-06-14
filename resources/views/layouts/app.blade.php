<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Onboarding</title>
    @vite(['resources/js/app.js', 'resources/css/app.css']) 
    <style> /* Simple styles for the dropdown */
        .nav-item { display: inline-block; position: relative; margin-right: 20px; }
        .dropdown-content { display: none; position: absolute; background-color: #f9f9f9; min-width: 300px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1; list-style: none; padding: 0; border: 1px solid #ddd;}
        .dropdown-content li a { color: black; padding: 12px 16px; text-decoration: none; display: block; border-bottom: 1px solid #eee; }
        .dropdown-content li a:hover { background-color: #f1f1f1 }
        .nav-item:hover .dropdown-content { display: block; }
    </style>
</head>
<body>

    <nav>
        <ul>
            <li><a href="{{ route('drivers.index') }}">Drivers</a></li>
            @can('manage-users')
                <li><a href="{{ route('admin.users.index') }}">Manage Users</a></li>
                <li><a href="{{ route('admin.audit-logs.index') }}">Audit Log</a></li>
            @endcan

            <li class="nav-item">
                <a href="#">Notifications
                    @if($unreadNotifications->count() > 0)
                        <strong style="color: red;">({{ $unreadNotifications->count() }})</strong>
                    @endif
                </a>
                <ul class="dropdown-content">
                    @forelse($unreadNotifications->take(10) as $notification)
                        <li>
                            <a href="{{ url($notification->data['url']) }}">
                                <small>{{ $notification->created_at->diffForHumans() }}</small><br>
                                {{ $notification->data['message'] }}
                            </a>
                        </li>
                    @empty
                        <li style="padding: 12px 16px;">No new notifications.</li>
                    @endforelse
                </ul>
            </li>
            <li>
                <span>Welcome, {{ Auth::user()->name }}</span>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </li>
        </ul>
    </nav>

    <hr>

    <main>
        @if (session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div style="color: red;">
                <strong>Whoops! Something went wrong.</strong>
                <ul>
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