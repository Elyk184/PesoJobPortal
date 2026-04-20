@extends('layouts.admin')

@section('title', 'Job Approvals | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Job Approvals', 'subtitle' => 'Review and approve job postings', 'icon' => 'bi-briefcase'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-briefcase me-2"></i>Job Approvals</h5>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>No jobs pending approval</p>
        </div>
    </div>
</div>

@endsection
