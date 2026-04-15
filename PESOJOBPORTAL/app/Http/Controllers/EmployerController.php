<?php

namespace App\Http\Controllers;

use App\Models\EmployerNotification;
use App\Models\JobApplication;
use App\Models\PesoJob;
use App\Models\RecruitmentActivityRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployerController extends Controller
{
    public function dashboard(Request $request): View
    {
        $employer = $request->user();

        return view('dashboard.employer', [
            'stats' => $this->buildDashboardStats($employer->id),
            'isVerifiedEmployer' => (bool) $employer->is_employer_verified,
        ]);
    }

    public function postNewJobPage(Request $request): View
    {
        return view('dashboard.employer.post-new-job', [
            'isVerifiedEmployer' => (bool) $request->user()->is_employer_verified,
        ]);
    }

    public function manageJobsPage(Request $request): View
    {
        $employer = $request->user();

        return view('dashboard.employer.manage-jobs', [
            'jobs' => $this->getEmployerJobs($employer->id),
            'isVerifiedEmployer' => (bool) $employer->is_employer_verified,
        ]);
    }

    public function viewApplicantsPage(Request $request): View
    {
        return view('dashboard.employer.view-applicants', [
            'referredApplications' => $this->getReferredApplications($request->user()->id),
        ]);
    }

    public function requestLraSraPage(Request $request): View
    {
        return view('dashboard.employer.request-lra-sra', [
            'recruitmentRequests' => $this->getRecruitmentRequests($request->user()->id),
        ]);
    }

    public function submitDocumentsPage(Request $request): View
    {
        $defaultActivityType = $request->query('activity_type');

        if (! in_array($defaultActivityType, ['lra', 'sra'], true)) {
            $defaultActivityType = null;
        }

        return view('dashboard.employer.submit-documents', [
            'defaultActivityType' => $defaultActivityType,
            'recruitmentRequests' => $this->getRecruitmentRequests($request->user()->id),
        ]);
    }

    public function companyProfilePage(Request $request): View
    {
        $employer = $request->user()->loadMissing('profile');

        return view('dashboard.employer.company-profile', [
            'employer' => $employer,
            'isVerifiedEmployer' => (bool) $employer->is_employer_verified,
        ]);
    }

    public function notificationsPage(Request $request): View
    {
        $notifications = $this->getNotifications($request->user()->id, 50);

        return view('dashboard.employer.notifications', [
            'notifications' => $notifications,
            'unreadCount' => $notifications->where('is_read', false)->count(),
        ]);
    }

    public function storeJob(Request $request): RedirectResponse
    {
        $employer = $request->user();

        if (! $employer->is_employer_verified) {
            return back()->with('error', 'Only verified employers can post job vacancies.');
        }

        $validated = $request->validate([
            'position' => ['required', 'string', 'max:255'],
            'qualifications' => ['required', 'string'],
            'salary' => ['nullable', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'job_type' => ['required', 'string', 'max:100'],
            'vacancies' => ['required', 'integer', 'min:1'],
            'application_start_date' => ['required', 'date'],
            'application_end_date' => ['required', 'date', 'after_or_equal:application_start_date'],
        ]);

        PesoJob::create([
            'employer_id' => $employer->id,
            'employer_name' => $employer->name,
            'title' => $validated['position'],
            'position' => $validated['position'],
            'description' => $validated['qualifications'],
            'qualifications' => $validated['qualifications'],
            'salary_range' => $validated['salary'] ?? null,
            'salary' => $validated['salary'] ?? null,
            'location' => $validated['location'],
            'job_type' => $validated['job_type'],
            'vacancies' => $validated['vacancies'],
            'application_start_date' => $validated['application_start_date'],
            'application_end_date' => $validated['application_end_date'],
            'status' => 'active',
        ]);

        return back()->with('success', 'Job vacancy posted successfully.');
    }

    public function extendJob(Request $request, PesoJob $job): RedirectResponse
    {
        $this->assertJobOwnership($request, $job);

        $validated = $request->validate([
            'application_end_date' => ['required', 'date', 'after:today'],
        ]);

        $job->update([
            'application_end_date' => $validated['application_end_date'],
            'status' => 'active',
            'archived_at' => null,
        ]);

        return back()->with('success', 'Posting end date extended.');
    }

    public function archiveJob(Request $request, PesoJob $job): RedirectResponse
    {
        $this->assertJobOwnership($request, $job);

        $job->update([
            'status' => 'closed',
            'archived_at' => now(),
        ]);

        return back()->with('success', 'Posting archived successfully.');
    }

    public function duplicateJob(Request $request, PesoJob $job): RedirectResponse
    {
        $this->assertJobOwnership($request, $job);

        if (! $request->user()->is_employer_verified) {
            return back()->with('error', 'Only verified employers can duplicate and republish jobs.');
        }

        $newJob = $job->replicate();
        $newJob->status = 'active';
        $newJob->archived_at = null;
        $newJob->is_filled = false;
        $newJob->filled_at = null;
        $newJob->application_start_date = now()->toDateString();
        $newJob->application_end_date = now()->addDays(30)->toDateString();
        $newJob->source_job_id = $job->id;
        $newJob->save();

        return back()->with('success', 'Job posting duplicated.');
    }

    public function markJobFilled(Request $request, PesoJob $job): RedirectResponse
    {
        $this->assertJobOwnership($request, $job);

        $job->update([
            'is_filled' => true,
            'filled_at' => now(),
            'status' => 'closed',
        ]);

        return back()->with('success', 'Vacancy marked as filled.');
    }

    public function requestRecruitmentActivity(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'activity_type' => ['required', 'in:lra,sra'],
            'letter_of_intent' => ['required', 'file', 'mimes:pdf,doc,docx,png,jpg,jpeg', 'max:5120'],
            'company_profile' => ['required', 'file', 'mimes:pdf,doc,docx,png,jpg,jpeg', 'max:5120'],
            'job_advertisement' => ['required', 'file', 'mimes:pdf,doc,docx,png,jpg,jpeg', 'max:5120'],
        ]);

        RecruitmentActivityRequest::create([
            'employer_id' => $request->user()->id,
            'activity_type' => $validated['activity_type'],
            'letter_of_intent_path' => $request->file('letter_of_intent')->store('recruitment-documents'),
            'company_profile_path' => $request->file('company_profile')->store('recruitment-documents'),
            'job_advertisement_path' => $request->file('job_advertisement')->store('recruitment-documents'),
        ]);

        return back()->with('success', 'LRA/SRA request submitted successfully.');
    }

    public function updateApplicantDecision(Request $request, JobApplication $application): RedirectResponse
    {
        $job = $application->job;

        if (! $job || (int) $job->employer_id !== (int) $request->user()->id) {
            abort(403, 'You can only update applicants referred to your postings.');
        }

        $validated = $request->validate([
            'employer_status' => ['required', 'in:interview_scheduled,hired,not_selected'],
            'final_decision' => ['required', 'in:pending,hired,not_selected'],
            'employer_feedback' => ['nullable', 'string'],
        ]);

        $application->update([
            'employer_status' => $validated['employer_status'],
            'final_decision' => $validated['final_decision'],
            'employer_feedback' => $validated['employer_feedback'] ?? null,
            'status' => $validated['final_decision'] === 'hired'
                ? 'hired'
                : ($validated['final_decision'] === 'not_selected' ? 'rejected' : 'interviewed'),
        ]);

        return back()->with('success', 'Applicant decision updated.');
    }

    public function markNotificationRead(Request $request, EmployerNotification $notification): RedirectResponse
    {
        if ((int) $notification->employer_id !== (int) $request->user()->id) {
            abort(403);
        }

        $notification->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return back()->with('success', 'Notification marked as read.');
    }

    private function assertJobOwnership(Request $request, PesoJob $job): void
    {
        if ((int) $job->employer_id !== (int) $request->user()->id) {
            abort(403, 'This posting does not belong to your employer account.');
        }
    }

    private function getEmployerJobs(int $employerId)
    {
        return PesoJob::query()
            ->where('employer_id', $employerId)
            ->latest()
            ->get();
    }

    private function getRecruitmentRequests(int $employerId)
    {
        return RecruitmentActivityRequest::query()
            ->where('employer_id', $employerId)
            ->latest()
            ->get();
    }

    private function getReferredApplications(int $employerId)
    {
        return JobApplication::query()
            ->with(['user.profile', 'job'])
            ->where('is_referred', true)
            ->whereHas('job', function ($query) use ($employerId) {
                $query->where('employer_id', $employerId);
            })
            ->latest()
            ->get();
    }

    private function getNotifications(int $employerId, int $limit = 20)
    {
        return EmployerNotification::query()
            ->where('employer_id', $employerId)
            ->latest()
            ->limit($limit)
            ->get();
    }

    private function buildDashboardStats(int $employerId): array
    {
        $activeJobsCount = PesoJob::query()
            ->where('employer_id', $employerId)
            ->where('status', 'active')
            ->whereNull('archived_at')
            ->where('is_filled', false)
            ->count();

        $totalApplications = JobApplication::query()
            ->whereHas('job', function ($query) use ($employerId) {
                $query->where('employer_id', $employerId);
            })
            ->count();

        $hiredCandidates = JobApplication::query()
            ->whereHas('job', function ($query) use ($employerId) {
                $query->where('employer_id', $employerId);
            })
            ->where('final_decision', 'hired')
            ->count();

        $newApplicationsToday = JobApplication::query()
            ->whereHas('job', function ($query) use ($employerId) {
                $query->where('employer_id', $employerId);
            })
            ->whereDate('created_at', now()->toDateString())
            ->count();

        return [
            'active_jobs_count' => $activeJobsCount,
            'total_applications' => $totalApplications,
            'hired_candidates' => $hiredCandidates,
            'new_applications_today' => $newApplicationsToday,
        ];
    }
}
