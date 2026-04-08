<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | PESO Job Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

        :root {
            --peso-blue-900: #0f2d52;
            --peso-blue-700: #2d65b1;
            --peso-red-600: #d72638;
            --peso-surface: #ffffff;
            --peso-text-muted: #5f6c7a;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: grid;
            place-items: center;
            background: linear-gradient(rgba(246, 248, 252, 0.9), rgba(246, 248, 252, 0.9)),
                        url('{{ asset('images/P1so.png') }}') center center / min(88vw, 980px) auto no-repeat,
                        #f6f8fc;
            position: relative;
            padding: 24px 16px;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background: radial-gradient(circle at top right, rgba(45, 101, 177, 0.12), transparent 45%),
                        radial-gradient(circle at bottom left, rgba(215, 38, 56, 0.1), transparent 45%);
        }

        .register-card {
            width: min(432px, 100%);
            background: var(--peso-surface);
            border: 1px solid rgba(15, 45, 82, 0.08);
            border-radius: 18px;
            box-shadow: 0 12px 28px rgba(15, 45, 82, 0.12);
            padding: clamp(22px, 4vw, 30px);
            position: relative;
            z-index: 1;
        }

        .brand-logo {
            width: 62px;
            height: 62px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 0 auto 10px;
        }

        .register-title {
            margin: 0;
            text-align: center;
            color: #2a5fa7;
            font-weight: 700;
            font-size: clamp(2rem, 4.6vw, 2.5rem);
        }

        .register-subtitle {
            margin: 6px 0 22px;
            text-align: center;
            color: var(--peso-text-muted);
            font-size: 0.95rem;
        }

        .form-label {
            font-weight: 600;
            color: #26313d;
            font-size: 0.95rem;
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 10px 12px;
            border: 1px solid #ccd3dc;
            min-height: 44px;
            font-size: 0.97rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #111827;
            box-shadow: 0 0 0 0.18rem rgba(17, 24, 39, 0.12);
        }

        .register-button {
            width: 100%;
            border: 0;
            border-radius: 8px;
            padding: 12px 16px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(120deg, #2f85c7, #37a0de);
            box-shadow: 0 8px 18px rgba(45, 101, 177, 0.22);
        }

        .register-button:hover {
            filter: brightness(1.05);
        }

        .home-button {
            display: block;
            width: 100%;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            padding: 12px 16px;
            font-weight: 600;
            color: var(--peso-blue-700);
            border: 2px solid var(--peso-blue-700);
            background: transparent;
            font-size: 0.97rem;
            margin: 1rem 0;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .home-button:hover {
            background: var(--peso-blue-700);
            color: #fff;
            box-shadow: 0 8px 20px rgba(45, 101, 177, 0.3);
            transform: translateY(-1px);
        }

        .link-muted {
            color: #3186cc;
            text-decoration: none;
            font-weight: 600;
        }

        .link-muted:hover {
            color: #2268a5;
            text-decoration: underline;
        }

        .divider {
            margin: 14px 0;
            border-top: 1px solid #e4e9ef;
        }

        .register-foot {
            color: #5f6c7a;
            font-size: 0.93rem;
        }

        .register-foot a {
            font-weight: 700;
        }

        @media (max-width: 480px) {
            .register-card {
                border-radius: 14px;
                padding: 20px 16px;
            }
        }
    </style>
</head>
<body>
    <main class="register-card" aria-label="Registration form">
        <img src="{{ asset('images/logo.png') }}" alt="PESO Logo" class="brand-logo">
        <h1 class="register-title">Create Account</h1>
        <p class="register-subtitle">Join PESO and find your perfect job</p>

<form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Register as</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="" selected disabled>Select your role</option>
                    <option value="jobseeker">Jobseeker</option>
                    <option value="employer">Employer</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Create a secure password" required>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
            </div>

            <button type="submit" class="register-button">
                <i class="bi bi-person-plus me-2"></i>Create Account
            </button>

            <a href="/" class="home-button mb-3">
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
