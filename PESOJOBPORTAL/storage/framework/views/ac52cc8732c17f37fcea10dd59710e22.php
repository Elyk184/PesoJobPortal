<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <a href="<?php echo e(route('admin.profile')); ?>" style="text-decoration: none; color: inherit; display: block; transition: all 0.3s ease; border-radius: 8px; padding: 0.5rem; margin: -0.5rem;">
            <div class="sidebar-user" style="cursor: pointer;">
                <div class="sidebar-user-avatar"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?></div>
                <div class="sidebar-user-name">
                    <h6><?php echo e(Str::limit(auth()->user()->name, 15)); ?></h6>
                    <p>Administrator</p>
                </div>
            </div>
        </a>
    </div>

    <ul class="sidebar-menu">
        <!-- Dashboard -->
        <li class="sidebar-menu-item">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

        <!-- Approvals & Verification Section -->
        <li style="padding: 0 1.5rem; margin: 0.5rem 0; opacity: 0.6;">
            <small style="text-transform: uppercase; font-weight: 700; letter-spacing: 1px; font-size: 10px;">Approvals & Verification</small>
        </li>

        <li class="sidebar-menu-item">
            <a href="<?php echo e(route('admin.employer-verification')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.employer-verification*') ? 'active' : ''); ?>">
                <i class="bi bi-building"></i>
                <span>Employers</span>
                <?php if(($adminSidebarCounts['pendingEmployerVerification'] ?? 0) > 0): ?>
                    <span class="sidebar-badge"><?php echo e($adminSidebarCounts['pendingEmployerVerification']); ?></span>
                <?php endif; ?>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="<?php echo e(route('admin.job-approvals')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.job-approvals') ? 'active' : ''); ?>">
                <i class="bi bi-file-check"></i>
                <span>Job Applicants</span>
                <?php if(($adminSidebarCounts['pendingJobApprovals'] ?? 0) > 0): ?>
                    <span class="sidebar-badge" style="background:#0ea5e9;"><?php echo e($adminSidebarCounts['pendingJobApprovals']); ?></span>
                <?php endif; ?>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="<?php echo e(route('admin.lra-sra-approvals')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.lra-sra-approvals') ? 'active' : ''); ?>">
                <i class="bi bi-clipboard-check"></i>
                <span>LRA/SRA Approvals</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="<?php echo e(route('admin.ofw-submissions')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.ofw-submissions*') ? 'active' : ''); ?>">
                <i class="bi bi-file-earmark-pdf"></i>
                <span>OFW Requests</span>
                <?php if(($adminSidebarCounts['submittedOfwRequests'] ?? 0) > 0): ?>
                    <span class="sidebar-badge" style="background:#10b981;"><?php echo e($adminSidebarCounts['submittedOfwRequests']); ?></span>
                <?php endif; ?>
            </a>
        </li>
   

        <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

        <!-- Intelligence & Reports Section -->
        <li style="padding: 0 1.5rem; margin: 0.5rem 0; opacity: 0.6;">
            <small style="text-transform: uppercase; font-weight: 700; letter-spacing: 1px; font-size: 10px;">Intelligence & Reports</small>
        </li>

        <li class="sidebar-menu-item">
            <a href="<?php echo e(route('admin.employment-stats')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.employment-stats') ? 'active' : ''); ?>">
                <i class="bi bi-bar-chart-line"></i>
                <span>Employment Stats</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="<?php echo e(route('admin.skills-gap-analysis')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.skills-gap-analysis') ? 'active' : ''); ?>">
                <i class="bi bi-diagram-3"></i>
                <span>Skills Gap Analysis</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="<?php echo e(route('admin.peso-clearances')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.peso-clearances') ? 'active' : ''); ?>">
                <i class="bi bi-file-pdf"></i>
                <span>PESO Clearances</span>
                <?php if(($adminSidebarCounts['pendingPesoClearances'] ?? 0) > 0): ?>
                    <span class="sidebar-badge" style="background:#f59e0b;"><?php echo e($adminSidebarCounts['pendingPesoClearances']); ?></span>
                <?php endif; ?>
            </a>
        </li>

        <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

        <!-- Tools & Settings Section -->
        <li style="padding: 0 1.5rem; margin: 0.5rem 0; opacity: 0.6;">
            <small style="text-transform: uppercase; font-weight: 700; letter-spacing: 1px; font-size: 10px;">Tools & Settings</small>
        </li>

        <li class="sidebar-menu-item">
            <a href="<?php echo e(route('admin.settings')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.settings') ? 'active' : ''); ?>">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="<?php echo e(route('admin.alerts-notifications')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.alerts-notifications') ? 'active' : ''); ?>">
                <i class="bi bi-bell"></i>
                <span>Alerts & Notifications</span>
                <?php if(($adminSidebarCounts['adminUnreadNotifications'] ?? 0) > 0): ?>
                    <span class="sidebar-badge"><?php echo e($adminSidebarCounts['adminUnreadNotifications']); ?></span>
                <?php endif; ?>
            </a>
        </li>
      

        <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

        <li class="sidebar-menu-item">
            <a href="<?php echo e(route('logout')); ?>" class="sidebar-menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
    <form id="logout-form" method="POST" action="<?php echo e(route('logout')); ?>" style="display: none;"><?php echo csrf_field(); ?></form>
</aside>
<?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\admin\layouts\sidebar.blade.php ENDPATH**/ ?>