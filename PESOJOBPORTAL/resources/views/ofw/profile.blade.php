@extends('layouts.dashboard')

@section('title', 'OFW | My Profile')

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
<section aria-label="OFW Profile">
    <div class="dashboard-topbar mb-4">
        <div>
            <div class="dashboard-topbar-title">My Profile</div>
            <div class="dashboard-topbar-subtitle">Personal information used to pre-fill your RFA forms</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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

    <form method="POST" action="{{ route('ofw.profile.update') }}">
        @csrf

        <div class="vstack gap-3">

            {{-- Personal Information --}}
            <div class="dashboard-section-card p-3 p-lg-4">
                <h2 class="h5 fw-bold mb-1"><i class="bi bi-person-circle me-2 text-danger"></i>Personal Information</h2>
                <hr class="mt-1 mb-3">
                <div class="row g-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">First Name</label>
                        <input class="form-control" name="first_name" value="{{ old('first_name', $ofwProfile->first_name) }}">
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Middle Name</label>
                        <input class="form-control" name="middle_name" value="{{ old('middle_name', $ofwProfile->middle_name) }}">
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Last Name</label>
                        <input class="form-control" name="last_name" value="{{ old('last_name', $ofwProfile->last_name) }}">
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Suffix</label>
                        <input class="form-control" name="suffix" placeholder="Jr., Sr., II" value="{{ old('suffix', $ofwProfile->suffix) }}">
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Date of Birth</label>
                        <input type="date" class="form-control" name="birthdate" value="{{ old('birthdate', $ofwProfile->birthdate?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Sex</label>
                        <select class="form-select" name="sex">
                            <option value="">— Select —</option>
                            <option value="male" @selected(old('sex', $ofwProfile->sex) === 'male')>Male</option>
                            <option value="female" @selected(old('sex', $ofwProfile->sex) === 'female')>Female</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Civil Status</label>
                        <select class="form-select" name="civil_status">
                            <option value="">— Select —</option>
                            <option value="single" @selected(old('civil_status', $ofwProfile->civil_status) === 'single')>Single</option>
                            <option value="married" @selected(old('civil_status', $ofwProfile->civil_status) === 'married')>Married</option>
                            <option value="widow" @selected(old('civil_status', $ofwProfile->civil_status) === 'widow')>Widow/Widower</option>
                            <option value="separated" @selected(old('civil_status', $ofwProfile->civil_status) === 'separated')>Separated</option>
                            <option value="soloparent" @selected(old('civil_status', $ofwProfile->civil_status) === 'soloparent')>Solo Parent</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label fw-semibold">Religion</label>
                        <input class="form-control" name="religion" value="{{ old('religion', $ofwProfile->religion) }}">
                    </div>
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="dashboard-section-card p-3 p-lg-4">
                <h2 class="h5 fw-bold mb-1"><i class="bi bi-telephone me-2 text-danger"></i>Contact Information</h2>
                <hr class="mt-1 mb-3">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Contact Number</label>
                        <input class="form-control" name="contact_number" value="{{ old('contact_number', $ofwProfile->contact_number) }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $ofwProfile->email) }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Passport Number</label>
                        <input class="form-control" name="passport_number" value="{{ old('passport_number', $ofwProfile->passport_number) }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Facebook Name</label>
                        <input class="form-control" name="facebook_name" value="{{ old('facebook_name', $ofwProfile->facebook_name) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Address (Philippines)</label>
                        <textarea class="form-control" name="address_philippines" rows="2">{{ old('address_philippines', $ofwProfile->address_philippines) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Address Abroad</label>
                        <textarea class="form-control" name="address_abroad" rows="2">{{ old('address_abroad', $ofwProfile->address_abroad) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Employment Information --}}
            <div class="dashboard-section-card p-3 p-lg-4">
                <h2 class="h5 fw-bold mb-1"><i class="bi bi-briefcase me-2 text-danger"></i>Employment Information</h2>
                <hr class="mt-1 mb-3">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Employer Name</label>
                        <input class="form-control" name="employer_name" value="{{ old('employer_name', $ofwProfile->employer_name) }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Jobsite / Country</label>
                        <input class="form-control" name="jobsite_country" value="{{ old('jobsite_country', $ofwProfile->jobsite_country) }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Monthly Salary</label>
                        <input class="form-control" name="monthly_salary" value="{{ old('monthly_salary', $ofwProfile->monthly_salary) }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Local Recruitment Agency</label>
                        <input class="form-control" name="local_agency" value="{{ old('local_agency', $ofwProfile->local_agency) }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Foreign Recruitment Agency</label>
                        <input class="form-control" name="foreign_agency" value="{{ old('foreign_agency', $ofwProfile->foreign_agency) }}">
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
