@extends('dashboard.employer.layout')

@section('title', 'Company Profile')
@section('page_title', 'Company Profile')
@section('page_subtitle', 'Review your company account details.')

@section('content')
    <div class="panel">
        <h2>Employer Information</h2>
        @if ($isVerifiedEmployer)
            <span class="pill">Verified Employer</span>
        @else
            <span class="pill" style="background:#fef2f2;color:#b91c1c;">Pending Verification</span>
        @endif

        <div class="grid" style="margin-top: 12px;">
            <div class="item">
                <h3>Company Name</h3>
                <p>{{ $employer->name }}</p>
            </div>
            <div class="item">
                <h3>Email</h3>
                <p>{{ $employer->email }}</p>
            </div>
            <div class="item">
                <h3>Contact Number</h3>
                <p>{{ $employer->profile->phone ?? 'Not set' }}</p>
            </div>
            <div class="item">
                <h3>Address</h3>
                <p>{{ $employer->profile->address ?? 'Not set' }}</p>
            </div>
            <div class="item">
                <h3>About Company</h3>
                <p>{{ $employer->profile->objective ?? 'Not set' }}</p>
            </div>
            <div class="item">
                <h3>Skills or Focus Areas</h3>
                <p>
                    @if (is_array($employer->profile->skills ?? null) && count($employer->profile->skills))
                        {{ implode(', ', $employer->profile->skills) }}
                    @else
                        Not set
                    @endif
                </p>
            </div>
        </div>
    </div>
@endsection
