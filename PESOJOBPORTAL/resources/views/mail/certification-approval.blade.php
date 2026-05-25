@component('mail::message')
# {{ $activityType }} Certification - Approved

Hello {{ $employerName }},

Your **{{ $activityType }} ({{ ucfirst(substr($activityType, 0, 3)) }})** certification has been **approved** and is now ready for use.

## Certification Details

- **Generated Date:** {{ $certificationDate->format('F d, Y H:i') }}
- **Status:** Approved
- **Office:** Manolo Fortich Public Employment Service Office

## Next Steps

Please review the attached certification document. This certificate is valid for the specified recruitment activity period as mentioned in the document.

If you have any questions or need further assistance, please contact the Manolo Fortich PESO Office.

---

**Contact Information:**
- Email: peso@manolofortich.gov.ph
- Phone: 0917-808-676

@component('mail::footer')
© {{ date('Y') }} Manolo Fortich Public Employment Service Office. All rights reserved.
@endcomponent

@endcomponent
