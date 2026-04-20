@extends('layouts.admin')

@section('title', 'LRA/SRA Approvals | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'LRA/SRA Approvals', 'subtitle' => 'Manage LRA and SRA approvals', 'icon' => 'bi-file-earmark-check'])

<div class="admin-dashboard">
    <style>
        .approval-table { width: 100%; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); overflow: hidden; }
        .approval-table table { width: 100%; border-collapse: collapse; }
        .approval-table thead { background: #f3f4f6; border-bottom: 2px solid #e5e7eb; }
        .approval-table th { padding: 1rem; text-align: left; font-weight: 700; color: #0d1f3c; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .approval-table td { padding: 1rem; vertical-align: middle; font-size: 14px; border-bottom: 1px solid #f0f0f0; }
        .approval-table tbody tr:hover { background: #f9fafb; }
        .status-badge { display: inline-block; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .btn-small { padding: 0.5rem 1rem; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-block; }
        .btn-view { background: #3b82f6; color: white; }
        .btn-view:hover { background: #2563eb; }
        .btn-approve { background: #10b981; color: white; }
        .btn-approve:hover { background: #059669; }
    </style>

    <div class="approval-table">
        <table>
            <thead>
                <tr>
                    <th>Organization Type</th>
                    <th>Name</th>
                    <th>Submitted Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>LRA</strong></td>
                    <td>Local Government Unit</td>
                    <td>18 Apr 2026</td>
                    <td><span class="status-badge status-pending"><i class="bi bi-hourglass-split me-1"></i>Pending</span></td>
                    <td>
                        <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>Review</button>
                        <button class="btn-small btn-approve"><i class="bi bi-check-lg me-1"></i>Approve</button>
                    </td>
                </tr>
                <tr>
                    <td><strong>SRA</strong></td>
                    <td>Community Partnership Office</td>
                    <td>19 Apr 2026</td>
                    <td><span class="status-badge status-pending"><i class="bi bi-hourglass-split me-1"></i>Pending</span></td>
                    <td>
                        <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>Review</button>
                        <button class="btn-small btn-approve"><i class="bi bi-check-lg me-1"></i>Approve</button>
                    </td>
                </tr>
                <tr>
                    <td><strong>LRA</strong></td>
                    <td>Provincial Government</td>
                    <td>20 Apr 2026</td>
                    <td><span class="status-badge status-pending"><i class="bi bi-hourglass-split me-1"></i>Pending</span></td>
                    <td>
                        <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>Review</button>
                        <button class="btn-small btn-approve"><i class="bi bi-check-lg me-1"></i>Approve</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
