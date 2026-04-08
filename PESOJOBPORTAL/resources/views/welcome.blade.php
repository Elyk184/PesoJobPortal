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
                height: 3px;
                background: #dc2626;
            }

            .news-cards {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 20px;
            }

            .news-card {
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 10px 25px rgba(0,0,0,0.1);
                transition: transform 0.2s ease;
                height: 100%;
                background: white;
            }

            .news-card:hover {
                transform: translateY(-5px);
            }

            .news-card-img {
                width: 100%;
                height: 180px;
                object-fit: cover;
            }

            .news-card-body {
                padding: 1rem;
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .news-card-title {
                font-size: 1.2rem;
                font-weight: 700;
            }

            .news-card-text {
                flex-grow: 1;
            }

            .news-card .btn {
                align-self: flex-start;
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
                    <div class="card news-card">
                        <img src="https://i.pinimg.com/originals/80/9a/3d/809a3de812b7389316cc4c4edb0a3c05.gif" class="news-card-img" alt="Events">
                        <div class="card-body news-card-body">
                            <h5 class="news-card-title">Events</h5>
                            <p class="card-text">Upcoming PESO events and job fairs.</p>
                            <a href="#" class="btn btn-danger">Learn More</a>
                        </div>
                    </div>

                    <div class="card news-card">
                        <img src="https://i.pinimg.com/originals/5c/87/17/5c871720baf04c9bb0330801f0101137.gif" class="news-card-img" alt="Announcements">
                        <div class="card-body news-card-body">
                            <h5 class="news-card-title">Announcements</h5>
                            <p class="card-text">Latest announcements and updates.</p>
                            <a href="#" class="btn btn-danger">Learn More</a>
                        </div>
                    </div>

                    <div class="card news-card">
                        <img src="https://i.pinimg.com/originals/d6/74/e7/d674e764a10d6b4f8cdd011f030c886f.gif" class="news-card-img" alt="Community">
                        <div class="card-body news-card-body">
                            <h5 class="news-card-title">Community</h5>
                            <p class="card-text">Community initiatives and programs.</p>
                            <a href="#" class="btn btn-danger">Learn More</a>
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