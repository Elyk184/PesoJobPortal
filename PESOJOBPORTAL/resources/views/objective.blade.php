@extends('layouts.app')

@section('title', 'Our Objective - PESO Manolo Fortich')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/objective-section.css') }}">
@endpush

@section('content')
<section class="objective-page" id="objective" aria-label="PESO Manolo Fortich Objectives">
    <div class="objective-hero container">
        <p class="hero-kicker">Get To Know Us</p>
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
                <h3>To facilitate employment opportunities for local residents</h3>
                <div class="objective-divider" aria-hidden="true"></div>
                <p>PESO aims to provide employment assistance by connecting job seekers with local and overseas employers, helping reduce unemployment in the municipality.</p>
            </div>

            <div class="objective-card">
                <span class="card-number">OBJECTIVE 2</span>
                <h3>To provide timely and accurate labor market information</h3>
                <div class="objective-divider" aria-hidden="true"></div>
                <p>PESO ensures that job seekers and employers have access to updated information on job vacancies, employment trends, and labor demands to support informed decision-making.</p>
            </div>

            <div class="objective-card">
                <span class="card-number">OBJECTIVE 3</span>
                <h3>To deliver career guidance and employment coaching services</h3>
                <div class="objective-divider" aria-hidden="true"></div>
                <p>PESO supports students and job seekers through career guidance, counseling, and training programs to help them choose appropriate career paths and prepare for employment.</p>
            </div>

            <div class="objective-card">
                <span class="card-number">OBJECTIVE 4</span>
                <h3>To implement skills training and employability programs</h3>
                <div class="objective-divider" aria-hidden="true"></div>
                <p>PESO coordinates with government agencies and private partners to conduct skills training, workshops, and employment programs that enhance the competencies of the workforce.</p>
            </div>

            <div class="objective-card">
                <span class="card-number">OBJECTIVE 5</span>
                <h3>To strengthen partnerships with stakeholders for employment generation</h3>
                <div class="objective-divider" aria-hidden="true"></div>
                <p>PESO builds strong collaboration with local government units, private companies, and other agencies to create more job opportunities and improve employment services.</p>
            </div>
        </div>
    </div>
</section>

@include('components.footer')
@endsection