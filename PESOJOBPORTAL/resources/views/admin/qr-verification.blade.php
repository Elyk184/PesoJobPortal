@extends('layouts.admin')

@section('title', 'QR Verification | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'QR Verification', 'subtitle' => 'Verify documents via QR codes', 'icon' => 'bi-qr-code'])

<div class="admin-dashboard">
    <div class="dashboard-card">
        <h5><i class="bi bi-qr-code me-2"></i>QR Verification</h5>
        <div class="empty-state">
            <i class="bi bi-qr-code"></i>
            <p>Ready to scan QR codes</p>
        </div>
    </div>
</div>

@endsection
