@extends('layouts.dashboard')

@section('title', 'Profile | Jobseeker | PESO Job Portal')

@section('content')
<section class="container py-4" aria-label="Jobseeker profile">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 mb-3">
        <div>
            <h1 class="mb-1 fw-bold dashboard-section-title">My Profile</h1>
            <p class="mb-0 text-muted">Profile details used for job matching (static demo).</p>
        </div>
        <a href="{{ route('jobseeker.dashboard') }}" class="btn btn-outline-danger">
            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-3">Basic Information</h5>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Full name</label>
                            <input class="form-control" value="{{ auth()->user()->name ?? '' }}" disabled>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Email</label>
                            <input class="form-control" value="{{ auth()->user()->email ?? '' }}" disabled>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Location / Barangay</label>
                            <input class="form-control" value="" placeholder="(coming soon)" disabled>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Preferred industry</label>
                            <input class="form-control" value="" placeholder="(coming soon)" disabled>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Skills</label>
                            <textarea class="form-control" rows="3" placeholder="(coming soon)" disabled></textarea>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-danger" type="button" disabled>
                            <i class="bi bi-pencil-square me-2"></i>Edit Profile (coming soon)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Resume Builder (Optional)</h5>
                    <p class="text-muted mb-3">Auto-generate a resume from your profile.</p>
                    <button class="btn btn-outline-secondary w-100" type="button" disabled>
                        <i class="bi bi-file-earmark-arrow-down me-2"></i>Generate Resume (coming soon)
                    </button>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Skill Gap Suggestions (Optional)</h5>
                    <p class="text-muted mb-0">Recommendations will appear based on your target roles.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
