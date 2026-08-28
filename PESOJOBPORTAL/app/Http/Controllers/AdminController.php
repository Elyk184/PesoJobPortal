<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PesoJob;
use App\Models\JobApplication;
use App\Models\IssuedClearance;
use App\Models\OfwFormSubmission;
use App\Models\PesoClearance;
use App\Models\JobseekerAddress;
use App\Models\JobseekerPersonalInformation;
use App\Models\RecruitmentActivityRequest;
use App\Models\AssociationRequest;
use App\Models\CompanyProfile;
use App\Models\EmployerNotification;
use App\Models\PortalNotification;
use App\Models\UserNotification;
use App\Services\CertificationService;
use App\Services\PesoClearanceService;
use App\Services\PesoClearanceDocumentService;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        // Show only pending and under_review employer company profiles in main table
        $companyProfiles = CompanyProfile::with('employer')
            ->whereIn('verification_status', ['pending', 'under_review'])
            ->orderByRaw("CASE WHEN verification_status = 'pending' THEN 0 WHEN verification_status = 'under_review' THEN 1 END")
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Get all employers with their company profiles (if they have one)
        $allEmployers = User::where('role', 'employer')
            ->with('companyProfile')
            ->get()
            ->sortBy(function ($employer) {
                $status = $employer->companyProfile?->verification_status;
                return match($status) {
                    'verified' => 0,
                    'under_review' => 1,
                    'pending' => 2,
                    'rejected' => 4,
                    default => 3, // No profile
                };
            }, SORT_REGULAR, false);

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

        return view('admin.employer-verification', compact('companyProfiles', 'allEmployers', 'verificationRequests', 'verificationAlerts', 'verificationUnreadCount', 'verificationRequestCount'));
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

    public function employmentStats(): View
    {
        // Basic statistics
        $stats = [
            'total_jobseekers' => User::where('role', 'jobseeker')->count(),
            'active_jobs' => PesoJob::where('status', 'active')->notArchived()->count(),
            'successful_placements' => JobApplication::where('status', 'accepted')->count(),
            'registered_employers' => User::where('role', 'employer')->count(),
        ];

        // Job postings by status over last 12 months
        $jobsByMonth = PesoJob::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as total'),
            DB::raw("SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active"),
            DB::raw("SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending"),
            DB::raw("SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) as closed")
        )
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
        ->orderBy('month')
        ->get();

        // Application status distribution
        $applicationsByStatus = JobApplication::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Top job types/positions
        $topCategories = PesoJob::select('job_type', DB::raw('COUNT(*) as count'))
            ->where('status', 'active')
            ->notArchived()
            ->whereNotNull('job_type')
            ->groupBy('job_type')
            ->orderByDesc('count')
            ->limit(8)
            ->get();

        // If no job types, get by location as fallback
        if ($topCategories->isEmpty()) {
            $topCategories = PesoJob::select('location', DB::raw('COUNT(*) as count'))
                ->where('status', 'active')
                ->notArchived()
                ->groupBy('location')
                ->orderByDesc('count')
                ->limit(8)
                ->get()
                ->map(function($item) {
                    $item->job_type = $item->location;
                    return $item;
                });
        }

        // Jobseeker profile completion
        $jobseekerStats = DB::table('users')
            ->leftJoin('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->where('users.role', 'jobseeker')
            ->select(
                DB::raw('SUM(CASE WHEN user_profiles.id IS NOT NULL THEN 1 ELSE 0 END) as with_profile'),
                DB::raw('COUNT(*) as total')
            )
            ->first();

        // Applications trend (last 30 days)
        $applicationsTrend = JobApplication::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total')
        )
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date')
        ->get();

        // Format chart data
        $monthLabels = $jobsByMonth->pluck('month')->map(fn($m) => Carbon::createFromFormat('Y-m', $m)->format('M Y'))->toArray();
        $jobsTotal = $jobsByMonth->pluck('total')->toArray();
        $jobsActive = $jobsByMonth->pluck('active')->toArray();
        $jobsPending = $jobsByMonth->pluck('pending')->toArray();
        $jobsClosed = $jobsByMonth->pluck('closed')->toArray();

        $categoryLabels = $topCategories->pluck('job_type')->toArray();
        $categoryData = $topCategories->pluck('count')->toArray();

        $appStatusLabels = ['Pending', 'Accepted', 'Rejected'];
        $appStatusData = [
            $applicationsByStatus->get('pending', 0),
            $applicationsByStatus->get('accepted', 0),
            $applicationsByStatus->get('rejected', 0),
        ];

        $trendDates = $applicationsTrend->pluck('date')->map(fn($d) => Carbon::parse($d)->format('M d'))->toArray();
        $trendData = $applicationsTrend->pluck('total')->toArray();

        return view('admin.employment-stats', compact(
            'stats',
            'monthLabels',
            'jobsTotal',
            'jobsActive',
            'jobsPending',
            'jobsClosed',
            'categoryLabels',
            'categoryData',
            'appStatusLabels',
            'appStatusData',
            'trendDates',
            'trendData',
            'jobseekerStats'
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
            'archived_at' => null,
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

        $recentRequests = RecruitmentActivityRequest::whereIn('status', ['approved', 'rejected'])
            ->with(['employer', 'approvedBy', 'certificationGeneratedBy'])
            ->latest('updated_at')
            ->limit(10)
            ->get();

        return view('admin.approvals.lra-sra', compact('pendingRequests', 'recentRequests'));
    }

    public function viewLraSraRequest(RecruitmentActivityRequest $activityRequest): View
    {
        $activityRequest->load(['employer', 'approvedBy', 'certificationGeneratedBy']);
        return view('admin.approvals.lra-sra-detail', compact('activityRequest'));
    }

    public function downloadLraSraFile(Request $request, RecruitmentActivityRequest $activityRequest, string $field)
    {
        // Only allow specific file fields to be downloaded
        $allowed = [
            'letter_of_intent_path',
            'dmw_certificate_path',
            'recruitment_officer_id_path',
            'job_order_balance_path',
            'deployment_report_path',
            'affidavit_undertaking_path',
            'sra_authority_file_path',
            'business_permit_path',
            'lra_recruitment_officer_id_path',
            'job_vacancies_path',
            'company_profile_path',
            'certification_path',
        ];

        if (! in_array($field, $allowed, true)) {
            abort(404);
        }

        $filePath = data_get($activityRequest, $field);
        if (! $filePath) {
            return back()->with('error', 'File not found.');
        }

        // Try public disk first, then fallback to default (local) disk.
        $disksToTry = ['public', config('filesystems.default')];
        foreach (array_unique($disksToTry) as $disk) {
            try {
                if (Storage::disk($disk)->exists($filePath)) {
                    $fullPath = Storage::disk($disk)->path($filePath);

                    // Prefer original uploaded filename if available
                    $originalField = preg_replace('/_path$/', '_original_name', $field);
                    $downloadName = basename($filePath);
                    if ($originalField && data_get($activityRequest, $originalField)) {
                        // sanitize original name
                        $candidate = str_replace(["\n", "\r", "\0"], '', data_get($activityRequest, $originalField));
                        $candidate = basename($candidate);
                        if ($candidate !== '') {
                            $downloadName = $candidate;
                        }
                    }

                    return response()->download($fullPath, $downloadName);
                }
            } catch (\Exception $e) {
                // ignore and try next disk
            }
        }

        return back()->with('error', 'File not found.');
    }

    public function approveLraSra(Request $request, RecruitmentActivityRequest $activityRequest): RedirectResponse
    {
        // Check if certification exists
        $certService = new CertificationService();
        if (!$certService->hasCertification($activityRequest)) {
            return back()->with('error', 'You must generate a certification before approving this request. Please generate the certification first.');
        }

        $activityRequest->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        $type = $activityRequest->activity_type === 'lra' ? 'LRA' : 'SRA';
        $typeLabel = $activityRequest->activity_type === 'lra' ? 'Local Recruitment Activity' : 'Special Recruitment Activity';

        // Send emails to employer
        try {
            if ($activityRequest->employer && $activityRequest->employer->email) {
                // Send certification email
                \Illuminate\Support\Facades\Mail::to($activityRequest->employer->email)
                    ->send(new \App\Mail\CertificationApprovalMail($activityRequest));

                // Send request approval email
                \Illuminate\Support\Facades\Mail::to($activityRequest->employer->email)
                    ->send(new \App\Mail\RequestApprovedMail($activityRequest));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send approval emails: ' . $e->getMessage());
        }

        // Create in-app notification for employer
        if ($activityRequest->employer) {
            $this->notifyEmployer(
                $activityRequest->employer,
                'lra_sra_update',
                "{$type} Request Approved",
                "Your {$typeLabel} request has been approved. Your certification is ready for download."
            );
        }

        return back()->with('success', "{$type} request has been approved and emails sent to employer.");
    }

    public function generateLraSraCertification(RecruitmentActivityRequest $activityRequest): RedirectResponse
    {
        try {
            $certService = new CertificationService();
            $certService->generateCertification($activityRequest, Auth::user());

            $type = $activityRequest->activity_type === 'lra' ? 'LRA' : 'SRA';
            return back()->with('success', "{$type} certification has been generated successfully.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate certification: ' . $e->getMessage());
        }
    }

    public function downloadLraSraCertification(RecruitmentActivityRequest $activityRequest)
    {
        try {
            $certService = new CertificationService();
            return $certService->downloadCertification($activityRequest);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to download certification: ' . $e->getMessage());
        }
    }

    public function viewLraSraCertification(RecruitmentActivityRequest $activityRequest)
    {
        try {
            $certService = new CertificationService();
            return $certService->viewCertification($activityRequest);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to view certification: ' . $e->getMessage());
        }
    }

    public function rejectLraSra(Request $request, RecruitmentActivityRequest $activityRequest): RedirectResponse
    {
        $request->validate(['notes' => 'required|string|max:500']);

        $activityRequest->update([
            'status' => 'rejected',
            'notes' => $request->notes,
        ]);

        $type = $activityRequest->activity_type === 'lra' ? 'LRA' : 'SRA';
        $typeLabel = $activityRequest->activity_type === 'lra' ? 'Local Recruitment Activity' : 'Special Recruitment Activity';

        // Send rejection email to employer
        try {
            if ($activityRequest->employer && $activityRequest->employer->email) {
                \Illuminate\Support\Facades\Mail::to($activityRequest->employer->email)
                    ->send(new \App\Mail\RequestRejectedMail($activityRequest, $request->notes));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send rejection email: ' . $e->getMessage());
        }

        // Create in-app notification for employer
        if ($activityRequest->employer) {
            $this->notifyEmployer(
                $activityRequest->employer,
                'lra_sra_update',
                "{$type} Request Rejected",
                "Your {$typeLabel} request has been rejected. Reason: {$request->notes}"
            );
        }

        return back()->with('success', "{$type} request has been rejected and notification sent to employer.");
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
        $baseQuery = PesoClearance::query()->with(['user', 'issuedClearance']);

        $stats = [
            'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
            'active' => (clone $baseQuery)->where('status', 'active')->count(),
            'declined' => (clone $baseQuery)->where('status', 'declined')->count(),
            'total' => (clone $baseQuery)->count(),
        ];

        $clearances = (clone $baseQuery)
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 WHEN status = 'active' THEN 1 ELSE 2 END")
            ->orderByDesc('request_date')
            ->paginate(15);

        $latestClearance = (clone $baseQuery)
            ->orderByDesc('request_date')
            ->first();

        return view('admin.peso-clearances', compact('clearances', 'stats', 'latestClearance'));
    }

    public function generateClearanceDocument(Request $request, PesoClearance $clearance)
    {
        $validated = $request->validate([
            'residence_address' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
        ]);

        $issuedClearance = IssuedClearance::updateOrCreate(
            ['peso_clearance_id' => $clearance->id],
            [
                'user_id' => $clearance->user_id,
                'clearance_number' => $clearance->clearance_number,
                'company_name' => $validated['company_name'] ?? null,
                'residence_address' => $validated['residence_address'],
                'status' => 'saved',
                'issued_at' => now(),
            ]
        );

        $clearance->setAttribute('company_name', $issuedClearance->company_name);
        $clearance->setAttribute('residence_address', $issuedClearance->residence_address);

        $documentService = new PesoClearanceDocumentService();
        $documentPath = $documentService->generateClearanceDocument($clearance);

        if ($documentPath) {
            $documentService->saveClearanceDocumentPath($clearance, $documentPath);
            $issuedClearance->update(['document_path' => $documentPath]);

            if ($request->boolean('preview')) {
                return redirect()->route('admin.peso-clearances.view-document', $clearance)
                    ->with('success', 'Clearance certificate is ready for review.');
            }

            $downloadName = 'PESO-Clearance-' . ($clearance->clearance_number ?: $clearance->id) . '.pdf';

            return response()->download(storage_path('app/' . $documentPath), $downloadName);
        }

        return back()->with('error', 'Failed to generate clearance document.');
    }

    public function viewClearanceDocument(PesoClearance $clearance)
    {
        $clearance->loadMissing('user');

        $issuedClearance = IssuedClearance::where('peso_clearance_id', $clearance->id)->latest()->first();

        // Prefer explicit personal information (sex) if available
        $sexRecord = JobseekerPersonalInformation::query()
            ->where('user_id', $clearance->user_id)
            ->first();

        $sex = $sexRecord?->sex ?? $clearance->user?->jobseekerProfile?->gender ?? null;

        $possessivePronoun = 'their';
        $objectivePronoun = 'him/her';

        if ($sex) {
            $s = strtolower($sex);
            if (in_array($s, ['male', 'm', 'man'])) {
                $possessivePronoun = 'his';
                $objectivePronoun = 'him';
            } elseif (in_array($s, ['female', 'f', 'woman'])) {
                $possessivePronoun = 'her';
                $objectivePronoun = 'her';
            }
        }

        return view('admin.clearance-document-view', [
            'clearance' => $clearance,
            'autoResidenceAddress' => $this->formatAutoResidenceAddress($clearance),
            'residenceAddress' => $issuedClearance?->residence_address ?? $clearance->residence_address ?? '',
            'companyName' => $issuedClearance?->company_name ?? $clearance->company_name ?? '',
            'possessivePronoun' => $possessivePronoun,
            'objectivePronoun' => $objectivePronoun,
        ]);
    }

    public function downloadClearanceDocument(PesoClearance $clearance)
    {
        $issuedClearance = IssuedClearance::where('peso_clearance_id', $clearance->id)->latest()->first();
        $documentPath = $issuedClearance?->document_path ?: $clearance->document_path;

        if (!$documentPath || !Storage::disk('local')->exists($documentPath)) {
            return back()->with('error', 'Document not found.');
        }

        return Storage::download($documentPath, 'clearance-' . $clearance->clearance_number . '.pdf');
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

        $validated = $request->validate([
            'clearance_number' => ['nullable', 'string', 'max:255', 'unique:peso_clearances,clearance_number,' . $clearance->id],
            'issue_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date'],
            'residence_address' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
        ]);

        $providedNumber = trim((string) ($validated['clearance_number'] ?? ''));
        $clearanceNumber = $providedNumber !== '' ? $providedNumber : 'CLR-' . now()->format('YmdHis') . '-' . $clearance->id;

        $issueDate = isset($validated['issue_date']) ? Carbon::parse($validated['issue_date']) : now();
        $expiryDate = isset($validated['expiry_date']) ? Carbon::parse($validated['expiry_date']) : now()->addYear();

        $clearance->update([
            'status' => 'active',
            'clearance_number' => $clearanceNumber,
            'issue_date' => $issueDate,
            'expiry_date' => $expiryDate,
            'remarks' => $clearance->remarks,
        ]);

        $issuedClearance = IssuedClearance::updateOrCreate(
            ['peso_clearance_id' => $clearance->id],
            [
                'user_id' => $clearance->user_id,
                'clearance_number' => $clearanceNumber,
                'company_name' => $validated['company_name'] ?? $clearance->company_name ?? null,
                'residence_address' => $validated['residence_address'] ?? $clearance->residence_address ?? null,
                'status' => 'saved',
                'issued_at' => now(),
            ]
        );

        $clearance->setAttribute('company_name', $issuedClearance->company_name);
        $clearance->setAttribute('residence_address', $issuedClearance->residence_address);

        // Generate and store clearance document
        $documentService = new PesoClearanceDocumentService();
        $documentPath = $documentService->generateClearanceDocument($clearance);

        if ($documentPath) {
            $documentService->saveClearanceDocumentPath($clearance, $documentPath);
            $issuedClearance->update(['document_path' => $documentPath]);
        }

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

        return redirect()
            ->route('admin.peso-clearances.view-document', $clearance)
            ->with('success', 'PESO clearance has been issued successfully.');
    }

    public function declinePesoClearance(Request $request, PesoClearance $clearance): RedirectResponse
    {
        if ($clearance->status !== 'pending') {
            return back()->with('warning', 'Only pending clearance requests can be declined.');
        }

        $clearance->update([
            'status' => 'declined',
        ]);

        return back()->with('success', 'PESO clearance request has been declined.');
    }

    private function formatAutoResidenceAddress(PesoClearance $clearance): string
    {
        $baseQuery = JobseekerAddress::query()
            ->where('user_id', $clearance->user_id)
            ->whereIn('type', ['present', 'permanent']);

        $presentAddress = (clone $baseQuery)
            ->where('type', 'present')
            ->latest('updated_at')
            ->first()
            ?? (clone $baseQuery)
                ->where('type', 'permanent')
                ->latest('updated_at')
                ->first()
            ?? JobseekerAddress::query()
                ->where('user_id', $clearance->user_id)
                ->latest('updated_at')
                ->first();

        $parts = array_filter([
            $presentAddress?->barangay,
            $presentAddress?->municipality,
            $presentAddress?->province,
        ], fn ($value) => filled($value));

        return $parts ? ucwords(strtolower(implode(', ', $parts))) : 'Manolo Fortich, Bukidnon';
    }

    /**
     * Auto-generate PESO clearances for jobseekers without one
     */
    public function autoGenerateClearances(Request $request): RedirectResponse
    {
        $service = new PesoClearanceService();
        $result = $service->generateForAllJobseekers();

        $message = sprintf(
            'Successfully created %d auto-generated PESO clearances. %d jobseekers already have clearances.',
            $result['count'],
            count($result['skipped'])
        );

        return back()->with('success', $message);
    }

    /**
     * Auto-generate clearance for specific users
     */
    public function autoGenerateClearancesForUsers(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'required|integer|exists:users,id',
        ]);

        $service = new PesoClearanceService();
        $result = $service->generateForMultipleJobseekers($validated['user_ids']);

        $message = sprintf(
            'Successfully created %d auto-generated PESO clearances.',
            $result['count']
        );

        if (!empty($result['skipped'])) {
            $message .= sprintf(' %d users skipped (already have clearances or not jobseekers).', count($result['skipped']));
        }

        return back()->with('success', $message);
    }

    /**
     * Show PESO clearance management dashboard with statistics
     */
    public function pesoClearanceManagement(): View
    {
        $service = new PesoClearanceService();
        $stats = $service->getStatistics();

        return view('admin.peso-clearance-management', compact('stats'));
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

    public function ofwSubmissions(Request $request): View
    {
        $filter = $request->query('filter', 'all');

        $submissions = OfwFormSubmission::query()
            ->with('user')
            ->when(in_array($filter, ['rfa', 'dmw'], true), fn ($query) => $query->where('form_type', $filter))
            ->when(in_array($filter, ['submitted', 'accepted'], true), fn ($query) => $query->where('status', $filter))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $ofwStats = [
            'all' => OfwFormSubmission::count(),
            'rfa' => OfwFormSubmission::where('form_type', 'rfa')->count(),
            'dmw' => OfwFormSubmission::where('form_type', 'dmw')->count(),
            'submitted' => OfwFormSubmission::where('status', 'submitted')->count(),
            'accepted' => OfwFormSubmission::where('status', 'accepted')->count(),
        ];

        return view('admin.ofw-submissions', compact('submissions', 'filter', 'ofwStats'));
    }

    public function downloadOfwSubmission(OfwFormSubmission $submission): StreamedResponse
    {
        abort_unless(Storage::exists($submission->pdf_path), 404);

        return Storage::download($submission->pdf_path, $submission->pdf_filename);
    }

    public function acceptOfwSubmission(OfwFormSubmission $submission): RedirectResponse
    {
        $submission->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        return back()->with('success', 'OFW request has been accepted.');
    }

    public function deleteOfwSubmission(OfwFormSubmission $submission): RedirectResponse
    {
        if (Storage::exists($submission->pdf_path)) {
            Storage::delete($submission->pdf_path);
        }

        $submission->delete();

        return back()->with('success', 'OFW submission has been deleted.');
    }

    // Associations
    public function associations(Request $request): View
    {
        $filter = $request->query('filter', 'all');

        $query = AssociationRequest::with('user')->latest();

        if ($filter === 'submitted') {
            $query->where('status', 'submitted');
        } elseif ($filter === 'accepted') {
            $query->where('status', 'accepted');
        } elseif ($filter === 'rejected') {
            $query->where('status', 'rejected');
        }

        $stats = [
            'all'       => AssociationRequest::count(),
            'submitted' => AssociationRequest::where('status', 'submitted')->count(),
            'accepted'  => AssociationRequest::where('status', 'accepted')->count(),
            'rejected'  => AssociationRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.associations', [
            'requests' => $query->paginate(15)->withQueryString(),
            'stats'    => $stats,
            'filter'   => $filter,
        ]);
    }

    public function acceptAssociationRequest(Request $request, AssociationRequest $associationRequest): RedirectResponse
    {
        $associationRequest->update(['status' => 'accepted']);

        return back()->with('success', 'Association request has been accepted.');
    }

    public function rejectAssociationRequest(Request $request, AssociationRequest $associationRequest): RedirectResponse
    {
        $associationRequest->update(['status' => 'rejected']);

        return back()->with('success', 'Association request has been rejected.');
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
