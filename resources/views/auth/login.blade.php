<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <div class="container mt-5"> 
        <div class="row justify-content-center"> {{-- Use grid to center the card --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body"> 
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus> {{-- form-control for styling, is-invalid class if there's an error --}}
                                @error('email')
                                    <div class="invalid-feedback"> {{-- Bootstrap for displaying validation errors --}}
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            </div>

                            <div class="mb-3 form-check"> 
                                <input id="remember_me" type="checkbox" name="remember" class="form-check-input"> 
                                <label for="remember_me" class="form-check-label">Remember me</label>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary">
                                    Log in
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>