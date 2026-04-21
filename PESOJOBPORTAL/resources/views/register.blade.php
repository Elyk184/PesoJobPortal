<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | PESO Job Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <main class="register-card" aria-label="Registration form">
        <img src="{{ asset('images/logo.png') }}" alt="PESO Logo" class="brand-logo">
        <h1 class="register-title">Create Account</h1>
        <p class="register-subtitle">Join PESO and find your perfect job</p>

        <form action="{{ route('register') }}" method="POST" autocomplete="on">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter your full name" value="{{ old('name') }}" autocomplete="name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" autocomplete="email" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Register as</label>
                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" autocomplete="off" required>
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select your role</option>
                    <option value="jobseeker" {{ old('role') === 'jobseeker' ? 'selected' : '' }}>Jobseeker</option>
                    <option value="employer" {{ old('role') === 'employer' ? 'selected' : '' }}>Employer</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Create a secure password" autocomplete="new-password" required>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" autocomplete="new-password" required>
            </div>

            <button type="submit" class="register-button">
                <i class="bi bi-person-plus me-2"></i>Create Account
            </button>

            <a href="{{ route('home') }}" class="home-button mb-3">
                <i class="bi bi-house-door me-2"></i>Back to Home
            </a>
        </form>

        <div class="divider"></div>
        <p class="text-center mb-0 register-foot">
            Already have an account? <a href="{{ route('login') }}" class="link-muted">Login</a>
        </p>
    </main>
</body>
</html>
