<!-- NAVBAR HEADER -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<nav class="navbar navbar-expand-lg navbar-dark fixed-top sticky-top custom-navbar">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
      <img src="{{ asset('images/logo.png') }}" alt="PESO Logo" title="PESO Logo" class="logo-img me-2" style="width: 95px; height: auto; border-radius: 4px; object-fit: contain;">
      <span class="d-none d-sm-inline navbar-brand-text">PUBLIC EMPLOYMENT SERVICES OFFICE</span>
      <span class="d-sm-none navbar-brand-text-sm">Manolo Fortich</span>
    </a>

    <button class="navbar-toggler navbar-toggler-custom" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto navbar-nav-custom">
        <li class="nav-item nav-item-custom">
          <a class="nav-link nav-link-custom {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="{{ url('/') }}">
            <i class="bi bi-house-door me-2"></i>Home
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle nav-link-custom {{ request()->is('about*','objectives','history','history-of-excellence','legal-mandate') ? 'active' : '' }}" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-info-circle me-2"></i>Get To Know Us
          </a>
          <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="aboutDropdown">
            <li><a class="dropdown-item dropdown-item-custom {{ request()->is('objectives') ? 'active' : '' }}" href="{{ url('/objectives') }}"><i class="bi bi-bullseye me-2"></i>Objectives</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->is('history') ? 'active' : '' }}" href="{{ url('/history') }}"><i class="bi bi-clock-history me-2"></i>History</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->is('history-of-excellence') ? 'active' : '' }}" href="{{ url('/history-of-excellence') }}"><i class="bi bi-award me-2"></i>History of Excellence</a></li>
            <li><a class="dropdown-item dropdown-item-custom {{ request()->is('legal-mandate') ? 'active' : '' }}" href="{{ url('/legal-mandate') }}"><i class="bi bi-shield-check me-2"></i>Legal Mandate</a></li>
            <li><a class="dropdown-item dropdown-item-custom" href="{{ url('/about') }}"><i class="bi bi-diagram-3 me-2"></i>Organizational Structure</a></li>
          </ul>
        </li>
        <li class="nav-item nav-item-custom">
          <a class="nav-link nav-link-custom {{ request()->is('jobs') ? 'active' : '' }}" href="{{ url('/jobs') }}">
            <i class="bi bi-briefcase me-2"></i>Job List
          </a>
        </li>
        <li class="nav-item nav-item-custom">
          <a class="nav-link nav-link-custom {{ str_contains(request()->url(), '#services') ? 'active' : '' }}" href="{{ url('/#services') }}">
            <i class="bi bi-tools me-2"></i>Services
          </a>
        </li>
        <li class="nav-item nav-item-custom">
          <a class="nav-link nav-link-custom {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">
            <i class="bi bi-telephone me-2"></i>Contact
          </a>
        </li>
        @auth
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle nav-link-custom" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle me-2"></i>{{ auth()->user()->name }}
          </a>
          <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="userDropdown">
            <li><a class="dropdown-item dropdown-item-custom" href="{{ auth()->user()->redirectToDashboard() }}">
              <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="dropdown-item dropdown-item-custom text-danger">
                  <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
              </form>
            </li>
          </ul>
        </li>
        @else
        <li class="nav-item d-flex align-items-center ms-2">
          <a href="{{ route('login') }}" class="btn fw-bold cta-button">
            <i class="bi bi-box-arrow-in-right me-2"></i><span class="d-none d-sm-inline">Log In</span><span class="d-sm-none">Login</span>
          </a>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<style>
.custom-navbar {
  background: linear-gradient(90deg, #0f2d52, #1f4b8f);
  border-bottom: 3px solid #d72638;
  box-shadow: 0 10px 28px rgba(10, 35, 80, 0.28);
  padding-block: 10px;
}

.navbar-brand-text {
  color: #f5f7fb;
  font-weight: 700;
  letter-spacing: 0.5px;
}

.navbar-brand-text-sm {
  color: #f5f7fb;
  font-weight: 700;
}

.navbar-nav-custom .nav-link-custom {
  color: #dfe7f5;
  font-weight: 600;
  padding: 10px 14px;
  border-radius: 10px;
  transition: color 0.18s ease, background-color 0.18s ease, box-shadow 0.18s ease;
}

.navbar-nav-custom .nav-link-custom:hover {
  color: #ffffff;
  background: rgba(255, 255, 255, 0.08);
  box-shadow: 0 8px 18px rgba(15, 45, 82, 0.32);
}

.navbar .nav-link-custom.active {
  color: #ffffff !important;
  background: rgba(215, 38, 56, 0.16);
  box-shadow: inset 0 0 0 1px rgba(215, 38, 56, 0.6);
}

.dropdown-menu-custom {
  border-radius: 12px;
  box-shadow: 0 14px 30px rgba(10, 35, 80, 0.18);
  border: 1px solid rgba(15, 45, 82, 0.08);
}

.dropdown-item-custom {
  font-weight: 600;
}

.dropdown-item-custom:hover,
.dropdown-item-custom.active {
  background: rgba(215, 38, 56, 0.14);
  color: #0f2d52;
}

.cta-button {
  background: linear-gradient(120deg, #d72638, #f24b5d);
  border: 1px solid #d72638;
  color: #ffffff;
  border-radius: 999px;
  padding: 10px 18px;
  box-shadow: 0 10px 20px rgba(215, 38, 56, 0.28);
}

.cta-button:hover {
  color: #ffffff;
  filter: brightness(1.05);
}

.navbar-toggler-custom {
  border-color: rgba(255, 255, 255, 0.5);
}

.navbar-toggler-custom .navbar-toggler-icon {
  filter: invert(92%);
}

.logo-fallback {
  font-size: 1.4rem !important;
}

/* Keep footer at the bottom even on short pages */
body {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

main {
  flex: 1 0 auto;
}

.peso-footer {
  margin-top: auto;
}
</style>



