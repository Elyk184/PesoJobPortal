@extends('layouts.admin-dashboard')

@section('title', 'Jobs Management | PESO Admin')

<?php
    $pageTitle = 'Jobs Management';
    $pageSubtitle = 'Manage all job postings in the system';
    $pageIcon = 'bi-briefcase';
?>

@section('content')
<div class="admin-dashboard">
    <style>
        .admin-dashboard {
            padding: 1.5rem;
        }

        .management-table {
            width: 100%;
            background: white;
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(17, 39, 76, 0.1);
            overflow: hidden;
            border: 1px solid #e5e7eb;
            margin-top: 0;
        }

        .management-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .management-table thead {
            background: linear-gradient(135deg, #fbfdff 0%, #f3f7fc 100%);
            border-bottom: 2px solid #e5e7eb;
        }

        .management-table th {
            padding: 1.2rem 1.4rem;
            text-align: left;
            font-weight: 800;
            color: #0d1f3c;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            word-spacing: 2px;
        }

        .management-table td {
            padding: 1.3rem 1.4rem;
            vertical-align: middle;
            font-size: 13.8px;
            border-bottom: 1px solid #f3f4f6;
            line-height: 1.5;
        }

        .management-table tbody tr {
            transition: all 0.2s ease;
        }

        .management-table tbody tr:hover {
            background: #f8fbff;
            box-shadow: inset 0 2px 8px rgba(56, 101, 179, 0.08);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.48rem 0.95rem;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .status-active {
            background: linear-gradient(135deg, #d1fae5 0%, #c0f3d6 100%);
            color: #065f46;
            border: 1px solid rgba(6, 95, 70, 0.2);
        }

        .status-closed {
            background: linear-gradient(135deg, #fee2e2 0%, #fdd8d8 100%);
            color: #991b1b;
            border: 1px solid rgba(153, 27, 27, 0.2);
        }

        .btn-small {
            padding: 0.55rem 1.15rem;
            border: none;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            white-space: nowrap;
            width: 110px;
            height: 38px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            letter-spacing: 0.3px;
        }

        .btn-view {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .btn-view:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            transform: translateY(-2px);
        }

        .btn-close {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-close:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.3);
            transform: translateY(-2px);
        }

        .job-title {
            font-weight: 800;
            color: #0f1729;
            letter-spacing: 0.2px;
        }

        .job-company {
            color: #475569;
            font-weight: 500;
        }

        .job-date {
            color: #64748b;
            font-weight: 500;
        }

        .job-applications {
            font-weight: 700;
            color: #1f2937;
            text-align: center;
        }

        .actions-cell {
            display: flex;
            gap: 0.9rem;
            align-items: center;
            justify-content: flex-start;
        }
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
                    <td class="job-title">Senior Software Engineer</td>
                    <td class="job-company">Tech Solutions Inc.</td>
                    <td class="job-applications">12</td>
                    <td class="job-date">05 Apr 2026</td>
                    <td><span class="status-badge status-active"><i class="bi bi-check-circle me-1"></i>Active</span></td>
                    <td class="actions-cell">
                        <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button>
                        <button class="btn-small btn-close"><i class="bi bi-x-lg me-1"></i>Close</button>
                    </td>
                </tr>
                <tr>
                    <td class="job-title">Marketing Manager</td>
                    <td class="job-company">Global Retail Co.</td>
                    <td class="job-applications">8</td>
                    <td class="job-date">08 Apr 2026</td>
                    <td><span class="status-badge status-active"><i class="bi bi-check-circle me-1"></i>Active</span></td>
                    <td class="actions-cell">
                        <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button>
                        <button class="btn-small btn-close"><i class="bi bi-x-lg me-1"></i>Close</button>
                    </td>
                </tr>
                <tr>
                    <td class="job-title">Registered Nurse</td>
                    <td class="job-company">Healthcare Services Ltd.</td>
                    <td class="job-applications">15</td>
                    <td class="job-date">10 Apr 2026</td>
                    <td><span class="status-badge status-closed"><i class="bi bi-x-circle me-1"></i>Closed</span></td>
                    <td class="actions-cell">
                        <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
