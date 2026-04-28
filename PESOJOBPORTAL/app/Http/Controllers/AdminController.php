<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PesoJob;
use App\Models\JobApplication;
use App\Models\PesoClearance;
use App\Models\RecruitmentActivityRequest;
use App\Models\CompanyProfile;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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
            'pending_documents' => \DB::table('employer_documents')->where('status', 'pending')->count(),
        ];

        $recentUsers = User::latest()->limit(5)->get();
        $recentJobs = PesoJob::notArchived()->latest()->limit(5)->get();
        $recentApplications = JobApplication::with(['user', 'job'])->latest()->limit(5)->get();

        return view('dashboard.admin', compact('stats', 'recentUsers', 'recentJobs', 'recentApplications'));
    }

    // Employer Verification
    public function employerVerification(): View
    {
        $companyProfiles = CompanyProfile::whereIn('verification_status', ['pending', 'under_review'])
            ->with('employer')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.employer-verification', compact('companyProfiles'));
    }

    public function viewCompanyProfile(CompanyProfile $companyProfile): View
    {
        $companyProfile->load('employer');
        return view('admin.employer-verification-detail', compact('companyProfile'));
    }

    public function approveCompanyProfile(Request $request, CompanyProfile $companyProfile): RedirectResponse
    {
        $companyProfile->update([
            'verification_status' => 'verified',
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        if ($companyProfile->employer) {
            $companyProfile->employer->update(['is_employer_verified' => true]);
        }

        return back()->with('success', "Company profile '{$companyProfile->company_name}' has been verified and approved.");
    }

    public function rejectCompanyProfile(Request $request, CompanyProfile $companyProfile): RedirectResponse
    {
        $request->validate(['verification_notes' => 'required|string|max:500']);

        $companyProfile->update([
            'verification_status' => 'rejected',
            'verification_notes' => $request->verification_notes,
            'verified_by' => auth()->id(),
        ]);

        return back()->with('warning', "Company profile '{$companyProfile->company_name}' has been rejected.");
    }

    public function jobApprovals(): View
    {
        $pendingJobs = PesoJob::where('status', 'pending')->with('employer')->paginate(15);
        return view('admin.approvals.jobs', compact('pendingJobs'));
    }

    public function viewJob(PesoJob $job): View
    {
        $job->load(['employer', 'approver', 'applications']);
        return view('admin.approvals.job-detail', compact('job'));
    }

    public function approveJob(Request $request, PesoJob $job): RedirectResponse
    {
        $job->update([
            'status' => 'active',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', "Job '{$job->title}' has been approved and is now active.");
    }

    public function rejectJob(Request $request, PesoJob $job): RedirectResponse
    {
        $request->validate(['rejection_reason' => 'required|string|max:500']);

        $job->update([
            'status' => 'draft',
            'rejection_reason' => $request->rejection_reason,
        ]);

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
            'approved_by' => auth()->id(),
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

    // Document Verification
    public function documentVerification(): View
    {
        $pendingDocuments = \DB::table('employer_documents')
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

    public function issuePesoClearance(Request $request, PesoClearance $clearance): RedirectResponse
    {
        if ($clearance->status !== 'pending') {
            return back()->with('warning', 'Only pending clearance requests can be issued.');
        }

        $clearance->update([
            'status' => 'active',
            'clearance_number' => 'CLR-' . now()->format('YmdHis') . '-' . $clearance->id,
            'issue_date' => now(),
            'expiry_date' => now()->addYear(),
            'remarks' => $clearance->remarks,
        ]);

        return back()->with('success', 'PESO clearance has been issued successfully.');
    }

    public function approveDocument(Request $request, $documentId): RedirectResponse
    {
        \DB::table('employer_documents')
            ->where('id', $documentId)
            ->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

        return back()->with('success', 'Document has been approved.');
    }

    public function rejectDocument(Request $request, $documentId): RedirectResponse
    {
        $request->validate(['notes' => 'required|string|max:500']);

        \DB::table('employer_documents')
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
        $admin = auth()->user();
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $admin = auth()->user();

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($admin->profile_photo && \Storage::disk('public')->exists($admin->profile_photo)) {
                \Storage::disk('public')->delete($admin->profile_photo);
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
