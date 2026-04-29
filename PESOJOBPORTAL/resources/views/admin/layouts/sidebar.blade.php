<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="sidebar-user-name">
                <h6>{{ Str::limit(auth()->user()->name, 15) }}</h6>
                <p>Administrator</p>
            </div>
        </div>
    </div>

    <ul class="sidebar-menu">
        <!-- Dashboard -->
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
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
            <a href="{{ route('admin.jobseekers.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.jobseekers.*') ? 'active' : '' }}">
                <i class="bi bi-person-check"></i>
                <span>Jobseeker Approvals</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.employer-verification') }}" class="sidebar-menu-link {{ request()->routeIs('admin.employer-verification') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Employer Verification</span>
                @if(($adminSidebarCounts['pendingEmployerVerification'] ?? 0) > 0)
                    <span style="margin-left:auto; min-width:22px; height:22px; padding:0 7px; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; background:#ef4444; color:#fff; font-size:11px; font-weight:700; line-height:1;">{{ $adminSidebarCounts['pendingEmployerVerification'] }}</span>
                @endif
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.job-approvals') }}" class="sidebar-menu-link {{ request()->routeIs('admin.job-approvals') ? 'active' : '' }}">
                <i class="bi bi-file-check"></i>
                <span>Job Approvals</span>
                @if(($adminSidebarCounts['pendingJobApprovals'] ?? 0) > 0)
                    <span style="margin-left:auto; min-width:22px; height:22px; padding:0 7px; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; background:#0ea5e9; color:#fff; font-size:11px; font-weight:700; line-height:1;">{{ $adminSidebarCounts['pendingJobApprovals'] }}</span>
                @endif
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.lra-sra-approvals') }}" class="sidebar-menu-link {{ request()->routeIs('admin.lra-sra-approvals') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check"></i>
                <span>LRA/SRA Approvals</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.document-verification') }}" class="sidebar-menu-link {{ request()->routeIs('admin.document-verification') ? 'active' : '' }}">
                <i class="bi bi-file-earmark"></i>
                <span>Document Verification</span>
            </a>
        </li>

        <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

        <!-- Management Section -->
        <li style="padding: 0 1.5rem; margin: 0.5rem 0; opacity: 0.6;">
            <small style="text-transform: uppercase; font-weight: 700; letter-spacing: 1px; font-size: 10px;">Management</small>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('admin.jobseekers-management') }}" class="sidebar-menu-link {{ request()->routeIs('admin.jobseekers-management') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Jobseekers</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.employers-management') }}" class="sidebar-menu-link {{ request()->routeIs('admin.employers-management') ? 'active' : '' }}">
                <i class="bi bi-shop"></i>
                <span>Employers</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.jobs-management') }}" class="sidebar-menu-link {{ request()->routeIs('admin.jobs-management') ? 'active' : '' }}">
                <i class="bi bi-briefcase"></i>
                <span>Jobs</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.applications-management') }}" class="sidebar-menu-link {{ request()->routeIs('admin.applications-management') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-check"></i>
                <span>Applications</span>
            </a>
        </li>

        <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

        <!-- Intelligence & Reports Section -->
        <li style="padding: 0 1.5rem; margin: 0.5rem 0; opacity: 0.6;">
            <small style="text-transform: uppercase; font-weight: 700; letter-spacing: 1px; font-size: 10px;">Intelligence & Reports</small>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('admin.employment-stats') }}" class="sidebar-menu-link {{ request()->routeIs('admin.employment-stats') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i>
                <span>Employment Stats</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.skills-gap-analysis') }}" class="sidebar-menu-link {{ request()->routeIs('admin.skills-gap-analysis') ? 'active' : '' }}">
                <i class="bi bi-diagram-3"></i>
                <span>Skills Gap Analysis</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.barangay-intelligence') }}" class="sidebar-menu-link {{ request()->routeIs('admin.barangay-intelligence') ? 'active' : '' }}">
                <i class="bi bi-map"></i>
                <span>Barangay Intelligence</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.report-builder') }}" class="sidebar-menu-link {{ request()->routeIs('admin.report-builder') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i>
                <span>Dynamic Report Builder</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.peso-clearances') }}" class="sidebar-menu-link {{ request()->routeIs('admin.peso-clearances') ? 'active' : '' }}">
                <i class="bi bi-file-pdf"></i>
                <span>PESO Clearances</span>
                @if(($adminSidebarCounts['pendingPesoClearances'] ?? 0) > 0)
                    <span class="sidebar-badge" style="background:#f59e0b;">{{ $adminSidebarCounts['pendingPesoClearances'] }}</span>
                @endif
            </a>
        </li>

        <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

        <!-- Tools & Settings Section -->
        <li style="padding: 0 1.5rem; margin: 0.5rem 0; opacity: 0.6;">
            <small style="text-transform: uppercase; font-weight: 700; letter-spacing: 1px; font-size: 10px;">Tools & Settings</small>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('admin.settings') }}" class="sidebar-menu-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.alerts-notifications') }}" class="sidebar-menu-link {{ request()->routeIs('admin.alerts-notifications') ? 'active' : '' }}">
                <i class="bi bi-bell"></i>
                <span>Alerts & Notifications</span>
                @if(($adminSidebarCounts['adminUnreadNotifications'] ?? 0) > 0)
                    <span class="sidebar-badge">{{ $adminSidebarCounts['adminUnreadNotifications'] }}</span>
                @endif
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.qr-verification') }}" class="sidebar-menu-link {{ request()->routeIs('admin.qr-verification') ? 'active' : '' }}">
                <i class="bi bi-qr-code"></i>
                <span>QR Verification</span>
            </a>
        </li>

        <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

        <li class="sidebar-menu-item">
            <a href="{{ route('logout') }}" class="sidebar-menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">@csrf</form>
</aside>
