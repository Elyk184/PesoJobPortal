@extends('layouts.admin-dashboard')

@section('title', 'Dynamic Report Builder | PESO Admin')

<?php
    $pageTitle = 'Dynamic Report Builder';
    $pageSubtitle = 'Create custom reports and analyze data';
    $pageIcon = 'bi-file-earmark-text';
?>

@section('content')
<div class="admin-dashboard">
    <style>
        .report-builder-form { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; font-weight: 600; color: #0d1f3c; margin-bottom: 0.5rem; font-size: 14px; }
        .form-control { width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; }
        .btn-primary { background: #0d1f3c; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
        .btn-primary:hover { background: #152d52; }
        .report-list { background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
        .report-item { padding: 1rem; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; }
        .report-item:last-child { border-bottom: none; }
    </style>

    <div class="report-builder-form">
        <h5><i class="bi bi-file-earmark-pdf me-2"></i>Create New Report</h5>
        <div class="form-group">
            <label class="form-label">Report Type</label>
            <select class="form-control">
                <option>-- Select Report Type --</option>
                <option>Employment Summary</option>
                <option>Placement Statistics</option>
                <option>Skills Analysis</option>
                <option>Employer Performance</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Date Range</label>
            <input type="date" class="form-control">
        </div>
        <button class="btn-primary"><i class="bi bi-download me-1"></i>Generate Report</button>
    </div>

    <div class="report-list">
        <h5 style="margin-top: 0;"><i class="bi bi-clock-history me-2"></i>Recent Reports</h5>
        <div class="report-item">
            <div>
                <strong>Monthly Employment Report</strong>
                <p style="color: #6b7280; font-size: 13px; margin: 0.25rem 0 0 0;">Generated on 15 Apr 2026</p>
            </div>
            <button class="btn-small" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border: none; border-radius: 6px; cursor: pointer;"><i class="bi bi-download me-1"></i>Download</button>
        </div>
        <div class="report-item">
            <div>
                <strong>Quarterly Skills Analysis</strong>
                <p style="color: #6b7280; font-size: 13px; margin: 0.25rem 0 0 0;">Generated on 10 Apr 2026</p>
            </div>
            <button class="btn-small" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border: none; border-radius: 6px; cursor: pointer;"><i class="bi bi-download me-1"></i>Download</button>
        </div>
    </div>
</div>

@endsection
