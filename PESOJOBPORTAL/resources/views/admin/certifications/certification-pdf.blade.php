<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ strtoupper($activity_request->activity_type) }} Certification</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4;
            margin: 0.2in;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.4;
            color: #000;
            background: white;
        }

        .container {
            width: 100%;
            padding: 0.2in 0.25in;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        /* ── HEADER ── */
        .header-top {
            display: table;
            width: 100%;
            margin-bottom: 4px;
            border-collapse: collapse;
        }

        .header-logo-cell {
            display: table-cell;
            width: 1.1in;
            vertical-align: middle;
            text-align: center;
        }

        .header-center-cell {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding: 0 0.1in;
        }

        .header-logo-left {
            width: 1.0in;
            height: 1.0in;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .header-logo {
            width: 1.0in;
            height: 1.0in;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .gov-line {
            font-size: 10.5px;
            line-height: 1.3;
        }

        .gov-main {
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 0.04em;
            line-height: 1.35;
            text-transform: uppercase;
        }

        .gov-peso {
            font-size: 17px;
            font-weight: bold;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            margin-top: 2px;
            line-height: 1.2;
        }

        /* ── DECORATIVE IMAGE STRIP ── */
        .decor-top {
            width: 100%;
            height: 0.22in;
            object-fit: cover;
            display: block;
            margin: 6px 0 4px 0;
        }

        .decor-bottom {
            width: 100%;
            height: 0.22in;
            object-fit: cover;
            display: block;
            margin-top: 8px;
        }

        /* ── TITLE ── */
        .title {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 0.15em;
            margin: 8px 0 10px 0;
            text-align: center;
            text-transform: uppercase;
            color: #000;
        }

        /* ── CONTENT ── */
        .content {
            margin: 0 0.15in;
            font-size: 12px;
            line-height: 1.5;
        }

        .salutation {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 12px;
        }

        .cert-paragraph {
            text-align: justify;
            text-indent: 0.4in;
            margin-bottom: 7px;
            line-height: 1.55;
            font-size: 12px;
        }

        .location-block {
            margin: 8px 0 0 0;
            font-size: 12px;
            line-height: 1.55;
            text-align: justify;
        }

        /* ── SIGNATURES ── */
        .signature-container {
            position: relative;
            margin: 10px 0.15in 0 0.15in;
            min-height: 1.4in;
        }

        .sig-block {
            position: absolute;
            width: 46%;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sig-block.left {
            left: 0;
            top: 0;
            align-items: flex-start;
        }

        .sig-block.right {
            right: 0;
            top: 0.55in;
            align-items: center;
        }

        .sig-label {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 0.45in; /* space for signature */
            text-align: left;
        }

        .sig-block.right .sig-label {
            text-align: center;
            align-self: center;
        }

        .sig-line {
            border-top: 1px solid #000;
            width: 80%;
            margin-bottom: 3px;
        }

        .sig-block.left .sig-line {
            width: 100%;
        }

        .sig-name {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
        }

        .sig-title {
            font-size: 12px;
            text-align: center;
        }

        /* ── TAGLINE ── */
        .tagline {
            text-align: center;
            font-style: italic;
            font-size: 14px;
            font-weight: 600;
            margin: 6px 0 2px 0;
            letter-spacing: 0.02em;
        }

        .tagline-sub {
            text-align: center;
            font-size: 8.5px;
            letter-spacing: 0.18em;
            color: #333;
            margin-bottom: 4px;
        }

        /* ── FOOTER ── */
        .footer {
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 4px;
        }

        .contact-row {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            font-size: 10px;
            flex-wrap: nowrap;
            padding: 2px 0.05in;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .contact-icon {
            font-size: 14px;
            width: 18px;
            text-align: center;
            display: inline-block;
        }
    </style>
</head>
<body>
<div class="container">

    <!-- ── HEADER ── -->
    <div class="header-top">
        <div class="header-logo-cell">
            <img src="{{ public_path('images/manolo fortich seal.png') }}"
                 alt="Manolo Fortich Seal"
                 class="header-logo-left">
        </div>

        <div class="header-center-cell">
            <div class="gov-line">Republic of the Philippines</div>
            <div class="gov-line">Province of Bukidnon</div>
            <div class="gov-main">MUNICIPALITY OF MANOLO FORTICH</div>
            <div class="gov-peso">PUBLIC EMPLOYMENT SERVICE OFFICE</div>
        </div>

        <div class="header-logo-cell">
            <img src="{{ public_path('images/BAGONG-PILIPINAS-LOGO.png') }}"
                 alt="Bagong Pilipinas"
                 class="header-logo">
        </div>
    </div>

    <!-- ── DECORATIVE STRIP (top) ── -->
    <img src="{{ public_path('images/decor.png') }}"
         alt="Decorative Pattern"
         class="decor-top">

    <!-- ── TITLE ── -->
    <div class="title">CERTIFICATION</div>

    <!-- ── CONTENT ── -->
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

    <!-- ── SIGNATURES ── -->
    <div class="signature-container">

        <div class="sig-block left">
            <div class="sig-label">ATTESTED BY:</div>
            <div class="sig-line"></div>
            <div class="sig-name">LORRAINE A. REQUINTON</div>
            <div class="sig-title">PESO Manager</div>
        </div>

        <div class="sig-block right">
            <div class="sig-label">NOTED BY:</div>
            <div class="sig-line"></div>
            <div class="sig-name">ROGELIO S. QUIÑO</div>
            <div class="sig-title">Municipal Mayor</div>
        </div>

    </div>

    <!-- ── TAGLINE ── -->
    <div class="tagline">"Lupad Manolo Fortich"</div>
    <div class="tagline-sub">SOAR HIGH MANOLO FORTICH</div>

    <!-- ── FOOTER ── -->
    <div class="footer">
        <div class="contact-row">
            <div class="contact-item">
                <span class="contact-icon">&#9993;</span>
            </div>
            <div class="contact-item">
                <span class="contact-icon">&#9723;</span>
            </div>
            <div class="contact-item">
                <span class="contact-icon"><strong>f</strong></span>
                <span>www.facebook.com/LGU Manolo Fortich</span>
            </div>
        </div>
    </div>

    <!-- ── DECORATIVE STRIP (bottom) ── -->
    <img src="{{ public_path('images/decor.png') }}"
         alt="Decorative Pattern"
         class="decor-bottom">

</div>
</body>
</html>
