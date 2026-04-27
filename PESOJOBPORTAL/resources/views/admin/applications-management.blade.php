@extends('layouts.app')

@section('title', 'Applications Management | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'Applications Management', 'subtitle' => 'Manage all job applications', 'icon' => 'bi-file-text'])

<div class="admin-dashboard">
    <style>
        .management-table { width: 100%; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); overflow: hidden; }
        .management-table table { width: 100%; border-collapse: collapse; }
        .management-table thead { background: #f3f4f6; border-bottom: 2px solid #e5e7eb; }
        .management-table th { padding: 1rem; text-align: left; font-weight: 700; color: #0d1f3c; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .management-table td { padding: 1rem; vertical-align: middle; font-size: 14px; border-bottom: 1px solid #f0f0f0; }
        .management-table tbody tr:hover { background: #f9fafb; }
        .status-badge { display: inline-block; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-accepted { background: #d1fae5; color: #065f46; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .btn-small { padding: 0.5rem 1rem; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-block; }
        .btn-view { background: #3b82f6; color: white; }
        .btn-view:hover { background: #2563eb; }
    </style>

    <div class="management-table">
        <table>
            <thead>
                <tr>
                    <th>Applicant Name</th>
                    <th>Job Title</th>
                    <th>Applied Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Carlo Rodriguez</strong></td>
                    <td>Senior Software Engineer</td>
                    <td>15 Apr 2026</td>
                    <td><span class="status-badge status-pending"><i class="bi bi-hourglass-split me-1"></i>Pending</span></td>
                    <td><button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button></td>
                </tr>
                <tr>
                    <td><strong>Maria Dela Cruz</strong></td>
                    <td>Marketing Manager</td>
                    <td>16 Apr 2026</td>
                    <td><span class="status-badge status-accepted"><i class="bi bi-check-circle me-1"></i>Accepted</span></td>
                    <td><button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button></td>
                </tr>
                <tr>
                    <td><strong>Juan Santos</strong></td>
                    <td>Registered Nurse</td>
                    <td>17 Apr 2026</td>
                    <td><span class="status-badge status-rejected"><i class="bi bi-x-circle me-1"></i>Rejected</span></td>
                    <td><button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
