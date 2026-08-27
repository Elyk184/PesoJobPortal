@extends('layouts.dashboard')

@section('title', 'Association | My Profile')

@section('dashboard-mobile-brand')
    <div class="dashboard-mobile-brand">
        <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
        <span>Association Portal</span>
    </div>
@endsection

@section('dashboard-sidebar')
    @include('dashboard.partials.association-nav')
@endsection

@section('content')
<section aria-label="Association Profile">
    <div class="dashboard-topbar mb-4">
        <div>
            <div class="dashboard-topbar-title">My Profile</div>
            <div class="dashboard-topbar-subtitle">Association account and contact information</div>
        </div>
    </div>

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('association.profile.update') }}">
        @csrf

        <div class="vstack gap-3">

            <div class="dashboard-section-card p-3 p-lg-4">
                <h2 class="h5 fw-bold mb-1"><i class="bi bi-building me-2 text-danger"></i>Association Information</h2>
                <hr class="mt-1 mb-3">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Association Name</label>
                        <input class="form-control @error('association_name') is-invalid @enderror"
                               name="association_name"
                               value="{{ old('association_name', $associationProfile->association_name) }}">
                        @error('association_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Contact Person</label>
                        <input class="form-control @error('contact_person') is-invalid @enderror"
                               name="contact_person"
                               value="{{ old('contact_person', $associationProfile->contact_person) }}">
                        @error('contact_person')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Phone</label>
                        <input class="form-control @error('phone') is-invalid @enderror"
                               name="phone"
                               value="{{ old('phone', $associationProfile->phone) }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email"
                               value="{{ old('email', $associationProfile->email) }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Address</label>
                        <input class="form-control @error('address') is-invalid @enderror"
                               name="address"
                               value="{{ old('address', $associationProfile->address) }}">
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end pb-2">
                <button type="submit" class="btn btn-danger px-4">
                    <i class="bi bi-cloud-arrow-up me-2"></i>Save Profile
                </button>
            </div>

        </div>
    </form>
</section>
@endsection
