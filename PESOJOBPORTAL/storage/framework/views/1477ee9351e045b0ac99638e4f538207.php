<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Link Job Resource Portal</title>

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
                        url("<?php echo e(asset('images/P1so.png')); ?>") center center / min(88vw, 980px) auto no-repeat,
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

        .policy-consent {
            margin-top: 10px;
            padding: 12px 14px;
            border: 1px solid #d7dfeb;
            border-radius: 10px;
            background: #f8fbff;
        }

        .policy-consent .form-check-label {
            font-size: 0.92rem;
            color: #334155;
            line-height: 1.4;
        }

        .policy-consent .form-check-input {
            margin-top: 0.24rem;
        }

        .password-toggle {
            cursor: pointer;
            color: #6b7280;
            font-size: 1.2em;
            padding: 0 8px;
            border-left: 1px solid #e5e7eb;
            background: transparent;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--peso-blue-700);
        }

        @media (max-width: 480px) {
            .register-card {
                border-radius: 14px;
                padding: 20px 16px;
            }

            .password-toggle {
                font-size: 1.1em;
            }
        }
    </style>
</head>
<body>
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId).querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>

    <main class="register-card" aria-label="Registration form">

        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="PESO Logo" class="brand-logo">
        <h1 class="register-title">Create Account</h1>
        <p class="register-subtitle">Join PESO and find your perfect job</p>

        <form action="<?php echo e(route('register')); ?>" method="POST" autocomplete="on">
            <?php echo csrf_field(); ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" placeholder="Enter your full name" value="<?php echo e(old('name')); ?>" autocomplete="name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" placeholder="Enter your email" value="<?php echo e(old('email')); ?>" autocomplete="email" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Register as</label>
                <select class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="role" name="role" autocomplete="off" required>
                    <option value="" disabled <?php echo e(old('role') ? '' : 'selected'); ?>>Select your role</option>
                    <option value="jobseeker" <?php echo e(old('role') === 'jobseeker' ? 'selected' : ''); ?>>Jobseeker</option>
                    <option value="employer" <?php echo e(old('role') === 'employer' ? 'selected' : ''); ?>>Employer</option>
                    <option value="ofw" <?php echo e(old('role') === 'ofw' ? 'selected' : ''); ?>>OFW</option>
                    <option value="association" <?php echo e(old('role') === 'association' ? 'selected' : ''); ?>>Association</option>
                </select>
            </div>

<div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" name="password" placeholder="Create a secure password" autocomplete="new-password" required>
                    <span class="input-group-text password-toggle" id="toggle-password-icon" onclick="togglePasswordVisibility('password', 'toggle-password-icon')">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
            </div>

<div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" autocomplete="new-password" required>
                    <span class="input-group-text password-toggle" id="toggle-password-confirm-icon" onclick="togglePasswordVisibility('password_confirmation', 'toggle-password-confirm-icon')">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="register-button">
                <i class="bi bi-person-plus me-2"></i>Create Account
            </button>

            <a href="<?php echo e(route('home')); ?>" class="home-button mb-3">
                <i class="bi bi-house-door me-2"></i>Back to Home
            </a>
            <div class="policy-consent mb-3">
                <div class="form-check">
                    <input class="form-check-input <?php $__errorArgs = ['policy_consent'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="checkbox" value="1" id="policy_consent" name="policy_consent" <?php echo e(old('policy_consent') ? 'checked' : ''); ?> required>
                    <label class="form-check-label" for="policy_consent">
                        I agree to the
                        <a href="<?php echo e(route('privacy-policy')); ?>" class="link-muted" target="_blank" rel="noopener noreferrer">Privacy Policy</a>
                        and
                        <a href="<?php echo e(route('terms-of-service')); ?>" class="link-muted" target="_blank" rel="noopener noreferrer">Terms of Service</a>.
                    </label>
                    <?php $__errorArgs = ['policy_consent'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback d-block">You must agree to the Privacy Policy and Terms of Service.</div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </form>

        <div class="divider"></div>
        <p class="text-center mb-0 register-foot">
            Already have an account? <a href="<?php echo e(route('login')); ?>" class="link-muted">Login</a>
        </p>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/register.blade.php ENDPATH**/ ?>