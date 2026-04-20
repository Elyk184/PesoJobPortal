@extends('layouts.admin')

@section('title', 'PESO Clearances | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'PESO Clearances', 'subtitle' => 'Manage PESO clearances', 'icon' => 'bi-clipboard'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-clipboard me-2"></i>PESO Clearances</h5>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>No clearances found</p>
        </div>
    </div>
</div>

@endsection
