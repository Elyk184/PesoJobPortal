@extends('layouts.dashboard')

@section('title', 'Apply for Job | Jobseeker | PESO Job Portal')

@section('content')
<section class="container py-4" aria-label="Job application">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 mb-3">
        <div>
            <h1 class="mb-1 fw-bold dashboard-section-title">Apply for Job</h1>
            <p class="mb-0 text-muted">Submit your application for this position.</p>
        </div>
        <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-outline-danger">
            <i class="bi bi-arrow-left me-2"></i>Back to Jobs
        </a>
    </div>

    <div class="row g-3">
        <!-- Job Details -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-3">Job Details</h5>
                    
                    <div class="mb-3">
                        <strong class="text-muted small d-block mb-1">Position</strong>
                        <p class="mb-0">{{ $job->title }}</p>
                    </div>

                    <div class="mb-3">
                        <strong class="text-muted small d-block mb-1">Company</strong>
                        <p class="mb-0">{{ $job->employer->name ?? 'Company' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong class="text-muted small d-block mb-1">Location</strong>
                        <p class="mb-0">{{ $job->location }}</p>
                    </div>

                    @if($job->job_type)
                        <div class="mb-3">
                            <strong class="text-muted small d-block mb-1">Job Type</strong>
                            <p class="mb-0">{{ ucfirst($job->job_type) }}</p>
                        </div>
                    @endif

                    @if($job->salary_range)
                        <div class="mb-3">
                            <strong class="text-muted small d-block mb-1">Salary Range</strong>
                            <p class="mb-0">{{ $job->salary_range }}</p>
                        </div>
                    @endif

                    @if($job->vacancies)
                        <div class="mb-3">
                            <strong class="text-muted small d-block mb-1">Vacancies</strong>
                            <p class="mb-0">{{ $job->vacancies }} position(s)</p>
                        </div>
                    @endif

                    @if($job->application_end_date)
                        <div class="mb-0">
                            <strong class="text-muted small d-block mb-1">Application Deadline</strong>
                            <p class="mb-0">{{ $job->application_end_date->format('M d, Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Application Form -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-3">Your Application</h5>

                    <form method="POST" action="{{ route('jobseeker.submit-application', $job->id) }}">
                        @csrf

                        <!-- Job Description -->
                        @if($job->description)
                            <div class="mb-4">
                                <h6 class="fw-semibold mb-2">About This Position</h6>
                                <div class="bg-light p-3 rounded small">
                                    {!! nl2br(e($job->description)) !!}
                                </div>
                            </div>
                        @endif

                        <!-- Key Responsibilities -->
                        @if($job->key_responsibilities)
                            <div class="mb-4">
                                <h6 class="fw-semibold mb-2">Key Responsibilities</h6>
                                <div class="bg-light p-3 rounded small">
                                    @foreach(explode('•', $job->key_responsibilities) as $responsibility)
                                        @if(trim($responsibility))
                                            <p class="mb-1">• {{ trim($responsibility) }}</p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Qualifications -->
                        @if($job->qualifications)
                            <div class="mb-4">
                                <h6 class="fw-semibold mb-2">Required Qualifications</h6>
                                <div class="bg-light p-3 rounded small">
                                    @foreach(explode('•', $job->qualifications) as $qual)
                                        @if(trim($qual))
                                            <p class="mb-1">• {{ trim($qual) }}</p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Application Letter -->
                        <div class="mb-3">
                            <label for="letter" class="form-label">Application Letter <span class="text-muted">(Optional)</span></label>
                            <textarea 
                                class="form-control @error('letter') is-invalid @enderror" 
                                id="letter" 
                                name="letter" 
                                rows="6" 
                                placeholder="Tell the employer why you're interested in this position and why you think you're a good fit..."
                            >{{ old('letter') }}</textarea>
                            @error('letter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Maximum 2000 characters</small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-send me-2"></i>Submit Application
                            </button>
                            <a href="{{ route('jobseeker.vacancies') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
