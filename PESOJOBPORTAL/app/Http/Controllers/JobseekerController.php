<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\User;
use App\Models\PesoJob;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class JobseekerController extends Controller
{
    public function dashboard(): View
    {
        return view('dashboard.jobseeker.dashboard');
    }

    public function vacancies(Request $request): View
    {
        $manoloFortichBarangays = [
            'Agusan Canyon',
            'Alae',
            'Dahilayan',
            'Dalirig',
            'Damilag',
            'Dicklum',
            'Guilang-guilang',
            'Kalugmanan',
            'Lindaban',
            'Lingion',
            'Lunocan',
            'Maluko',
            'Mambatangan',
            'Mampayag',
            'Mantibugao',
            'Minsuro',
            'San Miguel',
            'Sankanan',
            'Santiago',
            'Santo Nino',
            'Tankulan (Poblacion)',
            'Ticala',
        ];

        $keyword = trim((string) $request->query('keyword', ''));
        $location = trim((string) $request->query('location', ''));
        $skills = trim((string) $request->query('skills', ''));
        $employer = trim((string) $request->query('employer', ''));
        $sort = (string) $request->query('sort', 'newest');

        if (! in_array($location, $manoloFortichBarangays, true)) {
            $location = '';
        }

        $jobsQuery = PesoJob::query()->where('status', 'active');

        if ($keyword !== '') {
            $jobsQuery->where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%')
                    ->orWhere('employer_name', 'like', '%' . $keyword . '%')
                    ->orWhere('location', 'like', '%' . $keyword . '%')
                    ->orWhere('requirements', 'like', '%' . $keyword . '%');
            });
        }

        if ($location !== '') {
            $jobsQuery->where('location', 'like', '%' . $location . '%');
        }

        if ($skills !== '') {
            $jobsQuery->where(function ($query) use ($skills) {
                $query->where('requirements', 'like', '%' . $skills . '%')
                    ->orWhere('description', 'like', '%' . $skills . '%')
                    ->orWhere('title', 'like', '%' . $skills . '%');
            });
        }

        if ($employer !== '') {
            $jobsQuery->where('employer_name', 'like', '%' . $employer . '%');
        }

        if ($sort === 'oldest') {
            $jobsQuery->oldest();
        } elseif ($sort === 'title_asc') {
            $jobsQuery->orderBy('title');
        } elseif ($sort === 'location_asc') {
            $jobsQuery->orderBy('location')->orderByDesc('created_at');
        } else {
            $jobsQuery->latest();
        }

        $jobs = $jobsQuery->paginate(9)->withQueryString();

        $jobs->getCollection()->transform(function (PesoJob $job) {
            $job->setAttribute('requirements_list', $this->extractJobRequirements($job));

            return $job;
        });

        return view('dashboard.jobseeker.vacancies', [
            'jobs' => $jobs,
            'locations' => collect($manoloFortichBarangays),
            'filters' => [
                'keyword' => $keyword,
                'location' => $location,
                'skills' => $skills,
                'employer' => $employer,
                'sort' => $sort,
            ],
        ]);
    }

    public function applications(): View
    {
        return view('dashboard.jobseeker.applications');
    }

    public function profile(): View
    {
        return view('dashboard.jobseeker.profile', $this->profileFormData(Auth::user()));
    }

    public function saveProfile(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'personal_information.surname' => ['required', 'string', 'max:255'],
            'personal_information.first_name' => ['required', 'string', 'max:255'],
            'personal_information.middle_initial' => ['nullable', 'string', 'max:10'],
            'personal_information.suffix' => ['nullable', 'string', 'max:50'],
            'personal_information.date_of_birth' => ['nullable', 'date'],
            'personal_information.sex' => ['nullable', 'in:Male,Female'],
            'personal_information.religion' => ['nullable', 'string', 'max:255'],
            'personal_information.civil_status' => ['nullable', 'string', 'max:255'],
            'personal_information.height' => ['nullable', 'string', 'max:20'],
            'personal_information.tin' => ['nullable', 'string', 'max:50'],
            'personal_information.contact_number' => ['nullable', 'string', 'max:50'],
            'personal_information.email_address' => ['nullable', 'email', 'max:255'],
            'education_currently_in_school' => ['nullable', 'boolean'],

            'present_address.house_no' => ['nullable', 'string', 'max:255'],
            'present_address.barangay' => ['nullable', 'string', 'max:255'],
            'present_address.municipality' => ['nullable', 'string', 'max:255'],
            'present_address.province' => ['nullable', 'string', 'max:255'],

            'permanent_address.same_as_present' => ['nullable', 'boolean'],
            'permanent_address.house_no' => ['nullable', 'string', 'max:255'],
            'permanent_address.barangay' => ['nullable', 'string', 'max:255'],
            'permanent_address.municipality' => ['nullable', 'string', 'max:255'],
            'permanent_address.province' => ['nullable', 'string', 'max:255'],

            'education' => ['nullable', 'array'],
            'education.*.school' => ['nullable', 'string', 'max:255'],
            'education.*.course' => ['nullable', 'string', 'max:255'],
            'education.*.year' => ['nullable', 'string', 'max:50'],

            'training' => ['nullable', 'array'],
            'training.*.course' => ['nullable', 'string', 'max:255'],
            'training.*.hours' => ['nullable', 'string', 'max:50'],
            'training.*.institution' => ['nullable', 'string', 'max:255'],
            'training.*.dates' => ['nullable', 'string', 'max:100'],
            'training.*.skills' => ['nullable', 'string', 'max:1000'],
            'training.*.certificates' => ['nullable', 'string', 'max:255'],

            'experience' => ['nullable', 'array'],
            'experience.*.company' => ['nullable', 'string', 'max:255'],
            'experience.*.title' => ['nullable', 'string', 'max:255'],
            'experience.*.location' => ['nullable', 'string', 'max:255'],
            'experience.*.status' => ['nullable', 'string', 'max:255'],
            'experience.*.from_date' => ['nullable', 'string', 'max:100'],
            'experience.*.to_date' => ['nullable', 'string', 'max:100'],
            'experience.*.salary_amount' => ['nullable', 'string', 'max:50'],
            'experience.*.salary_type' => ['nullable', 'string', 'max:50'],
            'experience.*.details' => ['nullable', 'string', 'max:2000'],
            'work_experience_has' => ['nullable', 'boolean'],

            'eligibility' => ['nullable', 'array'],
            'eligibility.*.eligibility' => ['nullable', 'string', 'max:255'],
            'eligibility.*.date_taken' => ['nullable', 'string', 'max:50'],
            'eligibility.*.license' => ['nullable', 'string', 'max:255'],
            'eligibility.*.valid_until' => ['nullable', 'string', 'max:50'],

            'other_skills.trade_manual' => ['nullable', 'array'],
            'other_skills.it_technical' => ['nullable', 'array'],
            'other_skills.soft_skills' => ['nullable', 'array'],
            'other_skills.other_text' => ['nullable', 'string', 'max:255'],
            'other_skills.with_certificate' => ['nullable', 'boolean'],
            'other_skills.by_experience' => ['nullable', 'boolean'],

            'employment_status.wage_employed' => ['nullable', 'boolean'],
            'employment_status.self_employed' => ['nullable', 'boolean'],
            'employment_status.unemployed' => ['nullable', 'boolean'],

            'job_preferences.part_time' => ['nullable', 'boolean'],
            'job_preferences.full_time' => ['nullable', 'boolean'],
            'job_preferences.local' => ['nullable', 'boolean'],
            'job_preferences.overseas' => ['nullable', 'boolean'],
            'job_preferences.occupation_text' => ['nullable', 'string', 'max:1000'],

            'languages' => ['nullable', 'array'],
            'languages.*.language' => ['nullable', 'string', 'max:255'],
            'languages.*.read' => ['nullable', 'boolean'],
            'languages.*.write' => ['nullable', 'boolean'],
            'languages.*.speak' => ['nullable', 'boolean'],
            'languages.*.understand' => ['nullable', 'boolean'],
            'languages.*.other' => ['nullable', 'string', 'max:255'],

            'disability.visual' => ['nullable', 'boolean'],
            'disability.speech' => ['nullable', 'boolean'],
            'disability.mental' => ['nullable', 'boolean'],
            'disability.hearing' => ['nullable', 'boolean'],
            'disability.physical' => ['nullable', 'boolean'],
            'disability.other' => ['nullable', 'boolean'],
            'disability.other_text' => ['nullable', 'string', 'max:255'],
        ]);

        $personal = $validated['personal_information'] ?? [];
        $presentAddress = $validated['present_address'] ?? [];
        $permanentAddress = $validated['permanent_address'] ?? [];
        $personal['currently_in_school'] = (bool) ($validated['education_currently_in_school'] ?? false);
        $educationRows = $this->normalizeResumeSection($validated['education'] ?? [], ['school', 'course', 'year']);
        $trainingRows = $this->normalizeResumeSection($validated['training'] ?? [], ['course', 'hours', 'institution', 'dates', 'skills', 'certificates']);
        $experienceRows = $this->normalizeResumeSection($validated['experience'] ?? [], ['company', 'title', 'location', 'status', 'from_date', 'to_date', 'salary_amount', 'salary_type', 'details']);
        $eligibilityRows = $this->normalizeResumeSection($validated['eligibility'] ?? [], ['eligibility', 'date_taken', 'license', 'valid_until']);

        $otherSkills = [
            'trade_manual' => $this->normalizeList(implode(', ', $validated['other_skills']['trade_manual'] ?? [])),
            'it_technical' => $this->normalizeList(implode(', ', $validated['other_skills']['it_technical'] ?? [])),
            'soft_skills' => $this->normalizeList(implode(', ', $validated['other_skills']['soft_skills'] ?? [])),
            'other_text' => trim((string) ($validated['other_skills']['other_text'] ?? '')),
            'with_certificate' => (bool) ($validated['other_skills']['with_certificate'] ?? false),
            'by_experience' => (bool) ($validated['other_skills']['by_experience'] ?? false),
        ];

        $employmentStatus = [
            'wage_employed' => (bool) ($validated['employment_status']['wage_employed'] ?? false),
            'self_employed' => (bool) ($validated['employment_status']['self_employed'] ?? false),
            'unemployed' => (bool) ($validated['employment_status']['unemployed'] ?? false),
            'has_work_experience' => (bool) ($validated['work_experience_has'] ?? false),
        ];

        $jobPreferences = [
            'part_time' => (bool) ($validated['job_preferences']['part_time'] ?? false),
            'full_time' => (bool) ($validated['job_preferences']['full_time'] ?? false),
            'local' => (bool) ($validated['job_preferences']['local'] ?? false),
            'overseas' => (bool) ($validated['job_preferences']['overseas'] ?? false),
            'occupation_text' => trim((string) ($validated['job_preferences']['occupation_text'] ?? '')),
        ];

        $languages = $this->normalizeLanguageRows($validated['languages'] ?? []);

        $disability = [
            'visual' => (bool) ($validated['disability']['visual'] ?? false),
            'speech' => (bool) ($validated['disability']['speech'] ?? false),
            'mental' => (bool) ($validated['disability']['mental'] ?? false),
            'hearing' => (bool) ($validated['disability']['hearing'] ?? false),
            'physical' => (bool) ($validated['disability']['physical'] ?? false),
            'other' => (bool) ($validated['disability']['other'] ?? false),
            'other_text' => trim((string) ($validated['disability']['other_text'] ?? '')),
        ];

        $fullName = collect([
            $personal['first_name'] ?? '',
            $personal['middle_initial'] ?? '',
            $personal['surname'] ?? '',
            $personal['suffix'] ?? '',
        ])->filter()->join(' ');

        $profile = UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'personal_information' => $personal,
                'present_address' => $presentAddress,
                'permanent_address' => $permanentAddress,
                'resume_name' => $fullName ?: $user->name,
                'resume_email' => $personal['email_address'] ?? $user->email,
                'phone' => $personal['contact_number'] ?? null,
                'address' => $this->formatAddress($presentAddress),
                'skills' => $this->buildSkillList($otherSkills),
                'education' => $educationRows,
                'training' => $trainingRows,
                'experience' => $experienceRows,
                'eligibility' => $eligibilityRows,
                'other_skills' => $otherSkills,
                'employment_status' => $employmentStatus,
                'job_preferences' => $jobPreferences,
                'languages' => $languages,
                'disability' => $disability,
            ]
        );

        $user->name = $fullName ?: $user->name;
        $user->save();

        return redirect()
            ->route('jobseeker.profile')
            ->with('status', 'Profile saved successfully.');
    }

    public function resumeBuilder(): View
    {
        $data = $this->resumeBuilderData(Auth::user());

        return view('dashboard.jobseeker.resume-builder', $data);
    }

    public function exportResumeBuilder(): Response
    {
        $data = $this->resumeBuilderData(Auth::user());

        $pdf = Pdf::loadView('dashboard.jobseeker.resume-builder-pdf', $data)
            ->setPaper('a4', 'portrait');

        $fileName = trim(($data['resumeName'] ?: 'resume') . '-harvard-style.pdf');

        return $pdf->download($fileName);
    }

    public function saveResumeBuilder(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'objective' => ['nullable', 'string', 'max:1000'],
            'skills' => ['nullable', 'string', 'max:1000'],
            'education' => ['nullable', 'array'],
            'education.*.school' => ['nullable', 'string', 'max:255'],
            'education.*.course' => ['nullable', 'string', 'max:255'],
            'education.*.year' => ['nullable', 'string', 'max:50'],
            'experience' => ['nullable', 'array'],
            'experience.*.title' => ['nullable', 'string', 'max:255'],
            'experience.*.company' => ['nullable', 'string', 'max:255'],
            'experience.*.period' => ['nullable', 'string', 'max:100'],
            'experience.*.details' => ['nullable', 'string', 'max:1000'],
        ]);

        $profile = UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'resume_name' => $validated['name'],
                'resume_email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'objective' => $validated['objective'] ?? null,
                'skills' => $this->normalizeList($validated['skills'] ?? ''),
                'education' => $this->normalizeResumeSection($validated['education'] ?? [], ['school', 'course', 'year']),
                'experience' => $this->normalizeResumeSection($validated['experience'] ?? [], ['title', 'company', 'period', 'details']),
            ]
        );

        return redirect()
            ->route('jobseeker.resume-builder')
            ->with('status', 'Resume builder saved successfully.');
    }

    public function resetResumeBuilder(Request $request): RedirectResponse
    {
        $user = $request->user();
        $profile = $user?->profile;

        if ($profile) {
            $profile->update([
                // Marker values indicate "resume reset mode" while preserving profile data.
                'resume_name' => '',
                'resume_email' => '',
                'objective' => '',
                'resume_path' => null,
            ]);
        }

        return redirect()
            ->route('jobseeker.resume-builder')
            ->with('status', 'Resume builder reset successfully.');
    }

    private function normalizeList(?string $value): array
    {
        if (! $value) {
            return [];
        }

        return collect(preg_split('/[\r\n,]+/', $value) ?: [])
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    private function normalizeResumeSection(array $rows, array $allowedKeys): array
    {
        return collect($rows)
            ->map(function ($row) use ($allowedKeys) {
                $cleanRow = [];

                foreach ($allowedKeys as $key) {
                    $cleanRow[$key] = trim((string) ($row[$key] ?? ''));
                }

                return $cleanRow;
            })
            ->filter(function ($row) {
                return collect($row)->filter()->isNotEmpty();
            })
            ->values()
            ->all();
    }

    private function normalizeLanguageRows(array $rows): array
    {
        return collect($rows)
            ->map(function ($row) {
                return [
                    'language' => trim((string) ($row['language'] ?? '')),
                    'read' => (bool) ($row['read'] ?? false),
                    'write' => (bool) ($row['write'] ?? false),
                    'speak' => (bool) ($row['speak'] ?? false),
                    'understand' => (bool) ($row['understand'] ?? false),
                    'other' => trim((string) ($row['other'] ?? '')),
                ];
            })
            ->filter(function ($row) {
                return $row['language'] !== '' || $row['other'] !== '';
            })
            ->values()
            ->all();
    }

    private function buildSkillList(array $otherSkills): array
    {
        $skills = array_merge(
            $otherSkills['trade_manual'] ?? [],
            $otherSkills['it_technical'] ?? [],
            $otherSkills['soft_skills'] ?? [],
            array_filter([(string) ($otherSkills['other_text'] ?? '')])
        );

        return collect($skills)
            ->map(fn ($item) => trim((string) $item))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function buildResumeNameFromProfile(?User $user, array $personalInformation): string
    {
        $parts = collect([
            data_get($personalInformation, 'first_name', ''),
            data_get($personalInformation, 'middle_initial', ''),
            data_get($personalInformation, 'surname', ''),
            data_get($personalInformation, 'suffix', ''),
        ])->filter();

        return $parts->isNotEmpty() ? $parts->join(' ') : trim((string) ($user?->name ?? ''));
    }

    private function buildResumeSkillsFromProfile(?UserProfile $profile): array
    {
        if (! $profile) {
            return [];
        }

        $skills = $profile->skills ?? [];

        if (! empty($skills)) {
            return $skills;
        }

        return $this->buildSkillList($profile->other_skills ?? []);
    }

    private function buildResumeObjectiveFromProfile(array $personalInformation, ?UserProfile $profile): string
    {
        $occupation = trim((string) data_get($profile, 'job_preferences.occupation_text', ''));
        $skillText = collect($profile?->skills ?? [])->take(3)->implode(', ');

        if ($occupation !== '' && $skillText !== '') {
            return 'To secure a position in ' . $occupation . ' where I can apply my skills in ' . $skillText . ' and contribute to organizational success.';
        }

        if ($occupation !== '') {
            return 'To secure a position in ' . $occupation . ' where I can contribute my skills and experience to a growing organization.';
        }

        if ($skillText !== '') {
            return 'To secure a position where I can apply my skills in ' . $skillText . ' and contribute to organizational success.';
        }

        $firstName = trim((string) data_get($personalInformation, 'first_name', ''));

        return $firstName !== ''
            ? 'To secure a position where I can apply my skills and contribute to the success of the organization.'
            : '';
    }

    private function formatAddress(array $address): string
    {
        return collect([
            $address['house_no'] ?? '',
            $address['barangay'] ?? '',
            $address['municipality'] ?? '',
            $address['province'] ?? '',
        ])->filter()->join(', ');
    }

    private function resumeBuilderData(?\App\Models\User $user): array
    {
        $profile = $user?->profile;

        $isResumeReset = $profile
            && $profile->resume_name === ''
            && $profile->resume_email === '';

        $profilePersonal = $profile?->personal_information ?? [];
        $profilePresentAddress = $profile?->present_address ?? [];
        $profilePermanentAddress = $profile?->permanent_address ?? [];
        $profileSkills = $profile?->skills ?? [];
        $profileEducationRows = $profile?->education ?? [];
        $profileTrainingRows = $profile?->training ?? [];
        $profileExperienceRows = $profile?->experience ?? [];
        $profileEligibilityRows = $profile?->eligibility ?? [];

        $resumeName = old('name', $isResumeReset ? '' : ($profile->resume_name ?? $this->buildResumeNameFromProfile($user, $profilePersonal)));
        $resumeEmail = old('email', $isResumeReset ? '' : ($profile->resume_email ?? data_get($profilePersonal, 'email_address', $user?->email ?? '')));
        $resumePhone = old('phone', $isResumeReset ? '' : ($profile->phone ?? data_get($profilePersonal, 'contact_number', '')));
        $resumeAddress = old('address', $isResumeReset ? '' : ($profile->address ?? ($this->formatAddress($profilePresentAddress) ?: $this->formatAddress($profilePermanentAddress))));
        $resumeObjective = old('objective', $isResumeReset ? '' : ($profile->objective ?? $this->buildResumeObjectiveFromProfile($profilePersonal, $profile)));
        $resumeSkills = old('skills', $isResumeReset ? '' : implode(', ', $profileSkills ?: $this->buildResumeSkillsFromProfile($profile)));
        $educationRows = old('education', $isResumeReset ? [] : $profileEducationRows);
        $trainingRows = old('training', $isResumeReset ? [] : $profileTrainingRows);
        $experienceRows = old('experience', $isResumeReset ? [] : $profileExperienceRows);
        $eligibilityRows = old('eligibility', $isResumeReset ? [] : $profileEligibilityRows);

        return [
            'user' => $user,
            'profile' => $profile,
            'resumeName' => $resumeName,
            'resumeEmail' => $resumeEmail,
            'resumePhone' => $resumePhone,
            'resumeAddress' => $resumeAddress,
            'resumeObjective' => $resumeObjective,
            'resumeSkills' => $resumeSkills,
            'educationRows' => $educationRows,
            'trainingRows' => $trainingRows,
            'experienceRows' => $experienceRows,
            'eligibilityRows' => $eligibilityRows,
            'skillsPreview' => collect(explode(',', $resumeSkills))->map(fn ($item) => trim($item))->filter()->values(),
        ];
    }

    private function profileFormData(?User $user): array
    {
        $profile = $user?->profile;
        $displayName = trim((string) ($user?->name ?? ''));
        $nameParts = $this->splitDisplayName($displayName);

        $personalInformation = array_merge([
            'surname' => $nameParts['surname'],
            'first_name' => $nameParts['first_name'],
            'middle_initial' => $nameParts['middle_initial'],
            'suffix' => $nameParts['suffix'],
            'date_of_birth' => '',
            'sex' => 'Female',
            'religion' => '',
            'civil_status' => '',
            'height' => '',
            'tin' => '',
            'contact_number' => $profile?->phone ?? '',
            'email_address' => $profile?->resume_email ?? $user?->email ?? '',
            'currently_in_school' => (bool) data_get($profile, 'personal_information.currently_in_school', false),
        ], $profile?->personal_information ?? []);

        $presentAddress = array_merge([
            'house_no' => '',
            'barangay' => '',
            'municipality' => '',
            'province' => '',
        ], $profile?->present_address ?? $this->splitAddress((string) ($profile?->address ?? '')));

        $permanentAddress = array_merge([
            'same_as_present' => false,
            'house_no' => '',
            'barangay' => '',
            'municipality' => '',
            'province' => '',
        ], $profile?->permanent_address ?? []);

        $educationRows = $profile?->education ?? [[ 'school' => '', 'course' => '', 'year' => '' ]];
        $trainingRows = $profile?->training ?? [[ 'course' => '', 'hours' => '', 'institution' => '', 'dates' => '', 'skills' => '', 'certificates' => '' ]];
        $experienceRows = $profile?->experience ?? [[ 'company' => '', 'title' => '', 'location' => '', 'status' => '', 'from_date' => '', 'to_date' => '', 'salary_amount' => '', 'salary_type' => '', 'details' => '' ]];
        $eligibilityRows = $profile?->eligibility ?? [[ 'eligibility' => '', 'date_taken' => '', 'license' => '', 'valid_until' => '' ]];

        $otherSkills = $profile?->other_skills ?? $this->defaultOtherSkills();
        $employmentStatus = $profile?->employment_status ?? $this->defaultEmploymentStatus();
        $employmentStatus['has_work_experience'] = data_get($profile, 'employment_status.has_work_experience', null);
        $jobPreferences = $profile?->job_preferences ?? $this->defaultJobPreferences();
        $languages = $profile?->languages ?? $this->defaultLanguages();
        $disability = $profile?->disability ?? $this->defaultDisability();

        return [
            'user' => $user,
            'profile' => $profile,
            'personalInformation' => $personalInformation,
            'presentAddress' => $presentAddress,
            'permanentAddress' => $permanentAddress,
            'educationRows' => $educationRows,
            'trainingRows' => $trainingRows,
            'experienceRows' => $experienceRows,
            'eligibilityRows' => $eligibilityRows,
            'otherSkills' => $otherSkills,
            'employmentStatus' => $employmentStatus,
            'jobPreferences' => $jobPreferences,
            'languages' => $languages,
            'disability' => $disability,
            'resumeFileName' => $profile?->resume_path ? basename($profile->resume_path) : null,
            'resumeFileUrl' => $profile?->resume_path ? asset('storage/' . ltrim($profile->resume_path, '/')) : null,
        ];
    }

    private function defaultOtherSkills(): array
    {
        return [
            'trade_manual' => [],
            'it_technical' => [],
            'soft_skills' => [],
            'other_text' => '',
            'with_certificate' => false,
            'by_experience' => false,
        ];
    }

    private function defaultEmploymentStatus(): array
    {
        return [
            'wage_employed' => false,
            'self_employed' => false,
            'unemployed' => false,
            'has_work_experience' => null,
        ];
    }

    private function defaultJobPreferences(): array
    {
        return [
            'part_time' => false,
            'full_time' => false,
            'local' => false,
            'overseas' => false,
            'occupation_text' => '',
        ];
    }

    private function defaultLanguages(): array
    {
        return [
            ['language' => 'English', 'read' => false, 'write' => false, 'speak' => false, 'understand' => false, 'other' => ''],
            ['language' => 'Tagalog', 'read' => false, 'write' => false, 'speak' => false, 'understand' => false, 'other' => ''],
            ['language' => 'Visayan', 'read' => false, 'write' => false, 'speak' => false, 'understand' => false, 'other' => ''],
            ['language' => 'Others:', 'read' => false, 'write' => false, 'speak' => false, 'understand' => false, 'other' => ''],
        ];
    }

    private function defaultDisability(): array
    {
        return [
            'visual' => false,
            'speech' => false,
            'mental' => false,
            'hearing' => false,
            'physical' => false,
            'other' => false,
            'other_text' => '',
        ];
    }

    private function splitDisplayName(string $displayName): array
    {
        $segments = collect(preg_split('/\s+/', trim($displayName)) ?: [])
            ->filter()
            ->values()
            ->all();

        $suffixes = ['jr', 'jr.', 'sr', 'sr.', 'ii', 'iii', 'iv', 'v'];
        $suffix = '';

        if (! empty($segments)) {
            $lastSegment = strtolower(rtrim((string) end($segments), ','));

            if (in_array($lastSegment, $suffixes, true)) {
                $suffix = array_pop($segments);
            }
        }

        $firstName = $segments[0] ?? '';
        $middleInitial = '';
        $surname = '';

        if (count($segments) === 2) {
            $surname = $segments[1] ?? '';
        } elseif (count($segments) === 3) {
            $secondSegment = (string) ($segments[1] ?? '');

            if (preg_match('/^[A-Za-z]\.?$/', $secondSegment)) {
                $middleInitial = $secondSegment;
                $surname = $segments[2] ?? '';
            } else {
                $firstName = trim(($segments[0] ?? '') . ' ' . $secondSegment);
                $surname = $segments[2] ?? '';
            }
        } elseif (count($segments) > 3) {
            $penultimateSegment = (string) ($segments[count($segments) - 2] ?? '');

            if (preg_match('/^[A-Za-z]\.?$/', $penultimateSegment)) {
                $surname = array_pop($segments) ?? '';
                $middleInitial = array_pop($segments) ?? '';
                $firstName = implode(' ', $segments);
            } else {
                $firstName = implode(' ', array_slice($segments, 0, 2));
                $surname = array_pop($segments) ?? '';
            }
        }

        return [
            'first_name' => $firstName,
            'middle_initial' => $middleInitial,
            'surname' => $surname,
            'suffix' => $suffix,
        ];
    }

    private function splitAddress(string $address): array
    {
        $segments = collect(preg_split('/[\r\n,]+/', $address) ?: [])
            ->map(fn ($segment) => trim($segment))
            ->filter()
            ->values()
            ->all();

        return [
            'house_no' => $segments[0] ?? '',
            'barangay' => $segments[1] ?? '',
            'municipality' => $segments[2] ?? '',
            'province' => $segments[3] ?? '',
        ];
    }

    private function extractJobRequirements(PesoJob $job): array
    {
        $requirements = $job->requirements;

        if (is_array($requirements) && ! empty($requirements)) {
            return collect($requirements)
                ->map(fn ($item) => trim((string) $item))
                ->filter()
                ->values()
                ->all();
        }

        $rawRequirements = trim((string) $job->getRawOriginal('requirements'));

        if ($rawRequirements === '') {
            return [];
        }

        return collect(preg_split('/[\r\n,]+/', $rawRequirements) ?: [])
            ->map(fn ($item) => trim((string) $item))
            ->filter()
            ->values()
            ->all();
    }
}
