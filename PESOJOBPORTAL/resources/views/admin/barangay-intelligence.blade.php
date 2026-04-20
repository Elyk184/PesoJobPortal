@extends('layouts.admin')

@section('title', 'Barangay Intelligence | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Barangay Intelligence', 'subtitle' => 'Barangay-level employment insights', 'icon' => 'bi-map'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-map me-2"></i>Barangay Intelligence</h5>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>No intelligence available</p>
        </div>
    </div>
</div>

@endsection
