<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PESO Job Portal</title>

        <link rel="preload" as="image" href="/images/bg.png">
        <link rel="preload" as="image" href="/images/mobile-background.png" media="(max-width: 800px)">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @endif
        <link rel="stylesheet" href="{{ asset('css/services.css') }}">

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap');

            body.peso-body {
                font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            :root {
                --orig-blue-900: #1e3a8a;
                --orig-red-600: #dc2626;
                --orig-yellow-300: #fcd34d;
            }

            .peso-hero {
                min-height: calc(100vh - 76px);
                position: relative;
                display: flex;
                align-items: center;
                padding: clamp(22px, 3vw, 36px) 0;
            }

            .hero-static {
                width: min(1360px, 100%);
                min-height: 700px;
                margin: 0 auto;
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 22px;
                box-sizing: border-box;
                background-image: url('/images/bg.png');
                background-size: cover;
                background-position: center center;
                background-repeat: no-repeat;
                position: relative;
                overflow: hidden;
                padding: 100px 24px 90px;
                border-radius: 0;
            }

            .hero-copy {
                position: relative;
                z-index: 2;
                text-align: left;
                width: min(58%, 680px);
                transform: translateY(-2px);
            }

            .hero-copy h1 {
                margin: 0;
            }

            .hero-top {
                font-size: 46px;
                font-weight: 700;
                line-height: 1.03;
                margin-bottom: 10px;
                color: #075cb2e6;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            }

            .hero-town {
                font-size: 46px;
                font-weight: 700;
                line-height: 1.03;
                color: #e74c3c;
                margin-bottom: 20px;
            }

            .hero-main {
                font-size: 34px;
                font-weight: 700;
                line-height: 1.08;
                margin-bottom: 18px;
                color: #075cb2e6;
                text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
            }

            .hero-main span,
            .hero-top span {
                color: #e74c3c;
            }

            .hero-description {
                font-size: 18px;
                color: #070606;
                margin-bottom: 30px;
                line-height: 1.6;
                text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
                max-width: 640px;
            }

            .hero-cta {
                display: flex;
                justify-content: flex-start;
            }

            .hero-btn-primary {
                padding: 13px 45px;
                font-size: 15px;
                font-weight: 600;
                border-radius: 30px;
                border: 2px solid #3498db;
                color: #fff;
                background: #3498db;
                text-decoration: none;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .hero-btn-primary:hover {
                transform: translateY(-1px);
                box-shadow: 0 10px 22px rgba(7, 92, 178, 0.25);
            }

            .hero-tabulation {
                position: relative;
                z-index: 2;
                width: min(340px, 36%);
                background: rgba(255, 255, 255, 0.92);
                border: 1px solid rgba(7, 92, 178, 0.2);
                border-radius: 22px;
                padding: 20px;
                box-shadow: 0 18px 40px rgba(9, 32, 77, 0.22);
                backdrop-filter: blur(10px);
                transform: translateY(100px);
            }

            .hero-tabulation-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 18px 24px;
            }

            .hero-stat {
                text-align: center;
            }

            .hero-stat strong {
                display: block;
                font-size: 40px;
                line-height: 1;
                color: #075cb2e6;
                font-weight: 900;
            }

            .hero-stat span {
                display: block;
                font-size: 1rem;
                margin-top: 8px;
                font-weight: 600;
                color: #e74c3c;
            }

            .about-section {
                background: linear-gradient(180deg, #ffffff 0%, #f4f7fb 100%);
                border-radius: 28px;
                padding: 2.6rem 2.6rem 2.4rem;
                margin: 4rem auto 2.5rem;
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

            .news-cards services-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 20px;
            }

            .news-card {
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                transition: transform 0.2s ease;
                height: 100%;
                background: #fff;
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

            @media (max-width: 1024px) {
                .hero-static {
                    background-image: url('/images/bg.png');
                    min-height: 620px;
                    padding: 76px 20px 70px;
                }

                .hero-copy {
                    width: min(62%, 640px);
                }

                .hero-top,
                .hero-town {
                    font-size: clamp(2.2rem, 5vw, 2.8rem);
                }

                .hero-main {
                    font-size: clamp(1.8rem, 3.8vw, 2.3rem);
                }

                .hero-tabulation {
                    transform: translateY(60px);
                }
            }

            @media (max-width: 800px) {
                .peso-hero {
                    min-height: auto;
                    padding: 0;
                }

                .hero-static {
                    background-image: url('/images/mobile-background.png');
                    background-size: contain;
                    background-position: center top;
                    min-height: 700px;
                    padding: 76px 16px 68px;
                    gap: 16px;
                    flex-direction: column;
                    align-items: center;
                    justify-content: flex-start;
                }

                .hero-copy {
                    width: 100%;
                    text-align: center;
                    transform: none;
                }

                .hero-top,
                .hero-town {
                    font-size: clamp(1.9rem, 8vw, 2.4rem);
                }

                .hero-main {
                    font-size: clamp(1.35rem, 6vw, 1.95rem);
                }

                .hero-description {
                    margin: 14px auto 24px;
                    font-size: clamp(0.95rem, 4.4vw, 1.06rem);
                    max-width: 520px;
                }

                .hero-cta {
                    justify-content: center;
                }

                .hero-tabulation {
                    width: min(560px, 100%);
                    transform: none;
                }

                .about-section {
                    padding: 1.5rem;
                    margin: 2rem auto 1.5rem;
                }
            }

            @media (max-width: 540px) {
                .hero-static {
                    min-height: 640px;
                    padding: 70px 14px 52px;
                    background-position: center top;
                }

                .hero-btn-primary {
                    width: 100%;
                    text-align: center;
                }

                .hero-tabulation {
                    display: block;
                    width: 100%;
                    padding: 14px;
                }

                .hero-tabulation-grid {
                    gap: 12px;
                }

                .hero-stat strong {
                    font-size: 32px;
                }

                .hero-stat span {
                    font-size: 0.92rem;
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
            <section class="peso-hero hero-section" aria-label="Welcome section">
                <div class="hero-static">
                    <div class="hero-copy">
                        <h1 class="hero-top">Welcome to <span>PESO</span></h1>

                        <h2 class="hero-town">Manolo Fortich</h2>

                        <h1 class="hero-main">
                            Connecting People <span>with Opportunities</span>
                        </h1>

                        <p class="hero-description">
                            Connecting Filipino jobseekers with verified employers. Access thousands of local and overseas job opportunities through PESO.
                        </p>

                        <div class="hero-cta">
                            <a href="{{ route('login') }}" class="hero-btn-primary">Get Started</a>
                        </div>
                    </div>

                    <aside aria-label="Quick statistics" class="hero-tabulation">
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
                    <span>News &amp; Updates</span>
                    <span></span>
                </h2>

                <div class="news-cards services-grid">
                    <div class="service-card service-blue">
                        <div class="news-card-img-wrapper" style="overflow:hidden;position:relative;border-top-left-radius:20px;border-top-right-radius:20px;">
                            <img src="https://i.pinimg.com/originals/80/9a/3d/809a3de812b7389316cc4c4edb0a3c05.gif" class="news-card-img" alt="Events" style="width:100%;height:180px;object-fit:cover;">
                        </div>
                        <div class="service-card-title">Events</div>
                        <div class="news-card-text mb-2" style="text-align:center;">Upcoming PESO events and job fairs.</div>
                        <ul class="service-features">
                            <li class="service-feature"><span class="service-dot service-blue"><svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 13l4 4L19 7" /></svg></span><span>Upcoming PESO events</span></li>
                            <li class="service-feature"><span class="service-dot service-blue"><svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 13l4 4L19 7" /></svg></span><span>Job fairs and seminars</span></li>
                        </ul>
                        <div class="service-divider"></div>
                        <a href="#" class="service-btn service-blue">
                            <span>Learn More</span>
                            <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>

                    <div class="service-card service-green">
                        <div class="news-card-img-wrapper" style="overflow:hidden;position:relative;border-top-left-radius:20px;border-top-right-radius:20px;">
                            <img src="https://i.pinimg.com/originals/5c/87/17/5c871720baf04c9bb0330801f0101137.gif" class="news-card-img" alt="Announcements" style="width:100%;height:180px;object-fit:cover;">
                        </div>
                        <div class="service-card-title">Announcements</div>
                        <div class="news-card-text mb-2" style="text-align:center;">Latest announcements and updates.</div>
                        <ul class="service-features">
                            <li class="service-feature"><span class="service-dot service-green"><svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 13l4 4L19 7" /></svg></span><span>Latest updates</span></li>
                            <li class="service-feature"><span class="service-dot service-green"><svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 13l4 4L19 7" /></svg></span><span>Important notices</span></li>
                        </ul>
                        <div class="service-divider"></div>
                        <a href="#" class="service-btn service-green">
                            <span>Learn More</span>
                            <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>

                    <div class="service-card service-amber">
                        <div class="news-card-img-wrapper" style="overflow:hidden;position:relative;border-top-left-radius:20px;border-top-right-radius:20px;">
                            <img src="https://i.pinimg.com/originals/d6/74/e7/d674e764a10d6b4f8cdd011f030c886f.gif" class="news-card-img" alt="Community" style="width:100%;height:180px;object-fit:cover;">
                        </div>
                        <div class="service-card-title">Community</div>
                        <div class="news-card-text mb-2" style="text-align:center;">Community initiatives and programs.</div>
                        <ul class="service-features">
                            <li class="service-feature"><span class="service-dot service-amber"><svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 13l4 4L19 7" /></svg></span><span>Community programs</span></li>
                            <li class="service-feature"><span class="service-dot service-amber"><svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 13l4 4L19 7" /></svg></span><span>Initiatives & outreach</span></li>
                        </ul>
                        <div class="service-divider"></div>
                        <a href="#" class="service-btn service-amber">
                            <span>Learn More</span>
                            <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </section>

            @include('components.services')
            @include('components.footer')
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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

                    counters.forEach(function (el) {
                        observer.observe(el);
                    });
                } else {
                    counters.forEach(function (el) {
                        el.textContent = el.dataset.count + (el.dataset.suffix || '');
                    });
                }
            })();
        </script>
    </body>
</html>