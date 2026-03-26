<!-- FOOTER / CONTACT -->
<footer id="contact" class="peso-footer" style="background: linear-gradient(90deg, #0f2d52, #1f4b8f); color: #dfe7f5; border-top: 3px solid #d72638; box-shadow: 0 -10px 28px rgba(10, 35, 80, 0.18);">
    <div class="nav-container container py-5">
        <div class="row g-4 align-items-start">
            <div class="col-12 col-sm-6 col-lg-3 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="PESO Logo" class="rounded-circle shadow-sm me-3" style="width: 48px; height: 42px; object-fit: cover;">
                    <h4 class="footer-title mb-0" style="color: #f5f7fb; font-weight: 700;">PESO Manolo Fortich</h4>
                </div>
                <p class="text-blue-300 text-sm mb-3" style="color: #b3c6e0;">Public Employment Service Office — Connecting jobseekers with opportunities in Manolo Fortich, Bukidnon.</p>
                <div class="d-flex align-items-center mt-3">
                    <a href="https://www.facebook.com/lgupesomanolofortich" target="_blank" class="d-flex align-items-center gap-2" style="color: #b3c6e0; text-decoration: none;">
                        <i class="bi bi-facebook" style="font-size: 1.2rem;"></i>
                        <span>PESO Manolo Fortich</span>
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 mb-4 mb-lg-0">
                <h4 class="footer-title" style="color: #f5f7fb; font-weight: 700;">Contact Us</h4>
                <ul class="list-unstyled" style="color: #b3c6e0;">
                    <li class="d-flex align-items-start gap-2 mb-2">
                        <i class="bi bi-geo-alt-fill mt-1" style="font-size: 1rem;"></i>
                        <span>Gen. Andres Bonifacio St. Cor. Albarece St., Brgy. Tankulan, Manolo Fortich, Bukidnon 8703,</span>
                        <li>(In front of Tankulan Flea Market - Taboan)</li>
                    </li>
                    <li class="d-flex align-items-start gap-2 mb-2">
                        <i class="bi bi-envelope-fill mt-1" style="font-size: 1rem;"></i>
                        <span>peso@manolofortich.gov.ph</span>
                    </li>
                    <li class="d-flex align-items-start gap-2 mb-2">
                        <i class="bi bi-telephone-fill mt-1" style="font-size: 1rem;"></i>
                        <span>(088) 123-4567</span>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 mb-4 mb-lg-0">
                <h4 class="footer-title" style="color: #f5f7fb; font-weight: 700;">Quick Links</h4>
                <ul class="list-unstyled" style="color: #b3c6e0;">
                    <li class="mb-2"><a href="{{ url('/') }}" style="color: #b3c6e0; text-decoration: none;">Home</a></li>
                    <li class="mb-2"><a href="{{ url('/#services') }}" style="color: #b3c6e0; text-decoration: none;">Services</a></li>
                    <li class="mb-2"><a href="{{ url('/jobs') }}" style="color: #b3c6e0; text-decoration: none;">Job List</a></li>
                    <li class="mb-2"><a href="{{ url('/contact') }}" style="color: #b3c6e0; text-decoration: none;">Contact</a></li>
                </ul>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <h4 class="footer-title" style="color: #f5f7fb; font-weight: 700;">Office Hours</h4>
                <ul class="list-unstyled" style="color: #b3c6e0;">
                    <li class="d-flex justify-content-between mb-2"><span>Monday - Thursday</span><span style="color: #fff;">7:30 AM - 6:00 PM</span></li>
                    <li class="d-flex justify-content-between mb-2"><span>Friday</span><span style="color: #fff;">Closed</span></li>
                    <li class="d-flex justify-content-between mb-2"><span>Saturday</span><span style="color: #fff;">Closed</span></li>
                    <li class="d-flex justify-content-between mb-2"><span>Sunday</span><span style="color: #fff;">Closed</span></li>
                </ul>
                <div class="mt-4 pt-3 border-top" style="border-color: #1f4b8f !important;">
                    <a href="https://www.facebook.com/lgupesomanolofortich" target="_blank" class="d-inline-flex align-items-center gap-2 px-4 py-2 rounded-2 fw-medium" style="background: linear-gradient(120deg, #d72638, #f24b5d); color: #fff; text-decoration: none;">
                        <i class="bi bi-facebook" style="font-size: 1rem;"></i>
                        Visit our Facebook Page
                    </a>
                </div>
            </div>
        </div>
        <div class="text-center mt-4 pt-3" style="border-top: 1px solid #1f4b8f; color: #b3c6e0;">
            <p class="mb-0">&copy; {{ date('Y') }} PESO Job Portal System — Manolo Fortich, Bukidnon. All rights reserved.</p>
        </div>
    </div>
</footer>
