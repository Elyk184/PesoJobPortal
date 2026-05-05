<!-- PESO Footer - Fixed Alignment -->
<footer class="peso-footer bg-dark text-light py-5 mt-5 border-top border-danger" style="background: linear-gradient(135deg, #0a1428 0%, #0f1f35 50%, #08141f 100%); border-top: 3px solid #d72638 !important; box-shadow: 0 -8px 24px rgba(0,0,0,0.3);">
  <div class="container-xl">
    <div class="row g-4 g-lg-5 mb-5">
      <!-- About Column -->
      <div class="col-lg-3 col-md-6">
        <div class="d-flex align-items-center mb-4 gap-3">
          <img src="{{ asset('images/logo.png') }}" alt="PESO Logo" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
          <div>
            <h5 class="mb-1 text-white fw-bold" style="font-size: 1.1rem; letter-spacing: -0.5px;">PESO Manolo Fortich</h5>
            <p class="mb-0 small text-muted fw-medium">Public Employment Service Office</p>
          </div>
        </div>
        <p class="text-light opacity-90 lh-lg small mb-4">Connecting jobseekers with verified employers and opportunities in Manolo Fortich, Bukidnon.</p>
        <div class="d-flex gap-2">
          <a href="https://www.facebook.com/lgupesomanolofortich" target="_blank" class="btn btn-outline-danger btn-sm rounded-circle p-2" style="width: 44px; height: 44px;" title="Facebook">
            <i class="bi bi-facebook"></i>
          </a>
          <a href="#" class="btn btn-outline-danger btn-sm rounded-circle p-2" style="width: 44px; height: 44px;" title="Twitter">
            <i class="bi bi-twitter-x"></i>
          </a>
        </div>
      </div>

      <!-- Contact Column -->
      <div class="col-lg-3 col-md-6">
        <h5 class="text-white fw-bold mb-4" style="letter-spacing: -0.5px;">Contact Information</h5>
        <ul class="list-unstyled">
          <li class="mb-3 d-flex align-items-start gap-3">
            <i class="bi bi-geo-alt-fill text-danger mt-1 flex-shrink-0" style="font-size: 1.1rem;"></i>
            <span class="small lh-lg">Gen. Andres Bonifacio St. Cor. Albarece St., Brgy. Tankulan<br>Manolo Fortich, Bukidnon 8703</span>
          </li>
          <li class="mb-3 d-flex align-items-start gap-3">
            <i class="bi bi-envelope-fill text-danger mt-1 flex-shrink-0" style="font-size: 1.1rem;"></i>
            <span class="small lh-lg">peso@manolofortich.gov.ph</span>
          </li>
          <li class="d-flex align-items-start gap-3">
            <i class="bi bi-telephone-fill text-danger mt-1 flex-shrink-0" style="font-size: 1.1rem;"></i>
            <span class="small lh-lg">(088) 123-4567</span>
          </li>
        </ul>
      </div>

      <!-- Quick Links Column -->
      <div class="col-lg-3 col-md-6">
        <h5 class="text-white fw-bold mb-4" style="letter-spacing: -0.5px;">Quick Links</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="{{ route('home') }}" class="text-light text-decoration-none small lh-lg" style="transition: color 0.2s;">Home</a></li>
          <li class="mb-2"><a href="{{ route('history') }}" class="text-light text-decoration-none small lh-lg" style="transition: color 0.2s;">About</a></li>
          <li class="mb-2"><a href="{{ route('jobs.index') }}" class="text-light text-decoration-none small lh-lg" style="transition: color 0.2s;">Jobs</a></li>
          <li class="mb-2"><a href="{{ route('contact') }}" class="text-light text-decoration-none small lh-lg" style="transition: color 0.2s;">Contact</a></li>
          <li class="mb-2"><a href="{{ route('login') }}" class="text-light text-decoration-none small lh-lg" style="transition: color 0.2s;">Login</a></li>
        </ul>
      </div>

      <!-- Office Hours Column -->
      <div class="col-lg-3 col-md-6">
        <h5 class="text-white fw-bold mb-4" style="letter-spacing: -0.5px;">Office Hours</h5>
        <ul class="list-unstyled mb-4">
          <li class="mb-2 d-flex justify-content-between small">
            <span>Monday - Thursday</span>
            <span class="text-white fw-medium">7:30 AM - 6:00 PM</span>
          </li>
          <li class="mb-2 d-flex justify-content-between small">
            <span>Friday - Sunday</span>
            <span class="text-white fw-medium">Closed</span>
          </li>
        </ul>
        <a href="https://www.facebook.com/lgupesomanolofortich" target="_blank" class="btn btn-danger px-4 py-2 w-100 text-white fw-medium mb-3">
          <i class="bi bi-facebook me-2"></i>
          Visit Facebook
        </a>
      </div>
    </div>

    <!-- Copyright -->
    <div class="text-center border-top border-danger border-opacity-25 pt-4 mt-4">
      <p class="mb-0 small text-light opacity-75">&copy; {{ date('Y') }} PESO Job Portal — Manolo Fortich, Bukidnon. All rights reserved.</p>
    </div>
  </div>
</footer>
