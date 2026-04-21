<?php

namespace App\Http\Controllers;

use App\Models\PortalNotification;
use App\Models\User;
use App\Models\UserNotification;
use App\Services\JobRecommendationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $recentNotifications = PortalNotification::query()
            ->latest()
            ->with('creator:id,name')
            ->limit(8)
            ->get();

        $jobseekerCount = User::query()
            ->where('role', 'jobseeker')
            ->count();

        return view('dashboard.admin', [
            'recentNotifications' => $recentNotifications,
            'jobseekerCount' => $jobseekerCount,
        ]);
    }

    public function storeNotification(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $notification = PortalNotification::query()->create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'created_by' => Auth::id(),
        ]);

        $now = now();
        $jobseekerIds = User::query()
            ->where('role', 'jobseeker')
            ->pluck('id');

        $payload = $jobseekerIds->map(function ($jobseekerId) use ($notification, $now) {
            return [
                'user_id' => $jobseekerId,
                'portal_notification_id' => $notification->id,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        })->all();

        if (! empty($payload)) {
            UserNotification::query()->insert($payload);
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'Notification sent to ' . count($payload) . ' jobseeker(s).');
    }

    public function pushRecommendations(JobRecommendationService $recommendationService): RedirectResponse
    {
        $jobseekers = User::query()
            ->where('role', 'jobseeker')
            ->with('profile')
            ->get();

        $notifiedCount = 0;

        foreach ($jobseekers as $jobseeker) {
            $recommendations = $recommendationService->recommendForUser($jobseeker, 3);

            if ($recommendations->isEmpty()) {
                continue;
            }

            $summary = $recommendations
                ->map(function (array $item) {
                    $title = (string) data_get($item, 'job.title', 'Untitled Job');
                    $score = (int) data_get($item, 'score', 0);

                    return $title . ' (' . $score . '% match)';
                })
                ->implode('; ');

            $notification = PortalNotification::query()->create([
                'title' => 'New Job Recommendations for You',
                'message' => 'Based on your profile, we found jobs that fit your skillset: ' . $summary,
                'created_by' => Auth::id(),
            ]);

            UserNotification::query()->create([
                'user_id' => $jobseeker->id,
                'portal_notification_id' => $notification->id,
            ]);

            $notifiedCount++;
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'Recommendation notifications sent to ' . $notifiedCount . ' jobseeker(s).');
    }
}
