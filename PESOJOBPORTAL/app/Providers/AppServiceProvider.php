<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private function chatbotLimitResponse(array $headers)
    {
        $retryAfter = (int) ($headers['Retry-After'] ?? 60);

        return response()->json([
            'reply' => 'You are sending messages too quickly. Please wait before sending another message.',
            'cooldown_seconds' => $retryAfter,
        ], 429, $headers);
    }

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
            if ($request->user()) {
                $key = 'user:' . $request->user()->id;

                return [
                    Limit::perMinute(12)->by($key)->response(function (Request $request, array $headers) {
                        return $this->chatbotLimitResponse($headers);
                    }),
                    Limit::perHour(120)->by($key),
                ];
            }

            $userAgent = substr((string) $request->userAgent(), 0, 180);
            $guestKey = 'guest:' . sha1($request->ip() . '|' . $userAgent);

            return [
                Limit::perMinute(5)->by($guestKey)->response(function (Request $request, array $headers) {
                    return $this->chatbotLimitResponse($headers);
                }),
                Limit::perHour(40)->by($guestKey),
            ];
        });
    }
}
