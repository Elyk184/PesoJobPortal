<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PesoJob;
use App\Models\JobApplication;
use App\Models\RecruitmentActivityRequest;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_jobs' => PesoJob::count(),
            'total_applications' => JobApplication::count(),
            'active_jobs' => PesoJob::where('status', 'active')->count(),
            'total_employers' => User::where('role', 'employer')->count(),
            'total_jobseekers' => User::where('role', 'jobseeker')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'pending_applications' => JobApplication::where('status', 'pending')->count(),
            'pending_job_approvals' => PesoJob::where('status', 'pending')->count(),
            'pending_lra_sra' => RecruitmentActivityRequest::where('status', 'pending')->count(),
            'pending_documents' => \DB::table('employer_documents')->where('status', 'pending')->count(),
        ];

        $recentUsers = User::latest()->limit(5)->get();
        $recentJobs = PesoJob::latest()->limit(5)->get();
        $recentApplications = JobApplication::with(['user', 'job'])->latest()->limit(5)->get();

        return view('dashboard.admin', compact('stats', 'recentUsers', 'recentJobs', 'recentApplications'));
    }

    // Employer Verification
    public function employerVerification(): View
    {
        $unverifiedEmployers = User::where('role', 'employer')
            ->where('is_employer_verified', false)
            ->with('profile')
            ->paginate(15);
        return view('admin.employer-verification', compact('unverifiedEmployers'));
    }

    // Job Approvals
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
            ->with('user')
            ->paginate(15);
        return view('admin.approvals.documents', compact('pendingDocuments'));
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
}
