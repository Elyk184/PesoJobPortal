<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.profile') }}" style="text-decoration: none; color: inherit; display: block; transition: all 0.3s ease; border-radius: 8px; padding: 0.5rem; margin: -0.5rem;">
            <div class="sidebar-user" style="cursor: pointer;">
                <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="sidebar-user-name">
                    <h6>{{ Str::limit(auth()->user()->name, 15) }}</h6>
                    <p>Administrator</p>
                </div>
            </div>
        </a>
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
            <a href="{{ route('admin.employer-verification') }}" class="sidebar-menu-link {{ request()->routeIs('admin.employer-verification*') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Employers</span>
                @if(($adminSidebarCounts['pendingEmployerVerification'] ?? 0) > 0)
                    <span class="sidebar-badge">{{ $adminSidebarCounts['pendingEmployerVerification'] }}</span>
                @endif
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.jobseekers.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.jobseekers*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Jobseekers</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.job-approvals') }}" class="sidebar-menu-link {{ request()->routeIs('admin.job-approvals') ? 'active' : '' }}">
                <i class="bi bi-file-check"></i>
                <span>Job Approvals</span>
                @if(($adminSidebarCounts['pendingJobApprovals'] ?? 0) > 0)
                    <span class="sidebar-badge" style="background:#0ea5e9;">{{ $adminSidebarCounts['pendingJobApprovals'] }}</span>
                @endif
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.lra-sra-approvals') }}" class="sidebar-menu-link {{ request()->routeIs('admin.lra-sra-approvals') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check"></i>
                <span>LRA/SRA Approvals</span>
                @if(($adminSidebarCounts['pendingLraSraApprovals'] ?? 0) > 0)
                    <span class="sidebar-badge" style="background:#ec4899;">{{ $adminSidebarCounts['pendingLraSraApprovals'] }}</span>
                @endif
            </a>
        </li>
        {{--  <li class="sidebar-menu-item">
            <a href="{{ route('admin.document-verification') }}" class="sidebar-menu-link {{ request()->routeIs('admin.document-verification') ? 'active' : '' }}">
                <i class="bi bi-file-earmark"></i>
                <span>Document Verification</span>
            </a>
        </li>  --}}

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
