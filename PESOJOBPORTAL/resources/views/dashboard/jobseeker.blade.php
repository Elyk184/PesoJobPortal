@extends('layouts.app')

@section('title', 'Jobseeker Dashboard | PESO Job Portal')

@section('content')
    <div class="container py-4 py-lg-5">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 mb-4">
            <div>
                <h1 class="mb-1 fw-bold">Jobseeker Dashboard</h1>
                <p class="mb-0 text-muted">Welcome, {{ auth()->user()->name ?? 'Jobseeker' }}.</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
        </div>

        <div class="row g-3">
            <div class="col-12 col-md-6 col-lg-4">
                <a class="text-decoration-none" href="{{ route('jobseeker.vacancies') }}">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-2 fw-semibold">Browse Vacancies</h5>
                            <p class="card-text text-muted mb-0">View available job posts (static page for now).</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <a class="text-decoration-none" href="{{ route('jobseeker.applications') }}">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-2 fw-semibold">My Applications</h5>
                            <p class="card-text text-muted mb-0">Track your submitted applications (static page for now).</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <a class="text-decoration-none" href="{{ route('jobseeker.profile') }}">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-2 fw-semibold">My Profile</h5>
                            <p class="card-text text-muted mb-0">View and update your profile (static page for now).</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @include('components.footer')
@endsection
