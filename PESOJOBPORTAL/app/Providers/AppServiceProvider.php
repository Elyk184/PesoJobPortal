<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        RateLimiter::for('chatbot', function (Request $request) {
            $key = $request->user()
                ? 'user:' . $request->user()->id
                : 'ip:' . $request->ip();

            return [
                Limit::perMinute(8)->by($key)->response(function (Request $request, array $headers) {
                    return response()->json([
                        'reply' => 'You are sending messages too quickly. Please wait a minute and try again.',
                    ], 429, $headers);
                }),
                Limit::perHour(60)->by($key),
            ];
        });
    }
}
