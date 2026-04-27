<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PESO Job Portal</title>

        <link rel="preload" as="image" href="/images/background.png">
        <link rel="preload" as="image" href="/images/mobile-background.png" media="(max-width: 800px)">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Bootstrap Icons CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @endif
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/services.css') }}">
        

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap');

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body.peso-body {
                font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                overflow-x: hidden;
            }

            :root {
                --orig-blue-900: #1e3a8a;
                --orig-blue-800: #1e40af;
                --orig-red-600: #dc2626;
                --orig-yellow-300: #fcd34d;
                --orig-white: #ffffff;
            }

            .peso-header-inner {
                width: 100% !important;
                justify-content: space-between !important;
                padding: 0 16px !important;
            }

            .peso-brand {
                margin-right: 0 !important;
                flex-shrink: 0 !important;
            }

            .peso-header-right {
                margin-left: auto !important;
                display: flex !important;
                align-items: center !important;
                justify-content: flex-end !important;
                flex: 1 !important;
                min-width: 0 !important;
                gap: 18px !important;
            }

            .peso-nav {
                margin-left: 0 !important;
                justify-content: flex-end !important;
            }

            .peso-actions {
                justify-content: flex-end !important;
            }

            .peso-chip {
                min-width: 110px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                transition: background-color 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease,
                    transform 0.18s ease;
            }

            .peso-chip:hover {
                background: #1e3a8a;
                border-color: #fcd34d;
                box-shadow: 0 8px 18px rgba(9, 40, 73, 0.35);
                transform: translateY(-1px);
            }

            /* FIXED HERO SECTION - Full Screen Background */
            .peso-hero {
                position: relative;
                min-height: 100vh;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                isolation: isolate;
                overflow: hidden;
            }

            /* Background image with proper cover sizing - NO OVERLAY */
            .peso-hero::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image: url('/images/background-desktop.png'), url('/images/background.png');
                background-size: cover;
                background-position: center center;
                background-repeat: no-repeat;
                z-index: -1;
            }

            /* Tablet background */
            @media (max-width: 1024px) and (min-width: 801px) {
                .peso-hero::before {
                    background-image: url('/images/background-tablet.png'), url('/images/background.png');
                    background-size: cover;
                    background-position: center center;
                }
            }

            /* Mobile background */
            @media (max-width: 800px) {
                .peso-hero::before {
                    background-image: url('/images/background-mobile.png'), url('/images/background.png');
                    background-size: cover;
                    background-position: center center;
                }
            }

            .hero-static {
                width: min(1360px, 100%);
                margin: 0 auto;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 40px;
                position: relative;
                padding: 80px 24px;
                z-index: 1;
            }

            .hero-content-left {
                position: relative;
                z-index: 2;
                text-align: left;
                width: 55%;
            }

            .hero-title-welcome {
                font-size: 46px;
                font-weight: 700;
                line-height: 1.1;
                margin-bottom: 10px;
                color: #075cb2e6;
            }

            .hero-title-peso {
                font-size: 46px;
                font-weight: 700;
                line-height: 1.1;
                color: #e74c3c;
                margin-bottom: 20px;
            }

            .hero-title-connecting {
                font-size: 34px;
                font-weight: 700;
                line-height: 1.2;
                margin-bottom: 18px;
                color: #075cb2e6;
            }

            .hero-title-connecting span {
                color: #e74c3c;
            }

            .hero-description-text {
                font-size: 18px;
                color: #333;
                margin-bottom: 30px;
                line-height: 1.6;
            }

            .hero-btn-getstarted {
                padding: 12px 40px;
                font-size: 15px;
                font-weight: 600;
                border-radius: 30px;
                border: 2px solid #3498db;
                color: white;
                background: #3498db;
                text-decoration: none;
                display: inline-block;
                transition: all 0.3s ease;
            }

            .hero-btn-getstarted:hover {
                background: #2980b9;
                border-color: #2980b9;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
            }

            /* Stats Card */
            .hero-tabulation {
                background: rgba(255, 255, 255, 0.95);
                border: 1px solid rgba(252, 211, 77, 0.48);
                border-radius: 22px;
                padding: clamp(20px, 2.4vw, 28px);
                width: 35%;
                box-shadow: 0 18px 40px rgba(9, 32, 77, 0.22);
                backdrop-filter: blur(10px);
                position: relative;
                z-index: 2;
            }

            .hero-tabulation-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 20px 24px;
            }

            .hero-stat {
                text-align: center;
            }

            .hero-stat strong {
                display: block;
                font-size: clamp(32px, 3.2vw, 48px);
                line-height: 1.1;
                color: var(--orig-blue-900);
                font-weight: 800;
            }

            .hero-stat span {
                display: block;
                font-size: 0.85rem;
                margin-top: 6px;
                font-weight: 600;
                color: var(--orig-red-600);
            }

            .about-section {
                background: linear-gradient(180deg, #ffffff 0%, #f4f7fb 100%);
                border-radius: 28px;
                padding: 2.6rem 2.6rem 2.4rem;
                margin: 2.25rem auto 2.5rem;
                box-shadow: 0 18px 40px rgba(14, 38, 79, 0.12);
                border: 1px solid #e5e7eb;
                width: min(1300px, calc(100% - 24px));
                position: relative;
                z-index: 2;
            }

            .about-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.25rem;
            }

            .about-item {
                background: #fff2d0;
                padding: 1.5rem;
                border-radius: 18px;
                border-left: 6px solid #ee0e0d;
                border-top: 2px solid rgba(10, 55, 100, 0.12);
                box-shadow: 0 8px 20px rgba(10, 55, 100, 0.08);
            }

            .about-item h3 {
                color: #0a3764;
                font-size: 1.5rem;
                margin-bottom: 1rem;
                line-height: 1.2;
            }

            .about-item p {
                color: #1e2b3a;
                line-height: 1.7;
                margin: 0;
            }

            .news-updates-section {
                width: min(1300px, calc(100% - 24px));
                margin: 2rem auto;
            }

            .news-header {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 12px;
                font-size: 1.8rem;
                font-weight: 700;
                color: #0a3764;
                margin-bottom: 1.5rem;
            }

            .news-header span:first-child,
            .news-header span:last-child {
                flex: 1;
                height: 4px;
                background: linear-gradient(90deg, #dc2626 0%, transparent 100%);
            }

            .news-header span:last-child {
                background: linear-gradient(90deg, transparent 0%, #dc2626 100%);
            }

            .news-cards {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 20px;
            }

            .news-card {
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 8px 20px rgba(0,0,0,0.08);
                transition: all 0.3s ease;
                height: 100%;
                background: white;
                border: 1px solid #e5e7eb;
            }

            .news-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 16px 32px rgba(0,0,0,0.12);
            }

            .news-card-header {
                padding: 2rem 1.5rem 1rem;
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                position: relative;
            }

            .news-card-icon {
                width: 56px;
                height: 56px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.8rem;
                flex-shrink: 0;
            }

            .news-card-icon.events {
                background: #dbeafe;
                color: #1e40af;
            }

            .news-card-icon.announcements {
                background: #fecaca;
                color: #dc2626;
            }

            .news-card-icon.community {
                background: #fef3c7;
                color: #d97706;
            }

            .news-card-badge {
                display: inline-block;
                font-size: 0.65rem;
                font-weight: 700;
                letter-spacing: 1px;
                padding: 0.35rem 0.75rem;
                border-radius: 6px;
                text-transform: uppercase;
            }

            .news-card-badge.events {
                background: #dbeafe;
                color: #1e40af;
            }

            .news-card-badge.announcements {
                background: #fecaca;
                color: #dc2626;
            }

            .news-card-badge.community {
                background: #fef3c7;
                color: #d97706;
            }

            .news-card-body {
                padding: 0 1.5rem 1.5rem;
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .news-card-title {
                font-size: 1.35rem;
                font-weight: 800;
                color: #0a3764;
                line-height: 1.2;
                letter-spacing: -0.5px;
            }

            .news-card-features {
                list-style: none;
                padding: 0;
                margin: 0.5rem 0;
                display: flex;
                flex-direction: column;
                gap: 0.6rem;
            }

            .news-card-feature {
                display: flex;
                align-items: flex-start;
                gap: 0.6rem;
                font-size: 0.95rem;
                color: #374151;
                line-height: 1.4;
            }

            .news-card-feature-check {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 20px;
                height: 20px;
                border-radius: 4px;
                flex-shrink: 0;
                font-size: 0.75rem;
                font-weight: bold;
                color: white;
            }

            .news-card-feature-check.events {
                background: #3b82f6;
            }

            .news-card-feature-check.announcements {
                background: #ef4444;
            }

            .news-card-feature-check.community {
                background: #eab308;
            }

            .news-card-footer {
                padding: 1rem 1.5rem 1.5rem;
            }

            .news-card-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.6rem;
                width: 100%;
                padding: 0.85rem 1.5rem;
                font-size: 0.95rem;
                font-weight: 700;
                border-radius: 12px;
                border: none;
                cursor: pointer;
                transition: all 0.3s ease;
                text-decoration: none;
            }

            .news-card-btn.events {
                background: #dbeafe;
                color: #1e40af;
            }

            .news-card-btn.events:hover {
                background: #bfdbfe;
                transform: translateX(4px);
            }

            .news-card-btn.announcements {
                background: #fecaca;
                color: #dc2626;
            }

            .news-card-btn.announcements:hover {
                background: #fca5a5;
                transform: translateX(4px);
            }

            .news-card-btn.community {
                background: #fef3c7;
                color: #d97706;
            }

            .news-card-btn.community:hover {
                background: #fde68a;
                transform: translateX(4px);
            }

            .news-card-btn svg {
                width: 16px;
                height: 16px;
                stroke-width: 2.5;
            }

            /* Responsive Design */
            @media (max-width: 1024px) {
                .hero-static {
                    flex-direction: column;
                    padding: 60px 24px;
                }

                .hero-content-left {
                    width: 100%;
                    text-align: center;
                }

                .hero-tabulation {
                    width: 100%;
                    max-width: 500px;
                }
            }

            @media (max-width: 768px) {
                .hero-title-welcome,
                .hero-title-peso {
                    font-size: 36px;
                }

                .hero-title-connecting {
                    font-size: 28px;
                }

                .hero-description-text {
                    font-size: 16px;
                }

                .hero-static {
                    padding: 40px 20px;
                }
            }

            @media (max-width: 480px) {
                .hero-title-welcome,
                .hero-title-peso {
                    font-size: 28px;
                }

                .hero-title-connecting {
                    font-size: 22px;
                }

                .hero-description-text {
                    font-size: 14px;
                }

                .hero-btn-getstarted {
                    padding: 10px 30px;
                    font-size: 14px;
                }

                .hero-tabulation-grid {
                    gap: 15px;
                }

                .hero-stat strong {
                    font-size: 24px;
                }

                .hero-stat span {
                    font-size: 12px;
                }

                .about-section {
                    padding: 1.5rem;
                }

                .about-item h3 {
                    font-size: 1.2rem;
                }

                .news-header {
                    font-size: 1.4rem;
                }
            }
        </style>
    </head>
    <body class="peso-body">
        @include('components.navbar')

        <main class="peso-main">
            <section class="peso-hero" aria-label="Welcome section">
                <div class="hero-static">
                    <div class="hero-content-left">
                        <h1 class="hero-title-welcome">
                            Welcome to <span style="color: #e74c3c;">PESO</span>
                        </h1>

                        <h2 class="hero-title-peso">
                            Manolo Fortich
                        </h2>

                        <h1 class="hero-title-connecting">
                            Connecting People <span>with Opportunities</span>
                        </h1>

                        <p class="hero-description-text">
                            Connecting Filipino jobseekers with verified employers. Access thousands of local and overseas job opportunities through PESO.
                        </p>

                        <div>
                            <a href="{{ route('login') }}" class="hero-btn-getstarted">
                                Get Started
                            </a>
                        </div>
                    </div>

                    <aside class="hero-tabulation">
                        <div class="hero-tabulation-grid">
                            <div class="hero-stat">
                                <strong class="stat-counter" data-count="500" data-suffix="+">0</strong>
                                <span>Job Seekers</span>
                            </div>
                            <div class="hero-stat">
                                <strong class="stat-counter" data-count="50" data-suffix="+">0</strong>
                                <span>Employers</span>
                            </div>
                            <div class="hero-stat">
                                <strong class="stat-counter" data-count="300" data-suffix="+">0</strong>
                                <span>Jobs Posted</span>
                            </div>
                            <div class="hero-stat">
                                <strong class="stat-counter" data-count="85" data-suffix="+">0</strong>
                                <span>Placement Rate</span>
                            </div>
                        </div>
                    </aside>
                </div>
            </section>

            <section class="about-section" id="about-main" aria-label="About PESO Manolo Fortich">
                <div class="about-grid">
                    <article class="about-item">
                        <h3>Our Mission</h3>
                        <p>
                            To promote economic growth and sustainable development in Manolo Fortich through the
                            implementation of the PESO program, providing employment opportunities and skills
                            development for the community.
                        </p>
                    </article>

                    <article class="about-item">
                        <h3>Our Vision</h3>
                        <p>
                            To become the lead municipality in the Philippines by creating a robust local economy that
                            provides decent jobs, promotes entrepreneurship, and enhances the quality of life of the
                            residents of Manolo Fortich.
                        </p>
                    </article>
                </div>
            </section>

            <section id="features" class="news-updates-section">
                <h2 class="news-header">
                    <span></span>
                    <span>News & Updates</span>
                    <span></span>
                </h2>

                <div class="news-cards">
                    <div class="news-card">
                        <div class="news-card-header">
                            <div class="news-card-icon events">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/></svg>
                            </div>
                            <span class="news-card-badge events">Upcoming</span>
                        </div>
                        <div class="news-card-body">
                            <h3 class="news-card-title">Events</h3>
                            <ul class="news-card-features">
                                <li class="news-card-feature">
                                    <span class="news-card-feature-check events">✓</span>
                                    <span>Upcoming PESO events and job fairs</span>
                                </li>
                                <li class="news-card-feature">
                                    <span class="news-card-feature-check events">✓</span>
                                    <span>Career development workshops</span>
                                </li>
                                <li class="news-card-feature">
                                    <span class="news-card-feature-check events">✓</span>
                                    <span>Networking opportunities</span>
                                </li>
                            </ul>
                        </div>
                        <div class="news-card-footer">
                            <a href="#" class="news-card-btn events">
                                <span>Learn More</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div>
                    </div>

                    <div class="news-card">
                        <div class="news-card-header">
                            <div class="news-card-icon announcements">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                            </div>
                            <span class="news-card-badge announcements">CORE</span>
                        </div>
                        <div class="news-card-body">
                            <h3 class="news-card-title">Announcements</h3>
                            <ul class="news-card-features">
                                <li class="news-card-feature">
                                    <span class="news-card-feature-check announcements">✓</span>
                                    <span>Latest updates and news</span>
                                </li>
                                <li class="news-card-feature">
                                    <span class="news-card-feature-check announcements">✓</span>
                                    <span>Important policy notices</span>
                                </li>
                                <li class="news-card-feature">
                                    <span class="news-card-feature-check announcements">✓</span>
                                    <span>Program announcements</span>
                                </li>
                            </ul>
                        </div>
                        <div class="news-card-footer">
                            <a href="#" class="news-card-btn announcements">
                                <span>Learn More</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div>
                    </div>

                    <div class="news-card">
                        <div class="news-card-header">
                            <div class="news-card-icon community">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                            </div>
                        </div>
                        <div class="news-card-body">
                            <h3 class="news-card-title">Community</h3>
                            <ul class="news-card-features">
                                <li class="news-card-feature">
                                    <span class="news-card-feature-check community">✓</span>
                                    <span>Community initiatives</span>
                                </li>
                                <li class="news-card-feature">
                                    <span class="news-card-feature-check community">✓</span>
                                    <span>Local partnership programs</span>
                                </li>
                                <li class="news-card-feature">
                                    <span class="news-card-feature-check community">✓</span>
                                    <span>Community outreach</span>
                                </li>
                            </ul>
                        </div>
                        <div class="news-card-footer">
                            <a href="#" class="news-card-btn community">
                                <span>Learn More</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            @include('components.services')
            @include('components.footer')
        </main>

        <!-- Bootstrap JS (for dropdowns and navbar toggler) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <!-- Stat counter animation -->
        <script>
        (function () {
            const DURATION = 1800;

            function easeOutQuad(t) {
                return t * (2 - t);
            }

            function animateCounter(el) {
                const target = parseInt(el.dataset.count, 10);
                const suffix = el.dataset.suffix || '';
                const start = performance.now();

                function tick(now) {
                    const elapsed = now - start;
                    const progress = Math.min(elapsed / DURATION, 1);
                    const value = Math.floor(easeOutQuad(progress) * target);
                    el.textContent = value + (progress === 1 ? suffix : '');
                    if (progress < 1) {
                        requestAnimationFrame(tick);
                    }
                }

                requestAnimationFrame(tick);
            }

            const counters = document.querySelectorAll('.stat-counter');

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function (entries, obs) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            animateCounter(entry.target);
                            obs.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.25 });

                counters.forEach(function (el) { observer.observe(el); });
            } else {
                counters.forEach(function (el) {
                    el.textContent = el.dataset.count + (el.dataset.suffix || '');
                });
            }
        })();
        </script>
    </body>
</html>
