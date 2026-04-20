@extends('layouts.admin')

@section('title', 'Jobs Management | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Jobs Management', 'subtitle' => 'Manage all job postings', 'icon' => 'bi-briefcase'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-briefcase me-2"></i>All Jobs</h5>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>No jobs in system</p>
        </div>
    </div>
</div>

@endsection
