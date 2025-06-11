<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Onboarding</title>
</head>
<body>

    <nav>
        <ul>
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('drivers.index') }}">Drivers</a></li>
            @can('manage-users')
                <li><a href="{{ route('admin.users.index') }}">Manage Users</a></li>
            @endcan


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