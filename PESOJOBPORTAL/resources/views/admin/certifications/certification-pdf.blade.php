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
            line-height: 1.5;
            color: #000;
            background: #fff;
            /* 1.5 inch margins on all sides via padding */
            padding: 1.5in 1.5in 1.5in 1.5in;
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
        }

        /* ── FIXED FOOTER PINNED TO BOTTOM OF PAGE ── */
        .page-footer {
            position: fixed;
            bottom: 1.5in;
            left: 1.5in;
            right: 1.5in;
        }

        /* ── TAGLINE ── */
        .tagline {
            text-align: center;
            font-style: italic;
            font-size: 13px;
            font-weight: 600;
            margin: 0 0 1px 0;
            letter-spacing: 0.02em;
        }

        .tagline-sub {
            text-align: center;
            font-size: 7.5px;
            letter-spacing: 0.2em;
            color: #333;
            margin-bottom: 3px;
        }

        /* ── FOOTER CONTACT ROW ── */
        .footer {
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }

        .contact-row {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .contact-item {
            display: table-cell;
            font-size: 10px;
            white-space: nowrap;
            vertical-align: middle;
            text-align: center;
        }

        .contact-item:first-child { text-align: left; }
        .contact-item:last-child  { text-align: right; }

        .contact-icon {
            font-size: 12px;
            margin-right: 3px;
        }

        /* ── DECORATIVE BOTTOM ── */
        .decor-bottom-wrapper {
            text-align: center;
            margin-top: 4px;
        }

        .decor-bottom {
            width: 50%;
            height: 18px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }

        /* ── MAIN CONTENT AREA ── */
        .container {
            width: 100%;
        }

        /* ── HEADER ── */
        .header-top {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .header-logo-cell {
            display: table-cell;
            width: 90px;
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
            width: 80px;
            height: 80px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .gov-line  { font-size: 10px; line-height: 1.3; }
        .gov-main  { font-size: 12.5px; font-weight: bold; letter-spacing: 0.04em; text-transform: uppercase; line-height: 1.35; }
        .gov-peso  { font-size: 15px; font-weight: bold; letter-spacing: 0.03em; text-transform: uppercase; margin-top: 2px; }

        /* ── DECORATIVE TOP ── */
        .decor-wrapper {
            margin: 5px 0 0 0;
            text-align: center;
        }

        .decor-top {
            width: 50%;
            height: 18px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }

        /* ── TITLE ── */
        .title {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 0.18em;
            text-align: center;
            text-transform: uppercase;
            margin: 14px 0 14px 0;
        }

         /* ── CONTENT ── */
        .content { font-size: 12px; line-height: 1.55; text-align: center; }

        .salutation { font-weight: bold; margin-bottom: 10px; text-align: center; }

        .cert-paragraph {
            text-align: center;
            margin-bottom: 8px;
            line-height: 1.55;
        }

        .location-block {
            text-align: center;
            line-height: 1.55;
            margin-top: 10px;
        }

        /* ── SIGNATURES ── */
        .signature-container {
            display: table;
            width: 100%;
            margin-top: 18px;
            border-collapse: collapse;
        }

        .sig-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-top: 0;
        }

        .sig-col.right { padding-top: 60px; text-align: center; }
        .sig-col.left  { text-align: left; }

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
        .sig-col.right .sig-line { width: 80%; margin: 0 auto 3px auto; }

        .sig-name  { font-size: 12px; font-weight: bold; text-align: center; }
        .sig-title { font-size: 12px; text-align: center; }

        .sig-col.left .sig-name,
        .sig-col.left .sig-title { text-align: center; padding-left: 0; max-width: 75%; }
    </style>
</head>
<body>

    <!-- ── FIXED FOOTER (always pinned to bottom of A4) ── -->
    <div class="page-footer">
        <div class="tagline">"Lupad Manolo Fortich"</div>
        <div class="tagline-sub">SOAR HIGH MANOLO FORTICH</div>
        <div class="footer">
            <div class="contact-row">
                <div class="contact-item">
                    <span class="contact-icon">&#9993;</span>peso@manolofortich.gov.ph
                </div>
                <div class="contact-item">
                    <span class="contact-icon">&#9723;</span>0917-808-4796
                </div>
                <div class="contact-item">
                    <span class="contact-icon"><strong>f</strong></span>www.facebook.com/LGU Manolo Fortich
                </div>
            </div>
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

            <div class="cert-paragraph">
                THIS IS TO CERTIFY THAT <strong>{{ $company_profile?->company_name ?? $employer_name }}</strong>,
                a registered {{ $company_profile?->line_of_business ?? 'business' }} company in the Philippines
                established in {{ $company_profile?->established_year ?? '' }}, has been granted
                the permit and authority to conduct recruitment of applicants for local employment for
                <strong>ONE (1) day(s)</strong> valid on
                <strong>{{ $activity_request->activity_date?->format('M d, Y') ?? 'TBD' }}</strong>
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
                <div class="sig-line"></div>
                <div class="sig-name">LORRAINE A. REQUINTON</div>
                <div class="sig-title">PESO Manager</div>
            </div>
            <div class="sig-col right">
                <span class="sig-label">NOTED BY:</span>
                <div class="sig-line"></div>
                <div class="sig-name">ROGELIO S. QUIÑO</div>
                <div class="sig-title">Municipal Mayor</div>
            </div>
        </div>

    </div>

</body>
</html>
