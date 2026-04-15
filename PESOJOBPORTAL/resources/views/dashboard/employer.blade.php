@extends('dashboard.employer.layout')

@section('title', 'Employer Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Quick overview of your recruitment activity.')

@section('header_actions')
    @if ($isVerifiedEmployer)
        <span class="pill">Verified Employer</span>
    @else
        <span class="pill" style="background:#fef2f2;color:#b91c1c;">Not Verified</span>
    @endif
@endsection

@section('content')
    <div class="panel">
        <h2>Dashboard Statistics</h2>
        <p>This page now shows statistics only.</p>

        <div class="grid">
            <div class="metric-card">
                <p class="metric-value">{{ $stats['active_jobs_count'] }}</p>
                <p class="metric-label">Active Job Posts</p>
            </div>
            <div class="metric-card">
                <p class="metric-value">{{ $stats['total_applications'] }}</p>
                <p class="metric-label">Total Applications</p>
            </div>
            <div class="metric-card">
                <p class="metric-value">{{ $stats['hired_candidates'] }}</p>
                <p class="metric-label">Hired Candidates</p>
            </div>
            <div class="metric-card">
                <p class="metric-value">{{ $stats['new_applications_today'] }}</p>
                <p class="metric-label">New Applications Today</p>
            </div>
        </div>
    </div>
@endsection
