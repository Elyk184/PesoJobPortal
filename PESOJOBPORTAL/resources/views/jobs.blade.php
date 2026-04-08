<!DOCTYPE html>
@extends('layouts.app')

@section('title', 'Job Opportunities - PESO Job Portal')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

body{
    font-family:'Poppins',sans-serif;
    background:#f3f5f8;
    color:#1f2937;
}

/* HERO */
.jobs-hero{
    background:#26499a;
    color:#fff;
    padding:48px 20px 50px;
    position:relative;
}
.jobs-hero .lang-btn{
    position:absolute;
    top:16px;
    right:16px;
    width:38px;
    height:38px;
    border-radius:50%;
    border:2px solid rgba(255,255,255,.6);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    text-decoration:none;
    font-size:18px;
}
.jobs-hero h1{
    font-weight:800;
    font-size:52px;
    margin-bottom:8px;
}
.jobs-hero p{
    max-width:760px;
    margin:0 auto 18px;
    opacity:.95;
}
.hero-actions .btn{
    border-radius:6px;
    font-weight:600;
    padding:8px 16px;
}
.btn-jobseeker{
    background:#f4b400;
    color:#111827;
    border:1px solid #e5a800;
}
.btn-jobseeker:hover{ background:#e3a800; color:#111827; }
.btn-login{
    background:transparent;
    color:#fff;
    border:1px solid rgba(255,255,255,.7);
}
.btn-login:hover{
    background:rgba(255,255,255,.12);
    color:#fff;
}

/* FILTER BAR */
.filter-wrap{
    background:#e6e8ec;
    margin-top:18px;
    padding:16px 12px;
    border:1px solid #d8dbe1;
}
.filter-wrap label{
    font-size:12px;
    font-weight:500;
    margin-bottom:4px;
    color:#374151;
}
.filter-wrap .form-control,
.filter-wrap .form-select{
    height:38px;
    font-size:13px;
}
.filter-wrap .filter-btn{
    width:100%;
    height:38px;
    background:#1e6ef0;
    border:none;
    color:#fff;
    font-weight:600;
    border-radius:4px;
}
.filter-wrap .filter-btn:hover{ background:#145fda; }

/* STATS */
.stats-row{
    margin-top:22px;
}
.stat-card{
    border-radius:4px;
    color:#fff;
    text-align:center;
    padding:18px 12px 10px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}
.stat-card .icon{
    font-size:30px;
    line-height:1;
    margin-bottom:8px;
}
.stat-card .value{
    font-size:31px;
    font-weight:700;
    margin-bottom:2px;
}
.stat-card .label{
    font-size:14px;
    font-weight:600;
}
.stat-card .sub{
    font-size:12px;
    opacity:.95;
}
.stat-blue{ background:#1f70eb; }
.stat-green{ background:#1c8b54; }
.stat-cyan{ background:#1fbad6; }
.stat-yellow{ background:#f2b705; color:#fff; }

/* TABLE */
.jobs-table-wrap{
    margin-top:10px;
    border:1px solid #1f2937;
    overflow:auto;
    background:#fff;
}
.jobs-table{
    width:100%;
    min-width:1280px;
    border-collapse:collapse;
    font-size:15px;
}
.jobs-table thead th{
    background:#1f2430;
    color:#fff;
    padding:12px 10px;
    text-align:left;
    font-weight:600;
    border-right:1px solid #3b4352;
    white-space:nowrap;
}
.jobs-table tbody td{
    padding:12px 10px;
    border-top:1px solid #2f3442;
    vertical-align:top;
}
.jobs-table .job-title{
    font-weight:700;
    margin-bottom:2px;
}
.jobs-table .job-snippet{
    color:#4b5563;
    font-size:12px;
}
.badge-type{
    background:#5b6e87;
    color:#fff;
    border-radius:4px;
    padding:2px 8px;
    font-size:11px;
    text-transform:lowercase;
}
.badge-open{
    background:#10b981;
    color:#fff;
    border-radius:4px;
    font-size:11px;
    padding:2px 6px;
    font-weight:600;
}
.badge-app{
    background:#2563eb;
    color:#fff;
    border-radius:10px;
    font-size:11px;
    padding:1px 7px;
    display:inline-block;
    font-weight:600;
}
.deadline{
    color:#e11d48;
    font-weight:700;
}
.apply-btn{
    border:1px solid #f4b400;
    color:#f4b400;
    background:#fff;
    border-radius:4px;
    font-size:12px;
    padding:5px 8px;
    line-height:1.2;
    display:inline-flex;
    align-items:center;
    gap:4px;
}
.apply-btn:hover{
    background:#fff8e5;
    color:#e5a700;
}

.page-wrap{
    max-width:1320px;
    margin:0 auto;
    padding:0 10px 35px;
}

@media (max-width: 768px){
    .jobs-hero h1{ font-size:36px; }
}
</style>
@endpush

@section('content')
<section class="jobs-hero text-center">
    <a href="#" class="lang-btn" aria-label="Language"><i class="bi bi-translate"></i></a>
    <div class="container">
        <h1><i class="bi bi-briefcase me-2"></i> Job Opportunities</h1>
        <p>Discover exciting career opportunities in Manolo Fortich and surrounding areas. Verified jobs posted by approved employers.</p>
        <div class="hero-actions d-flex justify-content-center gap-2 flex-wrap">
            <a href="{{ route('register') }}" class="btn btn-jobseeker"><i class="bi bi-person-plus me-1"></i> Register as Jobseeker</a>
            <a href="{{ route('login') }}" class="btn btn-login"><i class="bi bi-box-arrow-in-right me-1"></i> Login</a>
        </div>
    </div>
</section>

<div class="page-wrap">
    <div class="filter-wrap">
        <form method="GET" action="{{ url()->current() }}">
            <div class="row g-2 align-items-end">
                <div class="col-lg-4 col-md-6">
                    <label>Keyword</label>
                    <input type="text" name="keyword" value="{{ $keyword ?? request('keyword') }}" class="form-control" placeholder="Job title, company...">
                </div>
                <div class="col-lg-3 col-md-6">
                    <label>Location</label>
                    <input type="text" name="location" value="{{ $location ?? request('location') }}" class="form-control" placeholder="e.g. Manolo Fortich">
                </div>
                <div class="col-lg-3 col-md-6">
                    <label>Employment Type</label>
                    <select name="employment_type" class="form-select">
                        <option value="all" {{ (($employmentType ?? request('employment_type', 'all')) === 'all') ? 'selected' : '' }}>All Types</option>
                        <option value="full time" {{ (($employmentType ?? request('employment_type')) === 'full time') ? 'selected' : '' }}>Full time</option>
                        <option value="part time" {{ (($employmentType ?? request('employment_type')) === 'part time') ? 'selected' : '' }}>Part time</option>
                        <option value="contract" {{ (($employmentType ?? request('employment_type')) === 'contract') ? 'selected' : '' }}>Contract</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <button type="submit" class="filter-btn"><i class="bi bi-search me-1"></i> Filter Jobs</button>
                </div>
            </div>
        </form>
    </div>

    <div class="row g-3 stats-row">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-blue">
                <div class="icon"><i class="bi bi-briefcase"></i></div>
                <div class="value">5</div>
                <div class="label">Active Jobs</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-green">
                <div class="icon"><i class="bi bi-eye"></i></div>
                <div class="value">1</div>
                <div class="label">Total Views</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-cyan">
                <div class="icon"><i class="bi bi-people"></i></div>
                <div class="value">4</div>
                <div class="label">Total Applications</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-yellow">
                <div class="icon"><i class="bi bi-calendar-check"></i></div>
                <div class="value" style="font-size:30px;">Updated Daily</div>
                <div class="sub">Fresh Listings</div>
            </div>
        </div>
    </div>

    <div class="jobs-table-wrap">
        <table class="jobs-table">
            <thead>
                <tr>
                    <th style="width:33%">Job Title</th>
                    <th style="width:12%">Company</th>
                    <th style="width:16%">Location</th>
                    <th style="width:7%">Type</th>
                    <th style="width:9%">Salary</th>
                    <th style="width:5%">Vacancies</th>
                    <th style="width:5%">Status</th>
                    <th style="width:6%">Applications</th>
                    <th style="width:8%">Deadline</th>
                    <th style="width:6%">Posted</th>
                    <th style="width:8%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="job-title">Senior Software Developer</div>
                        <div class="job-snippet">NexaCore Solutions Inc. is seeking an experienced Senior Software Developer to lead the design, deve...</div>
                    </td>
                    <td><strong>NexaCore Solutions Inc.</strong></td>
                    <td><i class="bi bi-geo-alt"></i> Cagayan de Oro City (On-site / Hybrid)</td>
                    <td><span class="badge-type">full time</span></td>
                    <td><strong>₱45,000 - ₱65,000</strong></td>
                    <td>8</td>
                    <td><span class="badge-open">Open</span></td>
                    <td><span class="badge-app">1</span></td>
                    <td class="deadline">Jun 04, 2026</td>
                    <td>1 week ago</td>
                    <td><a href="{{ route('login') }}" class="apply-btn"><i class="bi bi-box-arrow-in-right"></i> Login to Apply</a></td>
                </tr>

                <tr>
                    <td>
                        <div class="job-title">Creative Pixel Studio</div>
                        <div class="job-snippet">Creative Pixel Studio is looking for a talented Graphic Designer who can create visually appealing d...</div>
                    </td>
                    <td><strong>NexaCore Solutions Inc.</strong></td>
                    <td><i class="bi bi-geo-alt"></i> Cagayan de Oro City (On-site / Hybrid)</td>
                    <td><span class="badge-type">full time</span></td>
                    <td><strong>₱18,000 - ₱25,000</strong></td>
                    <td>1</td>
                    <td><span class="badge-open">Open</span></td>
                    <td><span class="badge-app">0</span></td>
                    <td class="deadline">May 29, 2026</td>
                    <td>2 weeks ago</td>
                    <td><a href="{{ route('login') }}" class="apply-btn"><i class="bi bi-box-arrow-in-right"></i> Login to Apply</a></td>
                </tr>

                <tr>
                    <td>
                        <div class="job-title">IT Support Specialist</div>
                        <div class="job-snippet">NexaTech IT Solutions is seeking an IT Support Specialist to assist with maintaining company compute...</div>
                    </td>
                    <td><strong>NexaCore Solutions Inc.</strong></td>
                    <td><i class="bi bi-geo-alt"></i> Cagayan de Oro City (On-site / Hybrid)</td>
                    <td><span class="badge-type">full time</span></td>
                    <td><strong>₱16,000 - ₱22,000</strong></td>
                    <td>3</td>
                    <td><span class="badge-open">Open</span></td>
                    <td><span class="badge-app">1</span></td>
                    <td class="deadline">May 08, 2026</td>
                    <td>2 weeks ago</td>
                    <td><a href="{{ route('login') }}" class="apply-btn"><i class="bi bi-box-arrow-in-right"></i> Login to Apply</a></td>
                </tr>

                <tr>
                    <td>
                        <div class="job-title">Junior Web Developer</div>
                        <div class="job-snippet">NexaCore Solutions Inc. is looking for a motivated and detail-oriented Junior Web Developer to join...</div>
                    </td>
                    <td><strong>NexaCore Solutions Inc.</strong></td>
                    <td><i class="bi bi-geo-alt"></i> Cagayan de Oro City (On-site / Hybrid)</td>
                    <td><span class="badge-type">full time</span></td>
                    <td><strong>₱18,000 - ₱28,000</strong></td>
                    <td>1</td>
                    <td><span class="badge-open">Open</span></td>
                    <td><span class="badge-app">1</span></td>
                    <td class="deadline">Apr 07, 2026</td>
                    <td>2 weeks ago</td>
                    <td><a href="{{ route('login') }}" class="apply-btn"><i class="bi bi-box-arrow-in-right"></i> Login to Apply</a></td>
                </tr>

                <tr>
                    <td>
                        <div class="job-title">Senior Database Administrator</div>
                        <div class="job-snippet">NexaCore Solutions Inc. is seeking a Senior Database Administrator to assist in managing and maintai...</div>
                    </td>
                    <td><strong>NexaCore Solutions Inc.</strong></td>
                    <td><i class="bi bi-geo-alt"></i> Cagayan de Oro City (On-site / Hybrid)</td>
                    <td><span class="badge-type">full time</span></td>
                    <td><strong>₱18,000 - ₱22,000</strong></td>
                    <td>1</td>
                    <td><span class="badge-open">Open</span></td>
                    <td><span class="badge-app">1</span></td>
                    <td class="deadline">Jul 09, 2026</td>
                    <td>2 weeks ago</td>
                    <td><a href="{{ route('login') }}" class="apply-btn"><i class="bi bi-box-arrow-in-right"></i> Login to Apply</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

