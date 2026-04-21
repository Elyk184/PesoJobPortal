<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard | Link Job Resource Portal')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    @stack('styles')
    <style>
        :root {
            --dash-sidebar-900: #22374f;
            --dash-sidebar-800: #2b435d;
            --dash-sidebar-700: #334d69;
            --dash-sidebar-600: #40607f;
            --dash-surface: #ffffff;
            --dash-page-bg: #eef2f7;
            --dash-border: #d9e2ee;
            --dash-text: #314458;
            --dash-muted: #728196;
            --dash-accent: #2d65b1;
            --dash-success: #2f9d62;
            --dash-warning: #dca42a;
            --dash-info: #5e88df;
            --dash-purple: #8e76d9;
        }

        .dashboard-shell {
            min-height: 100vh;
            display: flex;
            background: var(--dash-page-bg);
        }

        .dashboard-sidebar {
            width: 284px;
            flex: 0 0 284px;
            padding: 18px 16px 20px;
            background: linear-gradient(180deg, var(--dash-sidebar-900) 0%, #2b3f56 100%);
            color: #fff;
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow: auto;
            overscroll-behavior: contain;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        }

        .dashboard-sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .dashboard-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.28);
            border-radius: 999px;
        }

        .dashboard-mobile-bar {
            display: none;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
            padding: 12px 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(15, 45, 82, 0.08);
            box-shadow: 0 12px 24px rgba(15, 45, 82, 0.08);
        }

        .dashboard-mobile-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            color: #0f2d52;
        }

        .dashboard-mobile-brand img {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            object-fit: cover;
        }

        .dashboard-sidebar-close {
            display: none;
        }

        .dashboard-backdrop {
            display: none;
        }

        .dashboard-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dashboard-brand-mark img {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            object-fit: cover;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.16);
        }

        .dashboard-brand-kicker {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            opacity: 0.65;
        }

        .dashboard-brand-title {
            font-size: 1.05rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .dashboard-user-card,
        .dashboard-highlight {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 14px;
            backdrop-filter: blur(8px);
            box-shadow: 0 10px 24px rgba(7, 26, 48, 0.16);
        }

        .dashboard-user-card {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .dashboard-user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #4a9df0, #6bc1ff);
            color: #fff;
            font-size: 1.2rem;
            font-weight: 800;
            box-shadow: 0 12px 24px rgba(74, 157, 240, 0.28);
        }

        .dashboard-user-name {
            font-weight: 800;
            font-size: 0.98rem;
        }

        .dashboard-user-role {
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.85rem;
        }

        .dashboard-nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .dashboard-nav-section {
            margin-top: 2px;
        }

        .dashboard-nav-label {
            padding: 6px 12px 4px;
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.42);
            font-weight: 700;
        }

        .dashboard-nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 12px 14px;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.82);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: background-color 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
        }

        .dashboard-nav-link i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        .dashboard-nav-link:hover,
        .dashboard-nav-link.is-active {
            color: #ffffff;
            background: rgba(79, 138, 201, 0.5);
            box-shadow: inset 3px 0 0 #61a0ff;
        }

        .dashboard-highlight-label {
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 6px;
        }

        .dashboard-highlight-value {
            font-size: 1rem;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .dashboard-highlight-note {
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.84rem;
        }

        .dashboard-logout {
            margin-top: auto;
        }

        .dashboard-content {
            flex: 1;
            min-width: 0;
            padding: 18px 20px 20px;
        }

        .dashboard-page-card {
            background: transparent;
            backdrop-filter: none;
            border: 0;
            border-radius: 0;
            box-shadow: none;
        }

        .dashboard-section-title {
            color: #23374f;
        }

        .dashboard-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 12px 16px;
            margin-bottom: 16px;
            background: #ffffff;
            border: 1px solid var(--dash-border);
            border-radius: 0;
            box-shadow: 0 1px 0 rgba(17, 24, 39, 0.02);
        }

        .dashboard-topbar-title {
            font-size: 1.04rem;
            font-weight: 700;
            color: #37485d;
            line-height: 1.1;
        }

        .dashboard-topbar-subtitle {
            font-size: 0.78rem;
            color: var(--dash-muted);
        }

        .dashboard-section-card {
            background: #ffffff;
            border: 1px solid var(--dash-border);
            border-radius: 16px;
            box-shadow: 0 1px 0 rgba(17, 24, 39, 0.02);
        }

        .dashboard-stat-card {
            min-height: 102px;
            border-radius: 14px;
            border: 1px solid var(--dash-border);
            background: #ffffff;
            box-shadow: 0 1px 0 rgba(17, 24, 39, 0.02);
        }

        .dashboard-stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: rgba(45, 101, 177, 0.12);
            color: var(--dash-accent);
            font-size: 1.05rem;
        }

        .dashboard-stat-number {
            font-size: 1.15rem;
            font-weight: 800;
            line-height: 1;
            color: #37485d;
        }

        .dashboard-stat-label {
            font-size: 0.82rem;
            color: var(--dash-muted);
        }

        .dashboard-status-card {
            border-radius: 14px;
            border: 1px solid var(--dash-border);
            background: #fbfcfe;
            min-height: 78px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .dashboard-status-number {
            font-size: 1.6rem;
            font-weight: 800;
            line-height: 1;
        }

        .dashboard-status-label {
            margin-top: 2px;
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 700;
        }

        .status-yellow {
            color: var(--dash-warning);
            background: rgba(220, 164, 42, 0.13);
        }

        .status-green {
            color: var(--dash-success);
            background: rgba(47, 157, 98, 0.12);
        }

        .status-blue {
            color: #2d6be0;
            background: rgba(45, 107, 224, 0.12);
        }

        .status-purple {
            color: var(--dash-purple);
            background: rgba(142, 118, 217, 0.12);
        }

        .dashboard-empty-state {
            min-height: 168px;
            display: grid;
            place-items: center;
            text-align: center;
            color: var(--dash-muted);
        }

        @media (max-width: 991.98px) {
            .dashboard-shell {
                flex-direction: column;
            }

            .dashboard-sidebar {
                width: min(88vw, 320px);
                flex-basis: auto;
                height: 100vh;
                position: fixed;
                inset: 0 auto 0 0;
                z-index: 1055;
                transform: translateX(-102%);
                transition: transform 0.22s ease;
                border-right: 1px solid rgba(255, 255, 255, 0.08);
                border-bottom: 0;
                box-shadow: 0 22px 44px rgba(10, 35, 80, 0.26);
            }

            .dashboard-sidebar.is-open {
                transform: translateX(0);
            }

            .dashboard-mobile-bar {
                display: flex;
            }

            .dashboard-sidebar-close {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                border: 0;
                border-radius: 12px;
                background: rgba(255, 255, 255, 0.1);
                color: #fff;
            }

            .dashboard-backdrop {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(7, 18, 34, 0.42);
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.22s ease, visibility 0.22s ease;
                z-index: 1050;
            }

            .dashboard-backdrop.is-open {
                opacity: 1;
                visibility: visible;
            }

            .dashboard-content {
                padding: 14px;
            }
        }

        @media (max-width: 575.98px) {
            .dashboard-content {
                padding: 10px;
            }

            .dashboard-topbar {
                padding: 10px 12px;
            }
        }
    </style>
</head>
<body class="peso-body">
    <div class="dashboard-shell">
        <div class="dashboard-backdrop" data-dashboard-backdrop></div>
        @include('components.dashboard.sidebar')

        <main class="dashboard-content">
            <div class="dashboard-mobile-bar">
                <button type="button" class="btn btn-danger" data-dashboard-toggle aria-label="Open dashboard menu">
                    <i class="bi bi-list"></i>
                </button>
                <div class="dashboard-mobile-brand">
                    <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
                    <span>Jobseeker Dashboard</span>
                </div>
                <span style="width: 40px;"></span>
            </div>

            <div class="dashboard-page-card p-3 p-lg-4">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        (function () {
            const sidebar = document.querySelector('.dashboard-sidebar');
            const backdrop = document.querySelector('[data-dashboard-backdrop]');
            const toggles = document.querySelectorAll('[data-dashboard-toggle]');
            const closeButton = document.querySelector('[data-dashboard-close]');

            if (!sidebar || !backdrop) {
                return;
            }

            function openSidebar() {
                sidebar.classList.add('is-open');
                backdrop.classList.add('is-open');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('is-open');
                backdrop.classList.remove('is-open');
                document.body.style.overflow = '';
            }

            toggles.forEach(function (button) {
                button.addEventListener('click', function () {
                    if (sidebar.classList.contains('is-open')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });
            });

            if (closeButton) {
                closeButton.addEventListener('click', closeSidebar);
            }

            backdrop.addEventListener('click', closeSidebar);

            window.addEventListener('resize', function () {
                if (window.innerWidth > 991.98) {
                    closeSidebar();
                }
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
