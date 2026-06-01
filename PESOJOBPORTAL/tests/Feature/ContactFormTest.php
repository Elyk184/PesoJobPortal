<?php

namespace Tests\Feature;

use App\Mail\ContactFormMessage;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    public function test_validates_required_contact_form_fields(): void
    {
        $response = $this->post(route('contact.submit'), []);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'subject',
            'message',
        ]);
    }

    public function test_sends_contact_form_message_to_configured_recipient(): void
    {
        Mail::fake();

        config()->set('services.contact_form.recipient', '20221230@nbsc.edu.ph');

        $payload = [
            'name' => 'Juan Dela Cruz',
            'email' => 'juan@example.com',
            'phone' => '09123456789',
            'subject' => 'Need help with registration',
            'message' => 'Hello PESO, I need assistance with account registration.',
        ];

        $response = $this->post(route('contact.submit'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('status', 'Your message has been sent successfully.');

        Mail::assertSent(ContactFormMessage::class, function (ContactFormMessage $mail) use ($payload) {
            return $mail->hasTo('20221230@nbsc.edu.ph')
                && $mail->contactData['name'] === $payload['name']
                && $mail->contactData['email'] === $payload['email']
                && $mail->contactData['subject'] === $payload['subject']
                && $mail->contactData['message'] === $payload['message'];
        });
    }
}
