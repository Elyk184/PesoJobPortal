@extends('layouts.dashboard')

@section('title', $pageTitle)

@section('dashboard-mobile-brand')
    <div class="dashboard-mobile-brand">
        <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
        <span>OFW Portal</span>
    </div>
@endsection

@section('dashboard-sidebar')
    @include('dashboard.partials.ofw-nav')
@endsection

@section('content')
    <section class="dashboard-section-card p-4">
        <h1 class="h4 fw-bold mb-2">{{ $heading }}</h1>
        <p class="text-muted mb-4">{{ $message }}</p>
        <a class="btn btn-outline-primary" href="{{ route('ofw.dashboard') }}">Back to Dashboard</a>
    </section>
@endsection