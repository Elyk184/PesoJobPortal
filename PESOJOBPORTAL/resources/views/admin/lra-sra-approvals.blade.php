@extends('layouts.admin')

@section('title', 'LRA/SRA Approvals | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'LRA/SRA Approvals', 'subtitle' => 'Manage LRA and SRA approvals', 'icon' => 'bi-file-earmark-check'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-file-earmark-check me-2"></i>LRA/SRA Approvals</h5>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>No LRA/SRA approvals pending</p>
        </div>
    </div>
</div>

@endsection
