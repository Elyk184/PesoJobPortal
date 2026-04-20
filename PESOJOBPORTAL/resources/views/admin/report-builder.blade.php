@extends('layouts.admin')

@section('title', 'Dynamic Report Builder | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Dynamic Report Builder', 'subtitle' => 'Create custom reports', 'icon' => 'bi-file-earmark-pdf'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-file-earmark-pdf me-2"></i>Report Builder</h5>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>No reports available</p>
        </div>
    </div>
</div>

@endsection
