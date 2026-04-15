<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard | PESO Job Portal')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    @stack('styles')
    <style>
        .dashboard-shell {
            min-height: 100vh;
            display: flex;
            background:
                radial-gradient(circle at top left, rgba(13, 62, 114, 0.16), transparent 32%),
                radial-gradient(circle at bottom right, rgba(230, 31, 35, 0.12), transparent 30%),
                linear-gradient(180deg, #f5f8fc 0%, #eef3f9 100%);
        }

        .dashboard-sidebar {
            width: 320px;
            flex: 0 0 320px;
            padding: 24px;
            background: linear-gradient(180deg, #0f2d52 0%, #163d6e 100%);
            color: #fff;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            flex-direction: column;
            gap: 18px;
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
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(15, 45, 82, 0.08);
            box-shadow: 0 14px 30px rgba(15, 45, 82, 0.08);
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
            width: 58px;
            height: 58px;
            border-radius: 16px;
            object-fit: cover;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.16);
        }

        .dashboard-brand-kicker {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            opacity: 0.72;
        }

        .dashboard-brand-title {
            font-size: 1.15rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .dashboard-user-card,
        .dashboard-highlight {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 16px;
            backdrop-filter: blur(10px);
            box-shadow: 0 12px 30px rgba(7, 26, 48, 0.2);
        }

        .dashboard-user-card {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .dashboard-user-avatar {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #e61f23, #f24b5d);
            color: #fff;
            font-size: 1.4rem;
            font-weight: 800;
            box-shadow: 0 12px 24px rgba(230, 31, 35, 0.26);
        }

        .dashboard-user-name {
            font-weight: 800;
            font-size: 1.02rem;
        }

        .dashboard-user-role {
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.92rem;
        }

        .dashboard-nav {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .dashboard-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 16px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.18s ease, background-color 0.18s ease, color 0.18s ease;
        }

        .dashboard-nav-link i {
            font-size: 1.05rem;
        }

        .dashboard-nav-link:hover,
        .dashboard-nav-link.is-active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.12);
            transform: translateX(2px);
        }

        .dashboard-highlight-label {
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 6px;
        }

        .dashboard-highlight-value {
            font-size: 1.2rem;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .dashboard-highlight-note {
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.92rem;
        }

        .dashboard-logout {
            margin-top: auto;
        }

        .dashboard-content {
            flex: 1;
            min-width: 0;
            padding: 28px;
        }

        .dashboard-page-card {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(15, 45, 82, 0.08);
            border-radius: 24px;
            box-shadow: 0 18px 40px rgba(15, 45, 82, 0.08);
        }

        .dashboard-section-title {
            color: #0f2d52;
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
                padding: 18px;
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
