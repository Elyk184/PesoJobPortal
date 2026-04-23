@extends('layouts.app')

@section('title', 'Privacy Policy | PESO Job Portal')

@push('styles')
<style>
    .pp-page {
        background:
            radial-gradient(circle at top right, rgba(45, 101, 177, 0.1), transparent 36%),
            radial-gradient(circle at bottom left, rgba(215, 38, 56, 0.08), transparent 34%),
            #f6f8fc;
        padding: 36px 0 52px;
    }

    .pp-shell {
        max-width: 920px;
        margin: 0 auto;
    }

    .pp-header {
        background: #ffffff;
        border: 1px solid #e0e8f2;
        border-radius: 16px;
        padding: clamp(18px, 3vw, 28px);
        box-shadow: 0 10px 24px rgba(15, 45, 82, 0.08);
        margin-bottom: 14px;
    }

    .pp-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.83rem;
        font-weight: 600;
        color: #2d65b1;
        background: #edf4ff;
        border: 1px solid #d5e5fb;
        border-radius: 999px;
        padding: 5px 10px;
        margin-bottom: 10px;
    }

    .pp-header h1 {
        margin: 0;
        font-size: clamp(1.45rem, 3.4vw, 2rem);
        font-weight: 800;
        color: #163355;
    }

    .pp-meta {
        margin: 8px 0 0;
        color: #607083;
        font-size: 0.9rem;
    }

    .pp-card {
        background: #ffffff;
        border: 1px solid #e0e8f2;
        border-radius: 16px;
        box-shadow: 0 12px 26px rgba(15, 45, 82, 0.08);
        padding: clamp(18px, 3vw, 30px);
    }

    .pp-card h2 {
        font-size: 1rem;
        font-weight: 700;
        color: #18385e;
        margin: 1rem 0 0.45rem;
    }

    .pp-card h2:first-of-type {
        margin-top: 0;
    }

    .pp-card p,
    .pp-card li {
        color: #3f4d5d;
        font-size: 0.95rem;
        line-height: 1.65;
    }

    .pp-card ul {
        margin-bottom: 0.6rem;
    }

    .pp-note {
        margin-top: 12px;
        background: #f8fbff;
        border: 1px dashed #b1c8e6;
        border-radius: 10px;
        padding: 11px 12px;
        color: #2a4768;
        font-size: 0.9rem;
    }

    .pp-links {
        margin-top: 14px;
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    .pp-links a {
        color: #2d65b1;
        text-decoration: none;
        font-weight: 600;
    }

    .pp-links a:hover {
        text-decoration: underline;
        color: #224f8a;
    }
</style>
@endpush

@section('content')
<section class="pp-page">
    <div class="container pp-shell">
        <header class="pp-header">
            <span class="pp-badge"><i class="bi bi-shield-lock"></i> Data Privacy Notice</span>
            <h1>Privacy Policy</h1>
            <p class="pp-meta">Last updated: April 21, 2026</p>
        </header>

        <article class="pp-card">
            <p>
                PESO Job Portal values your privacy. This policy explains, in simple terms,
                what information we collect, how we use it, and how we protect it.
            </p>

            <h2>1. Information We Collect</h2>
            <ul>
                <li>Account information such as name, email address, and selected role.</li>
                <li>Profile and application details you submit through the portal.</li>
                <li>Basic usage data needed for security and service improvement.</li>
            </ul>

            <h2>2. How We Use Your Information</h2>
            <ul>
                <li>To create and manage your account.</li>
                <li>To connect jobseekers and employers through portal features.</li>
                <li>To maintain platform security, reliability, and support.</li>
            </ul>

            <h2>3. Information Sharing</h2>
            <p>
                We do not sell your personal data. Information is shared only when needed for
                service operations, legal compliance, or when you provide consent.
            </p>

            <h2>4. Data Security</h2>
            <p>
                We apply reasonable administrative and technical safeguards to protect
                personal data from unauthorized access, disclosure, or misuse.
            </p>

            <h2>5. Your Rights</h2>
            <p>
                You may request to review or correct your account details through official PESO channels.
            </p>

            <h2>6. Policy Updates</h2>
            <p>
                We may revise this Privacy Policy when needed. Updates take effect once published on this page.
            </p>

            <div class="pp-note">
                For privacy concerns, please contact PESO Manolo Fortich through the contact information provided on the portal.
            </div>

            <div class="pp-links">
                <a href="{{ route('terms-of-service') }}">View Terms of Service</a>
                <a href="{{ route('register') }}">Create Account</a>
                <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </div>
    </div>
</section>
@include('components.footer')
@endsection
