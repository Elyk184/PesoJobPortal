@extends('layouts.admin')

@section('title', 'Applications Management | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Applications Management', 'subtitle' => 'Manage all job applications', 'icon' => 'bi-file-text'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-file-text me-2"></i>All Applications</h5>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>No applications in system</p>
        </div>
    </div>
</div>

@endsection
