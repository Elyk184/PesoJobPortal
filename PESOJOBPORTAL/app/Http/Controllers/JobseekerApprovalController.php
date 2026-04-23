<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobseekerApprovalController extends Controller
{
    /**
     * Display list of pending jobseeker approvals
     */
    public function index(): View
    {
        $jobseekers = User::where('role', 'jobseeker')
            ->whereNull('is_approved')
            ->with(['profile', 'applications'])
            ->latest()
            ->paginate(15);

        return view('admin.jobseekers.approvals', [
            'jobseekers' => $jobseekers,
        ]);
    }

    /**
     * Show jobseeker details for approval
     */
    public function show(User $jobseeker): View
    {
        abort_if($jobseeker->role !== 'jobseeker', 403, 'Unauthorized');

        return view('admin.jobseekers.show', [
            'jobseeker' => $jobseeker->load('profile', 'applications'),
        ]);
    }

    /**
     * Approve jobseeker registration
     */
    public function approve(User $jobseeker): \Illuminate\Http\RedirectResponse
    {
        abort_if($jobseeker->role !== 'jobseeker', 403, 'Unauthorized');

        $jobseeker->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', "{$jobseeker->name} has been approved!");
    }

    /**
     * Reject jobseeker registration
     */
    public function reject(Request $request, User $jobseeker): \Illuminate\Http\RedirectResponse
    {
        abort_if($jobseeker->role !== 'jobseeker', 403, 'Unauthorized');

        $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500',
        ]);

        $jobseeker->update([
            'is_approved' => false,
            'rejection_reason' => $request->rejection_reason,
            'rejected_at' => now(),
            'rejected_by' => auth()->id(),
        ]);

        return back()->with('success', "{$jobseeker->name} has been rejected!");
    }
}
?>
