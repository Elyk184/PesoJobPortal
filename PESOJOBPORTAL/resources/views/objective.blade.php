@extends('layouts.app')

@section('title', 'Our Objectives | Link Job Resource Portal')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/objective-section.css') }}">
@endpush

@section('content')
<section class="objective-page" id="objective" aria-label="Link Job Resource Portal Objectives">
    <div class="objective-hero container">
        <p class="hero-kicker">Link Job Resource Portal</p>
        <h1>Our Objectives</h1>
        <div class="underline" aria-hidden="true"></div>
        <p class="hero-lead">
            PESO Manolo Fortich is committed to building a responsive, inclusive, and opportunities-driven local labor ecosystem.
            These objectives guide our services and partnerships with workers, employers, and institutions.
        </p>
    </div>

    <div class="objective-content container">
        <div class="objectives-grid">
            <div class="objective-card">
                <span class="card-number">OBJECTIVE 1</span>
                <h3>To create job opportunities for the residents of Manolo Fortich, reducing unemployment rates and promoting econimic growth in the municipality.</h3>
                <div class="objective-divider" aria-hidden="true"></div>
            </div>

            <div class="objective-card">
                <span class="card-number">OBJECTIVE 2</span>
                <h3>To provide training and skills development programs for job seekers, enhancing their employability and productivity in the workplace.</h3>
                <div class="objective-divider" aria-hidden="true"></div>
            </div>

            <div class="objective-card">
                <span class="card-number">OBJECTIVE 3</span>
                <h3>To promote entrepreneurship by providing access to resources, financial assistance, and business development services to aspiring entrepreneurs.</h3>
                <div class="objective-divider" aria-hidden="true"></div>
            </div>

            <div class="objective-card">
                <span class="card-number">OBJECTIVE 4</span>
                <h3>To attracts investments in the municipality by showcasing its potential for growth, resources, and business opportunities.</h3>
                <div class="objective-divider" aria-hidden="true"></div>
            </div>

            <div class="objective-card">
                <span class="card-number">OBJECTIVE 5</span>
                <h3>To strengthen partnerships with local stakeholders, government agencies, and private sectors in the implementation of the PESO program, fostering collaboration and innovation in promoting economic development.</h3>
                <div class="objective-divider" aria-hidden="true"></div>
            </div>
        </div>
    </div>
</section>

@include('components.footer')
@endsection