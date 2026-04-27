@extends('layouts.admin-dashboard')

@section('title', 'Barangay Intelligence | PESO Admin')

<?php
    $pageTitle = 'Barangay Intelligence';
    $pageSubtitle = 'Analyze employment data by barangay';
    $pageIcon = 'bi-map';
?>

@section('content')
<div class="admin-dashboard">
    <style>
        .barangay-card { background: white; padding: 1.5rem; border-radius: 10px; margin-bottom: 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.06); display: flex; justify-content: space-between; align-items: center; }
        .barangay-info h6 { margin: 0; color: #0d1f3c; font-weight: 700; }
        .barangay-stats { display: flex; gap: 2rem; }
        .barangay-stat { text-align: center; }
        .barangay-stat-value { font-size: 24px; font-weight: 700; color: #d72638; }
        .barangay-stat-label { font-size: 12px; color: #6b7280; margin-top: 0.25rem; }
    </style>

    <div class="barangay-card">
        <div class="barangay-info">
            <h6><i class="bi bi-map-fill me-2"></i>Manolo Fortich</h6>
            <p style="margin: 0.5rem 0 0 0; color: #6b7280; font-size: 14px;">Primary Barangay</p>
        </div>
        <div class="barangay-stats">
            <div class="barangay-stat">
                <div class="barangay-stat-value">284</div>
                <div class="barangay-stat-label">Jobseekers</div>
            </div>
            <div class="barangay-stat">
                <div class="barangay-stat-value">42</div>
                <div class="barangay-stat-label">Active Jobs</div>
            </div>
            <div class="barangay-stat">
                <div class="barangay-stat-value">68</div>
                <div class="barangay-stat-label">Placements</div>
            </div>
        </div>
    </div>

    <div class="barangay-card">
        <div class="barangay-info">
            <h6><i class="bi bi-map-fill me-2"></i>Santo Niño</h6>
            <p style="margin: 0.5rem 0 0 0; color: #6b7280; font-size: 14px;">Secondary Area</p>
        </div>
        <div class="barangay-stats">
            <div class="barangay-stat">
                <div class="barangay-stat-value">156</div>
                <div class="barangay-stat-label">Jobseekers</div>
            </div>
            <div class="barangay-stat">
                <div class="barangay-stat-value">28</div>
                <div class="barangay-stat-label">Active Jobs</div>
            </div>
            <div class="barangay-stat">
                <div class="barangay-stat-value">34</div>
                <div class="barangay-stat-label">Placements</div>
            </div>
        </div>
    </div>

    <div class="barangay-card">
        <div class="barangay-info">
            <h6><i class="bi bi-map-fill me-2"></i>Tibolo</h6>
            <p style="margin: 0.5rem 0 0 0; color: #6b7280; font-size: 14px;">Secondary Area</p>
        </div>
        <div class="barangay-stats">
            <div class="barangay-stat">
                <div class="barangay-stat-value">192</div>
                <div class="barangay-stat-label">Jobseekers</div>
            </div>
            <div class="barangay-stat">
                <div class="barangay-stat-value">35</div>
                <div class="barangay-stat-label">Active Jobs</div>
            </div>
            <div class="barangay-stat">
                <div class="barangay-stat-value">52</div>
                <div class="barangay-stat-label">Placements</div>
            </div>
        </div>
    </div>
</div>

@endsection
