@extends('layouts.admin')

@section('title', 'Jobseekers Management | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Jobseekers Management', 'subtitle' => 'Manage all jobseeker accounts', 'icon' => 'bi-people'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-people me-2"></i>All Jobseekers</h5>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>No jobseekers in system</p>
        </div>
    </div>
</div>

@endsection
