<?php

namespace App\Providers;

use App\Models\PesoClearance;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // If DB is unreachable at boot, fall back to file sessions so StartSession middleware
        // doesn't attempt a DB query and cause an immediate exception (useful for local dev).
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            \Log::warning('Database unreachable during boot, falling back session driver to file', ['error' => $e->getMessage()]);
            config(['session.driver' => 'file']);
        }
        View::composer([
            'components.admin-wrapper',
            'components.admin.sidebar',
            'admin.layouts.sidebar',
            'dashboard.admin',
        ], function ($view) {
            $view->with('adminSidebarCounts', $this->adminSidebarCounts());
        });

        View::composer('admin.alerts-notifications', function ($view) {
            $view->with([
                'adminSidebarCounts' => $this->adminSidebarCounts(),
                'adminNotifications' => $this->adminNotifications(),
                'adminUnreadNotificationsCount' => $this->adminUnreadNotificationsCount(),
            ]);
        });
    }

    private function adminSidebarCounts(): array
    {
        $adminId = Auth::id();

        $adminUnreadNotifications = 0;

        if ($adminId && Auth::user()?->role === 'admin') {
            $adminUnreadNotifications = UserNotification::query()
                ->where('user_id', $adminId)
                ->whereNull('read_at')
                ->count();
        }

        return [
            'pendingEmployerVerification' => DB::table('company_profiles')
                ->where(function ($query) {
                    $query->whereIn('verification_status', ['under_review', 'rejected'])
                        ->orWhere(function ($query) {
                            $query->whereNotNull('business_permit_path')
                                ->whereNotNull('dti_sec_registration_path')
                                ->where('verification_status', '!=', 'verified');
                        });
                })
                ->count(),
            'pendingJobApprovals' => DB::table('peso_jobs')
                ->where('status', 'pending')
                ->whereNull('archived_at')
                ->count(),
            'pendingLraSraApprovals' => DB::table('recruitment_activity_requests')
                ->where('status', 'pending')
                ->count(),
            'pendingPesoClearances' => PesoClearance::query()
                ->where('status', 'pending')
                ->count(),
            'submittedOfwRequests' => DB::table('ofw_form_submissions')
                ->where('status', 'submitted')
                ->count(),
            'adminUnreadNotifications' => $adminUnreadNotifications,
        ];
    }

    private function adminNotifications()
    {
        $adminId = Auth::id();

        if (! $adminId || Auth::user()?->role !== 'admin') {
            return collect();
        }

        return UserNotification::query()
            ->where('user_id', $adminId)
            ->with('portalNotification')
            ->latest('id')
            ->limit(10)
            ->get();
    }

    private function adminUnreadNotificationsCount(): int
    {
        $adminId = Auth::id();

        if (! $adminId || Auth::user()?->role !== 'admin') {
            return 0;
        }

        return (int) UserNotification::query()
            ->where('user_id', $adminId)
            ->whereNull('read_at')
            ->count();
    }
}
