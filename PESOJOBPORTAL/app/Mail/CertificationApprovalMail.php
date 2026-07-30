<?php

namespace App\Mail;

use App\Models\RecruitmentActivityRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CertificationApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public RecruitmentActivityRequest $activityRequest)
    {
    }

    public function envelope(): Envelope
    {
        $type = $this->activityRequest->activity_type === 'lra' ? 'LRA' : 'SRA';
        return new Envelope(
            subject: "Your {$type} Certification - Approved",
        );
    }

    public function content(): Content
    {
        $type = $this->activityRequest->activity_type === 'lra' ? 'Local Recruitment Activity' : 'Special Recruitment Activity';

        return new Content(
            view: 'mail.certification-approval',
            with: [
                'employerName' => $this->activityRequest->employer?->name ?? 'Employer',
                'activityType' => $type,
                'certificationDate' => $this->activityRequest->certification_generated_at,
            ],
        );
    }

    public function attachments(): array
    {
        if (!$this->activityRequest->certification_path) {
            return [];
        }

        $certPath = Storage::disk('public')->path($this->activityRequest->certification_path);

        if (!file_exists($certPath)) {
            return [];
        }

        return [
            Attachment::fromPath($certPath)
                ->as('LRA_SRA_Certification.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
