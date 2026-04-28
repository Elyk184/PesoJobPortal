<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

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
    }

    private function adminSidebarCounts(): array
    {
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
        ];
    }
}
