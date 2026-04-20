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

        .privacy-consent {
            border: 1px solid #dde5ee;
            border-radius: 10px;
            background: #f7f9fc;
            padding: 12px;
        }

        .privacy-consent .form-check-label {
            color: #243445;
            font-size: 0.93rem;
        }

        .consent-modal .modal-header {
            background: linear-gradient(120deg, #1f4e99, #285db2);
            color: #fff;
            border-bottom: 0;
        }

        .consent-modal .modal-title {
            font-weight: 700;
        }

        .consent-note {
            color: #3a4756;
            line-height: 1.5;
        }

        .consent-list {
            margin: 0;
            padding-left: 18px;
            color: #2f3d4d;
        }

        .consent-list li {
            margin-bottom: 8px;
        }

        @media (max-width: 480px) {
            .register-card {
                border-radius: 14px;
                padding: 20px 16px;
            }
        }
    </style>
</head>
<body data-auto-open-consent="{{ $errors->any() ? '0' : '1' }}">
    <main class="register-card" aria-label="Registration form">
        <img src="{{ asset('images/logo.png') }}" alt="PESO Logo" class="brand-logo">
        <h1 class="register-title">Create Account</h1>
        <p class="register-subtitle">Join PESO and find your perfect job</p>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

<form id="registerForm" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Register as</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="" selected disabled>Select your role</option>
                    <option value="jobseeker" @selected(old('role') === 'jobseeker')>Jobseeker</option>
                    <option value="employer" @selected(old('role') === 'employer')>Employer</option>
                    <option value="admin" @selected(old('role') === 'admin')>Admin</option>
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

            <input type="hidden" id="privacy_consent" name="privacy_consent" value="{{ old('privacy_consent') ? 1 : 0 }}">

            <button type="button" id="openConsentModal" class="register-button" onclick="openPrivacyConsent()">
                <i class="bi bi-person-plus me-2"></i>Create Account
            </button>
        </form>

        <div class="divider"></div>
        <p class="text-center mb-0 register-foot">
            Already have an account? <a href="{{ route('login') }}" class="link-muted">Login</a>
        </p>
    </main>

    <div class="modal fade consent-modal" id="privacyConsentModal" tabindex="-1" aria-labelledby="privacyConsentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="privacyConsentModalLabel">Data Privacy Act Consent</h5>
                    <button type="button" id="consentCloseButton" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="closePrivacyConsent()"></button>
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
                    <button type="button" id="consentCancelButton" class="btn btn-light" data-bs-dismiss="modal" onclick="closePrivacyConsent()">Cancel</button>
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

        window.openPrivacyConsent = openPrivacyConsent;
        window.closePrivacyConsent = closePrivacyConsent;
        window.togglePrivacyConsentButton = togglePrivacyConsentButton;
        window.confirmPrivacyConsent = confirmPrivacyConsent;

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
