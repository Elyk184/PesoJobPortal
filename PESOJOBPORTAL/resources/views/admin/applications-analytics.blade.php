@extends('layouts.admin-dashboard')

@section('title', 'Applications Analytics | PESO Admin')

<?php
    $pageTitle = 'Applications Analytics';
    $pageSubtitle = 'View job seeker application statistics and trends';
    $pageIcon = 'bi-pie-chart';
?>

@section('content')
<div class="admin-dashboard">
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalApps = {{ $totalApplications }};
        
        // Status Chart
        @if($totalApplications > 0)
            const statusCtx = document.getElementById('statusChart');
            if (statusCtx) {
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
                            backgroundColor: [
                                '#f59e0b',
                                '#10b981',
                                '#ef4444'
                            ],
                            borderColor: 'white',
                            borderWidth: 2,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
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
                            backgroundColor: [
                                '#6366f1',
                                '#0ea5e9',
                                '#14b8a6'
                            ],
                            borderColor: 'white',
                            borderWidth: 2,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
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
        @endif
    });
</script>
@endpush

@endsection
