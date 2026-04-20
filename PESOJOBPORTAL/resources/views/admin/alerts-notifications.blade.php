@extends('layouts.admin')

@section('title', 'Alerts & Notifications | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Alerts & Notifications', 'subtitle' => 'Manage system alerts and notifications', 'icon' => 'bi-bell'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-bell me-2"></i>Alerts & Notifications</h5>
        <div class="empty-state">
            <i class="bi bi-bell"></i>
            <p>No alerts at this time</p>
        </div>
    </div>
</div>

@endsection
