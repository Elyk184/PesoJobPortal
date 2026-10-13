<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMessage;
use App\Models\ContactMessage;
use App\Models\PortalNotification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
            'name'    => ['required', 'string', 'max:120'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:40'],
            'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $contactMessage = ContactMessage::create($validated);

        // Notify all admins via PortalNotification
        $notification = PortalNotification::create([
            'title'      => 'New Contact Message: ' . $validated['subject'],
            'message'    => 'From ' . $validated['name'] . ' (' . $validated['email'] . '): ' . mb_substr($validated['message'], 0, 120) . (mb_strlen($validated['message']) > 120 ? '…' : ''),
            'created_by' => null,
        ]);

        User::where('role', 'admin')->each(function (User $admin) use ($notification) {
            UserNotification::create([
                'user_id'                => $admin->id,
                'portal_notification_id' => $notification->id,
                'read_at'                => null,
            ]);
        });

        // Send email notification to admin
        try {
            Mail::to(config('mail.contact_recipient', env('CONTACT_FORM_RECIPIENT_EMAIL')))
                ->send(new ContactFormMessage($validated));
        } catch (\Throwable $e) {
            Log::error('Failed to send contact form email: ' . $e->getMessage());
        }

        return back()->with('status', 'Your message has been sent successfully.');
    }
}
