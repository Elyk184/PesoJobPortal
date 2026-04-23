<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
                        url("{{ asset('images/P1so.png') }}") center center / min(88vw, 980px) auto no-repeat,
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
                <select class="form-select" id="role" name="role" required>
                    <option value="" selected disabled>Select your role</option>
                    <option value="jobseeker">Jobseeker</option>
                    <option value="employer">Employer</option>
                </select>
            </div>

<div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Create a secure password" autocomplete="new-password" required>
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

            <input type="hidden" id="privacy_consent" name="privacy_consent" value="{{ old('privacy_consent') ? 1 : 0 }}">

            <button type="button" id="openConsentModal" class="register-button" onclick="openPrivacyConsent()">
                <i class="bi bi-person-plus me-2"></i>Create Account
            </button>

            <a href="/" class="home-button mb-3">
                <i class="bi bi-house-door me-2"></i>Back to Home
            </a>

            <div class="policy-consent mb-3">
                <div class="form-check">
                    <input class="form-check-input @error('policy_consent') is-invalid @enderror" type="checkbox" value="1" id="policy_consent" name="policy_consent" {{ old('policy_consent') ? 'checked' : '' }} required>
                    <label class="form-check-label" for="policy_consent">
                        I agree to the
                        <a href="{{ route('privacy-policy') }}" class="link-muted" target="_blank" rel="noopener noreferrer">Privacy Policy</a>
                        and
                        <a href="{{ route('terms-of-service') }}" class="link-muted" target="_blank" rel="noopener noreferrer">Terms of Service</a>.
                    </label>
                    @error('policy_consent')
                        <div class="invalid-feedback d-block">You must agree to the Privacy Policy and Terms of Service.</div>
                    @enderror
                </div>
            </div>
        </form>

        <div class="divider"></div>
        <p class="text-center mb-0 register-foot">
            Already have an account? <a href="{{ route('login') }}" class="link-muted">Login</a>
        </p>
    </main>

    <div class="modal fade consent-modal" id="privacyConsentModal" tabindex="-1" aria-labelledby="privacyConsentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="privacyConsentModalLabel">Data Privacy Act Consent</h5>
                </div>
                <div class="modal-body">
                    <p class="consent-note">
                        In accordance with the
                        <a href="https://privacy.gov.ph/data-privacy-act/" target="_blank" rel="noopener noreferrer">Data Privacy Act of 2012 (RA 10173)</a>,
                        PESO Manolo Fortich protects your personal information and uses it only for legitimate PESO services.
                    </p>
                    <p class="fw-semibold mb-2">By clicking Proceed, you agree that:</p>
                    <ul class="consent-list">
                        <li>Your registration data will be collected for account creation and employment service delivery.</li>
                        <li>Your data will be securely stored and accessed only by authorized personnel.</li>
                        <li>Your information will not be shared without consent, unless required by law.</li>
                    </ul>
                    <div class="privacy-consent mt-3">
                        <div class="form-check m-0">
                            <input class="form-check-input" type="checkbox" id="privacyConsentCheck" onchange="togglePrivacyConsentButton()">
                            <label class="form-check-label" for="privacyConsentCheck">
                                I have read and agree to the PESO Data Privacy Policy.
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="consentCancelButton" class="btn btn-light" onclick="cancelPrivacyConsent()">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmConsent" onclick="confirmPrivacyConsent()" disabled>Proceed to Registration</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        window.__privacyBackdrop = null;
        window.__privacyConsentAccepted = false;

        function getConsentElements() {
            return {
                form: document.getElementById('registerForm'),
                hiddenConsent: document.getElementById('privacy_consent'),
                consentCheck: document.getElementById('privacyConsentCheck'),
                confirmButton: document.getElementById('confirmConsent'),
                modalElement: document.getElementById('privacyConsentModal')
            };
        }

        function showModalFallback(modalElement) {
            modalElement.style.display = 'block';
            modalElement.classList.add('show');
            modalElement.removeAttribute('aria-hidden');
            modalElement.setAttribute('aria-modal', 'true');
            document.body.classList.add('modal-open');

            window.__privacyBackdrop = document.createElement('div');
            window.__privacyBackdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(window.__privacyBackdrop);
        }

        function hideModalFallback(modalElement) {
            modalElement.classList.remove('show');
            modalElement.style.display = 'none';
            modalElement.setAttribute('aria-hidden', 'true');
            modalElement.removeAttribute('aria-modal');
            document.body.classList.remove('modal-open');

            if (window.__privacyBackdrop) {
                window.__privacyBackdrop.remove();
                window.__privacyBackdrop = null;
            }
        }

        function openPrivacyConsent() {
            const { hiddenConsent, consentCheck, confirmButton, modalElement } = getConsentElements();
            if (!hiddenConsent || !consentCheck || !confirmButton || !modalElement) {
                return;
            }

            if (!window.__privacyConsentAccepted) {
                hiddenConsent.value = '0';
                consentCheck.checked = false;
            } else {
                hiddenConsent.value = '1';
                consentCheck.checked = true;
            }

            confirmButton.disabled = true;
            togglePrivacyConsentButton();

            if (window.bootstrap && window.bootstrap.Modal) {
                const modal = window.bootstrap.Modal.getOrCreateInstance(modalElement);
                modal.show();
                return;
            }

            showModalFallback(modalElement);
        }

        function closePrivacyConsent() {
            const { modalElement } = getConsentElements();
            if (!modalElement) {
                return;
            }

            if (window.bootstrap && window.bootstrap.Modal) {
                const modal = window.bootstrap.Modal.getOrCreateInstance(modalElement);
                modal.hide();
                return;
            }

            hideModalFallback(modalElement);
        }

        function togglePrivacyConsentButton() {
            const { consentCheck, confirmButton } = getConsentElements();
            if (!consentCheck || !confirmButton) {
                return;
            }

            confirmButton.disabled = !consentCheck.checked;
        }

        function confirmPrivacyConsent() {
            const { form, hiddenConsent, consentCheck } = getConsentElements();
            if (!form || !hiddenConsent || !consentCheck) {
                return;
            }

            if (!consentCheck.checked) {
                return;
            }

            window.__privacyConsentAccepted = true;
            hiddenConsent.value = '1';
            closePrivacyConsent();

            if (typeof form.requestSubmit === 'function') {
                form.requestSubmit();
                return;
            }

            if (form.reportValidity()) {
                form.submit();
            }
        }

        function cancelPrivacyConsent() {
            window.location.href = "{{ url('/') }}";
        }

        window.openPrivacyConsent = openPrivacyConsent;
        window.closePrivacyConsent = closePrivacyConsent;
        window.togglePrivacyConsentButton = togglePrivacyConsentButton;
        window.confirmPrivacyConsent = confirmPrivacyConsent;
        window.cancelPrivacyConsent = cancelPrivacyConsent;

        document.addEventListener('DOMContentLoaded', function () {
            const { form, hiddenConsent } = getConsentElements();
            if (!form || !hiddenConsent) {
                return;
            }

            window.__privacyConsentAccepted = hiddenConsent.value === '1';
            const shouldAutoOpenConsent = document.body.dataset.autoOpenConsent === '1';

            form.addEventListener('submit', function (event) {
                if (hiddenConsent.value === '1') {
                    return;
                }

                event.preventDefault();
                openPrivacyConsent();
            });

            if (shouldAutoOpenConsent && hiddenConsent.value !== '1') {
                openPrivacyConsent();
            }
        });
    </script>
</body>
</html>
