<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\PesoJob;
use App\Models\JobApplication;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{
    public function index(): View
    {
        $employmentTypes = [
            'full_time' => 'Full-time',
            'part_time' => 'Part-time',
            'contract' => 'Contract',
            'temporary' => 'Temporary',
            'internship' => 'Internship',
            'freelance' => 'Freelance',
        ];

        PesoJob::archiveExpiredPostings();

        $keyword = trim((string) request()->query('keyword', ''));
        $location = trim((string) request()->query('location', ''));
        $employmentType = trim((string) request()->query('employment_type', ''));

        $jobsQuery = PesoJob::query()
            ->activeApproved();

        if ($keyword !== '') {
            $jobsQuery->where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('position', 'like', '%' . $keyword . '%')
                    ->orWhere('employer_name', 'like', '%' . $keyword . '%')
                    ->orWhere('location', 'like', '%' . $keyword . '%')
                    ->orWhere('job_type', 'like', '%' . $keyword . '%');
            });
        }

        if ($location !== '') {
            $jobsQuery->where('location', 'like', '%' . $location . '%');
        }

        if ($employmentType !== '' && $employmentType !== 'all' && array_key_exists($employmentType, $employmentTypes)) {
            $jobsQuery->where('job_type', $employmentType);
        }

        $jobs = $jobsQuery
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $activeJobsCount = PesoJob::query()
            ->activeApproved()
            ->count();

        $totalApplicants = JobApplication::query()->distinct()->count('user_id');
        $totalApplications = JobApplication::count();

        return view('jobs', compact('jobs', 'activeJobsCount', 'totalApplicants', 'totalApplications', 'employmentTypes', 'employmentType', 'keyword', 'location'));
    }
}
?>

