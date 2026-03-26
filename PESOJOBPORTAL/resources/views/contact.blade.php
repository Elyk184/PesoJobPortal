@extends('layouts.app')

@section('title', 'Contact Us - PESO Manolo Fortich')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/contact-section.css') }}">
@endpush

@section('content')
<div class="contact-page d-flex flex-column min-vh-100">
    <header class="contact-hero" aria-labelledby="contact-heading">
        <div class="contact-hero-inner text-center text-lg-start">
            <span class="contact-hero-accent" aria-hidden="true"></span>
            <h1 id="contact-heading"><i class="bi bi-send-fill me-2" aria-hidden="true"></i>Get in touch</h1>
            <p>Send us a message about job listings, registrations, or local employment programs. We use the same channels as our main office information below.</p>
        </div>
    </header>

    <div class="contact-body">
        <div class="contact-card">
            <div class="contact-card-header">
                <h2><i class="bi bi-chat-dots-fill me-2 text-danger" style="color: #d72638 !important;" aria-hidden="true"></i>Contact form</h2>
                <p>Fields marked with <span class="text-danger">*</span> are required.</p>
            </div>
            <div class="contact-form-wrap">
                @if (session('status'))
                    <div class="alert contact-alert mb-4" role="status">
                        <i class="bi bi-check-circle-fill me-2" aria-hidden="true"></i>{{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mb-4 rounded-3 border-0" style="border-left: 4px solid #d72638 !important;" role="alert">
                        <strong>Please fix the following:</strong>
                        <ul class="mb-0 mt-2 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.submit') }}" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required maxlength="120" autocomplete="name" placeholder="Your name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email" placeholder="you@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="phone" class="form-label">Phone <span class="contact-hint fw-normal">(optional)</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" maxlength="40" autocomplete="tel" placeholder="(088) 123-4567">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required maxlength="180" placeholder="What is your inquiry about?">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required maxlength="5000" placeholder="Write your message here...">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3 mt-4">
                        <button type="submit" class="btn btn-contact-submit">
                            <i class="bi bi-send me-2" aria-hidden="true"></i>Send message
                        </button>
                        <p class="contact-hint mb-0">You can also reach us at the address and numbers in the footer.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('components.footer')
</div>
@endsection
