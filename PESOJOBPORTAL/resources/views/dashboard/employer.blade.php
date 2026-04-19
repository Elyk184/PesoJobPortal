@extends('layouts.app')

@section('title', 'Employer Dashboard | PESO Job Portal')

@section('content')
<section class="container pt-5 mt-4 pb-4" aria-label="Employer dashboard">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 mb-3">
        <div>
            <h1 class="mb-1 fw-bold">Employer Dashboard</h1>
            <p class="mb-0 text-muted">Welcome, {{ auth()->user()->name ?? 'Employer' }}.</p>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Logout</button>
        </form>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title fw-semibold">Overview</h5>
            <p class="text-muted mb-0">This dashboard is currently static. Next steps typically include posting vacancies and reviewing applicants.</p>
        </div>
    </div>
</section>

@include('components.footer')
@endsection
