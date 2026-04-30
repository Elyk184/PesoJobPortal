@extends('layouts.admin-dashboard')

@section('title', 'Applications Analytics | PESO Admin')

<?php
    $pageTitle = 'Applications Analytics';
    $pageSubtitle = 'View job seeker application statistics and trends';
    $pageIcon = 'bi-pie-chart';
?>

@section('content')
<div class="admin-dashboard">
    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-header">
            <h5><i class="bi bi-funnel me-2"></i>Filter Analytics</h5>
        </div>
        <form id="analyticsFilterForm" method="GET" action="{{ route('admin.applications-analytics') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
            <div class="filter-group">
                <label for="periodSelect" style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 0.5rem; display: block;">Time Period</label>
                <select id="periodSelect" name="period" style="padding: 0.6rem 1rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; color: #0f172a; background: white; cursor: pointer; transition: all 0.2s ease;">
                    <option value="7days" {{ request('period', '7days') === '7days' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30days" {{ request('period') === '30days' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>This Month</option>
                    <option value="year" {{ request('period') === 'year' ? 'selected' : '' }}>This Year</option>
                    <option value="custom" {{ request('period') === 'custom' ? 'selected' : '' }}>Custom Range</option>
                </select>
            </div>

            <div class="filter-group" id="customDateRange" style="display: {{ request('period') === 'custom' ? 'flex' : 'none' }}; gap: 1rem;">
                <div>
                    <label for="startDate" style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 0.5rem; display: block;">From Date</label>
                    <input type="date" id="startDate" name="start_date" value="{{ request('start_date') }}" style="padding: 0.6rem 1rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 14px; color: #0f172a; background: white;">
                </div>
                <div>
                    <label for="endDate" style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 0.5rem; display: block;">To Date</label>
                    <input type="date" id="endDate" name="end_date" value="{{ request('end_date') }}" style="padding: 0.6rem 1rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 14px; color: #0f172a; background: white;">
                </div>
            </div>

            <button type="submit" style="padding: 0.6rem 1.5rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; align-self: flex-end; margin-top: auto;">
                <i class="bi bi-search me-1"></i>Apply Filter
            </button>
        </form>
    </div>

    <style>
        .filter-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        }

        .filter-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .filter-header h5 {
            margin: 0;
            font-weight: 700;
            color: #0f172a;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        #periodSelect:hover, input[type="date"]:hover {
            border-color: #cbd5e1;
            background: #f9fafb;
        }

        #periodSelect:focus, input[type="date"]:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }
    </style>

    <script>
        document.getElementById('periodSelect').addEventListener('change', function() {
            const customRange = document.getElementById('customDateRange');
            if (this.value === 'custom') {
                customRange.style.display = 'flex';
            } else {
                customRange.style.display = 'none';
            }
        });
    </script>

    <style>
        .analytics-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            border-left: 5px solid #3b82f6;
        }

        .stat-card.pending {
            border-left-color: #f59e0b;
        }

        .stat-card.accepted {
            border-left-color: #10b981;
        }

        .stat-card.rejected {
            border-left-color: #ef4444;
        }

        .stat-card.referred {
            border-left-color: #8b5cf6;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #0d1f3c;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
        }

        .chart-wrapper {
            position: relative;
            width: 100%;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-canvas {
            max-height: 400px;
        }

        .chart-legend {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
            width: 100%;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 14px;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 3px;
        }

        .chart-card h3 {
            color: #0d1f3c;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
            width: 100%;
        }

        .no-data {
            color: #9ca3af;
            font-style: italic;
            padding: 2rem;
            text-align: center;
        }

        .detailed-stats {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            margin-top: 2rem;
        }

        .detailed-stats h4 {
            color: #0d1f3c;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .stats-table {
            width: 100%;
            border-collapse: collapse;
        }

        .stats-table thead {
            background: #f3f4f6;
            border-bottom: 2px solid #e5e7eb;
        }

        .stats-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 700;
            color: #0d1f3c;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stats-table td {
            padding: 1rem;
            vertical-align: middle;
            font-size: 14px;
            border-bottom: 1px solid #f0f0f0;
        }

        .stats-table tbody tr:hover {
            background: #f9fafb;
        }

        .percentage-bar {
            height: 20px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }

        .percentage-fill {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: 600;
        }
    </style>

    <!-- Statistics Overview -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $totalApplications }}</div>
            <div class="stat-label">Total Applications</div>
        </div>
        <div class="stat-card pending">
            <div class="stat-value">{{ $pendingApplications }}</div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card accepted">
            <div class="stat-value">{{ $acceptedApplications }}</div>
            <div class="stat-label">Accepted</div>
        </div>
        <div class="stat-card rejected">
            <div class="stat-value">{{ $rejectedApplications }}</div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="analytics-container">
        <!-- Applications by Status Chart -->
        <div class="chart-card">
            <h3><i class="bi bi-pie-chart me-2"></i>Applications by Status</h3>
            @if($totalApplications > 0)
                <div class="chart-wrapper">
                    <canvas id="statusChart" class="chart-canvas"></canvas>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #f59e0b;"></div>
                        <span>Pending: {{ $pendingApplications }} ({{ round($pendingApplications/$totalApplications*100, 1) }}%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #10b981;"></div>
                        <span>Accepted: {{ $acceptedApplications }} ({{ round($acceptedApplications/$totalApplications*100, 1) }}%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #ef4444;"></div>
                        <span>Rejected: {{ $rejectedApplications }} ({{ round($rejectedApplications/$totalApplications*100, 1) }}%)</span>
                    </div>
                </div>
            @else
                <div class="no-data">
                    <i class="bi bi-inbox" style="font-size: 32px; margin-bottom: 0.5rem; display: block;"></i>
                    No application data available
                </div>
            @endif
        </div>

        <!-- Applications by Gender Chart -->
        <div class="chart-card">
            <h3><i class="bi bi-people me-2"></i>Applicants by Gender</h3>
            @if($totalApplications > 0)
                <div class="chart-wrapper">
                    <canvas id="genderChart" class="chart-canvas"></canvas>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #6366f1;"></div>
                        <span>Female: {{ $femaleCount }} ({{ round($femaleCount/$totalApplications*100, 1) }}%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #0ea5e9;"></div>
                        <span>Male: {{ $maleCount }} ({{ round($maleCount/$totalApplications*100, 1) }}%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #14b8a6;"></div>
                        <span>Other: {{ $otherCount }} ({{ round($otherCount/$totalApplications*100, 1) }}%)</span>
                    </div>
                </div>
            @else
                <div class="no-data">
                    <i class="bi bi-inbox" style="font-size: 32px; margin-bottom: 0.5rem; display: block;"></i>
                    No demographic data available
                </div>
            @endif
        </div>
    </div>

    <!-- Trend Chart -->
    <div class="detailed-stats">
        <h4>
            <i class="bi bi-graph-up"></i>
            Applications Trend
        </h4>
        <div style="position: relative; height: 350px;">
            <canvas id="trendChart"></canvas>
        </div>
    </div>

    <!-- Detailed Statistics Table -->
    <div class="detailed-stats">
        <h4>
            <i class="bi bi-table"></i>
            Detailed Breakdown
        </h4>
        <table class="stats-table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                    <th>Percentage</th>
                    <th>Distribution</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span style="display: inline-block; width: 12px; height: 12px; background: #f59e0b; border-radius: 3px; margin-right: 8px;"></span>Pending</td>
                    <td><strong>{{ $pendingApplications }}</strong></td>
                    <td>{{ $totalApplications > 0 ? round($pendingApplications/$totalApplications*100, 1) : 0 }}%</td>
                    <td>
                        <div class="percentage-bar">
                            <div class="percentage-fill" style="width: {{ $totalApplications > 0 ? ($pendingApplications/$totalApplications*100) : 0 }}%; background: #f59e0b;">
                                {{ $totalApplications > 0 ? round($pendingApplications/$totalApplications*100, 1) : 0 }}%
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><span style="display: inline-block; width: 12px; height: 12px; background: #10b981; border-radius: 3px; margin-right: 8px;"></span>Accepted</td>
                    <td><strong>{{ $acceptedApplications }}</strong></td>
                    <td>{{ $totalApplications > 0 ? round($acceptedApplications/$totalApplications*100, 1) : 0 }}%</td>
                    <td>
                        <div class="percentage-bar">
                            <div class="percentage-fill" style="width: {{ $totalApplications > 0 ? ($acceptedApplications/$totalApplications*100) : 0 }}%; background: #10b981;">
                                {{ $totalApplications > 0 ? round($acceptedApplications/$totalApplications*100, 1) : 0 }}%
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><span style="display: inline-block; width: 12px; height: 12px; background: #ef4444; border-radius: 3px; margin-right: 8px;"></span>Rejected</td>
                    <td><strong>{{ $rejectedApplications }}</strong></td>
                    <td>{{ $totalApplications > 0 ? round($rejectedApplications/$totalApplications*100, 1) : 0 }}%</td>
                    <td>
                        <div class="percentage-bar">
                            <div class="percentage-fill" style="width: {{ $totalApplications > 0 ? ($rejectedApplications/$totalApplications*100) : 0 }}%; background: #ef4444;">
                                {{ $totalApplications > 0 ? round($rejectedApplications/$totalApplications*100, 1) : 0 }}%
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalApps = {{ $totalApplications }};
        
        // Status Chart
        @if($totalApplications > 0)
            const statusCtx = document.getElementById('statusChart');
            if (statusCtx) {
                const statusGradient = statusCtx.getContext('2d');
                const pendingGrad = statusGradient.createLinearGradient(0, 0, 0, 200);
                pendingGrad.addColorStop(0, '#f59e0b');
                pendingGrad.addColorStop(1, '#d97706');
                
                const acceptedGrad = statusGradient.createLinearGradient(0, 0, 0, 200);
                acceptedGrad.addColorStop(0, '#10b981');
                acceptedGrad.addColorStop(1, '#059669');
                
                const rejectedGrad = statusGradient.createLinearGradient(0, 0, 0, 200);
                rejectedGrad.addColorStop(0, '#ef4444');
                rejectedGrad.addColorStop(1, '#dc2626');

                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'Accepted', 'Rejected'],
                        datasets: [{
                            data: [
                                {{ $pendingApplications }},
                                {{ $acceptedApplications }},
                                {{ $rejectedApplications }}
                            ],
                            backgroundColor: [pendingGrad, acceptedGrad, rejectedGrad],
                            borderColor: 'white',
                            borderWidth: 3,
                            borderRadius: 6,
                            spacing: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        animation: {
                            animateRotate: true,
                            duration: 1500,
                            easing: 'easeInOutQuart'
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: { size: 13, weight: '700' },
                                    color: '#0f172a',
                                    padding: 15,
                                    usePointStyle: true
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleFont: { size: 14, weight: 'bold' },
                                bodyFont: { size: 13 },
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return label + ': ' + value + ' (' + percentage + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Gender Chart
            const genderCtx = document.getElementById('genderChart');
            if (genderCtx) {
                const genderGradient = genderCtx.getContext('2d');
                const femaleGrad = genderGradient.createLinearGradient(0, 0, 0, 200);
                femaleGrad.addColorStop(0, '#6366f1');
                femaleGrad.addColorStop(1, '#4f46e5');
                
                const maleGrad = genderGradient.createLinearGradient(0, 0, 0, 200);
                maleGrad.addColorStop(0, '#0ea5e9');
                maleGrad.addColorStop(1, '#0284c7');
                
                const otherGrad = genderGradient.createLinearGradient(0, 0, 0, 200);
                otherGrad.addColorStop(0, '#14b8a6');
                otherGrad.addColorStop(1, '#0d9488');

                new Chart(genderCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Female', 'Male', 'Other/Unknown'],
                        datasets: [{
                            data: [
                                {{ $femaleCount }},
                                {{ $maleCount }},
                                {{ $otherCount }}
                            ],
                            backgroundColor: [femaleGrad, maleGrad, otherGrad],
                            borderColor: 'white',
                            borderWidth: 3,
                            borderRadius: 6,
                            spacing: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        animation: {
                            animateRotate: true,
                            duration: 1500,
                            easing: 'easeInOutQuart'
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: { size: 13, weight: '700' },
                                    color: '#0f172a',
                                    padding: 15,
                                    usePointStyle: true
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleFont: { size: 14, weight: 'bold' },
                                bodyFont: { size: 13 },
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return label + ': ' + value + ' (' + percentage + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Trend Chart - Line Chart
            const trendCtx = document.getElementById('trendChart');
            if (trendCtx) {
                const ctx = trendCtx.getContext('2d');
                
                const pendingTrendGrad = ctx.createLinearGradient(0, 0, 0, 300);
                pendingTrendGrad.addColorStop(0, 'rgba(245, 158, 11, 0.3)');
                pendingTrendGrad.addColorStop(1, 'rgba(245, 158, 11, 0)');
                
                const acceptedTrendGrad = ctx.createLinearGradient(0, 0, 0, 300);
                acceptedTrendGrad.addColorStop(0, 'rgba(16, 185, 129, 0.3)');
                acceptedTrendGrad.addColorStop(1, 'rgba(16, 185, 129, 0)');
                
                const rejectedTrendGrad = ctx.createLinearGradient(0, 0, 0, 300);
                rejectedTrendGrad.addColorStop(0, 'rgba(239, 68, 68, 0.3)');
                rejectedTrendGrad.addColorStop(1, 'rgba(239, 68, 68, 0)');

                new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($trendDates) !!},
                        datasets: [
                            {
                                label: 'Pending',
                                data: {!! json_encode($trendPending) !!},
                                borderColor: '#f59e0b',
                                backgroundColor: pendingTrendGrad,
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#f59e0b',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointHoverRadius: 6
                            },
                            {
                                label: 'Accepted',
                                data: {!! json_encode($trendAccepted) !!},
                                borderColor: '#10b981',
                                backgroundColor: acceptedTrendGrad,
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#10b981',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointHoverRadius: 6
                            },
                            {
                                label: 'Rejected',
                                data: {!! json_encode($trendRejected) !!},
                                borderColor: '#ef4444',
                                backgroundColor: rejectedTrendGrad,
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#ef4444',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointHoverRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: { size: 13, weight: '700' },
                                    color: '#0f172a',
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                padding: 16,
                                titleFont: { size: 14, weight: '700' },
                                bodyFont: { size: 13 },
                                borderColor: 'rgba(255, 255, 255, 0.2)',
                                borderWidth: 1,
                                displayColors: true,
                                callbacks: {
                                    afterLabel: function() {
                                        return '';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    font: { size: 12, weight: '600' },
                                    color: '#64748b'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.08)',
                                    drawBorder: false
                                },
                                ticks: {
                                    font: { size: 12, weight: '600' },
                                    color: '#64748b',
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }
        @endif
    });
</script>
@endpush

@endsection
