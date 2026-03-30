<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PESO Job Portal</title>

        <!-- Preload hero background images to eliminate loading delay -->
        <link rel="preload" as="image" href="/images/background.png">
        <link rel="preload" as="image" href="/images/background-desktop.png" media="(min-width: 1025px)">
        <link rel="preload" as="image" href="/images/background-tablet.png" media="(min-width: 801px) and (max-width: 1024px)">
        <link rel="preload" as="image" href="/images/background-mobile.png" media="(max-width: 800px)">

        <!-- Bootstrap CSS for navbar and layout -->
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

            .peso-hero {
                background-image: url('/images/background-desktop.png'), url('/images/background.png') !important;
                background-size: 1100px auto, 1100px auto !important;
                background-position: center 12px !important;
                background-repeat: no-repeat !important;
                min-height: calc(100vh - 76px);
                position: relative;
                isolation: isolate;
                display: flex;
                align-items: center;
                padding: clamp(32px, 4vw, 52px) 0;
            }

            /* Responsive background sizing */
            .hero-section {
                background-size: 100% auto;
            }

            @media (max-width: 375px) {
                .hero-section {
                    background-size: 120% auto;
                }
            }

            @media (max-width: 480px) {
                .hero-section {
                    background-size: 100% auto;
                }
            }

            .peso-hero::before {
                content: none;
            }

            @media (max-width: 1024px) {
                .peso-hero {
                    background-image: url('/images/background-tablet.png'), url('/images/background.png') !important;
                    background-size: 920px auto, 920px auto !important;
                    background-position: center top !important;
                    height: calc(100svh - 74px) !important;
                    min-height: 520px !important;
                }
            }

            .peso-hero-content {
                width: 100%;
                height: 100%;
                min-height: 100% !important;
                padding: clamp(28px, 5vw, 72px) clamp(18px, 4vw, 38px) !important;
                display: flex;
                align-items: center !important;
                justify-content: center !important;
                position: relative;
                z-index: 1;
            }

            .hero-split {
                width: min(1240px, 100%);
                display: grid;
                grid-template-columns: 1.1fr 0.9fr;
                gap: clamp(28px, 4vw, 56px);
                align-items: start;
                margin: 0 auto;
            }

            .hero-badge {
                display: inline-flex;
                align-items: center;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.9);
                border: 1px solid rgba(252, 211, 77, 0.45);
                color: var(--orig-blue-900);
                padding: 8px 15px;
                font-size: 0.875rem;
                font-weight: 500;
                margin-bottom: 14px;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.22);
            }

            .peso-copy {
                width: 100%;
                margin-inline: 0;
                text-align: left !important;
                justify-self: start;
                max-width: 620px;
            }

            .hero-title {
                margin: 0;
                font-size: clamp(2.1rem, 4.3vw, 3rem);
                line-height: 1.04;
                color: var(--orig-blue-900);
                text-shadow: 0 6px 16px rgba(255, 255, 255, 0.55);
                font-weight: 900;
            }

            .hero-subtitle {
                margin: 8px 0 0;
                color: var(--orig-yellow-300);
                font-size: clamp(1.2rem, 2vw, 1.5rem);
                line-height: 1.1;
                font-weight: 700;
            }

            .hero-description {
                margin: 18px 0 22px;
                color: var(--orig-blue-900);
                font-size: clamp(1rem, 1.2vw, 1.2rem);
                line-height: 1.6;
                max-width: 620px;
            }

            .hero-cta {
                display: inline-flex;
                gap: 14px;
                align-items: center;
                margin-top: 6px;
            }

            .hero-btn-primary {
                background: #1e3a8a;
                color: #ffffff;
                border: 2px solid #1e3a8a;
                padding: 12px 26px;
                border-radius: 999px;
                font-weight: 700;
                letter-spacing: 0.2px;
                box-shadow: 0 12px 30px rgba(30, 58, 138, 0.24);
                transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
                text-decoration: none;
            }

            .hero-btn-primary:hover {
                transform: translateY(-1px);
                box-shadow: 0 16px 34px rgba(30, 58, 138, 0.3);
                background: #2546a3;
            }

            .hero-tabulation {
                background: rgba(255, 255, 255, 0.92);
                color: var(--orig-blue-900);
                border: 1px solid rgba(252, 211, 77, 0.48);
                border-radius: 22px;
                padding: clamp(22px, 2.4vw, 32px);
                width: min(440px, 100%);
                box-shadow: 0 18px 40px rgba(9, 32, 77, 0.22);
                backdrop-filter: blur(10px);
                justify-self: end;
                position: relative;
                overflow: hidden;
                align-self: start;
                margin-top: clamp(32px, 5vw, 78px);
            }

            .hero-tabulation::after {
                content: "";
                position: absolute;
                inset: 0;
                border-radius: inherit;
                pointer-events: none;
                box-shadow: inset 0 0 0 1px rgba(252, 211, 77, 0.32);
            }

            .hero-tabulation-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 18px 24px;
            }

            .hero-stat {
                background: transparent;
                border: 0;
                border-radius: 0;
                padding: 0;
                text-align: center;
            }

            .hero-stat strong {
                display: block;
                font-size: clamp(34px, 3.2vw, 52px);
                line-height: 1;
                color: var(--orig-blue-900);
                font-weight: 900;
            }

            .hero-stat span {
                display: block;
                font-size: 1rem;
                opacity: 0.96;
                margin-top: 8px;
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

            .about-section::before {
                content: none;
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

            @media (max-width: 800px) {
                .peso-hero {
                    background-image: url('/images/background-mobile.png'), url('/images/background.png') !important;
                    background-size: 700px auto, 700px auto !important;
                    height: calc(100svh - 74px) !important;
                    min-height: 520px !important;
                    background-position: center -12px !important;
                }
                    .hero-split {
                        grid-template-columns: 1fr;
                        gap: 18px;
                        align-items: start;
                    }
                    .peso-copy {
                        text-align: center !important;
                        justify-self: center;
                        margin-top: 18px;
                    }
                    .hero-description {
                        margin-inline: auto;
                    }
                    .hero-tabulation {
                        justify-self: center;
                        width: min(560px, 100%);
                        margin-top: 28px;
                    }

                .peso-hero-content {
                    padding: 18px 16px 8px !important;
                }

                .hero-split {
                    grid-template-columns: 1fr;
                        min-height: 620px !important;
                }

                .hero-badge {
                    font-size: 0.8125rem;
                    margin-bottom: 12px;
                }

                .hero-title {
                    font-size: clamp(1.6rem, 7vw, 2.2rem);
                }

                .hero-subtitle {
                    font-size: clamp(1.05rem, 5vw, 1.3rem);
                }

                .hero-tabulation {
                    max-width: 560px;
                    width: 100%;
                    margin-inline: auto;
                    padding: 20px;
                }

                .hero-tabulation-grid {
                    gap: 14px;
                }

                .hero-stat strong {
                    font-size: clamp(26px, 7vw, 38px);
                }

                .about-section {
                    padding: 1.5rem;
                    margin: -0.75rem auto 1.5rem;
                }

                .about-section::before {
                    width: 58%;
                }
                }

            /* Mobile refinements */
            @media (max-width: 540px) {
                .peso-hero {
                    padding: 22px 0 32px;
                    background-size: 680px auto, 680px auto !important;
                    background-position: center 24px !important;
                    padding-bottom: 88px;
                }

                .peso-hero-content {
                    padding: 20px 16px 6px !important;
                }

                .hero-split {
                    gap: 16px;
                }

                .hero-title {
                    font-size: clamp(1.45rem, 6.6vw, 1.95rem);
                    line-height: 1.08;
                }

                .hero-subtitle {
                    font-size: clamp(0.98rem, 5vw, 1.18rem);
                }

                .hero-description {
                    font-size: clamp(0.95rem, 4.6vw, 1.08rem);
                    line-height: 1.55;
                    margin: 12px 0 18px;
                }

                .hero-tabulation {
                    margin-top: 14px;
                    padding: 18px;
                    width: 100%;
                }

                .hero-tabulation-grid {
                    gap: 12px;
                }

                .hero-cta {
                    justify-content: center;
                    margin-top: 12px;
                }

                .hero-btn-primary {
                    width: 100%;
                    text-align: center;
                }

                /* Hide stats card on small phones */
                .hero-tabulation {
                    display: none;
                }
            }

                @media (max-width: 620px) {
                    .peso-brand-text {
                        font-size: 2rem;
                    }
                    .peso-nav {
                        gap: 10px;
                    }
                    .peso-nav a {
                        font-size: 13px;
                    }
                    .peso-chip {
                        min-width: 102px;
                        padding: 8px 12px;
                    }
                    .hero-tabulation {
                        padding: 16px;
                    }
                    .hero-tabulation-grid {
                        gap: 10px 12px;
                    }
                    .hero-stat strong {
                        font-size: clamp(24px, 10vw, 32px);
                    }
                    .hero-stat span {
                        font-size: 0.9rem;
                    }
                }
                .news-updates-section {
    width: min(1320px, calc(100% - 24px));
    margin: 2.2rem auto 3rem;
    padding: 1.5rem 0.6rem;
    border-radius: 16px;
                    background: #ffffff;
    box-shadow: 0 12px 34px rgba(0, 0, 0, 0.08);
}

.news-header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    font-size: clamp(1.25rem, 2vw, 1.8rem);
    font-weight: 700;
    color: #444444;
    margin: 0 0 1.2rem;
    letter-spacing: 1px;
}

.news-header span:first-child,
.news-header span:last-child {
    flex: 1;
    height: 2px;
    background: #cccccc;
}

.news-header-title {
    color: #444444;
}

.news-header-title .news-word {
    color: #185fa5;
}

.news-header-title .updates-word {
    color: #dc2626;
}

.news-updates-section .cards {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    margin: 0;
    padding: 0;
}

.news-updates-section .cards__item {
    display: flex;
    padding: 0.6rem;
    width: 100%;
}

@media (min-width: 40rem) {
    .news-updates-section .cards__item {
        width: 50%;
    }
}

@media (min-width: 56rem) {
    .news-updates-section .cards__item {
        width: 33.3333%;
    }
}

.news-updates-section .card {
    background-color: #ffffff;
    border-radius: 0.25rem;
    box-shadow: 0 20px 40px -14px rgba(0, 0, 0, 0.25);
    display: grid;
    grid-template-rows: auto 1fr;
    overflow: hidden;
    width: 100%;
    transition: transform 0.22s ease;
}

.news-updates-section .card,
.news-updates-section .card__content,
.news-updates-section .card__image {
    background-color: #ffffff;
}

.news-updates-section .card::before,
.news-updates-section .card__image::after {
    content: none !important;
}

.news-updates-section .card:hover {
    transform: translateY(-6px);
}

.news-updates-section .card:hover .card__image {
    filter: contrast(100%);
}

.news-updates-section .card__content {
    display: flex;
    flex-direction: column;
    padding: 1rem;
    text-align: center;
}

.news-updates-section .card__image {
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    filter: none !important;
    overflow: hidden;
    position: relative;
    transition: filter 0.5s cubic-bezier(.43, .41, .22, .91);
}

.news-updates-section .card__image::before {
    content: "";
    display: block;
    padding-top: 56.25%;
}

@media (min-width: 40rem) {
    .news-updates-section .card__image::before {
        padding-top: 66.6%;
    }
}

.news-updates-section .card__image--events {
    background-image: url('https://i.pinimg.com/originals/80/9a/3d/809a3de812b7389316cc4c4edb0a3c05.gif');
}

.news-updates-section .card__image--announcements {
    background-image: url('https://i.pinimg.com/originals/5c/87/17/5c871720baf04c9bb0330801f0101137.gif');
}

.news-updates-section .card__image--community {
    background-image: url('https://i.pinimg.com/originals/d6/74/e7/d674e764a10d6b4f8cdd011f030c886f.gif');
}

.news-updates-section .card__image--careers {
    background-image: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80');
}

.news-updates-section .card__title {
    color: #696969;
    font-size: 1.15rem;
    font-weight: 500;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin: 0 0 0.65rem;
}

.news-updates-section .card__title--events {
    color: #0c4a6e;
}

.news-updates-section .card__title--announcements {
    color: #b91c1c;
}

.news-updates-section .card__title--community {
    color: #166534;
}

.news-updates-section .card__text {
    flex: 1 1 auto;
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0 0 1.1rem;
    color: #666666;
    text-align: justify;
}

.news-updates-section .card__text--events {
    color: #334155;
}

.news-updates-section .card__text--announcements {
    color: #7f1d1d;
}

.news-updates-section .card__text--community {
    color: #14532d;
}

.news-updates-section .btn {
    background-color: #ffffff;
    border: 1px solid #cccccc;
    color: #696969;
    padding: 0.55rem;
    text-transform: lowercase;
    border-radius: 0;
}

.news-updates-section .btn--block {
    display: block;
    width: 100%;
}

.news-updates-section .card__btn:hover {
    background: #f7f7f7;
    border-color: #bdbdbd;
}

.news-updates-section .card__btn:focus-visible {
    outline: 2px solid #185fa5;
    outline-offset: 2px;
}

.news-updates-section .card__btn--events {
    border-color: #bae6fd;
    color: #0c4a6e;
    background: #f0f9ff;
}

.news-updates-section .card__btn--announcements {
    border-color: #fecaca;
    color: #b91c1c;
    background: #fef2f2;
}

.news-updates-section .card__btn--community {
    border-color: #bbf7d0;
    color: #166534;
    background: #f0fdf4;
}

.news-updates-section .card__image img {
    width: 100%;
    height: auto;
    object-fit: cover;
}

        </style>
    </head>
    <body class="peso-body">
        <!-- Navbar Blade Component -->
        @include('components.navbar')

        <main class="peso-main">
            <section class="peso-hero hero-section" aria-label="Welcome section">
                <!-- HERO -->
                <div class="hero-static" style="width: min(1360px, 100%); height: 700px; margin: 0 auto; display: flex; align-items: flex-start; justify-content: space-between; gap: 22px; box-sizing: border-box; background: url('{{ asset('css/images/background.png') }}') center/cover no-repeat; position: relative; overflow: hidden; padding: 100px 24px 90px;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.1);"></div>

                    <div style="position: relative; z-index: 2; text-align: left; color: white; width: min(58%, 680px); transform: translateY(-2px);">
                        <h1 style="font-size: 46px; font-weight: 700; line-height: 1.03; margin-bottom: 10px; color: #075cb2e6; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
                            Welcome to <span style="color: #e74c3c;">PESO</span>
                        </h1>

                        <h2 style="font-size: 46px; font-weight: 700; line-height: 1.03; color: #e74c3c; margin-bottom: 20px;">
                            Manolo Fortich
                        </h2>

                        <h1 style="font-size: 34px; font-weight: 700; line-height: 1.08; margin-bottom: 18px; color: #075cb2e6; text-shadow: 2px 2px 6px rgba(0,0,0,0.3);">
                            Connecting People <span style="color: #e74c3c;">with Opportunities</span>
                        </h1>

                        <p style="font-size: 18px; color: rgb(7, 6, 6); margin-bottom: 30px; line-height: 1.6; text-shadow: 1px 1px 3px rgba(0,0,0,0.3);">
                            Connecting Filipino jobseekers with verified employers. Access thousands of local and overseas job opportunities through PESO.
                        </p>

                        <div style="display: flex; justify-content: flex-start;">
                            <a href="{{ route('login') }}" style="padding: 13px 45px; font-size: 15px; font-weight: 600; border-radius: 30px; border: 2px solid #3498db; color: white; background: #3498db; text-decoration: none;">
                                Get Started
                            </a>
                        </div>
                    </div>

                    <aside aria-label="Quick statistics" style="position: relative; z-index: 2; width: min(340px, 36%); background: rgba(255, 255, 255, 0.92); border: 1px solid rgba(7, 92, 178, 0.2); border-radius: 22px; padding: 20px; box-shadow: 0 18px 40px rgba(9, 32, 77, 0.22); backdrop-filter: blur(10px); transform: translateY(100px);">
                        <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px 24px;">
                            <div style="text-align: center;">
                                <strong class="stat-counter" data-count="500" data-suffix="+" style="display: block; font-size: 40px; line-height: 1; color: #075cb2e6; font-weight: 900;">0</strong>
                                <span style="display: block; font-size: 1rem; margin-top: 8px; font-weight: 600; color: #e74c3c;">Job Seekers</span>
                            </div>
                            <div style="text-align: center;">
                                <strong class="stat-counter" data-count="50" data-suffix="+" style="display: block; font-size: 40px; line-height: 1; color: #075cb2e6; font-weight: 900;">0</strong>
                                <span style="display: block; font-size: 1rem; margin-top: 8px; font-weight: 600; color: #e74c3c;">Employers</span>
                            </div>
                            <div style="text-align: center;">
                                <strong class="stat-counter" data-count="300" data-suffix="+" style="display: block; font-size: 40px; line-height: 1; color: #075cb2e6; font-weight: 900;">0</strong>
                                <span style="display: block; font-size: 1rem; margin-top: 8px; font-weight: 600; color: #e74c3c;">Jobs Posted</span>
                            </div>
                            <div style="text-align: center;">
                                <strong class="stat-counter" data-count="85" data-suffix="+" style="display: block; font-size: 40px; line-height: 1; color: #075cb2e6; font-weight: 900;">0</strong>
                                <span style="display: block; font-size: 1rem; margin-top: 8px; font-weight: 600; color: #e74c3c;">Placement Rate</span>
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
        <span class="news-header-title"><span class="news-word">News</span> &amp; <span class="updates-word">Updates</span></span>
        <span></span>
    </h2>

    <ul class="cards">
        <li class="cards__item">
            <div class="card">
                <div class="card__image card__image--events"></div>
                <div class="card__content">
                    <div class="card__title card__title--events">Events</div>
                    <p class="card__text card__text--events">Stay updated on upcoming PESO events, recruitment drives, and local job fairs open to all applicants.</p>
                    <button class="btn btn--block card__btn card__btn--events">learn more..</button>
                </div>
            </div>
        </li>

        <li class="cards__item">
            <div class="card">
                <div class="card__image card__image--announcements"></div>
                <div class="card__content">
                    <div class="card__title card__title--announcements">Announcements</div>
                    <p class="card__text card__text--announcements">Read recent advisories, office updates, and guidance for employers and jobseekers in Manolo Fortich.</p>
                    <button class="btn btn--block card__btn card__btn--announcements">learn more..</button>
                </div>
            </div>
        </li>

        <li class="cards__item">
            <div class="card">
                <div class="card__image card__image--community"></div>
                <div class="card__content">
                    <div class="card__title card__title--community">Community</div>
                    <p class="card__text card__text--community">Explore skills training, livelihood initiatives, and community-led programs supported by PESO partners.</p>
                    <button class="btn btn--block card__btn card__btn--community">learn more..</button>
                </div>
            </div>
        </li>
    </ul>
</section>
        @include('components.services')
        @include('components.footer')

        </main>

    <!-- Bootstrap JS (for dropdowns and navbar toggler) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Stat counter animation -->
    <script>
    (function () {
        const DURATION = 1800; // ms

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
            // Fallback: just show final values immediately
            counters.forEach(function (el) {
                el.textContent = el.dataset.count + (el.dataset.suffix || '');
            });
        }
    })();
    </script>
    </body>
</html>
