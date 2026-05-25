<?php

namespace App\Mail;

use App\Models\RecruitmentActivityRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public RecruitmentActivityRequest $activityRequest,
        public string $reason = ''
    ) {
    }

    public function envelope(): Envelope
    {
        $type = $this->activityRequest->activity_type === 'lra' ? 'LRA' : 'SRA';
        return new Envelope(
            subject: "Your {$type} Request Has Been Rejected",
        );
    }

    public function content(): Content
    {
        $type = $this->activityRequest->activity_type === 'lra' ? 'Local Recruitment Activity' : 'Special Recruitment Activity';

        return new Content(
            view: 'mail.request-rejected',
            with: [
                'employerName' => $this->activityRequest->employer?->name ?? 'Employer',
                'activityType' => $type,
                'reason' => $this->reason,
            ],
        );
    }
}
