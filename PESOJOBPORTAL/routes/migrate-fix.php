<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Route::get('/admin/fix-migrations', function () {
    try {
        // Mark the conflicting migration as completed
        DB::table('migrations')->insert([
            'migration' => '2026_04_22_000001_create_company_profiles_table',
            'batch' => 9
        ]);

        // Run remaining migrations
        Artisan::call('migrate', ['--force' => true]);
        $output = Artisan::output();

        return "<pre>" . htmlspecialchars($output) . "</pre>";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
