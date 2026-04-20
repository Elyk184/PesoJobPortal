@extends('layouts.admin')

@section('title', 'Document Verification | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Document Verification', 'subtitle' => 'Verify submitted documents', 'icon' => 'bi-file-earmark'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-file-earmark me-2"></i>Document Verification</h5>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>No documents pending verification</p>
        </div>
    </div>
</div>

@endsection
