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
            line-height: 1.3;
            color: #000;
            background: white;
        }

        .container {
            width: 8.27in;
            padding: 0.2in;
            position: relative;
            display: flex;
            flex-direction: column;
            page-break-after: avoid;
            overflow: hidden;
        }

        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: 0.15in;
            padding-bottom: 0.1in;
            border-bottom: 2px solid #000;
        }

        .header-top {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            margin-bottom: 0.08in;
            width: 100%;
            gap: 0.1in;
        }

        .header-logo {
            width: 1.2in;
            height: 1.2in;
            object-fit: contain;
            flex: 0 0 1.2in;
        }

        .header-logo-left {
            width: 1.2in;
            height: 1.2in;
            object-fit: contain;
            flex: 0 0 1.2in;
        }

        .header-center {
            flex: 1 1 auto;
            text-align: center;
            padding: 0 0.15in;
            min-width: 0;
        }

        .seal {
            width: 28px;
            height: 28px;
            border: 2px solid #000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            flex-shrink: 0;
        }

        .header-text {
            flex: 1;
            text-align: center;
            margin: 0 0.1in;
        }

        .gov-line {
            font-size: 11px;
            line-height: 1.2;
            letter-spacing: 0.04em;
            font-weight: 500;
        }

        .gov-main {
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 0.08em;
            line-height: 1.3;
            text-transform: uppercase;
        }

        .decorative-line {
            text-align: center;
            font-size: 11px;
            letter-spacing: 0.15em;
            margin: 0.05in 0;
            color: #333;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 0.1em;
            margin: 0.08in 0 0.06in 0;
            text-align: center;
            text-transform: uppercase;
            color: #000;
        }

        /* Content Section */
        .content {
            margin: 0.12in 0.3in;
            font-size: 12px;
            line-height: 1.5;
            flex-grow: 1;
        }

        .salutation {
            font-weight: bold;
            margin-bottom: 0.08in;
            text-align: left;
            font-size: 12px;
        }

        .cert-paragraph {
            text-align: justify;
            margin-bottom: 0.06in;
            text-indent: 0.3in;
            line-height: 1.5;
            font-size: 12px;
        }

        .cert-paragraph:first-of-type {
            text-indent: 0.3in;
        }

        .location-block {
            margin: 0.08in 0;
            font-size: 12px;
            text-align: justify;
            line-height: 1.5;
        }

        /* Signature Section */
        .signature-container {
            position: relative;
            margin: 0.08in 0 0 0;
            min-height: 1.2in;
        }

        .sig-block {
            position: absolute;
            width: 48%;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sig-block:first-child {
            left: 0;
            top: 0;
        }

        .sig-block:last-child {
            right: 0;
            top: 0.5in;
        }

        .sig-label {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 0.08in;
            min-height: 0.15in;
        }

        .sig-line {
            border-top: 1px solid #000;
            height: 0;
            margin: 0.15in 0 0.02in 0;
        }

        .sig-name {
            font-size: 12px;
            font-weight: bold;
        }

        .sig-title {
            font-size: 12px;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 0.08in;
            padding-top: 0.08in;
            border-top: 2px solid #000;
            font-size: 11px;
            line-height: 1.4;
        }

        .footer-top-line {
            border-top: 1px solid #000;
            margin: 0 0 0.05in 0;
        }

        .tagline {
            font-style: italic;
            margin: 0.1in 0 0.08in 0;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.02em;
            text-align: center;
        }

        .contact-info {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
            gap: 0.1in;
            margin-top: 0.05in;
            font-size: 10px;
            padding: 0 0.1in;
            width: 100%;
            flex-wrap: nowrap;
        }

        .contact-item {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 0.05in;
            flex: 0 1 auto;
            white-space: nowrap;
        }

        .contact-icon {
            font-size: 13px;
            flex-shrink: 0;
            font-weight: bold;
        }

        .contact {
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-top">
                <img src="{{ public_path('images/manolo fortich seal.png') }}" alt="Manolo Fortich Seal" class="header-logo-left">
                <div class="header-center">
                    <div class="gov-line">Republic of the Philippines</div>
                    <div class="gov-line">Province of Bukidnon</div>
                    <div class="gov-main">MUNICIPALITY OF MANOLO FORTICH</div>
                    <div class="gov-main" style="font-size: 12px;">PUBLIC EMPLOYMENT SERVICE OFFICE</div>
                </div>
                <img src="{{ public_path('images/BAGONG-PILIPINAS-LOGO.png') }}" alt="Bagong Pilipinas" class="header-logo">
            </div>

        </div>

        <!-- Title -->
        <div class="title">CERTIFICATION</div>

        <!-- Content -->
        <div class="content">
            <div class="salutation">TO WHOM IT MAY CONCERN:</div>

            <div class="cert-paragraph">
                THIS IS TO CERTIFY THAT <strong>{{ $company_profile?->company_name ?? $employer_name }}</strong>,
                a registered {{ $company_profile?->line_of_business ?? 'business' }} company in the Philippines, has been granted
                the permit and authority to conduct recruitment of applicants for local employment for <strong>ONE (1) day(s)</strong>
                valid on <strong>{{ $activity_request->activity_date?->format('M d, Y') ?? 'TBD' }}</strong> at Lobby area in Ground floor of Manolo Fortich PESO Office.
                Located in, Gen. Andres Bonifacio St. Cor. Albarces St. Brgy. Tankulan, Manolo Fortich, Bukidnon.
            </div>

            <div class="cert-paragraph">
                This certifies that the office of the undersigned poses no objection's whatsoever relative to the conduct of said activities.
            </div>

            <div class="cert-paragraph">
                This certification is issued upon the request of the above agency for whatever legal intent or purpose this may serve.
            </div>

            <div class="location-block">
                Given this <strong>{{ $activity_request->created_at?->format('jS \d\a\y \o\f F') ?? now()->format('jS \d\a\y \o\f F') }} 2026</strong>
                at Lobby area in Ground floor of Manolo Fortich PESO Office.<br>
                Located in, Gen. Andres Bonifacio St. Cor. Albarces St. Brgy. Tankulan, Manolo Fortich, Bukidnon.
            </div>
        </div>

        <!-- Signatures -->
    <div> </div>
        <div class="signature-container">
            <div class="sig-block">
                <div class="sig-label">ATTESTED BY:</div>
                <div class="sig-name">LORRAINE A. REQUINTON</div>
                <div class="sig-title">PESO Manager</div>
            </div>
            <div class="sig-block">
                <div class="sig-label">NOTED BY:</div>
                <div class="sig-name">ROGELIO S. QUINO</div>
                <div class="sig-title">Municipal Mayor</div>
            </div>
        </div>

        <!-- Tagline -->
        <div class="tagline">"Lupad Manolo Fortich"</div>

        <!-- Footer -->
        <div class="footer">
            <div class="contact-info">
                <div class="contact-item">
                    <span class="contact-icon">[E]</span>
                    <span class="contact">peso@manolofortich.gov.ph</span>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">[T]</span>
                    <span class="contact">0917-808-676</span>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">[F]</span>
                    <span class="contact">www.facebook.com/LGU Manolo Fortich</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
