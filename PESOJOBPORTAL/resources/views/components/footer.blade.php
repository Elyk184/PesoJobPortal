<!-- FOOTER / CONTACT -->
<footer id="contact" class="peso-footer">
    <style>
        .peso-footer {
            background: linear-gradient(135deg, #0a1428 0%, #0f1f35 50%, #08141f 100%);
            color: #e0e7ff;
            padding: 4rem 2rem 1.5rem;
            margin-top: 6rem;
            border-top: 3px solid #d72638;
            box-shadow: 0 -8px 24px rgba(0, 0, 0, 0.3);
        }

        .peso-footer .container {
            max-width: 1300px;
            margin: 0 auto;
        }

        .peso-footer .row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .peso-footer .col-lg-3 {
            grid-column: span 1;
        }

        .footer-title {
            color: #ffffff !important;
            font-weight: 800 !important;
            font-size: 16px;
            margin-bottom: 1.5rem !important;
            letter-spacing: -0.3px;
        }

        .peso-footer p {
            color: #cbd5e1;
            font-size: 14px;
            line-height: 1.6;
        }

        .peso-footer .text-blue-300 {
            color: #cbd5e1 !important;
        }

        .peso-footer .list-unstyled li {
            color: #cbd5e1;
            font-size: 14px;
        }

        .peso-footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .peso-footer a:hover {
            color: #d72638;
        }

        .peso-footer .bi {
            color: #d72638;
            font-size: 1.2rem;
        }

        .peso-footer .d-flex.align-items-center.gap-2 {
            gap: 0.75rem !important;
        }

        .peso-footer .d-flex.justify-content-between {
            display: flex;
            justify-content: space-between;
        }

        .peso-footer .mb-lg-0 {
            margin-bottom: 0 !important;
        }

        .peso-footer hr,
        .peso-footer .border-top {
            border-color: rgba(215, 38, 56, 0.2) !important;
        }

        .peso-footer .py-5 {
            padding: 2rem 0 !important;
        }

        .peso-footer .mt-4 {
            margin-top: 1.5rem !important;
        }

        .peso-footer .pt-3 {
            padding-top: 1.5rem !important;
        }

        .peso-footer .gap-4 {
            gap: 2rem !important;
        }

        .footer-social-btn {
            background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%);
            color: white !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 8px !important;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .footer-social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(215, 38, 56, 0.3);
        }

        @media (max-width: 768px) {
            .peso-footer {
                padding: 2.5rem 1rem 1rem;
            }

            .peso-footer .row {
                grid-template-columns: 1fr;
                gap: 2rem;
                margin-bottom: 2rem;
            }

            .footer-title {
                font-size: 15px;
            }

            .peso-footer p,
            .peso-footer .list-unstyled li {
                font-size: 13px;
            }
        }
    </style>

    <div class="container py-5">
        <div class="row g-4 align-items-start">
            <!-- About Section -->
            <div class="col-12 col-sm-6 col-lg-3 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="PESO Logo" class="rounded-circle shadow-sm me-3" style="width: 48px; height: 42px; object-fit: cover;">
                    <div>
                        <h4 class="footer-title mb-0">PESO</h4>
                        <p style="margin: 0.25rem 0 0 0; font-size: 12px; color: #b0b8d4; font-weight: 600;">Manolo Fortich</p>
                    </div>
                </div>
                <p style="margin-bottom: 1.5rem;">Public Employment Service Office — Connecting jobseekers with opportunities in Manolo Fortich, Bukidnon.</p>
                <div class="d-flex align-items-center gap-2">
                    <a href="https://www.facebook.com/lgupesomanolofortich" target="_blank" style="width: 40px; height: 40px; background: rgba(215, 38, 56, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" style="width: 40px; height: 40px; background: rgba(215, 38, 56, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                        <i class="bi bi-twitter"></i>
                    </a>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="col-12 col-sm-6 col-lg-3 mb-4 mb-lg-0">
                <h4 class="footer-title">Contact Us</h4>
                <ul class="list-unstyled">
                    <li class="d-flex align-items-start gap-2 mb-2">
                        <i class="bi bi-geo-alt-fill" style="margin-top: 2px; flex-shrink: 0;"></i>
                        <span>Gen. Andres Bonifacio St. Cor. Albarece St., Brgy. Tankulan, Manolo Fortich, Bukidnon 8703</span>
                    </li>
                    <li class="d-flex align-items-start gap-2 mb-2">
                        <i class="bi bi-envelope-fill" style="margin-top: 2px; flex-shrink: 0;"></i>
                        <span>peso@manolofortich.gov.ph</span>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-telephone-fill" style="margin-top: 2px; flex-shrink: 0;"></i>
                        <span>(088) 123-4567</span>
                    </li>
                </ul>
            </div>

            <!-- Quick Links Section -->
            <div class="col-12 col-sm-6 col-lg-3 mb-4 mb-lg-0">
                <h4 class="footer-title">Quick Links</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/') }}">Home</a></li>
                    <li class="mb-2"><a href="{{ url('/#about-main') }}">About Us</a></li>
                    <li class="mb-2"><a href="{{ url('/#features') }}">Services</a></li>
                    <li class="mb-2"><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                </ul>
            </div>

            <!-- Office Hours Section -->
            <div class="col-12 col-sm-6 col-lg-3">
                <h4 class="footer-title">Office Hours</h4>
                <ul class="list-unstyled">
                    <li class="d-flex justify-content-between mb-2">
                        <span>Monday - Thursday</span>
                        <span style="color: #fff; font-weight: 600;">7:30 AM - 6:00 PM</span>
                    </li>
                    <li class="d-flex justify-content-between mb-2">
                        <span>Friday</span>
                        <span style="color: #fff; font-weight: 600;">Closed</span>
                    </li>
                    <li class="d-flex justify-content-between mb-2">
                        <span>Saturday</span>
                        <span style="color: #fff; font-weight: 600;">Closed</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span>Sunday</span>
                        <span style="color: #fff; font-weight: 600;">Closed</span>
                    </li>
                </ul>
                <div class="mt-4 pt-3" style="border-top: 1px solid rgba(215, 38, 56, 0.2);">
                    <a href="https://www.facebook.com/lgupesomanolofortich" target="_blank" class="footer-social-btn">
                        <i class="bi bi-facebook"></i>
                        <span>Facebook</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="text-center mt-4 pt-3" style="border-top: 1px solid rgba(215, 38, 56, 0.2);">
            <p style="margin: 0; font-size: 13px; color: #b0b8d4;">&copy; {{ date('Y') }} PESO Job Portal System — Manolo Fortich, Bukidnon. All rights reserved.</p>
        </div>
    </div>
</footer>
