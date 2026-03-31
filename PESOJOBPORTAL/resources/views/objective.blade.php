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

@endsection

