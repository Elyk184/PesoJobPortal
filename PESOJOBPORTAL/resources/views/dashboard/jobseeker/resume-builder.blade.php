@extends('layouts.dashboard')

@section('title', 'Resume Builder | Jobseeker')

@section('content')
@php
    $profile = $profile ?? null;
    $resumeName = old('name', $resumeName ?? ($profile->resume_name ?? ''));
    $resumeEmail = old('email', $resumeEmail ?? ($profile->resume_email ?? ''));
    $resumePhone = old('phone', $resumePhone ?? ($profile->phone ?? ''));
    $resumeAddress = old('address', $resumeAddress ?? ($profile->address ?? ''));
    $resumeObjective = old('objective', $resumeObjective ?? ($profile->objective ?? ''));
    $resumeSkills = old('skills', $resumeSkills ?? implode(', ', $profile->skills ?? []));

    $educationRows = old('education', $educationRows ?? ($profile->education ?? []));
    $trainingRows = old('training', $trainingRows ?? ($profile->training ?? []));
    $experienceRows = old('experience', $experienceRows ?? ($profile->experience ?? []));
    $eligibilityRows = old('eligibility', $eligibilityRows ?? ($profile->eligibility ?? []));

    $skillsPreview = collect(explode(',', $resumeSkills))->map(fn ($item) => trim($item))->filter()->values();
@endphp

<section aria-label="Resume builder">
    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm">
            <div class="fw-semibold mb-1">Please fix the highlighted problems.</div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="dashboard-section-card p-3 p-lg-4 mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h2 class="h4 mb-1 fw-bold">Build a clean, Harvard-style resume</h2>
                <p class="mb-0 text-muted">Your profile data now fills this draft automatically, and everything below is still editable.</p>
            </div>
            <div class="text-lg-end">
                <div class="fw-semibold text-secondary">{{ $resumeName ?: 'Resume draft' }}</div>
                <div class="small text-muted">Saved to your jobseeker profile</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-xl-5">
            <form method="POST" action="{{ route('jobseeker.resume-builder.save') }}" class="dashboard-section-card p-3 p-lg-4 h-100">
                @csrf

                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                    <h3 class="h5 mb-0 fw-bold">Resume Details</h3>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="name">Full name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $resumeName }}" placeholder="Enter your full name">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $resumeEmail }}" placeholder="Enter your email">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ $resumePhone }}" placeholder="Enter your phone number">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="address">Address</label>
                        <textarea name="address" id="address" class="form-control" rows="2" placeholder="Enter your address">{{ $resumeAddress }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="objective">Career objective</label>
                        <textarea name="objective" id="objective" class="form-control" rows="4" placeholder="Write a short professional objective">{{ $resumeObjective }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="skills">Skills</label>
                        <textarea name="skills" id="skills" class="form-control" rows="3" placeholder="Separate with commas or line breaks">{{ $resumeSkills }}</textarea>
                        <div class="form-text">Example: Communication, Microsoft Office, Customer Service</div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h4 class="h6 fw-bold mb-0">Education</h4>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-add-row="education">
                            <i class="bi bi-plus-lg me-1"></i>Add Education
                        </button>
                    </div>

                    <div class="vstack gap-3" id="education-rows">
                        @forelse ($educationRows as $index => $row)
                            <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="education">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="fw-semibold small text-secondary">Education {{ $index + 1 }}</div>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>
                                        Remove
                                    </button>
                                </div>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <input type="text" name="education[{{ $index }}][school]" class="form-control" placeholder="School / University" value="{{ $row['school'] ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="education[{{ $index }}][course]" class="form-control" placeholder="Course / Strand" value="{{ $row['course'] ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="education[{{ $index }}][year]" class="form-control" placeholder="Year" value="{{ $row['year'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>

                <div class="mt-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h4 class="h6 fw-bold mb-0">Experience</h4>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-add-row="experience">
                            <i class="bi bi-plus-lg me-1"></i>Add Experience
                        </button>
                    </div>

                    <div class="vstack gap-3" id="experience-rows">
                        @forelse ($experienceRows as $index => $row)
                            <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="experience">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="fw-semibold small text-secondary">Experience {{ $index + 1 }}</div>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>
                                        Remove
                                    </button>
                                </div>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <input type="text" name="experience[{{ $index }}][title]" class="form-control" placeholder="Job title" value="{{ $row['title'] ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="experience[{{ $index }}][company]" class="form-control" placeholder="Company / Organization" value="{{ $row['company'] ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="experience[{{ $index }}][period]" class="form-control" placeholder="Year / Period" value="{{ $row['period'] ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <textarea name="experience[{{ $index }}][details]" class="form-control" rows="3" placeholder="Short job description">{{ $row['details'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>

                <div class="mt-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h4 class="h6 fw-bold mb-0">Training</h4>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-add-row="training">
                            <i class="bi bi-plus-lg me-1"></i>Add Training
                        </button>
                    </div>

                    <div class="vstack gap-3" id="training-rows">
                        @forelse ($trainingRows ?? [] as $index => $row)
                            <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="training">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="fw-semibold small text-secondary">Training {{ $index + 1 }}</div>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>
                                        Remove
                                    </button>
                                </div>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <input type="text" name="training[{{ $index }}][course]" class="form-control" placeholder="Course / Training name" value="{{ $row['course'] ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="training[{{ $index }}][institution]" class="form-control" placeholder="Institution / Provider" value="{{ $row['institution'] ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="training[{{ $index }}][dates]" class="form-control" placeholder="Dates" value="{{ $row['dates'] ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="training[{{ $index }}][hours]" class="form-control" placeholder="Hours" value="{{ $row['hours'] ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="training[{{ $index }}][skills]" class="form-control" placeholder="Skills learned" value="{{ $row['skills'] ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="training[{{ $index }}][certificates]" class="form-control" placeholder="Certificates" value="{{ $row['certificates'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>

                <div class="mt-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h4 class="h6 fw-bold mb-0">Eligibility</h4>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-add-row="eligibility">
                            <i class="bi bi-plus-lg me-1"></i>Add Eligibility
                        </button>
                    </div>

                    <div class="vstack gap-3" id="eligibility-rows">
                        @forelse ($eligibilityRows ?? [] as $index => $row)
                            <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="eligibility">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="fw-semibold small text-secondary">Eligibility {{ $index + 1 }}</div>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>
                                        Remove
                                    </button>
                                </div>
                                <div class="row g-2">
                                    <div class="col-12">
                                        <input type="text" name="eligibility[{{ $index }}][eligibility]" class="form-control" placeholder="Eligibility / Exam" value="{{ $row['eligibility'] ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="eligibility[{{ $index }}][license]" class="form-control" placeholder="License / Certificate No." value="{{ $row['license'] ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="eligibility[{{ $index }}][date_taken]" class="form-control" placeholder="Date Taken" value="{{ $row['date_taken'] ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="eligibility[{{ $index }}][valid_until]" class="form-control" placeholder="Valid Until" value="{{ $row['valid_until'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="bi bi-save me-2"></i>Save Resume
                    </button>
                    <button type="submit" form="reset-resume-form" class="btn btn-outline-danger flex-fill">
                        <i class="bi bi-trash3 me-2"></i>Reset Resume
                    </button>
                </div>
            </form>
        </div>

        <div class="col-12 col-xl-7">
            <div class="dashboard-section-card p-3 p-lg-4 h-100">
                <div class="d-flex align-items-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                    <h3 class="h5 mb-0 fw-bold">Live Preview</h3>
                    <div class="d-flex gap-2">
                        <a href="{{ route('jobseeker.resume-builder.export') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-download me-1"></i>Export PDF
                        </a>
                    </div>
                </div>

                <div class="resume-preview mx-auto">
                    <div class="resume-header text-center pb-3 mb-4 border-bottom">
                        <h1 class="resume-name">{{ $resumeName }}</h1>
                        <div class="resume-contact">{{ collect([$resumeAddress, $resumePhone, $resumeEmail])->filter()->join(' | ') }}</div>
                    </div>

                    @if($resumeObjective)
                    <section class="resume-section mb-4">
                        <h2>Objective</h2>
                        <p>{{ $resumeObjective }}</p>
                    </section>
                    @endif

                    @if($educationRows && collect($educationRows)->filter(function($item) { return collect($item)->filter()->isNotEmpty(); })->isNotEmpty())
                    <section class="resume-section mb-4">
                        <h2>Education</h2>
                        @forelse ($educationRows as $item)
                            @if(collect($item)->filter()->isNotEmpty())
                                <div class="resume-item mb-3">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div class="fw-semibold">{{ $item['school'] ?? '' }}</div>
                                        <div class="text-muted">{{ $item['year'] ?? '' }}</div>
                                    </div>
                                    <div class="fst-italic text-muted">{{ $item['course'] ?? '' }}</div>
                                </div>
                            @endif
                        @empty
                        @endforelse
                    </section>
                    @endif

                    @if($trainingRows && collect($trainingRows)->filter(function($item) { return collect($item)->filter()->isNotEmpty(); })->isNotEmpty())
                    <section class="resume-section mb-4">
                        <h2>Training</h2>
                        @forelse ($trainingRows as $item)
                            @if(collect($item)->filter()->isNotEmpty())
                                <div class="resume-item mb-3">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div class="fw-semibold">{{ $item['course'] ?? '' }}</div>
                                        <div class="text-muted">{{ $item['dates'] ?? '' }}</div>
                                    </div>
                                    <div class="fst-italic text-muted">{{ $item['institution'] ?? '' }}</div>
                                    <p class="mb-0">{{ collect([$item['hours'] ?? '', $item['skills'] ?? '', $item['certificates'] ?? ''])->filter()->join(' | ') }}</p>
                                </div>
                            @endif
                        @empty
                        @endforelse
                    </section>
                    @endif

                    @if($experienceRows && collect($experienceRows)->filter(function($item) { return collect($item)->filter()->isNotEmpty(); })->isNotEmpty())
                    <section class="resume-section mb-4">
                        <h2>Experience</h2>
                        @forelse ($experienceRows as $item)
                            @if(collect($item)->filter()->isNotEmpty())
                                <div class="resume-item mb-3">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div class="fw-semibold">{{ $item['title'] ?? '' }}</div>
                                        <div class="text-muted">{{ $item['period'] ?? '' }}</div>
                                    </div>
                                    <div class="fst-italic text-muted">{{ $item['company'] ?? '' }}</div>
                                    <p class="mb-0">{{ $item['details'] ?? '' }}</p>
                                </div>
                            @endif
                        @empty
                        @endforelse
                    </section>
                    @endif

                    @if($eligibilityRows && collect($eligibilityRows)->filter(function($item) { return collect($item)->filter()->isNotEmpty(); })->isNotEmpty())
                    <section class="resume-section mb-4">
                        <h2>Eligibility</h2>
                        @forelse ($eligibilityRows as $item)
                            @if(collect($item)->filter()->isNotEmpty())
                                <div class="resume-item mb-3">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div class="fw-semibold">{{ $item['eligibility'] ?? '' }}</div>
                                        <div class="text-muted">{{ $item['valid_until'] ?? '' }}</div>
                                    </div>
                                    <div class="fst-italic text-muted">{{ $item['license'] ?? '' }}</div>
                                    <p class="mb-0">{{ $item['date_taken'] ?? '' }}</p>
                                </div>
                            @endif
                        @empty
                        @endforelse
                    </section>
                    @endif

                    @if($skillsPreview->count())
                    <section class="resume-section mb-0">
                        <h2>Skills</h2>
                        <p class="mb-0">{{ $skillsPreview->join(', ') }}</p>
                    </section>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<form id="reset-resume-form" method="POST" action="{{ route('jobseeker.resume-builder.reset') }}" class="d-none">
    @csrf
    @method('DELETE')
</form>

<template id="education-template">
    <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="education">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="fw-semibold small text-secondary">Education</div>
            <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>Remove</button>
        </div>
        <div class="row g-2">
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="School / University"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Course / Strand"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Year"></div>
        </div>
    </div>
</template>

<template id="experience-template">
    <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="experience">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="fw-semibold small text-secondary">Experience</div>
            <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>Remove</button>
        </div>
        <div class="row g-2">
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Job title"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Company / Organization"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Year / Period"></div>
            <div class="col-12"><textarea class="form-control" rows="3" name="__NAME__" placeholder="Short job description"></textarea></div>
        </div>
    </div>
</template>

<template id="training-template">
    <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="training">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="fw-semibold small text-secondary">Training</div>
            <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>Remove</button>
        </div>
        <div class="row g-2">
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Course / Training name"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Institution / Provider"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Dates"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Hours"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Skills learned"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Certificates"></div>
        </div>
    </div>
</template>

<template id="eligibility-template">
    <div class="border rounded-3 p-3 bg-light-subtle resume-row" data-row="eligibility">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="fw-semibold small text-secondary">Eligibility</div>
            <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove-row>Remove</button>
        </div>
        <div class="row g-2">
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Eligibility / Exam"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="License / Certificate No."></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Date Taken"></div>
            <div class="col-12"><input type="text" class="form-control" name="__NAME__" placeholder="Valid Until"></div>
        </div>
    </div>
</template>

@push('styles')
    <style>
        .resume-preview {
            max-width: 820px;
            background: #fff;
            border: 1px solid #d8dde5;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            padding: 36px 42px;
            color: #111827;
            font-family: Georgia, 'Times New Roman', Times, serif;
        }

        .resume-name {
            font-size: clamp(1.7rem, 3vw, 2.4rem);
            margin: 0;
            letter-spacing: 0.02em;
            font-weight: 700;
        }

        .resume-contact {
            font-size: 0.95rem;
            color: #374151;
            margin-top: 8px;
        }

        .resume-section h2 {
            font-size: 1.02rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 10px;
            padding-bottom: 4px;
            border-bottom: 1px solid #111827;
        }

        .resume-section p,
        .resume-section li {
            font-size: 0.98rem;
            line-height: 1.55;
            color: #111827;
        }

        .resume-item {
            font-size: 0.98rem;
        }

        @media (max-width: 575.98px) {
            .resume-preview {
                padding: 24px 18px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function () {
            let educationCount = document.querySelectorAll('[data-row="education"]').length;
            let experienceCount = document.querySelectorAll('[data-row="experience"]').length;
            let trainingCount = document.querySelectorAll('[data-row="training"]').length;
            let eligibilityCount = document.querySelectorAll('[data-row="eligibility"]').length;

            function addRow(type) {
                const template = document.getElementById(type + '-template');
                const container = document.getElementById(type + '-rows');
                if (!template || !container) return;

                const clone = template.content.cloneNode(true);
                const row = clone.querySelector('[data-row="' + type + '"]');
                const fields = row.querySelectorAll('input, textarea');
                let rowIndex, names;

                if (type === 'education') {
                    rowIndex = educationCount++;
                    names = ['education[' + rowIndex + '][school]', 'education[' + rowIndex + '][course]', 'education[' + rowIndex + '][year]'];
                } else if (type === 'experience') {
                    rowIndex = experienceCount++;
                    names = ['experience[' + rowIndex + '][title]', 'experience[' + rowIndex + '][company]', 'experience[' + rowIndex + '][period]', 'experience[' + rowIndex + '][details]'];
                } else if (type === 'training') {
                    rowIndex = trainingCount++;
                    names = ['training[' + rowIndex + '][course]', 'training[' + rowIndex + '][institution]', 'training[' + rowIndex + '][dates]', 'training[' + rowIndex + '][hours]', 'training[' + rowIndex + '][skills]', 'training[' + rowIndex + '][certificates]'];
                } else if (type === 'eligibility') {
                    rowIndex = eligibilityCount++;
                    names = ['eligibility[' + rowIndex + '][eligibility]', 'eligibility[' + rowIndex + '][license]', 'eligibility[' + rowIndex + '][date_taken]', 'eligibility[' + rowIndex + '][valid_until]'];
                }

                fields.forEach(function (field, index) {
                    field.name = names[index];
                });

                container.appendChild(clone);
            }

            document.querySelectorAll('[data-add-row]').forEach(function (button) {
                button.addEventListener('click', function () {
                    addRow(button.getAttribute('data-add-row'));
                });
            });

            document.addEventListener('click', function (event) {
                if (event.target && event.target.matches('[data-remove-row]')) {
                    const row = event.target.closest('[data-row]');
                    if (row) {
                        row.remove();
                    }
                }
            });
        })();
    </script>
@endpush
@endsection
