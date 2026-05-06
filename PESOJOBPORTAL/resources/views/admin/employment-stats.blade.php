@extends('layouts.admin-dashboard')

@section('title', 'Employment Statistics | PESO Admin')

<?php
    $pageTitle = 'Employment Statistics';
    $pageSubtitle = 'View employment trends and statistics';
    $pageIcon = 'bi-bar-chart-line';
?>

@section('content')
<div class="admin-dashboard">
    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); border-left: 4px solid #3b82f6; }
        .stat-card:nth-child(2) { border-left-color: #10b981; }
        .stat-card:nth-child(3) { border-left-color: #f59e0b; }
        .stat-card:nth-child(4) { border-left-color: #8b5cf6; }
        .stat-value { font-size: 32px; font-weight: 700; color: #0d1f3c; }
        .stat-label { font-size: 14px; color: #6b7280; font-weight: 500; margin-top: 0.5rem; }
        .stat-icon { font-size: 32px; margin-bottom: 1rem; opacity: 0.7; }
        .chart-card { background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 1.5rem; }
        .chart-title { font-size: 16px; font-weight: 700; color: #0d1f3c; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px; }
        .charts-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .print-button-container { margin-bottom: 1.5rem; display: flex; gap: 0.5rem; }
        .print-btn { padding: 0.75rem 1.5rem; background: #3b82f6; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; font-size: 14px; transition: all 0.2s ease; }
        .print-btn:hover { background: #2563eb; }
        .print-btn i { font-size: 16px; }
        
        @media (max-width: 1024px) {
            .charts-grid { grid-template-columns: 1fr; }
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            body {
                background: white;
                margin: 0;
                padding: 20px;
            }

            .admin-sidebar,
            .admin-topbar,
            .sidebar-header,
            .sidebar-menu,
            .print-button-container,
            .navbar,
            .peso-header,
            nav {
                display: none !important;
            }

            .admin-wrapper {
                display: flex;
            }

            .admin-main {
                margin-left: 0 !important;
                padding: 0 !important;
            }

            .admin-dashboard {
                background: white !important;
                padding: 0;
            }

            .stats-grid {
                gap: 1rem;
                page-break-inside: avoid;
            }

            .stat-card {
                background: white;
                border: 1px solid #d1d5db;
                box-shadow: none;
                page-break-inside: avoid;
            }

            .chart-card {
                background: white;
                border: 1px solid #d1d5db;
                box-shadow: none;
                page-break-inside: avoid;
                padding: 1rem;
            }

            .chart-title {
                font-size: 14px;
                margin-bottom: 1rem;
            }

            .charts-grid {
                gap: 1rem;
            }

            canvas {
                max-width: 100%;
                height: auto !important;
            }

            /* Add page breaks strategically */
            .chart-card:nth-child(3) {
                page-break-before: auto;
            }

            /* Print header */
            .print-header {
                text-align: center;
                margin-bottom: 2rem;
                padding-bottom: 1rem;
                border-bottom: 2px solid #0d1f3c;
                page-break-after: avoid;
            }

            .print-header h1 {
                margin: 0;
                font-size: 24px;
                color: #0d1f3c;
            }

            .print-header p {
                margin: 0.5rem 0 0;
                font-size: 12px;
                color: #6b7280;
            }

            @page {
                size: A4;
                margin: 10mm;
            }
        }
    </style>

    <!-- Print Button -->
    <div class="print-button-container">
        <button class="print-btn" onclick="window.print()">
            <i class="bi bi-printer"></i>
            Print Report
        </button>
    </div>

    <!-- Print Header (Only shows in print) -->
    <div class="print-header" style="display: none;">
        <h1>Employment Statistics Report</h1>
        <p>Generated on {{ now()->format('F d, Y') }}</p>
    </div>

    <style>
        @media print {
            .print-header { display: block !important; }
        }
    </style>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <div class="stat-value">{{ number_format($stats['total_jobseekers']) }}</div>
            <div class="stat-label">Total Jobseekers</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-briefcase"></i></div>
            <div class="stat-value">{{ number_format($stats['active_jobs']) }}</div>
            <div class="stat-label">Active Job Postings</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
            <div class="stat-value">{{ number_format($stats['successful_placements']) }}</div>
            <div class="stat-label">Successful Placements</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-building"></i></div>
            <div class="stat-value">{{ number_format($stats['registered_employers']) }}</div>
            <div class="stat-label">Registered Employers</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-grid">
        <!-- Jobs Posted Trend -->
        <div class="chart-card">
            <div class="chart-title">
                <i class="bi bi-graph-up"></i>
                Jobs Posted (Last 12 Months)
            </div>
            <canvas id="jobsTrendChart" height="300"></canvas>
        </div>

        <!-- Application Status Distribution -->
        <div class="chart-card">
            <div class="chart-title">
                <i class="bi bi-pie-chart"></i>
                Application Status Distribution
            </div>
            <canvas id="appStatusChart" height="300"></canvas>
        </div>
    </div>

<!-- Top Categories Chart -->
        <div class="chart-card">
            <div class="chart-title">
                <i class="bi bi-bar-chart"></i>
                Top Job Types
        </div>
        <canvas id="categoriesChart" height="80"></canvas>
    </div>

    <div class="chart-card">
        <div class="chart-title">
            <i class="bi bi-graph-up-arrow"></i>
            Applications Trend (Last 30 Days)
        </div>
        <canvas id="trendChart" height="80"></canvas>
    </div>

    @if($jobseekerStats && $jobseekerStats->total > 0)
    <div class="chart-card">
        <div class="chart-title">
            <i class="bi bi-person-check"></i>
            Jobseeker Profile Completion
        </div>
        <canvas id="profileCompletionChart" height="80"></canvas>
    </div>
    @endif
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Jobs Posted Trend Chart
    const jobsTrendCtx = document.getElementById('jobsTrendChart').getContext('2d');
    new Chart(jobsTrendCtx, {
        type: 'line',
        data: {
            labels: @json($monthLabels),
            datasets: [
                {
                    label: 'Active',
                    data: @json($jobsActive),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                },
                {
                    label: 'Pending',
                    data: @json($jobsPending),
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#f59e0b',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                },
                {
                    label: 'Closed',
                    data: @json($jobsClosed),
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#ef4444',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 15, font: { size: 12 } }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                }
            }
        }
    });

    // Application Status Distribution
    const appStatusCtx = document.getElementById('appStatusChart').getContext('2d');
    new Chart(appStatusCtx, {
        type: 'doughnut',
        data: {
            labels: @json($appStatusLabels),
            datasets: [{
                data: @json($appStatusData),
                backgroundColor: ['#3b82f6', '#10b981', '#ef4444'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 15, font: { size: 12 } }
                }
            }
        }
    });

    // Top Categories Chart
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    new Chart(categoriesCtx, {
        type: 'bar',
        data: {
            labels: @json($categoryLabels),
            datasets: [{
                label: 'Number of Jobs',
                data: @json($categoryData),
                backgroundColor: [
                    '#3b82f6', '#10b981', '#f59e0b', '#ef4444',
                    '#8b5cf6', '#ec4899', '#14b8a6', '#f97316'
                ],
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                }
            }
        }
    });

    // Applications Trend
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'bar',
        data: {
            labels: @json($trendDates),
            datasets: [{
                label: 'Applications',
                data: @json($trendData),
                backgroundColor: '#3b82f6',
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                }
            }
        }
    });

    @if($jobseekerStats && $jobseekerStats->total > 0)
    // Profile Completion Chart
    const profileCompletionCtx = document.getElementById('profileCompletionChart').getContext('2d');
    const withoutProfile = {{ $jobseekerStats->total - $jobseekerStats->with_profile }};
    new Chart(profileCompletionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Profile Complete', 'No Profile'],
            datasets: [{
                data: [{{ $jobseekerStats->with_profile }}, withoutProfile],
                backgroundColor: ['#10b981', '#e5e7eb'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 15, font: { size: 12 } }
                }
            }
        }
    });
    @endif

    // Print functionality
    window.addEventListener('beforeprint', function() {
        // This event fires before printing
        const charts = Chart.helpers?.get || [];
    });

    window.addEventListener('afterprint', function() {
        // This event fires after printing
        console.log('Print completed');
    });

    // Add keyboard shortcut for print (Ctrl+P)
    document.addEventListener('keydown', function(event) {
        if ((event.ctrlKey || event.metaKey) && event.key === 'p') {
            event.preventDefault();
            window.print();
        }
    });
</script>

@endsection
