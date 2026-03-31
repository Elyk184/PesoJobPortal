@extends('layouts.app')

@section('title', 'Our Objective - PESO Manolo Fortich')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/objective-section.css') }}">
@endpush

@section('content')
<section class="objective-section" id="objective" aria-label="PESO Manolo Fortich Objective">
    <div class="objective-card">
        <h2 class="objective-title">1. To facilitate employment opportunities for local residents</h2>
        <div class="objective-divider" aria-hidden="true"></div>
        <p class="objective-text">
            PESO aims to provide employment assistance by connecting job seekers with local and overseas employers, helping reduce unemployment in the municipality.
        </p>
    </div>
</section>

<section class="objective-section" id="objective" aria-label="PESO Manolo Fortich Objective">
    <div class="objective-card">
        <h2 class="objective-title">2. To provide timely and accurate labor market information</h2>
        <div class="objective-divider" aria-hidden="true"></div>
        <p class="objective-text">
            PESO ensures that job seekers and employers have access to updated information on job vacancies, employment trends, and labor demands to support informed decision-making.
        </p>
    </div>
</section>

<section class="objective-section" id="objective" aria-label="PESO Manolo Fortich Objective">
    <div class="objective-card">
        <h2 class="objective-title">3. To deliver career guidance and employment coaching services</h2>
        <div class="objective-divider" aria-hidden="true"></div>
        <p class="objective-text">
            PESO supports students and job seekers pinaagi sa career guidance, counseling, and training programs to help them choose appropriate career paths and prepare for employment.
        </p>
    </div>
</section>

<section class="objective-section" id="objective" aria-label="PESO Manolo Fortich Objective">
    <div class="objective-card">
        <h2 class="objective-title">4. To implement skills training and employability programs</h2>
        <div class="objective-divider" aria-hidden="true"></div>
        <p class="objective-text">
            PESO coordinates with government agencies and private partners to conduct skills training, workshops, and employment programs that enhance the competencies of the workforce.
        </p>
    </div>
</section>

<section class="objective-section" id="objective" aria-label="PESO Manolo Fortich Objective">
    <div class="objective-card">
        <h2 class="objective-title">5. To strengthen partnerships with stakeholders for employment generation</h2>
        <div class="objective-divider" aria-hidden="true"></div>
        <p class="objective-text">
           PESO builds strong collaboration with local government units, private companies, and other agencies to create more job opportunities and improve employment services.
    </div>
</section>

@endsection

