@extends('layouts.app')

@section('title', 'OFW Dashboard | Link Job Resource Portal')

@section('content')
    <div class="container py-4 py-lg-5">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 mb-4">
            <div>
                <h1 class="mb-1 fw-bold">OFW Dashboard</h1>
                <p class="mb-0 text-muted">Welcome, {{ auth()->user()->name ?? 'OFW' }}.</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
        </div>

        <div class="row g-3">
            <div class="col-12 col-md-6 col-lg-4">
                <a class="text-decoration-none" href="{{ route('ofw.opportunities') }}">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-2 fw-semibold">Job Opportunities</h5>
                            <p class="card-text text-muted mb-0">Explore international employment opportunities.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <a class="text-decoration-none" href="{{ route('ofw.applications') }}">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-2 fw-semibold">My Applications</h5>
                            <p class="card-text text-muted mb-0">Monitor your job applications and status updates.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <a class="text-decoration-none" href="{{ route('ofw.documents') }}">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-2 fw-semibold">Documents</h5>
                            <p class="card-text text-muted mb-0">Manage your work permits and required documents.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <a class="text-decoration-none" href="{{ route('ofw.profile') }}">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-2 fw-semibold">My Profile</h5>
                            <p class="card-text text-muted mb-0">View and update your professional profile.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <a class="text-decoration-none" href="{{ route('ofw.contract-review') }}">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-2 fw-semibold">Contract Review</h5>
                            <p class="card-text text-muted mb-0">Review and manage employment contracts.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <a class="text-decoration-none" href="{{ route('ofw.support') }}">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-2 fw-semibold">Support & Resources</h5>
                            <p class="card-text text-muted mb-0">Access guidance and support materials.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @include('components.footer')
@endsection
