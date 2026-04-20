@extends('layouts.admin')

@section('title', 'Employer Verification | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Employer Verification', 'subtitle' => 'Verify and approve employer registrations', 'icon' => 'bi-building'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-building me-2"></i>Employer Verification</h5>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>No employers to verify at this time</p>
        </div>
    </div>
</div>

@endsection
