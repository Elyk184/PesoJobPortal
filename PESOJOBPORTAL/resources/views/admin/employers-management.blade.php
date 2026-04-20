@extends('layouts.admin')

@section('title', 'Employers Management | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Employers Management', 'subtitle' => 'Manage all employer accounts', 'icon' => 'bi-shop'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-shop me-2"></i>All Employers</h5>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>No employers in system</p>
        </div>
    </div>
</div>

@endsection
