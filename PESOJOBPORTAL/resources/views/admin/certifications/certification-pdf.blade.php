<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ strtoupper($activity_request->activity_type) }} Certification</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        @page {
            size: A4;
            margin: 0;
        }

        html {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            line-height: 1;
            color: #000;
            background: #fff;
            padding: 0.5in 0.5in 0.5in 0.5in;
            min-height: 297mm;
            margin: 0 auto;
        }

        /* ── FIXED FOOTER PINNED TO BOTTOM OF PAGE ── */
        .page-footer {
            position: fixed;
            bottom: 1in;
            left: 1in;
            right: 1in;
            text-align: center;
        }

        /* ── TAGLINE ── */
        .qr-image {
            display: block;
            width: 100%;
            height: 100px;
            margin: 0 auto 8px auto;
            object-fit: contain;
        }

        .tagline {
            text-align: center;
            font-style: italic;
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 5px 0;
            letter-spacing: 0.02em;
        }

        .tagline-sub {
            text-align: center;
            font-size: 7px;
            letter-spacing: 0.2em;
            color: #333;
            margin-bottom: 3px;
        }

        /* ── FOOTER CONTACT ROW ── */
        .footer {
            border-top: 1px solid #000;
            padding-top: 4px;
            margin-top: 5px;
        }

        .contact-table {
            width: auto;
            margin: 0 auto;
            border-collapse: collapse;
            table-layout: auto;
            display: inline-table;
        }

        .contact-table td {
            font-size: 10px;
            white-space: nowrap;
            vertical-align: middle;
            padding: 0;
        }

        .contact-item {
            padding: 0 6px;
        }

        .contact-item-table {
            border-collapse: collapse;
            display: inline-table;
        }

        .contact-item-table td {
            padding: 0;
            vertical-align: middle;
        }

        .contact-item-table td.icon-cell {
            width: 20px;
            padding-right: 4px;
            text-align: center;
        }

        .contact-item-table td.icon-cell img {
            width: 24px;
            height: 24px;
            display: inline-block;
            vertical-align: middle;
        }

        .contact-item-text {
            line-height: 1;
        }

        .contact-table td.sep-cell {
            padding: 0 6px;
            color: #000;
        }

        /* ── DECORATIVE BOTTOM ── */
        .decor-bottom-wrapper {
            text-align: center;
            margin-top: 12px;
        }

        .decor-bottom {
            width: 92.3mm;
            height: 18px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }

        /* ── MAIN CONTENT AREA ── */
        .container {
            width: calc(210mm - 1in);
            margin: 0 auto;
        }

        /* ── HEADER ── */
        .header-top {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .header-logo-cell {
            display: table-cell;
            width: 110px;
            vertical-align: middle;
            text-align: center;
        }

        .header-center-cell {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .header-logo-left,
        .header-logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .gov-line  { font-size: 14px; line-height: 1.3; }
        .gov-main  { font-size: 16px; font-weight: bold; letter-spacing: 0.04em; text-transform: uppercase; line-height: 1.35; }
        .gov-peso  { font-size: 22px; font-weight: bold; letter-spacing: 0.03em; text-transform: uppercase; margin-top: 2px; }

        /* ── DECORATIVE TOP ── */
        .decor-wrapper {
            margin: 5px 0 65px 0;
            text-align: center;
        }

        .decor-top {
            width: 92.3mm;
            height: 18px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }

        /* ── TITLE ── */
        .title {
            font-size: 30px;
            font-weight: bold;
            letter-spacing: 0.20em;
            text-align: center;
            text-transform: uppercase;
            margin: 14px 0 14px 0;
        }

        /* ── CONTENT ── */
        .content {
            font-size: 12px;
            line-height: 1;
            width: 86%;
            margin: 0 auto;
            text-align: left;
        }

        .salutation { font-weight: bold; margin: 45px 0 35px; text-align: left; }

        .cert-paragraph {
            text-align: justify;
            text-indent: 0.5in;
            margin-bottom: 12px;
            line-height: 1;
        }

        .location-block {
            text-align: justify;
            line-height: 1;
            margin-top: 10px;
        }

        /* ── SIGNATURES ── */
        .signature-container {
            display: table;
            width: 100%;
            margin-top: 85px;
            border-collapse: collapse;
        }

        .sig-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-top: 0;
        }

        .sig-col.left  { text-align: left; }

        .sig-col.right { padding-top: 160px; text-align: right; }

        .sig-label {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 50px;
            display: block;
        }

        .sig-line {
            border-top: 1px solid #000;
            margin-bottom: 3px;
        }

        .sig-col.left  .sig-line { width: 75%; }
        .sig-col.right .sig-line { width: 75%; margin-left: auto; }

        .sig-name  { font-size: 12px; font-weight: bold; }
        .sig-title { font-size: 12px; }

        .sig-col.left .sig-name,
        .sig-col.left .sig-title { text-align: left; max-width: 75%; }
        .sig-col.right .sig-name,
        .sig-col.right .sig-title { text-align: right; }
    </style>
</head>
<body>

    <!-- ── FIXED FOOTER (always pinned to bottom of A4) ── -->
    <div class="page-footer">
        <img src="{{ public_path('images/TestQR.png') }}" alt="QR Code" class="qr-image">
        <div class="tagline">"Lupad Manolo Fortich"</div>
        <div class="tagline-sub">SOAR HIGH MANOLO FORTICH</div>
        <div class="footer">
            <table class="contact-table">
                <tr>
                    <td class="contact-item">
                        <table class="contact-item-table">
                            <tr>
                                <td class="icon-cell">
                                    <img src="{{ public_path('images/email.png') }}" alt="Email">
                                </td>
                                <td class="contact-item-text">peso@manolofortich.gov.ph</td>
                            </tr>
                        </table>
                    </td>

                    <td class="sep-cell">|</td>

                    <td class="contact-item">
                        <table class="contact-item-table">
                            <tr>
                                <td class="icon-cell">
                                    <img src="{{ public_path('images/phone.png') }}" alt="Phone">
                                </td>
                                <td class="contact-item-text">0955-9546-049</td>
                            </tr>
                        </table>
                    </td>

                    <td class="sep-cell">|</td>

                    <td class="contact-item">
                        <table class="contact-item-table">
                            <tr>
                                <td class="icon-cell">
                                    <img src="{{ public_path('images/facebook.png') }}" alt="Facebook">
                                </td>
                                <td class="contact-item-text">www.facebook.com/LGU Manolo Fortich</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="decor-bottom-wrapper">
            <img src="{{ public_path('images/decor.png') }}" alt="" class="decor-bottom">
        </div>
    </div>

    <!-- ── MAIN CONTENT ── -->
    <div class="container">

        <!-- HEADER -->
        <div class="header-top">
            <div class="header-logo-cell">
                <img src="{{ public_path('images/manolo fortich seal.png') }}"
                     alt="Manolo Fortich Seal" class="header-logo-left">
            </div>
            <div class="header-center-cell">
                <div class="gov-line">Republic of the Philippines</div>
                <div class="gov-line">Province of Bukidnon</div>
                <div class="gov-main">MUNICIPALITY OF MANOLO FORTICH</div>
                <div class="gov-peso">PUBLIC EMPLOYMENT SERVICE OFFICE</div>
            </div>
            <div class="header-logo-cell">
                <img src="{{ public_path('images/BAGONG-PILIPINAS-LOGO.png') }}"
                     alt="Bagong Pilipinas" class="header-logo">
            </div>
        </div>

        <!-- DECORATIVE TOP -->
        <div class="decor-wrapper">
            <img src="{{ public_path('images/decor.png') }}" alt="" class="decor-top">
        </div>

        <!-- TITLE -->
        <div class="title">CERTIFICATION</div>

        <!-- CONTENT -->
        <div class="content">

            <div class="salutation">TO WHOM IT MAY CONCERN:</div>

            @php
                $startDate  = $activity_request->recruitment_start_date
                                ? \Carbon\Carbon::parse($activity_request->recruitment_start_date)
                                : null;

                $endDate    = $activity_request->recruitment_end_date
                                ? \Carbon\Carbon::parse($activity_request->recruitment_end_date)
                                : null;

                $numDays    = $activity_request->recruitment_days
                                ?? ($startDate && $endDate
                                    ? $startDate->diffInDays($endDate) + 1
                                    : 1);

                $numberWords = [
                    1 => 'ONE', 2 => 'TWO', 3 => 'THREE', 4 => 'FOUR', 5 => 'FIVE',
                    6 => 'SIX', 7 => 'SEVEN', 8 => 'EIGHT', 9 => 'NINE', 10 => 'TEN',
                ];
                $numDaysWord = $numberWords[$numDays] ?? strtoupper((string) $numDays);

                if ($startDate && $endDate && $startDate->ne($endDate)) {
                    $dateDisplay = $startDate->format('M d, Y') . ' to ' . $endDate->format('M d, Y');
                } elseif ($startDate) {
                    $dateDisplay = $startDate->format('M d, Y');
                } elseif ($activity_request->activity_date) {
                    $dateDisplay = $activity_request->activity_date->format('M d, Y');
                } else {
                    $dateDisplay = 'TBD';
                }
            @endphp

            <div class="cert-paragraph">
                <strong>THIS IS TO CERTIFY THAT</strong> <strong>{{ $company_profile?->company_name ?? $employer_name }}</strong>,
                a registered {{ $company_profile?->line_of_business ?? 'business' }} company in the Philippines
                @if(!empty($company_profile?->established_year))
                    established in {{ $company_profile->established_year }},
                @endif
                has been granted
                the permit and authority to conduct recruitment of applicants for local employment for
                <strong>{{ $numDaysWord }} ({{ $numDays }}) day(s)</strong> valid on
                <strong>{{ $dateDisplay }}</strong>
                at Lobby area in Ground floor of Manolo Fortich PESO office, Located in,
                Gen. Andres Bonifacio St. Cor. Albarece St. Brgy. Tankulan, Manolo Fortich, Bukidnon.
                8703. (in front of Tankulan Flea Market - Taboan).
            </div>

            <div class="cert-paragraph">
                This certifies that the office of the undersigned poses no objection's whatsoever relative to conduct
                of said activities.
            </div>

            <div class="cert-paragraph">
                This certification is issued upon the request of the above agency for whatever legal intent or purpose
                this may serve.
            </div>

            <div class="location-block">
                Given this <strong>{{ $activity_request->created_at?->format('jS') ?? now()->format('jS') }}</strong>
                day of <strong>{{ $activity_request->created_at?->format('F Y') ?? now()->format('F Y') }}</strong>
                at Lobby area in Ground floor of Manolo Fortich PESO Office,
                Located in, Gen. Andres Bonifacio St. Cor. Albarece St. Brgy. Tankulan, Manolo Fortich, Bukidnon.
            </div>

        </div>

        <!-- SIGNATURES -->
        <div class="signature-container">
            <div class="sig-col left">
                <span class="sig-label">ATTESTED BY:</span>
                <div class="sig-name">LORRAINE A. REQUINTON</div>
                <div class="sig-title">PESO Manager</div>
            </div>
            <div class="sig-col right">
                <span class="sig-label">NOTED BY:</span>
                <div class="sig-name">ROGELIO S. QUIÑO</div>
                <div class="sig-title">Municipal Mayor</div>
            </div>
        </div>

    </div>

</body>
</html>
