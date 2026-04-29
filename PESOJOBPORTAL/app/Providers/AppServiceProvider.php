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
        View::composer([
            'components.admin-wrapper',
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
            'pendingPesoClearances' => PesoClearance::query()
                ->where('status', 'pending')
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
