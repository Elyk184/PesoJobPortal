@component('mail::message')
# {{ $activityType }} Request - Rejected

Hello {{ $employerName }},

We regret to inform you that your **{{ $activityType }} ({{ ucfirst(substr($activityType, 0, 3)) }})** request has been **REJECTED** by the Manolo Fortich Public Employment Service Office.

## Rejection Reason

{{ $reason }}

## What To Do Next

Please review the reason for rejection above and submit a new request with the necessary corrections or clarifications. Our team is ready to assist you.

If you have questions about the rejection or need clarification, please contact the Manolo Fortich PESO Office.

---

**Contact Information:**
- Email: peso@manolofortich.gov.ph
- Phone: 0917-808-676

We look forward to assisting you with your next request.

@component('mail::footer')
© {{ date('Y') }} Manolo Fortich Public Employment Service Office. All rights reserved.
@endcomponent

@endcomponent
