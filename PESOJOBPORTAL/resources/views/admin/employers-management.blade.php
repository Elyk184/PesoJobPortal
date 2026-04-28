@extends('layouts.admin-dashboard')

@section('title', 'Employers Management | PESO Admin')

<?php
    $pageTitle = 'Employers Management';
    $pageSubtitle = 'Manage registered employers and their profiles';
    $pageIcon = 'bi-shop';
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
                    <th>Company Name</th>
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Tech Solutions Inc.</strong></td>
                    <td>John Smith</td>
                    <td>hr@techsolutions.com</td>
                    <td>05 Mar 2026</td>
                    <td><span class="status-badge status-active"><i class="bi bi-check-circle me-1"></i>Active</span></td>
                    <td>
                        <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button>
                        <button class="btn-small btn-edit"><i class="bi bi-pencil me-1"></i>Edit</button>
                    </td>
                </tr>
                <tr>
                    <td><strong>Global Retail Co.</strong></td>
                    <td>Jane Doe</td>
                    <td>careers@globalretail.com</td>
                    <td>12 Mar 2026</td>
                    <td><span class="status-badge status-active"><i class="bi bi-check-circle me-1"></i>Active</span></td>
                    <td>
                        <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button>
                        <button class="btn-small btn-edit"><i class="bi bi-pencil me-1"></i>Edit</button>
                    </td>
                </tr>
                <tr>
                    <td><strong>Healthcare Services Ltd.</strong></td>
                    <td>Dr. Maria Santos</td>
                    <td>recruit@healthcare.com</td>
                    <td>20 Mar 2026</td>
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
