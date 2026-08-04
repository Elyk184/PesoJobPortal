<?php $__env->startSection('title', 'PESO Clearances | PESO Admin'); ?>

<?php
    $pageTitle = 'PESO Clearances';
    $pageSubtitle = 'Generate and manage PESO clearance documents';
    $pageIcon = 'bi-file-pdf';
?>

<?php $__env->startSection('content'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

    .peso-wrap {
        padding: 2rem 2.5rem;
        font-family: 'DM Sans', sans-serif;
        color: #0f172a;
    }

    /* ── Page Header ── */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 2rem;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .page-header-left h1 {
        font-size: 1.6rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 0.25rem;
        letter-spacing: -0.02em;
    }
    .page-header-left p {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
    }
    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    /* ── Buttons ── */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        text-decoration: none;
        transition: all 0.18s ease;
        white-space: nowrap;
    }
    .btn-primary {
        background: #0f172a;
        color: #fff;
    }
    .btn-primary:hover { background: #1e293b; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(15,23,42,0.2); }
    .btn-outline {
        background: #fff;
        color: #0f172a;
        border: 1.5px solid #e2e8f0;
    }
    .btn-outline:hover { border-color: #94a3b8; background: #f8fafc; }

    .btn-issue {
        background: #dcfce7;
        color: #15803d;
        border: 1.5px solid #bbf7d0;
        padding: 0.4rem 0.9rem;
        font-size: 0.8rem;
    }
    .btn-issue:hover { background: #16a34a; color: #fff; border-color: #16a34a; }
    .btn-issued {
        background: #dcfce7;
        color: #15803d;
        border: 1.5px solid #86efac;
        padding: 0.4rem 0.9rem;
        font-size: 0.8rem;
    }
    .btn-issued:hover { background: #dcfce7; color: #15803d; border-color: #86efac; }

    .btn-decline {
        background: #fef2f2;
        color: #dc2626;
        border: 1.5px solid #fecaca;
        padding: 0.4rem 0.9rem;
        font-size: 0.8rem;
    }
    .btn-decline:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

    .btn-view {
        background: #eff6ff;
        color: #2563eb;
        border: 1.5px solid #bfdbfe;
        padding: 0.4rem 0.9rem;
        font-size: 0.8rem;
    }
    .btn-view:hover { background: #2563eb; color: #fff; border-color: #2563eb; }

    /* ── Stats Row ── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: box-shadow 0.2s;
    }
    .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.07); }
    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .stat-icon.yellow { background: #fef9c3; color: #ca8a04; }
    .stat-icon.green  { background: #dcfce7; color: #16a34a; }
    .stat-icon.red    { background: #fef2f2; color: #dc2626; }
    .stat-icon.blue   { background: #eff6ff; color: #2563eb; }
    .stat-info .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 0.2rem;
    }
    .stat-info .stat-label {
        font-size: 0.78rem;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    /* ── Table Card ── */
    .table-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }
    .table-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .table-card-header h3 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .badge-count {
        background: #f1f5f9;
        color: #475569;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.15rem 0.55rem;
        border-radius: 20px;
    }
    .search-box {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.45rem 0.75rem;
        font-size: 0.85rem;
        color: #64748b;
        min-width: 220px;
    }
    .search-box input {
        border: none;
        background: transparent;
        outline: none;
        font-size: 0.85rem;
        color: #0f172a;
        width: 100%;
        font-family: 'DM Sans', sans-serif;
    }
    .search-box input::placeholder { color: #94a3b8; }

    /* ── Table ── */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table thead tr {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
    .data-table th {
        padding: 0.75rem 1.5rem;
        text-align: left;
        font-size: 0.72rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        white-space: nowrap;
    }
    .data-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #fafbff; }
    .data-table tbody tr.row-issued {
        background: #dcfce7;
    }
    .data-table tbody tr.row-issued:hover {
        background: #c8f7d4;
    }
    .data-table tbody tr.row-declined {
        background: #fee2e2;
    }
    .data-table tbody tr.row-declined:hover {
        background: #fecaca;
    }
    .data-table td {
        padding: 1rem 1.5rem;
        font-size: 0.875rem;
        color: #374151;
        vertical-align: middle;
    }

    .applicant-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .applicant-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        font-size: 0.75rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        text-transform: uppercase;
    }
    .applicant-name {
        font-weight: 600;
        color: #0f172a;
        line-height: 1.2;
    }
    .applicant-name-link {
        color: inherit;
        text-decoration: none;
    }
    .applicant-name-link:hover {
        color: #2563eb;
        text-decoration: underline;
    }

    .address-text {
        color: #64748b;
        font-size: 0.85rem;
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .address-text.na { color: #cbd5e1; font-style: italic; }

    .date-text {
        font-family: 'DM Mono', monospace;
        font-size: 0.8rem;
        color: #64748b;
        background: #f8fafc;
        padding: 0.2rem 0.5rem;
        border-radius: 5px;
        border: 1px solid #e2e8f0;
        display: inline-block;
    }
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        width: max-content;
        padding: 0.2rem 0.55rem;
        border-radius: 999px;
        font-size: 0.74rem;
        font-weight: 700;
        letter-spacing: 0.01em;
        margin-top: 0.35rem;
    }

    .action-cell {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    /* ── Empty State ── */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
        color: #94a3b8;
    }
    .empty-state i { font-size: 2.5rem; margin-bottom: 0.75rem; display: block; opacity: 0.4; }
    .empty-state p { margin: 0; font-size: 0.9rem; }

    /* ── Confirm Modal ── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15,23,42,0.45);
        backdrop-filter: blur(3px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        animation: modalIn 0.2s ease;
    }
    @keyframes modalIn { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    .modal-icon {
        width: 52px; height: 52px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 1rem;
    }
    .modal-icon.issue { background: #dcfce7; color: #16a34a; }
    .modal-icon.decline { background: #fef2f2; color: #dc2626; }
    .modal-box h4 { margin: 0 0 0.4rem; font-size: 1.05rem; font-weight: 700; }
    .modal-box p { margin: 0 0 1.5rem; color: #64748b; font-size: 0.88rem; line-height: 1.5; }
    .modal-actions { display: flex; gap: 0.75rem; justify-content: flex-end; }
    .btn-cancel { background: #f1f5f9; color: #475569; border: none; padding: 0.55rem 1.1rem; border-radius: 8px; font-size: 0.875rem; font-weight: 600; cursor: pointer; }
    .btn-cancel:hover { background: #e2e8f0; }
    .btn-confirm-issue { background: #16a34a; color: #fff; border: none; padding: 0.55rem 1.1rem; border-radius: 8px; font-size: 0.875rem; font-weight: 600; cursor: pointer; }
    .btn-confirm-issue:hover { background: #15803d; }
    .btn-confirm-decline { background: #dc2626; color: #fff; border: none; padding: 0.55rem 1.1rem; border-radius: 8px; font-size: 0.875rem; font-weight: 600; cursor: pointer; }
    .btn-confirm-decline:hover { background: #b91c1c; }
</style>

<div class="peso-wrap">
    <?php
        $latestClearance = $latestClearance ?? null;
        $latestDocumentClearance = $latestClearance && !empty($latestClearance->document_path) ? $latestClearance : null;
    ?>

    
    <div class="page-header">
        <div class="page-header-left">
            <h1>PESO Clearances</h1>
            <p>Review, issue, and manage employment clearance requests</p>
        </div>
        <div class="header-actions">
                <?php if($latestClearance): ?>
                <form method="POST" action="<?php echo e(route('admin.peso-clearances.generate-document', $latestClearance)); ?>" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-lightning-charge-fill"></i> Generate Document
                    </button>
                </form>
                    <?php if($latestDocumentClearance): ?>
                        <a href="<?php echo e(route('admin.peso-clearances.view-document', $latestDocumentClearance)); ?>" class="btn btn-outline">
                            <i class="bi bi-eye"></i> View Latest
                        </a>
                    <?php else: ?>
                        <button type="button" class="btn btn-outline" disabled>
                            <i class="bi bi-eye"></i> View Latest
                        </button>
                    <?php endif; ?>
            <?php else: ?>
                <button type="button" class="btn btn-primary" disabled>
                    <i class="bi bi-lightning-charge-fill"></i> Generate Document
                </button>
                <button type="button" class="btn btn-outline" disabled>
                    <i class="bi bi-eye"></i> View Latest
                </button>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon yellow"><i class="bi bi-hourglass-split"></i></div>
            <div class="stat-info">
                <div class="stat-value"><?php echo e($stats['pending']); ?></div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-check-circle"></i></div>
            <div class="stat-info">
                <div class="stat-value"><?php echo e($stats['active']); ?></div>
                <div class="stat-label">Issued</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red"><i class="bi bi-x-circle"></i></div>
            <div class="stat-info">
                <div class="stat-value"><?php echo e($stats['declined']); ?></div>
                <div class="stat-label">Declined</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-files"></i></div>
            <div class="stat-info">
                <div class="stat-value"><?php echo e($stats['total']); ?></div>
                <div class="stat-label">Total</div>
            </div>
        </div>
    </div>

    
    <div class="table-card">
        <div class="table-card-header">
            <h3>
                <i class="bi bi-clock-history" style="color:#f59e0b;"></i>
                Clearance Requests
                <span class="badge-count"><?php echo e($clearances->total()); ?></span>
            </h3>
            <div class="search-box">
                <i class="bi bi-search" style="color:#94a3b8; font-size:0.85rem;"></i>
                <input type="text" id="searchInput" placeholder="Search applicant..." oninput="filterTable()">
            </div>
        </div>

        <table class="data-table" id="clearanceTable">
            <thead>
                <tr>
                    <th>Applicant</th>
                    <th>Address</th>
                    <th>Date Requested</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $clearances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clearance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $applicantName = $clearance->user?->name ?? 'N/A';
                    $applicantEmail = $clearance->user?->email ?? 'N/A';
                    $requestDate = $clearance->request_date?->format('m/d/Y') ?? $clearance->created_at?->format('m/d/Y') ?? 'N/A';
                    $statusLabel = ucfirst($clearance->status ?? 'pending');
                    $statusClass = match ($clearance->status) {
                        'active' => 'background:#dcfce7;color:#15803d;',
                        'declined', 'rejected' => 'background:#fee2e2;color:#dc2626;',
                        default => 'background:#fef9c3;color:#a16207;',
                    };
                    $hasDocument = !empty($clearance->document_path) || !empty($clearance->issuedClearance?->document_path);
                    $fullNameParts = collect(preg_split('/\s+/', trim($applicantName)) ?: [])->filter()->values();
                    $avatar = $fullNameParts->take(2)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->join('');
                ?>
                <tr data-name="<?php echo e(strtolower($applicantName)); ?>" data-status="<?php echo e(strtolower($clearance->status ?? '')); ?>" class="<?php echo e($clearance->status === 'active' ? 'row-issued' : ($clearance->status === 'declined' ? 'row-declined' : '')); ?>">
                    <td>
                        <div class="applicant-cell">
                            <div class="applicant-avatar">
                                <?php echo e($avatar !== '' ? $avatar : strtoupper(substr($applicantName, 0, 1))); ?>

                            </div>
                            <?php if($clearance->user): ?>
                                <a href="<?php echo e(route('admin.jobseekers.show', $clearance->user)); ?>" class="applicant-name applicant-name-link">
                                    <?php echo e($clearance->user?->name ?? 'N/A'); ?>

                                </a>
                            <?php else: ?>
                                <div class="applicant-name"><?php echo e($clearance->user?->name ?? 'N/A'); ?></div>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <?php if($clearance->request_date || $clearance->issue_date || $clearance->expiry_date): ?>
                            <div style="display:flex;flex-direction:column;gap:0.2rem;">
                                <span class="address-text" style="white-space:normal;max-width:none;"><?php echo e($clearance->clearance_number); ?></span>
                                <span class="small text-muted"><?php echo e($clearance->remarks ?: 'No remarks provided'); ?></span>
                                <span class="small" style="color: <?php echo e($hasDocument ? '#15803d' : '#94a3b8'); ?>;">
                                    <?php echo e($hasDocument ? 'Document available' : 'Document not generated yet'); ?>

                                </span>
                                <?php if($clearance->is_first_time_jobseeker): ?>
                                    <span class="badge text-bg-info" style="width:max-content;">First-time jobseeker</span>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <span class="address-text na">Not provided</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="date-text"><?php echo e($requestDate); ?></span>
                        <div class="small text-muted mt-1">
                            <?php if($clearance->issue_date): ?>
                                Issued <?php echo e($clearance->issue_date->format('m/d/Y')); ?>

                            <?php elseif($clearance->status === 'pending'): ?>
                                Awaiting review
                            <?php endif; ?>
                        </div>
                        <div class="status-pill" style="<?php echo e($statusClass); ?>">
                            <?php echo e($statusLabel); ?>

                        </div>
                    </td>
                    <td>
                        <div class="action-cell">
                            <?php if($clearance->status !== 'pending'): ?>
                                <button class="btn btn-issued" type="button" disabled style="cursor:not-allowed;">
                                    <i class="bi bi-check-lg"></i> Issued
                                </button>
                            <?php endif; ?>
                            <a href="<?php echo e(route('admin.peso-clearances.view-document', $clearance)); ?>" class="btn btn-view">
                                <i class="bi bi-eye"></i> Open
                            </a>
                            <?php if($clearance->status === 'pending'): ?>
                                <form method="POST" action="<?php echo e(route('admin.peso-clearances.decline', $clearance)); ?>" style="display:inline;" onsubmit="return confirm('Decline this clearance request?');">
                                    <?php echo csrf_field(); ?>
                                    <button class="btn btn-decline" type="submit">
                                        <i class="bi bi-x-lg"></i> Decline
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>No PESO clearance requests at the moment.</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<div class="modal-overlay" id="confirmModal">
    <div class="modal-box">
        <div class="modal-icon" id="modalIcon"></div>
        <h4 id="modalTitle"></h4>
        <p id="modalDesc"></p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal()">Cancel</button>
            <button id="modalConfirmBtn"></button>
        </div>
    </div>
</div>

<script>
let pendingAction = null;
let pendingId = null;

function confirmAction(action, id) {
    pendingAction = action;
    pendingId = id;
    const modal = document.getElementById('confirmModal');
    const icon = document.getElementById('modalIcon');
    const title = document.getElementById('modalTitle');
    const desc = document.getElementById('modalDesc');
    const btn = document.getElementById('modalConfirmBtn');

    if (action === 'issue') {
        icon.className = 'modal-icon issue';
        icon.innerHTML = '<i class="bi bi-check-circle-fill"></i>';
        title.textContent = 'Preview Certificate?';
        desc.textContent = 'This will generate the certificate first so you can review it before issuing the clearance.';
        btn.className = 'btn-confirm-issue';
        btn.textContent = 'Yes, Preview';
        btn.onclick = () => executeAction('issue', id);
    }

    modal.classList.add('active');
}

function closeModal() {
    document.getElementById('confirmModal').classList.remove('active');
}

function executeAction(action, id) {
    closeModal();
    console.log(`${action} clearance:`, id);
    alert('This action is now handled directly from the table buttons.');
}

function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('#clearanceTable tbody tr[data-name]').forEach(row => {
        row.style.display = row.dataset.name.includes(q) ? '' : 'none';
    });
}

// Close modal on backdrop click
document.getElementById('confirmModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\admin\peso-clearances.blade.php ENDPATH**/ ?>