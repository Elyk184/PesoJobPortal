@extends('layouts.admin')

@section('title', 'Settings | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Settings', 'subtitle' => 'Configure system settings', 'icon' => 'bi-gear'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-gear me-2"></i>System Settings</h5>
        <div class="empty-state">
            <i class="bi bi-gear"></i>
            <p>Settings configuration area</p>
        </div>
    </div>
</div>

@endsection
