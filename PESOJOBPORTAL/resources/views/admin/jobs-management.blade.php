@extends('layouts.app')

@section('title', 'Jobs Management | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Jobs Management', 'subtitle' => 'Manage all job postings', 'icon' => 'bi-briefcase'])

<div class="admin-dashboard">
    <style>
        .management-table { width: 100%; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); overflow: hidden; }
        .management-table table { width: 100%; border-collapse: collapse; }
        .management-table thead { background: #f3f4f6; border-bottom: 2px solid #e5e7eb; }
        .management-table th { padding: 1rem; text-align: left; font-weight: 700; color: #0d1f3c; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .management-table td { padding: 1rem; vertical-align: middle; font-size: 14px; border-bottom: 1px solid #f0f0f0; }
        .management-table tbody tr:hover { background: #f9fafb; }
        .status-badge { display: inline-block; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .status-active { background: #d1fae5; color: #065f46; }
        .status-closed { background: #fee2e2; color: #991b1b; }
        .btn-small { padding: 0.5rem 1rem; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-block; }
        .btn-view { background: #3b82f6; color: white; }
        .btn-view:hover { background: #2563eb; }
        .btn-close { background: #ef4444; color: white; }
        .btn-close:hover { background: #dc2626; }
    </style>

    <div class="management-table">
        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Applications</th>
                    <th>Posted Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Senior Software Engineer</strong></td>
                    <td>Tech Solutions Inc.</td>
                    <td>12</td>
                    <td>05 Apr 2026</td>
                    <td><span class="status-badge status-active"><i class="bi bi-check-circle me-1"></i>Active</span></td>
                    <td>
                        <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button>
                        <button class="btn-small btn-close"><i class="bi bi-x-lg me-1"></i>Close</button>
                    </td>
                </tr>
                <tr>
                    <td><strong>Marketing Manager</strong></td>
                    <td>Global Retail Co.</td>
                    <td>8</td>
                    <td>08 Apr 2026</td>
                    <td><span class="status-badge status-active"><i class="bi bi-check-circle me-1"></i>Active</span></td>
                    <td>
                        <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button>
                        <button class="btn-small btn-close"><i class="bi bi-x-lg me-1"></i>Close</button>
                    </td>
                </tr>
                <tr>
                    <td><strong>Registered Nurse</strong></td>
                    <td>Healthcare Services Ltd.</td>
                    <td>15</td>
                    <td>10 Apr 2026</td>
                    <td><span class="status-badge status-closed"><i class="bi bi-x-circle me-1"></i>Closed</span></td>
                    <td>
                        <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
