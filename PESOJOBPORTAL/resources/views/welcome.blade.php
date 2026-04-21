@extends('layouts.app')

@section('title', 'PESO Job Portal')

@push('styles')
    <link rel="preload" as="image" href="/images/bg.png">
    <link rel="preload" as="image" href="/images/mobile-background.png" media="(max-width: 800px)">
    <link rel="stylesheet" href="{{ asset('css/objective-section.css') }}">
    <link rel="stylesheet" href="{{ asset('css/services.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') . '?v=' . filemtime(public_path('css/welcome.css')) }}">
@endpush

@section('content')
    <section class="peso-hero hero-section" aria-label="Welcome section">
        <div class="hero-static">
            <div class="hero-copy">
                <p class="hero-kicker">Welcome</p>
                <h1 class="hero-main">
                    Connecting People <span>with Opportunities</span>
                </h1>
                <div class="underline" aria-hidden="true"></div>

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
                        <div class="objective-divider" aria-hidden="true"></div>
                        <span>Job Seekers</span>
                    </div>
                    <div class="hero-stat">
                        <strong class="stat-counter" data-count="50" data-suffix="+">0</strong>
                        <div class="objective-divider" aria-hidden="true"></div>
                        <span>Employers</span>
                    </div>
                    <div class="hero-stat">
                        <strong class="stat-counter" data-count="300" data-suffix="+">0</strong>
                        <div class="objective-divider" aria-hidden="true"></div>
                        <span>Jobs Posted</span>
                    </div>
                    <div class="hero-stat">
                        <strong class="stat-counter" data-count="85" data-suffix="+">0</strong>
                        <div class="objective-divider" aria-hidden="true"></div>
                        <span>Placement Rate</span>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <section class="about-section" id="about-main" aria-label="About PESO Manolo Fortich">
        <div class="about-grid">
            <article class="about-item objective-card">
                <span class="card-number">OUR MISSION</span>
                <h3>Our Mission</h3>
                <div class="objective-divider" aria-hidden="true"></div>
                <p>
                    To promote economic growth and sustainable development in Manolo Fortich through the
                    implementation of the PESO program, providing employment opportunities and skills
                    development for the community.
                </p>
            </article>

            <article class="about-item objective-card">
                <span class="card-number">OUR VISION</span>
                <h3>Our Vision</h3>
                <div class="objective-divider" aria-hidden="true"></div>
                <p>
                    To become the lead municipality in the Philippines by creating a robust local economy that
                    provides decent jobs, promotes entrepreneurship, and enhances the quality of life of the
                    residents of Manolo Fortich.
                </p>
            </article>
        </div>
    </section>

    <section id="features" class="news-updates-section portal-features">
        <div class="portal-features-head">
            <h2 class="news-header">
                <span></span>
                <span>News &amp; Updates</span>
                <span></span>
            </h2>
            <p class="portal-features-subtitle">Stay informed with PESO programs, announcements, and community updates.</p>
        </div>

        <div class="news-cards">
            <div class="card news-card objective-card">
                <img src="https://i.pinimg.com/originals/80/9a/3d/809a3de812b7389316cc4c4edb0a3c05.gif" class="news-card-img" alt="Events">
                <div class="card-body news-card-body">
                    <span class="feature-chip">Feature 01</span>
                    <h5 class="news-card-title">Events</h5>
                    <div class="objective-divider" aria-hidden="true"></div>
                    <p class="card-text news-card-text">Upcoming PESO events and job fairs.</p>
                    <a href="#" class="btn btn-danger">Learn More <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
                </div>
            </div>

            <div class="card news-card objective-card">
                <img src="https://i.pinimg.com/originals/5c/87/17/5c871720baf04c9bb0330801f0101137.gif" class="news-card-img" alt="Announcements">
                <div class="card-body news-card-body">
                    <span class="feature-chip">Feature 02</span>
                    <h5 class="news-card-title">Announcements</h5>
                    <div class="objective-divider" aria-hidden="true"></div>
                    <p class="card-text news-card-text">Latest announcements and updates.</p>
                    <a href="#" class="btn btn-danger">Learn More <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
                </div>
            </div>

            <div class="card news-card objective-card">
                <img src="https://i.pinimg.com/originals/d6/74/e7/d674e764a10d6b4f8cdd011f030c886f.gif" class="news-card-img" alt="Community">
                <div class="card-body news-card-body">
                    <span class="feature-chip">Feature 03</span>
                    <h5 class="news-card-title">Community</h5>
                    <div class="objective-divider" aria-hidden="true"></div>
                    <p class="card-text news-card-text">Community initiatives and programs.</p>
                    <a href="#" class="btn btn-danger">Learn More <span class="btn-arrow" aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
        </div>
    </section>

    @include('components.services')
    @include('components.footer')
@endsection

@push('scripts')
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
@endpush