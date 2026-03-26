@extends('layouts.app')

@section('title', 'Our Objective - PESO Manolo Fortich')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/objective-section.css') }}">
@endpush

@section('content')
<section class="objective-section" id="objective" aria-label="PESO Manolo Fortich Objective">
    <div class="objective-card">
        <h2 class="objective-title">Our Objective</h2>
        <div class="objective-divider" aria-hidden="true"></div>
        <p class="objective-text">
            The objective of PESO Manolo Fortich is to create job opportunities for residents,
            reduce unemployment, and promote economic growth in the municipality. We aim to
            provide training and skills development programs to enhance employability and
            productivity, foster entrepreneurship by offering access to resources and business
            support, and attract investments by showcasing the municipality's potential. We are
            committed to strengthening partnerships with local stakeholders, government agencies,
            and the private sector to ensure the effective implementation of the PESO program
            and to drive sustainable economic development for the community.
        </p>
    </div>
</section>
@endsection