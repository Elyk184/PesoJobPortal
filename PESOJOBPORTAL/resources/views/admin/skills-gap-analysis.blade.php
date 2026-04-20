@extends('layouts.admin')

@section('title', 'Skills Gap Analysis | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Skills Gap Analysis', 'subtitle' => 'Identify skills gaps in the locality', 'icon' => 'bi-diagram-3'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-diagram-3 me-2"></i>Skills Gap Analysis</h5>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>No analysis available</p>
        </div>
    </div>
</div>

@endsection
