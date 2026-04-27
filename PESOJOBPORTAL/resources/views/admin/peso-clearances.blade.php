@extends('layouts.app')

@section('title', 'PESO Clearances | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'PESO Clearances', 'subtitle' => 'Manage PESO clearances', 'icon' => 'bi-clipboard'])

<div class="admin-dashboard">
    <style>
        .clearance-table { width: 100%; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); overflow: hidden; }
        .clearance-table table { width: 100%; border-collapse: collapse; }
        .clearance-table thead { background: #f3f4f6; border-bottom: 2px solid #e5e7eb; }
        .clearance-table th { padding: 1rem; text-align: left; font-weight: 700; color: #0d1f3c; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .clearance-table td { padding: 1rem; vertical-align: middle; font-size: 14px; border-bottom: 1px solid #f0f0f0; }
        .clearance-table tbody tr:hover { background: #f9fafb; }
        .status-badge { display: inline-block; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .status-issued { background: #d1fae5; color: #065f46; }
        .btn-small { padding: 0.5rem 1rem; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-block; }
        .btn-view { background: #3b82f6; color: white; }
        .btn-view:hover { background: #2563eb; }
    </style>

    <div class="clearance-table">
        <table>
            <thead>
                <tr>
                    <th>Clearance #</th>
                    <th>Name</th>
                    <th>Issued Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>CLR-2026-001</strong></td>
                    <td>Carlo Rodriguez</td>
                    <td>10 Apr 2026</td>
                    <td><span class="status-badge status-issued"><i class="bi bi-check-circle me-1"></i>Issued</span></td>
                    <td><button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button></td>
                </tr>
                <tr>
                    <td><strong>CLR-2026-002</strong></td>
                    <td>Maria Dela Cruz</td>
                    <td>12 Apr 2026</td>
                    <td><span class="status-badge status-issued"><i class="bi bi-check-circle me-1"></i>Issued</span></td>
                    <td><button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button></td>
                </tr>
                <tr>
                    <td><strong>CLR-2026-003</strong></td>
                    <td>Juan Santos</td>
                    <td>15 Apr 2026</td>
                    <td><span class="status-badge status-issued"><i class="bi bi-check-circle me-1"></i>Issued</span></td>
                    <td><button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
