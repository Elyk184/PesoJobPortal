<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class BrevoMailService
{
    public function sendTransactionalEmail(string $toEmail, ?string $toName, string $subject, string $htmlContent, ?string $textContent = null): void
    {
        $apiKey = config('services.brevo.key');

        if (! $apiKey) {
            throw new RuntimeException('Brevo API key is not configured.');
        }

        $payload = [
            'subject' => $subject,
            'htmlContent' => $htmlContent,
            'sender' => [
                'email' => config('mail.from.address'),
                'name' => config('mail.from.name'),
            ],
            'to' => [[
                'email' => $toEmail,
                'name' => $toName,
            ]],
        ];

        if ($textContent !== null) {
            $payload['textContent'] = $textContent;
        }

        Http::withHeaders([
            'api-key' => $apiKey,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', $payload)->throw();
    }
}