<?php

namespace App\Http\Controllers;

use App\Models\PortalNotification;
use App\Models\User;
use App\Models\UserNotification;
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
}
