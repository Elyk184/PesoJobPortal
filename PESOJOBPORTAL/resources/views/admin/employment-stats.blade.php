@extends('layouts.app')

@section('title', 'Employment Statistics | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Employment Statistics', 'subtitle' => 'View employment trends and analytics', 'icon' => 'bi-graph-up'])

<div class="admin-dashboard">
    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
        .stat-value { font-size: 32px; font-weight: 700; color: #0d1f3c; }
        .stat-label { font-size: 14px; color: #6b7280; font-weight: 500; margin-top: 0.5rem; }
        .stat-icon { font-size: 32px; margin-bottom: 1rem; opacity: 0.7; }
    </style>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <div class="stat-value">1,284</div>
            <div class="stat-label">Total Jobseekers</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-briefcase"></i></div>
            <div class="stat-value">156</div>
            <div class="stat-label">Active Job Postings</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
            <div class="stat-value">342</div>
            <div class="stat-label">Successful Placements</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-building"></i></div>
            <div class="stat-value">48</div>
            <div class="stat-label">Registered Employers</div>
        </div>
    </div>

    <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
        <h5><i class="bi bi-graph-up me-2"></i>Analytics</h5>
        <p style="color: #6b7280; margin-top: 1rem;">Chart and detailed analytics will display here</p>
    </div>
</div>

@endsection
