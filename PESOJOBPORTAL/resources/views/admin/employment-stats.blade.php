@extends('layouts.admin')

@section('title', 'Employment Statistics | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Employment Statistics', 'subtitle' => 'View employment trends and analytics', 'icon' => 'bi-graph-up'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-graph-up me-2"></i>Employment Stats</h5>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>No analytics available</p>
        </div>
    </div>
</div>

@endsection
