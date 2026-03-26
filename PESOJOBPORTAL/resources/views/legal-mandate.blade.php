@extends('layouts.app')

@section('title', 'Legal Mandate – PESO Manolo Fortich')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('css/legal-mandate.css') }}">
@endpush

@section('content')

{{-- ── HERO BANNER ── --}}
<div class="lm-hero">
    <div class="lm-act-badge">
        <i class="bi bi-file-earmark-text-fill"></i>
        Republic Act No. 8759 &nbsp;·&nbsp; February 14, 2000
    </div>
    <div class="lm-hero-seal">
        <i class="bi bi-shield-shaded"></i>
    </div>
    <h1>Our <span>Legal Mandate</span></h1>
    <div class="lm-divider"></div>
    <p>The law that establishes and empowers the Public Employment Service Office (PESO) nationwide, including PESO Manolo Fortich.</p>
</div>

{{-- ── BODY ── --}}
<div class="lm-body">
    <div class="lm-container">

        {{-- ── LAW CARD ── --}}
        <div class="lm-law-card">
            <div class="lm-law-header">
                <div class="lm-law-icon"><i class="bi bi-journal-bookmark-fill"></i></div>
                <div class="lm-law-title">
                    <h2>Republic Act No. 8759</h2>
                    <p>The PESO Act of 1999 &nbsp;·&nbsp; Signed February 14, 2000</p>
                </div>
            </div>

            <div class="lm-law-body">

                {{-- Full official title --}}
                <div class="lm-act-full-title">
                    <i class="bi bi-chevron-double-right me-2" style="color: var(--lm-red-600);"></i>
                    AN ACT INSTITUTIONALIZING A NATIONAL FACILITATION SERVICE NETWORK THROUGH THE ESTABLISHMENT OF A
                    PUBLIC EMPLOYMENT SERVICE OFFICE IN EVERY PROVINCE, KEY CITY AND OTHER STRATEGIC AREAS
                    THROUGHOUT THE COUNTRY
                </div>

                {{-- Key provisions --}}
                <div class="lm-provisions-label">
                    <i class="bi bi-list-check"></i> Key Provisions
                </div>
                <div class="lm-provisions-grid">
                    <div class="lm-provision-card">
                        <div class="lm-provision-icon blue"><i class="bi bi-building-fill"></i></div>
                        <h4>PESO Establishment</h4>
                        <p>Mandates the creation of a PESO in every province, key city, and strategic area across the Philippines.</p>
                    </div>
                    <div class="lm-provision-card">
                        <div class="lm-provision-icon red"><i class="bi bi-people-fill"></i></div>
                        <h4>Employment Facilitation</h4>
                        <p>Provides free job placement assistance, career guidance, and labor market information to all Filipino workers.</p>
                    </div>
                    <div class="lm-provision-card">
                        <div class="lm-provision-icon gold"><i class="bi bi-diagram-3-fill"></i></div>
                        <h4>National Network</h4>
                        <p>Institutionalizes a nationwide facilitation service network linking PESOs with DOLE and other government agencies.</p>
                    </div>
                    <div class="lm-provision-card">
                        <div class="lm-provision-icon blue"><i class="bi bi-person-check-fill"></i></div>
                        <h4>LGU Integration</h4>
                        <p>Embeds PESO within Local Government Units (LGUs), ensuring localized, community-focused employment services.</p>
                    </div>
                    <div class="lm-provision-card">
                        <div class="lm-provision-icon red"><i class="bi bi-bar-chart-fill"></i></div>
                        <h4>Labor Market Info</h4>
                        <p>Collects, processes, and disseminates updated labor market data to guide job seekers and policymakers.</p>
                    </div>
                    <div class="lm-provision-card">
                        <div class="lm-provision-icon gold"><i class="bi bi-award-fill"></i></div>
                        <h4>Skills & Training</h4>
                        <p>Links workers to skills training, scholarship programs, and livelihood opportunities under DOLE-funded initiatives.</p>
                    </div>
                </div>

                {{-- Info pills --}}
                <div class="lm-info-strip">
                    <div class="lm-info-pill"><i class="bi bi-calendar-event-fill"></i> Signed: February 14, 2000</div>
                    <div class="lm-info-pill"><i class="bi bi-hash"></i> Republic Act No. 8759</div>
                    <div class="lm-info-pill"><i class="bi bi-geo-alt-fill"></i> Coverage: Nationwide</div>
                    <div class="lm-info-pill"><i class="bi bi-link-45deg"></i> Implementing Agency: DOLE</div>
                </div>

            </div>
        </div>

        {{-- ── LAW CARD (RA 10691) ── --}}
        <div class="lm-law-card">
            <div class="lm-law-header">
                <div class="lm-law-icon"><i class="bi bi-file-earmark-check-fill"></i></div>
                <div class="lm-law-title">
                    <h2>Republic Act No. 10691</h2>
                    <p>Amended PESO Act &nbsp;·&nbsp; Signed October 26, 2015</p>
                </div>
            </div>

            <div class="lm-law-body">

                {{-- Full official title --}}
                <div class="lm-act-full-title">
                    <i class="bi bi-chevron-double-right me-2" style="color: var(--lm-red-600);"></i>
                    AN ACT DEFINING THE ROLE OF THE DEPARTMENT OF LABOR AND EMPLOYMENT (DOLE), THE LOCAL GOVERNMENT UNITS (LGUs), AND ACCREDITED NONGOVERNMENT ORGANIZATIONS (NGOs) IN THE ESTABLISHMENT AND OPERATION OF THE PUBLIC EMPLOYMENT SERVICE OFFICE (PESO), AND THE OPERATION OF JOB PLACEMENT OFFICES IN EDUCATIONAL INSTITUTIONS (Els), AMENDING FOR THE PURPOSE SECTIONS 3, 5, 6, 7 AND 9 OF REPUBLIC ACT NO. 8759
                </div>

                {{-- Key provisions --}}
                <div class="lm-provisions-label">
                    <i class="bi bi-list-check"></i> Key Amendments & Provisions
                </div>
                <div class="lm-provisions-grid">
                    <div class="lm-provision-card">
                        <div class="lm-provision-icon blue"><i class="bi bi-person-workspace"></i></div>
                        <h4>Role Definition</h4>
                        <p>Clearly defines and solidifies the roles of DOLE, LGUs, and NGOs in the establishment, operation, and maintenance of PESOs.</p>
                    </div>
                    <div class="lm-provision-card">
                        <div class="lm-provision-icon red"><i class="bi bi-bank"></i></div>
                        <h4>LGU Funding & Operations</h4>
                        <p>Mandates LGUs to establish and operate PESOs, ensuring their funding, staffing, and inclusion in the local development plan.</p>
                    </div>
                    <div class="lm-provision-card">
                        <div class="lm-provision-icon gold"><i class="bi bi-mortarboard-fill"></i></div>
                        <h4>Educational Institutions</h4>
                        <p>Authorizes and defines the operation of Job Placement Offices (JPOs) within Higher Education Institutions and State Universities.</p>
                    </div>
                    <div class="lm-provision-card">
                        <div class="lm-provision-icon blue"><i class="bi bi-briefcase-fill"></i></div>
                        <h4>DOLE Support</h4>
                        <p>Requires DOLE to strictly provide technical assistance, training, and integration into the national manpower registry system.</p>
                    </div>
                </div>

                {{-- Info pills --}}
                <div class="lm-info-strip">
                    <div class="lm-info-pill"><i class="bi bi-calendar-event-fill"></i> Signed: October 26, 2015</div>
                    <div class="lm-info-pill"><i class="bi bi-hash"></i> Republic Act No. 10691</div>
                    <div class="lm-info-pill"><i class="bi bi-file-earmark-diff-fill"></i> Amends: RA 8759</div>
                    <div class="lm-info-pill"><i class="bi bi-link-45deg"></i> Implementing Agency: DOLE, LGUs</div>
                </div>

            </div>
        </div>



    </div>
</div>

@include('components.footer')

@endsection
