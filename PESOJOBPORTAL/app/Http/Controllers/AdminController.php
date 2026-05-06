<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PesoJob;
use App\Models\JobApplication;
use App\Models\PesoClearance;
use App\Models\RecruitmentActivityRequest;
use App\Models\CompanyProfile;
use App\Models\EmployerNotification;
use App\Models\PortalNotification;
use App\Models\UserNotification;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_jobs' => PesoJob::notArchived()->count(),
            'total_applications' => JobApplication::count(),
            'active_jobs' => PesoJob::where('status', 'active')->notArchived()->count(),
            'total_employers' => User::where('role', 'employer')->count(),
            'total_jobseekers' => User::where('role', 'jobseeker')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'pending_applications' => JobApplication::where('status', 'pending')->count(),
            'pending_job_approvals' => PesoJob::where('status', 'pending')->notArchived()->count(),
            'pending_lra_sra' => RecruitmentActivityRequest::where('status', 'pending')->count(),
            'pending_documents' => DB::table('employer_documents')->where('status', 'pending')->count(),
        ];

        $recentUsers = User::latest()->limit(5)->get();
        $recentJobs = PesoJob::notArchived()->latest()->limit(5)->get();
        $recentApplications = JobApplication::with(['user', 'job'])->latest()->limit(5)->get();

        return view('dashboard.admin', compact('stats', 'recentUsers', 'recentJobs', 'recentApplications'));
    }

    // Employer Verification
    public function employerVerification(Request $request): View
    {
        // Show employers who have uploaded verification documents or whose status indicates review/rejection.
        $companyProfiles = CompanyProfile::where(function($q) {
                $q->whereIn('verification_status', ['under_review', 'rejected']);
            })->orWhere(function($q) {
                // Also include profiles that already have both required documents uploaded even if status is still 'pending'
                $q->whereNotNull('business_permit_path')
                  ->whereNotNull('dti_sec_registration_path')
                  ->where('verification_status', '!=', 'verified');
            })
            ->with('employer')
            ->orderByRaw("CASE WHEN verification_status = 'under_review' THEN 0 WHEN verification_status = 'rejected' THEN 1 ELSE 2 END")
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $verificationRequests = DB::table('employer_documents as documents')
            ->join('users as employers', 'employers.id', '=', 'documents.user_id')
            ->leftJoin('company_profiles as profiles', 'profiles.user_id', '=', 'employers.id')
            ->whereIn('documents.document_type', ['business_permit', 'dti_sec_registration'])
            ->where('documents.status', 'pending')
            ->select([
                'documents.user_id',
                'documents.document_type',
                'documents.file_path',
                'documents.created_at',
                'employers.name as employer_name',
                'employers.email as employer_email',
                'profiles.id as company_profile_id',
                'profiles.company_name',
                'profiles.verification_status',
            ])
            ->orderByDesc('documents.created_at')
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                $first = $items->first();

                return [
                    'user_id' => (int) $first->user_id,
                    'employer_name' => $first->employer_name,
                    'employer_email' => $first->employer_email,
                    'company_profile_id' => $first->company_profile_id ? (int) $first->company_profile_id : null,
                    'company_name' => $first->company_name ?: $first->employer_name,
                    'verification_status' => $first->verification_status ?: 'pending',
                    'has_business_permit' => $items->contains('document_type', 'business_permit'),
                    'has_dti_sec' => $items->contains('document_type', 'dti_sec_registration'),
                    'documents' => $items->map(function ($item) {
                        return [
                            'type' => $item->document_type,
                            'file_path' => $item->file_path,
                            'created_at' => $item->created_at,
                        ];
                    })->values(),
                ];
            })->values();

        $verificationAlerts = UserNotification::query()
            ->where('user_id', (int) $request->user()->id)
            ->with('portalNotification')
            ->whereHas('portalNotification', function ($query) {
                $query->where('title', 'like', '%Verification%')
                    ->orWhere('message', 'like', '%Business Permit%')
                    ->orWhere('message', 'like', '%DTI/SEC%');
            })
            ->orderByRaw('read_at IS NULL DESC')
            ->latest('id')
            ->limit(5)
            ->get();

        $verificationUnreadCount = (int) $verificationAlerts->whereNull('read_at')->count();
        $verificationRequestCount = (int) $verificationRequests->count();

        return view('admin.employer-verification', compact('companyProfiles', 'verificationRequests', 'verificationAlerts', 'verificationUnreadCount', 'verificationRequestCount'));
    }

    public function viewCompanyProfile(CompanyProfile $companyProfile): View
    {
        $companyProfile->load('employer');
        return view('admin.employer-verification-detail', compact('companyProfile'));
    }

    public function approveCompanyProfile(Request $request, CompanyProfile $companyProfile): RedirectResponse
    {
        $wasVerified = $companyProfile->verification_status === 'verified';

        $companyProfile->update([
            'verification_status' => 'verified',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        if ($companyProfile->employer) {
            $companyProfile->employer->update(['is_employer_verified' => true]);

            if (! $wasVerified) {
                $this->notifyEmployer(
                    $companyProfile->employer,
                    'verification_update',
                    'Company Verification Approved',
                    'Your company verification was approved by PESO admin. Your employer account is now verified.'
                );
            }
        }

        return back()->with('success', "Company profile '{$companyProfile->company_name}' has been verified and approved.");
    }

    public function rejectCompanyProfile(Request $request, CompanyProfile $companyProfile): RedirectResponse
    {
        $request->validate(['verification_notes' => 'required|string|max:500']);

        $rejectionReason = (string) $request->verification_notes;

        $companyProfile->update([
            'verification_status' => 'rejected',
            'verification_notes' => $rejectionReason,
            'verified_by' => Auth::id(),
        ]);

        if ($companyProfile->employer) {
            $companyProfile->employer->update(['is_employer_verified' => false]);

            $this->notifyEmployer(
                $companyProfile->employer,
                'verification_update',
                'Company Verification Rejected',
                sprintf(
                    "Your company verification was rejected by PESO admin. Reason: %s",
                    $rejectionReason
                )
            );
        }

        return back()->with('warning', "Company profile '{$companyProfile->company_name}' has been rejected.");
    }

    public function jobApprovals(): View
    {
        $pendingJobs = PesoJob::where('status', 'pending')->with('employer')->paginate(15);
        return view('admin.approvals.jobs', compact('pendingJobs'));
    }

    public function jobsManagement(): View
    {
        $jobs = PesoJob::where('status', 'active')
            ->notArchived()
            ->with(['employer', 'applications'])
            ->orderByDesc('approved_at')
            ->paginate(15);

        return view('admin.jobs-management', compact('jobs'));
    }

    public function employersManagement(): View
    {
        $employers = User::where('role', 'employer')
            ->with('companyProfile')
            ->whereHas('companyProfile', function ($query) {
                $query->where('verification_status', 'verified');
            })
            ->orderByDesc('is_employer_verified')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.employers-management', compact('employers'));
    }

    public function applicationsAnalytics(Request $request): View
    {
        // Get date range parameters
        $period = $request->input('period', '7days');
        $startDate = null;
        $endDate = now();

        // Calculate date range based on period
        switch ($period) {
            case '7days':
                $startDate = now()->subDays(7);
                break;
            case '30days':
                $startDate = now()->subDays(30);
                break;
            case 'month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'year':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
            case 'custom':
                $startDate = $request->input('start_date') ? \Carbon\Carbon::parse($request->input('start_date')) : now()->subDays(30);
                $endDate = $request->input('end_date') ? \Carbon\Carbon::parse($request->input('end_date')) : now();
                break;
        }

        // Get application statistics within date range
        $totalApplications = JobApplication::whereBetween('created_at', [$startDate, $endDate])->count();
        $pendingApplications = JobApplication::where('status', 'pending')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $acceptedApplications = JobApplication::where('status', 'accepted')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $rejectedApplications = JobApplication::where('status', 'rejected')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Get gender distribution from jobseeker profiles (for applicants in date range)
        $genderData = DB::table('jobseeker_profiles')
            ->select('gender', DB::raw('COUNT(*) as count'))
            ->whereIn('user_id', function($query) use ($startDate, $endDate) {
                $query->select('user_id')
                    ->from('job_applications')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->distinct();
            })
            ->groupBy('gender')
            ->get();

        $femaleCount = $genderData->where('gender', 'female')->first()?->count ?? 0;
        $maleCount = $genderData->where('gender', 'male')->first()?->count ?? 0;
        $otherCount = $genderData->where('gender', null)->first()?->count ?? 0;

        // Handle case where gender values might be different
        $otherCount = $totalApplications - ($femaleCount + $maleCount);
        if ($otherCount < 0) $otherCount = 0;

        // Get daily application trends
        $dailyTrends = JobApplication::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total'),
            DB::raw("SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending"),
            DB::raw("SUM(CASE WHEN status = 'accepted' THEN 1 ELSE 0 END) as accepted"),
            DB::raw("SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected")
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date', 'asc')
        ->get();

        // Format trend data for charts
        $trendDates = $dailyTrends->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('M d'))->toArray();
        $trendTotal = $dailyTrends->pluck('total')->toArray();
        $trendPending = $dailyTrends->pluck('pending')->toArray();
        $trendAccepted = $dailyTrends->pluck('accepted')->toArray();
        $trendRejected = $dailyTrends->pluck('rejected')->toArray();

        return view('admin.applications-analytics', compact(
            'totalApplications',
            'pendingApplications',
            'acceptedApplications',
            'rejectedApplications',
            'femaleCount',
            'maleCount',
            'otherCount',
            'period',
            'trendDates',
            'trendTotal',
            'trendPending',
            'trendAccepted',
            'trendRejected'
        ));
    }

    public function viewJob(PesoJob $job): View
    {
        $job->load(['employer', 'approver', 'applications']);
        return view('admin.approvals.job-detail', compact('job'));
    }

    public function approveJob(Request $request, PesoJob $job): RedirectResponse
    {
        $wasActive = $job->status === 'active';

        $job->update([
            'status' => 'active',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        if (! $wasActive && $job->employer) {
            $this->notifyEmployer(
                $job->employer,
                'job_update',
                'Job Post Approved',
                sprintf(
                    "Your job post '%s' has been approved by PESO admin and is now active.",
                    $job->title
                )
            );
        }

        return back()->with('success', "Job '{$job->title}' has been approved and is now active.");
    }

    public function rejectJob(Request $request, PesoJob $job): RedirectResponse
    {
        $request->validate(['rejection_reason' => 'required|string|max:500']);

        $rejectionReason = (string) $request->rejection_reason;

        $job->update([
            'status' => 'draft',
            'rejection_reason' => $rejectionReason,
        ]);

        if ($job->employer) {
            $this->notifyEmployer(
                $job->employer,
                'job_update',
                'Job Post Rejected',
                sprintf(
                    "Your job post '%s' was rejected by PESO admin. Reason: %s",
                    $job->title,
                    $rejectionReason
                )
            );
        }

        return back()->with('success', "Job '{$job->title}' has been rejected.");
    }

    // LRA/SRA Approvals
    public function lraSraApprovals(): View
    {
        $pendingRequests = RecruitmentActivityRequest::where('status', 'pending')
            ->with('employer')
            ->paginate(15);
        return view('admin.approvals.lra-sra', compact('pendingRequests'));
    }

    public function viewLraSraRequest(RecruitmentActivityRequest $activityRequest): View
    {
        $activityRequest->load(['employer', 'approvedBy']);
        return view('admin.approvals.lra-sra-detail', compact('activityRequest'));
    }

    public function approveLraSra(Request $request, RecruitmentActivityRequest $activityRequest): RedirectResponse
    {
        $activityRequest->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        $type = $activityRequest->activity_type === 'lra' ? 'LRA' : 'SRA';
        return back()->with('success', "{$type} request has been approved.");
    }

    public function rejectLraSra(Request $request, RecruitmentActivityRequest $activityRequest): RedirectResponse
    {
        $request->validate(['notes' => 'required|string|max:500']);

        $activityRequest->update([
            'status' => 'rejected',
            'notes' => $request->notes,
        ]);

        $type = $activityRequest->activity_type === 'lra' ? 'LRA' : 'SRA';
        return back()->with('success', "{$type} request has been rejected.");
    }

    private function notifyEmployer(User $employer, string $preferredType, string $title, string $message): void
    {
        $payload = [
            'employer_id' => $employer->id,
            'type' => $preferredType,
            'title' => $title,
            'message' => $message,
            'is_read' => false,
        ];

        try {
            EmployerNotification::query()->create($payload);
            return;
        } catch (\Throwable) {
            // Fall back to a schema-safe type below.
        }

        $payload['type'] = 'general';

        try {
            EmployerNotification::query()->create($payload);
        } catch (\Throwable) {
            // Swallow the error so admin approval does not fail just because notifications cannot be recorded.
        }
    }

    private function notifyJobseeker(User $user, string $title, string $message): void
    {
        try {
            $portalNotification = PortalNotification::query()->create([
                'title' => $title,
                'message' => $message,
                'created_by' => Auth::id(),
            ]);

            UserNotification::query()->create([
                'user_id' => $user->id,
                'portal_notification_id' => $portalNotification->id,
                'read_at' => null,
            ]);
        } catch (\Throwable) {
            // Ignore notification failures so clearance issuance still succeeds.
        }
    }

    // Document Verification
    public function documentVerification(): View
    {
        $pendingDocuments = DB::table('employer_documents')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.approvals.documents', compact('pendingDocuments'));
    }

    public function pesoClearances(): View
    {
        $clearances = PesoClearance::query()
            ->with('user')
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 WHEN status = 'active' THEN 1 ELSE 2 END")
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.peso-clearances', compact('clearances'));
    }

    public function showPesoClearance(PesoClearance $clearance): View
    {
        $clearance->load('user');
        return view('admin.peso-clearance-show', compact('clearance'));
    }

    public function issuePesoClearance(Request $request, PesoClearance $clearance): RedirectResponse
    {
        if ($clearance->status !== 'pending') {
            return back()->with('warning', 'Only pending clearance requests can be issued.');
        }

        $request->validate([
            'clearance_number' => ['nullable', 'string', 'max:255', 'unique:peso_clearances,clearance_number,' . $clearance->id],
            'issue_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date'],
        ]);

        $providedNumber = trim((string) $request->input('clearance_number'));
        $clearanceNumber = $providedNumber !== '' ? $providedNumber : '00000';

        $issueDateInput = $request->input('issue_date');
        $expiryDateInput = $request->input('expiry_date');

        $issueDate = $issueDateInput ? Carbon::parse($issueDateInput) : now();
        $expiryDate = $expiryDateInput ? Carbon::parse($expiryDateInput) : now()->addYear();

        $clearance->update([
            'status' => 'active',
            'clearance_number' => $clearanceNumber,
            'issue_date' => $issueDate,
            'expiry_date' => $expiryDate,
            'remarks' => $clearance->remarks,
        ]);

        if ($clearance->user) {
            $this->notifyJobseeker(
                $clearance->user,
                'PESO Clearance Issued',
                sprintf(
                    'Your PESO clearance request has been issued. Clearance Number: %s.',
                    $clearanceNumber
                )
            );
        }

        return redirect()->route('admin.peso-clearances')->with('success', 'PESO clearance has been issued successfully.');
    }

    public function approveDocument(Request $request, int $documentId): RedirectResponse
    {
        DB::table('employer_documents')
            ->where('id', $documentId)
            ->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);

        return back()->with('success', 'Document has been approved.');
    }

    public function rejectDocument(Request $request, int $documentId): RedirectResponse
    {
        $request->validate(['notes' => 'required|string|max:500']);

        DB::table('employer_documents')
            ->where('id', $documentId)
            ->update([
                'status' => 'rejected',
                'notes' => $request->notes,
            ]);

        return back()->with('success', 'Document has been rejected.');
    }

    // Admin Profile
    public function profile(): View
    {
        $admin = Auth::user();

        if (! $admin instanceof User) {
            abort(403, 'Unauthorized');
        }

        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $admin = Auth::user();

        if (! $admin instanceof User) {
            abort(403, 'Unauthorized');
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($admin->profile_photo && Storage::disk('public')->exists($admin->profile_photo)) {
                Storage::disk('public')->delete($admin->profile_photo);
            }

            // Store new photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $admin->profile_photo = $path;
        }

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'profile_photo' => $admin->profile_photo,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }
}
