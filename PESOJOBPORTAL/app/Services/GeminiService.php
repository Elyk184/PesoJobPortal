<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    /**
     * Send a prompt to Gemini and return the first text reply.
     */
    public function generatedContent(string $prompt): string
    {
        $apiKey = config('services.gemini.key');
        $endpoint = config('services.gemini.endpoint');

        if (!$apiKey || !$endpoint) {
            return 'error: Gemini API is not configured. Set GEMINI_API_KEY and GEMINI_ENDPOINT in .env.';
        }

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
        ];

        try {
            $maxAttempts = 3;
            $delayMs = 500;
            $response = null;

            for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post($endpoint . '?key=' . $apiKey, $payload);

                if ($response->successful()) {
                    break;
                }

                // Retry on temporary throttling or overload.
                if (in_array($response->status(), [429, 503], true) && $attempt < $maxAttempts) {
                    usleep($delayMs * 1000);
                    $delayMs *= 2;
                    continue;
                }

                break;
            }

            if (!$response || $response->failed()) {
                return 'error: Gemini API call failed (' . $response?->status() . '). ' . $response?->body();
            }

            $data = $response->json();
            return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'error: Empty response from Gemini API.';
        } catch (\Throwable $e) {
            return 'error: ' . $e->getMessage();
        }
    }
}
