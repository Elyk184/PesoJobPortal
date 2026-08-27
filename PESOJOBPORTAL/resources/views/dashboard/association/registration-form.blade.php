@extends('layouts.dashboard')

@section('title', 'Association | WA Registration')

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
    <section aria-label="WA Registration Form">
        <div class="dashboard-topbar">
            <div>
                <div class="dashboard-topbar-title">Worker's Association Registration</div>
                <div class="dashboard-topbar-subtitle">Application for Registration of Worker's Association</div>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="dashboard-section-card p-3 p-lg-4">
            <form method="POST" action="{{ route('association.registration.submit') }}" enctype="multipart/form-data">
                @csrf

                <h5 class="fw-bold mb-3">Association Information</h5>
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6">
                        <label class="form-label">Association Name <span class="text-danger">*</span></label>
                        <input type="text" name="association_name" class="form-control @error('association_name') is-invalid @enderror"
                               value="{{ old('association_name') }}" required>
                        @error('association_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                               value="{{ old('address') }}" required>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Place of Operation <span class="text-danger">*</span></label>
                        <input type="text" name="place_of_operation" class="form-control @error('place_of_operation') is-invalid @enderror"
                               value="{{ old('place_of_operation') }}" required>
                        @error('place_of_operation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label">Date Organized <span class="text-danger">*</span></label>
                        <input type="date" name="date_organized" class="form-control @error('date_organized') is-invalid @enderror"
                               value="{{ old('date_organized') }}" required>
                        @error('date_organized')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label">Date CBL Ratification</label>
                        <input type="date" name="date_cbl_ratification" class="form-control @error('date_cbl_ratification') is-invalid @enderror"
                               value="{{ old('date_cbl_ratification') }}">
                        @error('date_cbl_ratification')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <h5 class="fw-bold mb-3">President Information</h5>
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="president_last_name" class="form-control @error('president_last_name') is-invalid @enderror"
                               value="{{ old('president_last_name') }}" required>
                        @error('president_last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="president_first_name" class="form-control @error('president_first_name') is-invalid @enderror"
                               value="{{ old('president_first_name') }}" required>
                        @error('president_first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Middle Name</label>
                        <input type="text" name="president_middle_name" class="form-control @error('president_middle_name') is-invalid @enderror"
                               value="{{ old('president_middle_name') }}">
                        @error('president_middle_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">President Address <span class="text-danger">*</span></label>
                        <input type="text" name="president_address" class="form-control @error('president_address') is-invalid @enderror"
                               value="{{ old('president_address') }}" required>
                        @error('president_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label">Contact No. <span class="text-danger">*</span></label>
                        <input type="text" name="contact_no" class="form-control @error('contact_no') is-invalid @enderror"
                               value="{{ old('contact_no') }}" required>
                        @error('contact_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label">ID No.</label>
                        <input type="text" name="id_no" class="form-control @error('id_no') is-invalid @enderror"
                               value="{{ old('id_no') }}">
                        @error('id_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <h5 class="fw-bold mb-3">Membership</h5>
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <label class="form-label">Male Members <span class="text-danger">*</span></label>
                        <input type="number" name="male_members" class="form-control @error('male_members') is-invalid @enderror"
                               value="{{ old('male_members', 0) }}" min="0" required>
                        @error('male_members')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Female Members <span class="text-danger">*</span></label>
                        <input type="number" name="female_members" class="form-control @error('female_members') is-invalid @enderror"
                               value="{{ old('female_members', 0) }}" min="0" required>
                        @error('female_members')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Total Members <span class="text-danger">*</span></label>
                        <input type="number" name="total_members" class="form-control @error('total_members') is-invalid @enderror"
                               value="{{ old('total_members', 0) }}" min="0" required>
                        @error('total_members')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <h5 class="fw-bold mb-3">Occupation</h5>
                <div class="mb-4">
                    @php
                        $occupations = ['Agriculture','Fishing','Construction','Manufacturing','Trade','Transport','Services','Others'];
                    @endphp
                    <div class="row g-2">
                        @foreach($occupations as $occ)
                            <div class="col-6 col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="occupation[]"
                                           value="{{ $occ }}" id="occ_{{ $loop->index }}"
                                           {{ in_array($occ, old('occupation', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="occ_{{ $loop->index }}">{{ $occ }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('occupation')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    <div class="mt-2">
                        <input type="text" name="occupation_other_text" class="form-control"
                               placeholder="If Others, please specify" value="{{ old('occupation_other_text') }}">
                    </div>
                </div>

                <h5 class="fw-bold mb-3">Documents</h5>
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <label class="form-label">Constitution / By-Laws</label>
                        <input type="file" name="constitution_document" class="form-control @error('constitution_document') is-invalid @enderror"
                               accept=".pdf,.jpg,.jpeg,.png">
                        @error('constitution_document')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Financial Report</label>
                        <input type="file" name="financial_report" class="form-control @error('financial_report') is-invalid @enderror"
                               accept=".pdf,.jpg,.jpeg,.png">
                        @error('financial_report')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Additional Documents</label>
                        <input type="file" name="additional_documents[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png" multiple>
                    </div>
                </div>

                <h5 class="fw-bold mb-3">Declaration & Signature</h5>
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <label class="form-label">President Signature (Full Name) <span class="text-danger">*</span></label>
                        <input type="text" name="president_signature" class="form-control @error('president_signature') is-invalid @enderror"
                               value="{{ old('president_signature') }}" required>
                        @error('president_signature')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Signature Location</label>
                        <input type="text" name="signature_location" class="form-control @error('signature_location') is-invalid @enderror"
                               value="{{ old('signature_location') }}">
                        @error('signature_location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">Signature Date</label>
                        <input type="date" name="signature_date" class="form-control @error('signature_date') is-invalid @enderror"
                               value="{{ old('signature_date') }}">
                        @error('signature_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input @error('declaration') is-invalid @enderror"
                                   type="checkbox" name="declaration" id="declaration" value="1"
                                   {{ old('declaration') ? 'checked' : '' }}>
                            <label class="form-check-label" for="declaration">
                                I declare that all information provided is true and correct. <span class="text-danger">*</span>
                            </label>
                            @error('declaration')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="bi bi-send me-2"></i>Submit Registration
                    </button>
                    <a href="{{ route('association.dashboard') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection
