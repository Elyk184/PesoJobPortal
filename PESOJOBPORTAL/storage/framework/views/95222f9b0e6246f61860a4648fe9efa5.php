<!-- NAVBAR HEADER -->

<style>
  .custom-navbar {
    background: linear-gradient(90deg, #0f2d52, #1f4b8f);
    border-bottom: 3px solid #d72638;
    box-shadow: 0 8px 22px rgba(10, 35, 80, 0.22);
    z-index: 1000;
    padding: 0.55rem 0;
  }

  .logo-img {
    width: 86px;
    height: auto;
    border-radius: 8px;
    object-fit: contain;
  }

  .navbar-brand-text,
  .navbar-brand-text-sm {
    color: #f5f7fb;
    font-weight: 700;
    letter-spacing: 0.2px;
  }

  .navbar-brand-text {
    font-size: 1rem;
  }

  .navbar-brand-text-sm {
    font-size: 0.95rem;
  }

  .navbar-nav-custom {
    gap: 0.2rem;
  }

  .nav-link-custom {
    color: #dfe7f5 !important;
    font-weight: 600;
    border-radius: 999px;
    padding: 0.45rem 0.8rem !important;
    transition: all 0.18s ease;
  }

  .nav-link-custom:hover,
  .nav-link-custom.active,
  .show > .nav-link-custom {
    background: rgba(215, 38, 56, 0.92);
    color: #ffffff !important;
  }

  .navbar-toggler-custom {
    border-color: rgba(245, 247, 251, 0.65);
    padding: 0.3rem 0.45rem;
  }

  .navbar-toggler-custom:focus {
    box-shadow: 0 0 0 0.2rem rgba(179, 198, 224, 0.28);
  }

  .dropdown-menu-custom {
    background: #10315a;
    border: 1px solid #2f5e9e;
    border-radius: 12px;
    box-shadow: 0 12px 28px rgba(6, 24, 51, 0.35);
    padding: 0.45rem;
  }

  .dropdown-item-custom {
    border-radius: 8px;
    color: #dfe7f5;
    font-weight: 500;
  }

  .dropdown-item-custom:hover,
  .dropdown-item-custom.active {
    background: rgba(215, 38, 56, 0.92);
    color: #ffffff;
  }

  .cta-button {
    background: linear-gradient(120deg, #d72638, #f24b5d);
    color: #ffffff;
    border: 1px solid #d72638;
    border-radius: 999px;
    padding: 0.42rem 1rem;
    transition: all 0.18s ease;
  }

  .cta-button:hover {
    background: linear-gradient(120deg, #c21e30, #e33f52);
    border-color: #c21e30;
    color: #ffffff;
  }

  @media (max-width: 991.98px) {
    .navbar-brand-text {
      font-size: 0.9rem;
    }

    .logo-img {
      width: 74px;
    }

    .navbar-collapse {
      margin-top: 0.45rem;
      background: linear-gradient(180deg, #0f2d52, #19437f);
      border-radius: 12px;
      padding: 0.55rem;
      border: 1px solid #2f5e9e;
    }

    .nav-link-custom {
      border-radius: 10px;
      padding: 0.55rem 0.8rem !important;
    }
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="<?php echo e(url('/')); ?>">
      <img src="<?php echo e(asset('images/logo.png')); ?>" alt="PESO Logo" title="PESO Logo" class="logo-img me-2">
      <span class="d-none d-sm-inline navbar-brand-text">PUBLIC EMPLOYMENT SERVICES OFFICE</span>
      <span class="d-sm-none navbar-brand-text-sm">Manolo Fortich</span>
    </a>

    <button class="navbar-toggler navbar-toggler-custom" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto navbar-nav-custom">
        <li class="nav-item nav-item-custom">
          <a class="nav-link nav-link-custom <?php echo e(request()->is('/') ? 'active' : ''); ?>" aria-current="page" href="<?php echo e(url('/')); ?>">
            <i class="bi bi-house-door me-2"></i>Home
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle nav-link-custom <?php echo e(request()->is('about*','objectives','history','history-of-excellence','legal-mandate') ? 'active' : ''); ?>" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-info-circle me-2"></i>Get To Know Us
          </a>
          <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="aboutDropdown">
            <li><a class="dropdown-item dropdown-item-custom <?php echo e(request()->is('objectives') ? 'active' : ''); ?>" href="<?php echo e(url('/objectives')); ?>"><i class="bi bi-bullseye me-2"></i>Objectives</a></li>
            <li><a class="dropdown-item dropdown-item-custom <?php echo e(request()->is('history') ? 'active' : ''); ?>" href="<?php echo e(url('/history')); ?>"><i class="bi bi-clock-history me-2"></i>History</a></li>
            <li><a class="dropdown-item dropdown-item-custom <?php echo e(request()->is('history-of-excellence') ? 'active' : ''); ?>" href="<?php echo e(url('/history-of-excellence')); ?>"><i class="bi bi-award me-2"></i>History of Excellence</a></li>
            <li><a class="dropdown-item dropdown-item-custom <?php echo e(request()->is('legal-mandate') ? 'active' : ''); ?>" href="<?php echo e(url('/legal-mandate')); ?>"><i class="bi bi-shield-check me-2"></i>Legal Mandate</a></li>
            <li><a class="dropdown-item dropdown-item-custom" href="<?php echo e(url('/structure')); ?>"><i class="bi bi-diagram-3 me-2"></i>Organizational Structure</a></li>
          </ul>
        </li>
        <li class="nav-item nav-item-custom">
          <a class="nav-link nav-link-custom <?php echo e(request()->is('jobs') ? 'active' : ''); ?>" href="<?php echo e(url('/jobs')); ?>">
            <i class="bi bi-briefcase me-2"></i>Job List
          </a>
        </li>
        <li class="nav-item nav-item-custom">
          <a class="nav-link nav-link-custom <?php echo e(str_contains(request()->url(), '#services') ? 'active' : ''); ?>" href="<?php echo e(url('/#services')); ?>">
            <i class="bi bi-tools me-2"></i>Services
          </a>
        </li>
        <li class="nav-item nav-item-custom">
          <a class="nav-link nav-link-custom <?php echo e(request()->is('contact') ? 'active' : ''); ?>" href="<?php echo e(url('/contact')); ?>">
            <i class="bi bi-telephone me-2"></i>Contact
          </a>
        </li>
        <?php if(auth()->guard()->check()): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle nav-link-custom" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle me-2"></i><?php echo e(auth()->user()->name); ?>

          </a>
          <ul class="dropdown-menu dropdown-menu-custom" aria-labelledby="userDropdown">
            <li><a class="dropdown-item dropdown-item-custom" href="<?php echo e(auth()->user()->redirectToDashboard()); ?>">
              <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="<?php echo e(url('/logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="dropdown-item dropdown-item-custom text-danger">
                  <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
              </form>
            </li>
          </ul>
        </li>
        <?php else: ?>
        <li class="nav-item d-flex align-items-center ms-2">
          <a href="<?php echo e(route('login')); ?>" class="btn fw-bold cta-button">
            <i class="bi bi-box-arrow-in-right me-2"></i><span class="d-none d-sm-inline">Log In</span><span class="d-sm-none">Login</span>
          </a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>



<?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\components\navbar.blade.php ENDPATH**/ ?>