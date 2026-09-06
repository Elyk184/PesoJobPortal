<?php $__env->startSection('title', 'Employment Statistics | PESO Admin'); ?>

<?php
    $pageTitle = 'Employment Statistics';
    $pageSubtitle = 'View employment trends and statistics';
    $pageIcon = 'bi-bar-chart-line';
?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
<style>
    /* ── Base ── */
    .es-wrap {
        padding: 0.5rem 0 2rem;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    /* ── Toolbar ── */
    .es-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.75rem;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    .es-toolbar-title {
        font-size: 20px;
        font-weight: 600;
        color: #0d1f3c;
        margin: 0;
    }
    .es-toolbar-sub {
        font-size: 13px;
        color: #6b7280;
        margin: 2px 0 0;
    }
    .es-print-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.5rem 1rem;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        transition: background 0.15s, border-color 0.15s;
    }
    .es-print-btn:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }
    .es-print-btn i { font-size: 15px; }

    /* ── Stat cards ── */
    .es-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px;
        margin-bottom: 1.5rem;
    }
    .es-stat {
        background: #f9fafb;
        border-radius: 10px;
        padding: 1.1rem 1.25rem;
        border: 1px solid #f3f4f6;
    }
    .es-stat-label {
        font-size: 12px;
        color: #9ca3af;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin: 0 0 8px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .es-stat-label i { font-size: 13px; }
    .es-stat-value {
        font-size: 28px;
        font-weight: 600;
        color: #0d1f3c;
        line-height: 1;
        margin: 0 0 6px;
    }
    .es-stat-trend {
        font-size: 11px;
        color: #10b981;
        font-weight: 500;
        margin: 0;
    }
    .es-stat-trend.down { color: #ef4444; }

    /* ── Chart cards ── */
    .es-two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 12px;
    }
    .es-chart-card {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 1.25rem;
    }
    .es-chart-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }
    .es-chart-title {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 6px;
        margin: 0;
    }
    .es-chart-title i { font-size: 14px; color: #9ca3af; }

    /* ── Legends ── */
    .es-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 10px;
        font-size: 11px;
        color: #6b7280;
    }
    .es-legend span {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .es-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
        display: inline-block;
    }

    /* ── Print ── */
    .print-header { display: none; }

    @media (max-width: 768px) {
        .es-two-col { grid-template-columns: 1fr; }
        .es-stat-value { font-size: 24px; }
    }

    @media print {
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .admin-sidebar,
        .admin-topbar,
        .sidebar-header,
        .sidebar-menu,
        .es-print-btn,
        .navbar,
        nav { display: none !important; }

        .admin-main { margin-left: 0 !important; padding: 0 !important; }
        .admin-dashboard { background: white !important; }

        .es-chart-card, .es-stat {
            border: 1px solid #e5e7eb !important;
            box-shadow: none !important;
            break-inside: avoid;
        }

        .print-header {
            display: block !important;
            text-align: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #0d1f3c;
        }
        .print-header h1 { font-size: 22px; color: #0d1f3c; margin: 0; }
        .print-header p { font-size: 12px; color: #6b7280; margin: 4px 0 0; }

        canvas { max-width: 100%; height: auto !important; }

        @page { size: A4; margin: 12mm; }
    }
</style>

<div class="es-wrap">

    <!-- Print header (only shows on print) -->
    <div class="print-header">
        <h1>Employment Statistics Report</h1>
        <p>Generated on <?php echo e(now()->format('F d, Y')); ?></p>
    </div>

    <!-- Toolbar -->
    <div class="es-toolbar">
        <div>
            <p class="es-toolbar-title">Employment Statistics</p>
            <p class="es-toolbar-sub">Overview of placements, postings, and application trends</p>
        </div>
        <button class="es-print-btn" onclick="window.print()">
            <i class="bi bi-printer"></i> Print Report
        </button>
    </div>

    <!-- Stat cards -->
    <div class="es-stats">
        <div class="es-stat">
            <p class="es-stat-label"><i class="bi bi-people"></i> Jobseekers</p>
            <p class="es-stat-value"><?php echo e(number_format($stats['total_jobseekers'])); ?></p>
            <p class="es-stat-trend">↑ Registered to date</p>
        </div>
        <div class="es-stat">
            <p class="es-stat-label"><i class="bi bi-briefcase"></i> Active postings</p>
            <p class="es-stat-value"><?php echo e(number_format($stats['active_jobs'])); ?></p>
            <p class="es-stat-trend">↑ Open right now</p>
        </div>
        <div class="es-stat">
            <p class="es-stat-label"><i class="bi bi-check2-circle"></i> Placements</p>
            <p class="es-stat-value"><?php echo e(number_format($stats['successful_placements'])); ?></p>
            <p class="es-stat-trend">↑ Successful hires</p>
        </div>
        <div class="es-stat">
            <p class="es-stat-label"><i class="bi bi-building"></i> Employers</p>
            <p class="es-stat-value"><?php echo e(number_format($stats['registered_employers'])); ?></p>
            <p class="es-stat-trend">↑ Registered partners</p>
        </div>
    </div>

    <!-- Row 1: Line + Donut -->
    <div class="es-two-col">
        <div class="es-chart-card">
            <div class="es-chart-head">
                <p class="es-chart-title"><i class="bi bi-graph-up"></i> Jobs posted — last 12 months</p>
            </div>
            <div class="es-legend">
                <span><span class="es-dot" style="background:#1D9E75"></span>Active</span>
                <span><span class="es-dot" style="background:#EF9F27"></span>Pending</span>
                <span><span class="es-dot" style="background:#E24B4A"></span>Closed</span>
            </div>
            <div style="position:relative;width:100%;height:200px">
                <canvas id="jobsTrendChart"></canvas>
            </div>
        </div>

        <div class="es-chart-card">
            <div class="es-chart-head">
                <p class="es-chart-title"><i class="bi bi-pie-chart"></i> Application status</p>
            </div>
            <div class="es-legend">
                <?php $__currentLoopData = $appStatusLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $dotColors = ['#378ADD','#1D9E75','#E24B4A'];
                    $pct = $appStatusData[$i] > 0 ? round($appStatusData[$i] / max(array_sum($appStatusData),1) * 100) : 0;
                ?>
                <span>
                    <span class="es-dot" style="background:<?php echo e($dotColors[$i % count($dotColors)]); ?>"></span>
                    <?php echo e($label); ?> <?php echo e($pct); ?>%
                </span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div style="position:relative;width:100%;height:200px">
                <canvas id="appStatusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top job types -->
    <div class="es-chart-card" style="margin-bottom:12px">
        <div class="es-chart-head">
            <p class="es-chart-title"><i class="bi bi-bar-chart"></i> Top job types</p>
        </div>
        <div style="position:relative;width:100%;height:<?php echo e(count($categoryLabels) * 40 + 60); ?>px">
            <canvas id="categoriesChart"></canvas>
        </div>
    </div>

    <!-- Applications trend -->
    <div class="es-chart-card" style="margin-bottom:12px">
        <div class="es-chart-head">
            <p class="es-chart-title"><i class="bi bi-bar-chart-line"></i> Applications — last 30 days</p>
        </div>
        <div style="position:relative;width:100%;height:160px">
            <canvas id="trendChart"></canvas>
        </div>
    </div>

    <!-- Profile completion (conditional) -->
    <?php if($jobseekerStats && $jobseekerStats->total > 0): ?>
    <div class="es-chart-card">
        <div class="es-chart-head">
            <p class="es-chart-title"><i class="bi bi-person-check"></i> Jobseeker profile completion</p>
        </div>
        <?php
            $withProfile = $jobseekerStats->with_profile;
            $withoutProfile = $jobseekerStats->total - $jobseekerStats->with_profile;
            $completePct = round($withProfile / max($jobseekerStats->total, 1) * 100);
        ?>
        <div class="es-legend">
            <span><span class="es-dot" style="background:#1D9E75"></span>Complete <?php echo e($completePct); ?>%</span>
            <span><span class="es-dot" style="background:#e5e7eb"></span>Incomplete <?php echo e(100 - $completePct); ?>%</span>
        </div>
        <div style="position:relative;width:100%;height:200px">
            <canvas id="profileCompletionChart"></canvas>
        </div>
    </div>
    <?php endif; ?>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const _gridColor = 'rgba(0,0,0,0.04)';
    const _tickColor = 'rgba(0,0,0,0.35)';
    const _baseFont = { family: "-apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif", size: 11 };

    // ── Jobs Trend (Line) ──────────────────────────────
    new Chart(document.getElementById('jobsTrendChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: <?php echo json_encode($monthLabels, 15, 512) ?>,
            datasets: [
                {
                    label: 'Active',
                    data: <?php echo json_encode($jobsActive, 15, 512) ?>,
                    borderColor: '#1D9E75',
                    backgroundColor: 'rgba(29,158,117,0.07)',
                    tension: 0.4, fill: true,
                    borderWidth: 2, pointRadius: 0, pointHoverRadius: 4,
                    pointBackgroundColor: '#1D9E75'
                },
                {
                    label: 'Pending',
                    data: <?php echo json_encode($jobsPending, 15, 512) ?>,
                    borderColor: '#EF9F27',
                    backgroundColor: 'rgba(239,159,39,0.07)',
                    tension: 0.4, fill: true,
                    borderWidth: 2, pointRadius: 0, pointHoverRadius: 4,
                    pointBackgroundColor: '#EF9F27'
                },
                {
                    label: 'Closed',
                    data: <?php echo json_encode($jobsClosed, 15, 512) ?>,
                    borderColor: '#E24B4A',
                    backgroundColor: 'rgba(226,75,74,0.07)',
                    tension: 0.4, fill: true,
                    borderWidth: 2, pointRadius: 0, pointHoverRadius: 4,
                    pointBackgroundColor: '#E24B4A'
                }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    grid: { color: _gridColor },
                    ticks: { color: _tickColor, font: _baseFont, maxRotation: 0, autoSkip: true, maxTicksLimit: 6 }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: _gridColor },
                    ticks: { color: _tickColor, font: _baseFont }
                }
            }
        }
    });

    // ── Application Status (Donut) ─────────────────────
    new Chart(document.getElementById('appStatusChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($appStatusLabels, 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($appStatusData, 15, 512) ?>,
                backgroundColor: ['#378ADD', '#1D9E75', '#E24B4A'],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '70%',
            plugins: { legend: { display: false } }
        }
    });

    // ── Top Job Types (Horizontal Bar) ─────────────────
    new Chart(document.getElementById('categoriesChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($categoryLabels, 15, 512) ?>,
            datasets: [{
                label: 'Jobs',
                data: <?php echo json_encode($categoryData, 15, 512) ?>,
                backgroundColor: '#378ADD',
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: _gridColor },
                    ticks: { color: _tickColor, font: _baseFont }
                },
                y: {
                    grid: { display: false },
                    ticks: { color: _tickColor, font: _baseFont }
                }
            }
        }
    });

    // ── Applications Trend (Bar) ───────────────────────
    new Chart(document.getElementById('trendChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($trendDates, 15, 512) ?>,
            datasets: [{
                label: 'Applications',
                data: <?php echo json_encode($trendData, 15, 512) ?>,
                backgroundColor: 'rgba(55,138,221,0.55)',
                borderRadius: 3,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: _tickColor, font: _baseFont, autoSkip: true, maxTicksLimit: 8, maxRotation: 0 }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: _gridColor },
                    ticks: { color: _tickColor, font: _baseFont }
                }
            }
        }
    });

    // ── Profile Completion (Donut) ─────────────────────
    <?php if($jobseekerStats && $jobseekerStats->total > 0): ?>
    new Chart(document.getElementById('profileCompletionChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Complete', 'Incomplete'],
            datasets: [{
                data: [<?php echo e($jobseekerStats->with_profile); ?>, <?php echo e($jobseekerStats->total - $jobseekerStats->with_profile); ?>],
                backgroundColor: ['#1D9E75', '#e5e7eb'],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '70%',
            plugins: { legend: { display: false } }
        }
    });
    <?php endif; ?>

    // ── Print helpers ──────────────────────────────────
    document.addEventListener('keydown', e => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
            e.preventDefault();
            window.print();
        }
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/admin/employment-stats.blade.php ENDPATH**/ ?>