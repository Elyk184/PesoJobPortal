<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Models\ContactSubmissionMessage;
use App\Models\PortalNotification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('contact');
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        DB::transaction(function () use ($validated) {
            $portalNotification = PortalNotification::query()->create([
                'title' => 'New Contact Form Message',
                'message' => sprintf(
                    '%s (%s) submitted a contact form message about "%s".',
                    $validated['name'],
                    $validated['email'],
                    $validated['subject']
                ),
                'created_by' => null,
            ]);

            $submission = ContactSubmission::query()->create([
                'reference_code' => 'TMP',
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'status' => 'open',
                'last_message_at' => now(),
                'portal_notification_id' => $portalNotification->id,
            ]);

            $submission->update([
                'reference_code' => sprintf('INQ-%s-%06d', now()->format('Y'), $submission->id),
            ]);

            ContactSubmissionMessage::query()->create([
                'contact_submission_id' => $submission->id,
                'sender_type' => 'user',
                'message' => $validated['message'],
                'sent_by_user_id' => null,
            ]);

            $adminIds = User::query()
                ->where('role', 'admin')
                ->pluck('id');

            if ($adminIds->isNotEmpty()) {
                $rows = $adminIds->map(fn (int $adminId) => [
                    'user_id' => $adminId,
                    'portal_notification_id' => $portalNotification->id,
                    'read_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])->all();

                UserNotification::query()->insert($rows);
            }
        });

        return back()->with('status', 'Your message has been sent successfully and the admin has been notified.');
    }
}
