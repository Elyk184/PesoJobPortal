<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PESO Job Portal</title>

        <link rel="preload" as="image" href="/images/background.png">
        <link rel="preload" as="image" href="/images/mobile-background.png" media="(max-width: 800px)">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @endif
        <link rel="stylesheet" href="{{ asset('css/services.css') }}">
        <link rel="stylesheet" href="{{ asset('css/welcome.css') . '?v=' . filemtime(public_path('css/welcome.css')) }}">

        
    </head>
    <body class="peso-body">
        @include('components.navbar')

        <main class="peso-main">
            <section class="peso-hero hero-section" aria-label="Welcome section">
                <div class="hero-static">
                    <div class="hero-copy">
                        

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