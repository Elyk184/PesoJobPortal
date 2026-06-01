@component('mail::message')
# {{ $activityType }} Request - Approved

Hello {{ $employerName }},

Great news! Your **{{ $activityType }} ({{ ucfirst(substr($activityType, 0, 3)) }})** request has been **APPROVED** by the Manolo Fortich Public Employment Service Office.

## Approval Details

- **Status:** Approved
- **Approved On:** {{ $approvedAt->format('F d, Y H:i') }}
- **Office:** Manolo Fortich Public Employment Service Office

## Next Steps

Your certification document has been attached to your previous email. You can now proceed with your recruitment activities as outlined in the request.

If you have any questions or need further assistance, please contact the Manolo Fortich PESO Office.

---

**Contact Information:**
- Email: peso@manolofortich.gov.ph
- Phone: 0917-808-676

Thank you for choosing our services!

@component('mail::footer')
© {{ date('Y') }} Manolo Fortich Public Employment Service Office. All rights reserved.
@endcomponent

@endcomponent
