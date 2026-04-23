@extends('layouts.app')

@section('title', 'Legal Mandate | Link Job Resource Portal')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
    .mandate-page {
        padding: 2.5rem 0 3.5rem;
        background: linear-gradient(180deg, #f3f6fb 0%, #eef3f9 100%);
    }

    .mandate-hero {
        width: min(1200px, calc(100% - 2rem));
        margin: 0 auto 1.5rem;
        padding: 2rem 1.25rem;
        border-radius: 1rem;
        border: 1px solid #d7e1ee;
        background: linear-gradient(130deg, #0f2d52 0%, #1f4b8f 60%, #2e63af 100%);
        box-shadow: 0 12px 28px rgba(15, 45, 82, 0.16);
        color: #fff;
        text-align: center;
    }

    .mandate-kicker {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        font-size: 0.78rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        font-weight: 700;
        border: 1px solid rgba(255, 255, 255, 0.35);
        background: rgba(255, 255, 255, 0.12);
        color: #ffe08a;
    }

    .mandate-hero h1 {
        margin: 0.8rem 0 0.6rem;
        font-size: clamp(1.7rem, 4.3vw, 2.5rem);
        font-weight: 800;
    }

    .mandate-hero p {
        margin: 0;
        max-width: 760px;
        margin-inline: auto;
        color: rgba(255, 255, 255, 0.9);
    }

    .mandate-grid {
        width: min(1200px, calc(100% - 2rem));
        margin: 0 auto;
        display: grid;
        gap: 1rem;
    }

    .mandate-card {
        background: #fff;
        border: 1px solid #d7e1ee;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 8px 18px rgba(15, 45, 82, 0.07);
    }

    .mandate-card-head {
        padding: 1rem 1.15rem;
        color: #fff;
        background: linear-gradient(90deg, #12345e, #1f4b8f);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
    }

    .mandate-card-head h2 {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 800;
    }

    .mandate-card-head p {
        margin: 0.2rem 0 0;
        font-size: 0.86rem;
        color: rgba(255, 255, 255, 0.84);
    }

    .mandate-card-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.7rem;
        border: 1px solid rgba(255, 255, 255, 0.25);
        background: rgba(255, 255, 255, 0.1);
        display: grid;
        place-items: center;
        flex-shrink: 0;
        font-size: 1.15rem;
        color: #ffd86b;
    }

    .mandate-card-body {
        padding: 1.1rem 1.15rem 1.2rem;
    }

    .mandate-act-text {
        margin: 0 0 1rem;
        padding: 0.9rem 1rem;
        border: 1px solid #d8e7ff;
        border-left: 4px solid #1f4b8f;
        background: #f1f7ff;
        border-radius: 0.75rem;
        font-size: 0.92rem;
        line-height: 1.55;
        color: #0f2d52;
        font-weight: 700;
    }

    .mandate-subtitle {
        margin: 0 0 0.65rem;
        font-size: 0.78rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #c72034;
        font-weight: 700;
    }

    .mandate-points {
        margin: 0;
        padding-left: 1rem;
        display: grid;
        gap: 0.65rem;
    }

    .mandate-points li {
        color: #3f5068;
        line-height: 1.5;
    }

    .mandate-points strong {
        color: #112f56;
    }

    .mandate-meta {
        margin-top: 0.95rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.45rem;
    }

    .mandate-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.34rem 0.65rem;
        border-radius: 999px;
        border: 1px solid #d4deec;
        background: #f8fbff;
        color: #264365;
        font-size: 0.8rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<section class="mandate-page" aria-label="Legal mandate">
    <div class="mandate-hero">
        <div class="mandate-kicker">
            <i class="bi bi-file-earmark-text-fill"></i>
            Public Employment Service Office Legal Basis
        </div>
        <h1>Our Legal Mandate</h1>
        <p>
            These national laws establish and strengthen Public Employment Service Offices nationwide,
            including the local PESO in Manolo Fortich.
        </p>
    </div>

    <div class="mandate-grid">
        <article class="mandate-card">
            <header class="mandate-card-head">
                <div>
                    <h2>Republic Act No. 8759</h2>
                    <p>The PESO Act of 1999 · Signed February 14, 2000</p>
                </div>
                <div class="mandate-card-icon" aria-hidden="true"><i class="bi bi-journal-bookmark-fill"></i></div>
            </header>

            <div class="mandate-card-body">
                <p class="mandate-act-text">
                    AN ACT INSTITUTIONALIZING A NATIONAL FACILITATION SERVICE NETWORK THROUGH THE
                    ESTABLISHMENT OF A PUBLIC EMPLOYMENT SERVICE OFFICE IN EVERY PROVINCE, KEY CITY,
                    AND OTHER STRATEGIC AREAS THROUGHOUT THE COUNTRY.
                </p>

                <p class="mandate-subtitle">Key Provisions</p>
                <ul class="mandate-points">
                    <li><strong>PESO Establishment:</strong> Requires PESO offices in provinces, key cities, and strategic areas.</li>
                    <li><strong>Employment Facilitation:</strong> Provides free job placement support, guidance, and labor market information.</li>
                    <li><strong>National Network:</strong> Links PESO operations with DOLE and related government agencies.</li>
                    <li><strong>LGU Integration:</strong> Embeds employment services within local government systems.</li>
                </ul>

                <div class="mandate-meta">
                    <span class="mandate-chip"><i class="bi bi-calendar-event-fill"></i> Signed: February 14, 2000</span>
                    <span class="mandate-chip"><i class="bi bi-hash"></i> RA 8759</span>
                    <span class="mandate-chip"><i class="bi bi-geo-alt-fill"></i> Nationwide Coverage</span>
                    <span class="mandate-chip"><i class="bi bi-link-45deg"></i> Implementing Agency: DOLE</span>
                </div>
            </div>
        </article>

        <article class="mandate-card">
            <header class="mandate-card-head">
                <div>
                    <h2>Republic Act No. 10691</h2>
                    <p>Amended PESO Act · Signed October 26, 2015</p>
                </div>
                <div class="mandate-card-icon" aria-hidden="true"><i class="bi bi-file-earmark-check-fill"></i></div>
            </header>

            <div class="mandate-card-body">
                <p class="mandate-act-text">
                    AN ACT DEFINING THE ROLE OF DOLE, LGUs, AND ACCREDITED NGOs IN THE ESTABLISHMENT
                    AND OPERATION OF PESO, INCLUDING JOB PLACEMENT OFFICES IN EDUCATIONAL INSTITUTIONS,
                    AMENDING SECTIONS 3, 5, 6, 7, AND 9 OF REPUBLIC ACT NO. 8759.
                </p>

                <p class="mandate-subtitle">Key Amendments</p>
                <ul class="mandate-points">
                    <li><strong>Role Definition:</strong> Clarifies responsibilities of DOLE, LGUs, and accredited NGOs.</li>
                    <li><strong>LGU Funding and Operations:</strong> Requires LGUs to fund and operate PESO offices sustainably.</li>
                    <li><strong>Education Linkage:</strong> Recognizes job placement offices in schools and universities.</li>
                    <li><strong>Technical Support:</strong> Mandates DOLE support for capability-building and integration systems.</li>
                </ul>

                <div class="mandate-meta">
                    <span class="mandate-chip"><i class="bi bi-calendar-event-fill"></i> Signed: October 26, 2015</span>
                    <span class="mandate-chip"><i class="bi bi-hash"></i> RA 10691</span>
                    <span class="mandate-chip"><i class="bi bi-file-earmark-diff-fill"></i> Amends: RA 8759</span>
                    <span class="mandate-chip"><i class="bi bi-link-45deg"></i> Implementers: DOLE and LGUs</span>
                </div>
            </div>
        </article>
    </div>
</section>

@include('components.footer')
@endsection
