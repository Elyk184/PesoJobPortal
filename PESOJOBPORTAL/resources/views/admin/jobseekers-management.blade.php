@extends('layouts.admin-dashboard')

@section('title', 'Jobseekers Management | PESO Admin')

<?php
    $pageTitle = 'Jobseekers Management';
    $pageSubtitle = 'Manage all registered jobseekers and their profiles';
    $pageIcon = 'bi-people';
?>

@section('content')
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
        .btn-small { padding: 0.5rem 1rem; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-block; }
        .btn-view { background: #3b82f6; color: white; }
        .btn-view:hover { background: #2563eb; }
        .btn-edit { background: #8b5cf6; color: white; }
        .btn-edit:hover { background: #7c3aed; }
    </style>

    <div class="management-table">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Location</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Carlo Rodriguez</strong></td>
                    <td>carlo@email.com</td>
                    <td>Manolo Fortich</td>
                    <td>15 Mar 2026</td>
                    <td><span class="status-badge status-active"><i class="bi bi-check-circle me-1"></i>Active</span></td>
                    <td>
                        <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button>
                        <button class="btn-small btn-edit"><i class="bi bi-pencil me-1"></i>Edit</button>
                    </td>
                </tr>
                <tr>
                    <td><strong>Maria Dela Cruz</strong></td>
                    <td>maria@email.com</td>
                    <td>Manolo Fortich</td>
                    <td>02 Apr 2026</td>
                    <td><span class="status-badge status-active"><i class="bi bi-check-circle me-1"></i>Active</span></td>
                    <td>
                        <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button>
                        <button class="btn-small btn-edit"><i class="bi bi-pencil me-1"></i>Edit</button>
                    </td>
                </tr>
                <tr>
                    <td><strong>Juan Santos</strong></td>
                    <td>juan@email.com</td>
                    <td>Manolo Fortich</td>
                    <td>10 Apr 2026</td>
                    <td><span class="status-badge status-active"><i class="bi bi-check-circle me-1"></i>Active</span></td>
                    <td>
                        <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button>
                        <button class="btn-small btn-edit"><i class="bi bi-pencil me-1"></i>Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
