@extends('layouts.app')

@section('title', 'Terms of Service | PESO Job Portal')

@push('styles')
<style>
    .tos-page {
        background:
            radial-gradient(circle at top right, rgba(45, 101, 177, 0.1), transparent 36%),
            radial-gradient(circle at bottom left, rgba(215, 38, 56, 0.08), transparent 34%),
            #f6f8fc;
        padding: 36px 0 52px;
    }

    .tos-shell {
        max-width: 920px;
        margin: 0 auto;
    }

    .tos-header {
        background: #ffffff;
        border: 1px solid #e0e8f2;
        border-radius: 16px;
        box-shadow: 0 10px 24px rgba(15, 45, 82, 0.08);
        padding: clamp(18px, 3vw, 28px);
        margin-bottom: 14px;
    }

    .tos-badge {
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

    .tos-header h1 {
        margin: 0;
        font-size: clamp(1.45rem, 3.4vw, 2rem);
        font-weight: 800;
        color: #163355;
    }

    .tos-meta {
        margin: 8px 0 0;
        color: #607083;
        font-size: 0.9rem;
    }

    .tos-content {
        background: #ffffff;
        border: 1px solid #e0e8f2;
        border-radius: 16px;
        box-shadow: 0 12px 26px rgba(15, 45, 82, 0.08);
        padding: clamp(18px, 3vw, 28px);
    }

    .tos-content h2 {
        font-size: 1rem;
        font-weight: 700;
        color: #18385e;
        margin: 1rem 0 0.45rem;
    }

    .tos-content h2:first-of-type {
        margin-top: 0;
    }

    .tos-content p,
    .tos-content li {
        color: #3f4d5d;
        line-height: 1.65;
        font-size: 0.95rem;
    }

    .tos-content ul {
        margin-bottom: 0.6rem;
    }

    .tos-content .notice {
        border: 1px dashed #b1c8e6;
        background: #f8fbff;
        border-radius: 10px;
        padding: 11px 12px;
        margin-top: 12px;
        color: #2a4768;
        font-size: 0.9rem;
    }

    .tos-links {
        margin-top: 14px;
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    .tos-links a {
        color: #2d65b1;
        text-decoration: none;
        font-weight: 600;
    }

    .tos-links a:hover {
        text-decoration: underline;
        color: #224f8a;
    }
</style>
@endpush

@section('content')
<section class="tos-page">
    <div class="container tos-shell">
        <header class="tos-header">
            <span class="tos-badge"><i class="bi bi-file-earmark-text"></i> User Agreement</span>
            <h1>Terms of Service</h1>
            <p class="tos-meta">Last updated: April 21, 2026</p>
        </header>

        <div class="tos-content">
            <p>
                By creating an account and using PESO Job Portal, you agree to these Terms.
                Please read them carefully before using the platform.
            </p>

            <h2>1. Acceptance of Terms</h2>
            <p>
                You agree to follow these Terms and related policies, including the Privacy Policy,
                when you access and use this service.
            </p>

            <h2>2. Account Registration and Security</h2>
            <ul>
                <li>You must provide accurate, complete, and current information during registration.</li>
                <li>You are responsible for protecting your password and limiting access to your account.</li>
                <li>You must promptly report suspected unauthorized access or account misuse.</li>
            </ul>

            <h2>3. Acceptable Use</h2>
            <p>You must not:</p>
            <ul>
                <li>post false, misleading, discriminatory, or unlawful content;</li>
                <li>attempt unauthorized access, probing, or disruption of the platform;</li>
                <li>use automated scripts or tools to scrape or abuse portal data;</li>
                <li>impersonate other users, agencies, or organizations.</li>
            </ul>

            <h2>4. Job Posts and Applications</h2>
            <p>
                Employers and jobseekers are responsible for the legality, accuracy, and completeness
                of their listings, profiles, and submitted materials.
            </p>

            <h2>5. Service Availability</h2>
            <p>
                We may update, pause, or change platform features as needed for maintenance,
                security, legal compliance, or service improvements.
            </p>

            <h2>6. Account Suspension or Termination</h2>
            <p>
                Accounts may be suspended or terminated for violations of these Terms,
                fraudulent behavior, or activities that threaten users, data integrity, or platform security.
            </p>

            <h2>7. Limitation of Liability</h2>
            <p>
                PESO Job Portal facilitates employment connections but does not guarantee
                job placement outcomes, hiring decisions, or uninterrupted service availability.
            </p>

            <h2>8. Updates to These Terms</h2>
            <p>
                We may revise these Terms when needed. Continued use of the portal after updates are posted
                means acceptance of the latest version.
            </p>

            <div class="notice">
                For policy-related concerns, users may contact PESO Manolo Fortich through the official contact channels listed on the portal.
            </div>

            <div class="tos-links">
                <a href="{{ route('privacy-policy') }}">View Privacy Policy</a>
                <a href="{{ route('register') }}">Create Account</a>
                <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </div>
    </div>
</section>
@include('components.footer')
@endsection
