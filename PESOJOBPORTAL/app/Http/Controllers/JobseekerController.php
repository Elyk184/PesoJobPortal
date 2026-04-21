<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
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
        return view('jobseeker.dashboard');
    }

    public function vacancies(): View
    {
        return view('jobseeker.vacancies');
    }

    public function applications(): View
    {
        return view('jobseeker.applications');
    }

    public function profile(): View
    {
        return view('jobseeker.profile');
    }

    public function resumeBuilder(): View
    {
        $data = $this->resumeBuilderData(Auth::user());

        return view('jobseeker.resume-builder', $data);
    }

    public function exportResumeBuilder(): Response
    {
        $data = $this->resumeBuilderData(Auth::user());

        $pdf = Pdf::loadView('jobseeker.resume-builder-pdf', $data)
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
        $profile = $request->user()?->profile;

        if ($profile) {
            $profile->delete();
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

    private function resumeBuilderData(?\App\Models\User $user): array
    {
        $profile = $user?->profile;

        $resumeName = old('name', $profile->resume_name ?? '');
        $resumeEmail = old('email', $profile->resume_email ?? '');
        $resumePhone = old('phone', $profile->phone ?? '');
        $resumeAddress = old('address', $profile->address ?? '');
        $resumeObjective = old('objective', $profile->objective ?? '');
        $resumeSkills = old('skills', implode(', ', $profile->skills ?? []));
        $educationRows = old('education', $profile->education ?? []);
        $experienceRows = old('experience', $profile->experience ?? []);

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
            'experienceRows' => $experienceRows,
            'skillsPreview' => collect(explode(',', $resumeSkills))->map(fn ($item) => trim($item))->filter()->values(),
        ];
    }
}
