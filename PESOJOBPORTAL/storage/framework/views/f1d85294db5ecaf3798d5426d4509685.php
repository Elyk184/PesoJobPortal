<?php $__env->startSection('title', 'Employers Management | PESO Admin'); ?>

<?php
    $pageTitle = 'Employers Management';
    $pageSubtitle = 'Manage registered employers and their profiles';
    $pageIcon = 'bi-shop';
?>

<?php $__env->startSection('content'); ?>
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

        .btn-edit {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            border: 1px solid rgba(139, 92, 246, 0.3);
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            box-shadow: 0 8px 20px rgba(124, 58, 237, 0.3);
            transform: translateY(-2px);
        }

        .company-name {
            font-weight: 800;
            color: #0f1729;
            letter-spacing: 0.2px;
        }

        .contact-person {
            color: #475569;
            font-weight: 500;
        }

        .employer-email {
            color: #64748b;
            font-weight: 500;
        }

        .joined-date {
            color: #6b7280;
            font-weight: 500;
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
                    <th>Company Name</th>
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $employers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="company-name"><?php echo e($employer->companyProfile?->company_name ?? $employer->name); ?></td>
                        <td class="contact-person"><?php echo e($employer->companyProfile?->establishment_contact_person ?? 'N/A'); ?></td>
                        <td class="employer-email"><?php echo e($employer->email); ?></td>
                        <td class="joined-date"><?php echo e($employer->created_at?->format('d M Y') ?? 'N/A'); ?></td>
                        <td><span class="status-badge status-active"><i class="bi bi-check-circle me-1"></i>Active</span></td>
                        <td class="actions-cell">
                            <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button>
                            <button class="btn-small btn-edit"><i class="bi bi-pencil me-1"></i>Edit</button>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2rem; color: #6b7280;">
                            <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                            No verified employers at the moment.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\admin\employers-management.blade.php ENDPATH**/ ?>