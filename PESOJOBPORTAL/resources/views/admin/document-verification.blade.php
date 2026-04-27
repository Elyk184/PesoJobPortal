@extends('layouts.app')

@section('title', 'Document Verification | PESO Admin')

@section('content')
@include('admin.layouts.topbar', ['title' => 'Document Verification', 'subtitle' => 'Verify submitted documents', 'icon' => 'bi-file-earmark'])

<div class="admin-dashboard">
    <style>
        .document-table { width: 100%; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); overflow: hidden; }
        .document-table table { width: 100%; border-collapse: collapse; }
        .document-table thead { background: #f3f4f6; border-bottom: 2px solid #e5e7eb; }
        .document-table th { padding: 1rem; text-align: left; font-weight: 700; color: #0d1f3c; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .document-table td { padding: 1rem; vertical-align: middle; font-size: 14px; border-bottom: 1px solid #f0f0f0; }
        .document-table tbody tr:hover { background: #f9fafb; }
        .status-badge { display: inline-block; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .btn-small { padding: 0.5rem 1rem; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-block; }
        .btn-view { background: #3b82f6; color: white; }
        .btn-view:hover { background: #2563eb; }
    </style>

    <div class="document-table">
        <table>
            <thead>
                <tr>
                    <th>Submitted By</th>
                    <th>Document Type</th>
                    <th>Submission Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Carlo Rodriguez</strong></td>
                    <td>Diploma Certificate</td>
                    <td>18 Apr 2026</td>
                    <td><span class="status-badge status-pending"><i class="bi bi-hourglass-split me-1"></i>Pending</span></td>
                    <td><button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>Verify</button></td>
                </tr>
                <tr>
                    <td><strong>Maria Dela Cruz</strong></td>
                    <td>NBI Clearance</td>
                    <td>19 Apr 2026</td>
                    <td><span class="status-badge status-pending"><i class="bi bi-hourglass-split me-1"></i>Pending</span></td>
                    <td><button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>Verify</button></td>
                </tr>
                <tr>
                    <td><strong>Juan Santos</strong></td>
                    <td>Government ID</td>
                    <td>20 Apr 2026</td>
                    <td><span class="status-badge status-pending"><i class="bi bi-hourglass-split me-1"></i>Pending</span></td>
                    <td><button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>Verify</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
