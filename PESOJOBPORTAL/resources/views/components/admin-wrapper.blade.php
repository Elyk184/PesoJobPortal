<style>
    :root {
        --bs-body-color: #0f172a;
    }

    html, body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', 'Inter', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif;
        font-weight: 400;
        letter-spacing: 0.3px;
    }

    body {
        background: #f8fafc;
        color: #0f172a;
        min-height: 100vh;
    }

    .peso-main {
        margin: 0;
        padding: 0;
    }

    .admin-wrapper {
        display: flex;
        min-height: 100vh;
        margin-top: 0;
    }

    .admin-sidebar {
        width: 260px;
        background: linear-gradient(180deg, #1e293b 0%, #0f172a 50%, #0f172a 100%);
        color: white;
        padding: 1.5rem 0;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
        z-index: 100;
    }

    .admin-sidebar::-webkit-scrollbar { width: 8px; }
    .admin-sidebar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.05); }
    .admin-sidebar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.25); border-radius: 4px; }
    .admin-sidebar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.4); }

    .sidebar-header {
        padding: 1.5rem 1.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid rgba(215, 38, 56, 0.3);
        padding-bottom: 1.5rem;
        background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
    }

    .sidebar-header a:hover { background: rgba(255, 255, 255, 0.1) !important; border-radius: 8px; }

    .sidebar-user { display: flex; align-items: center; gap: 12px; }

    .sidebar-user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 20px;
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .sidebar-user-name { flex: 1; }
    .sidebar-user-name h6 { margin: 0; font-size: 14px; font-weight: 700; color: white; letter-spacing: 0.2px; }
    .sidebar-user-name p { margin: 4px 0 0 0; font-size: 12px; opacity: 0.8; font-weight: 500; color: rgba(255, 255, 255, 0.7); }

    .sidebar-menu { list-style: none; margin: 0; padding: 0; }
    .sidebar-menu-item { margin: 0; padding: 0; }

    .sidebar-menu-link {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 1.5rem;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.3px;
        border-left: 3px solid transparent;
    }

    .sidebar-menu-link:hover {
        color: white;
        background: rgba(59, 130, 246, 0.15);
        padding-left: 1.8rem;
        border-left-color: #3b82f6;
    }

    .sidebar-menu-link.active {
        color: #fff;
        background: linear-gradient(90deg, rgba(59, 130, 246, 0.2) 0%, rgba(59, 130, 246, 0.05) 100%);
        border-left-color: #3b82f6;
        font-weight: 600;
    }

    .sidebar-menu-link i { font-size: 20px; min-width: 20px; opacity: 0.85; }
    .sidebar-menu-link.active i { opacity: 1; }

    .sidebar-menu-divider {
        height: 1px;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0) 100%);
        margin: 1rem 0;
    }

    .admin-main {
        margin-left: 260px;
        flex: 1;
        padding: 2.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);
    }

    .admin-topbar {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        padding: 2rem 2rem;
        margin-bottom: 2.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .admin-topbar-left { display: flex; align-items: center; gap: 2rem; flex: 1; }

    .topbar-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        width: 80px;
        height: 80px;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        flex-shrink: 0;
    }

    .topbar-logo img { height: 50px; width: auto; }

    .topbar-title { display: flex; flex-direction: column; gap: 0.25rem; }

    .admin-topbar h2 {
        margin: 0;
        color: #1e293b;
        font-weight: 800;
        font-size: 36px;
        letter-spacing: -0.5px;
    }

    .topbar-subtitle { font-size: 14px; color: #64748b; font-weight: 600; letter-spacing: 0.3px; }

    .admin-topbar-right { display: flex; gap: 1.5rem; align-items: center; }

    .topbar-datetime {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1rem 1.75rem;
        background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%);
        border-radius: 16px;
        border: 2px solid #bfdbfe;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
    }

    .topbar-time { text-align: right; }
    .topbar-time-display { font-size: 22px; font-weight: 800; color: #1e293b; line-height: 1.1; letter-spacing: -0.3px; }
    .topbar-date-display { font-size: 13px; color: #64748b; font-weight: 600; letter-spacing: 0.3px; }
    .topbar-datetime-icon { font-size: 28px; color: #3b82f6; }

    .analog-clock {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        position: relative;
        border: 3px solid #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .clock-center {
        width: 12px;
        height: 12px;
        background: #3b82f6;
        border-radius: 50%;
        position: absolute;
        z-index: 10;
    }

    .hand {
        position: absolute;
        bottom: 50%;
        left: 50%;
        transform-origin: bottom center;
        background: #1e293b;
        border-radius: 10px;
    }

    .hour-hand {
        width: 4px;
        height: 32px;
        margin-left: -2px;
    }

    .minute-hand {
        width: 3px;
        height: 42px;
        margin-left: -1.5px;
    }

    .second-hand {
        width: 2px;
        height: 45px;
        margin-left: -1px;
        background: #ef4444;
    }

    .clock-marker {
        position: absolute;
        width: 2px;
        height: 8px;
        background: #3b82f6;
        left: 50%;
        margin-left: -1px;
    }

    .clock-marker-12 { top: 6px; }
    .clock-marker-3 { top: 50%; right: 6px; left: auto; width: 8px; height: 2px; margin-left: 0; margin-top: -1px; }
    .clock-marker-6 { bottom: 6px; top: auto; }
    .clock-marker-9 { top: 50%; left: 6px; right: auto; width: 8px; height: 2px; margin-left: 0; margin-top: -1px; }
    .sidebar-badge {
        margin-left: auto;
        min-width: 22px;
        height: 22px;
        padding: 0 7px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #ef4444;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        line-height: 1;
        flex-shrink: 0;
    }
</style>

<div class="admin-wrapper">
    <!-- Sidebar -->
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
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li style="padding: 0; margin: 1rem 0;"><div class="sidebar-menu-divider"></div></li>

            <li style="padding: 0 1.5rem; margin: 0.5rem 0; opacity: 0.6;">
                <small style="text-transform: uppercase; font-weight: 700; letter-spacing: 1px; font-size: 10px;">Approvals & Verification</small>
            </li>

            <li class="sidebar-menu-item">
                <a href="{{ route('admin.jobseekers.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.jobseekers.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-check"></i>
                    <span>Application Approvals</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.employer-verification') }}" class="sidebar-menu-link {{ request()->routeIs('admin.employer-verification*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i>
                    <span>Employer Verification</span>
                    @if(($adminSidebarCounts['pendingEmployerVerification'] ?? 0) > 0)
                        <span class="sidebar-badge">{{ $adminSidebarCounts['pendingEmployerVerification'] }}</span>
                    @endif
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

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Top Bar -->
        <div class="admin-topbar">
            <div class="admin-topbar-left">
                <div class="topbar-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
                </div>
                <div class="topbar-title">
                    <h2><i class="bi {{ $icon ?? 'bi-speedometer2' }} me-2"></i>{{ $title ?? 'Admin' }}</h2>
                    <div class="topbar-subtitle">{{ $subtitle ?? 'PESO Admin Portal' }}</div>
                </div>
            </div>
            <div class="admin-topbar-right">
                <div class="topbar-datetime">
                    <div class="analog-clock" id="analogClock">
                        <div class="clock-marker clock-marker-12"></div>
                        <div class="clock-marker clock-marker-3"></div>
                        <div class="clock-marker clock-marker-6"></div>
                        <div class="clock-marker clock-marker-9"></div>
                        <div class="hand hour-hand" id="hourHand"></div>
                        <div class="hand minute-hand" id="minuteHand"></div>
                        <div class="hand second-hand" id="secondHand"></div>
                        <div class="clock-center"></div>
                    </div>
                    <div class="topbar-time">
                        <div class="topbar-time-display" id="currentTime">--:--</div>
                        <div class="topbar-date-display" id="currentDate">--/--/----</div>
                    </div>
                </div>
            </div>
        </div>

        {{ $slot }}
    </main>
</div>

<script>
    function updateDateTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = now.getSeconds();
        const milliseconds = now.getMilliseconds();

        const timeString = `${hours}:${minutes}`;
        const dateString = now.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });

        const timeElement = document.getElementById('currentTime');
        const dateElement = document.getElementById('currentDate');

        if (timeElement) {
            timeElement.textContent = timeString;
        }
        if (dateElement) {
            dateElement.textContent = dateString;
        }

        // Update analog clock
        updateAnalogClock(now);
    }

    function updateAnalogClock(now) {
        const seconds = now.getSeconds();
        const minutes = now.getMinutes();
        const hours = now.getHours();
        const milliseconds = now.getMilliseconds();

        // Calculate smooth rotations (including milliseconds for smooth motion)
        const totalSeconds = seconds + milliseconds / 1000;
        const secondDegrees = (totalSeconds / 60) * 360;

        const totalMinutes = minutes + totalSeconds / 60;
        const minuteDegrees = (totalMinutes / 60) * 360;

        const totalHours = hours % 12 + totalMinutes / 60;
        const hourDegrees = (totalHours / 12) * 360;

        const secondHand = document.getElementById('secondHand');
        const minuteHand = document.getElementById('minuteHand');
        const hourHand = document.getElementById('hourHand');

        if (secondHand) {
            secondHand.style.transform = `rotate(${secondDegrees}deg)`;
        }
        if (minuteHand) {
            minuteHand.style.transform = `rotate(${minuteDegrees}deg)`;
        }
        if (hourHand) {
            hourHand.style.transform = `rotate(${hourDegrees}deg)`;
        }
    }

    updateDateTime();
    setInterval(updateDateTime, 100); // Update 10 times per second for smooth animation
</script>
