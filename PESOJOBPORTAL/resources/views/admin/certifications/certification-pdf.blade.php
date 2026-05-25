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
            margin-bottom: 0.08in;
            padding-bottom: 0.05in;
        }

        .seal-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.04in;
        }

        .seal {
            width: 28px;
            height: 28px;
            border: 2px solid #000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .header-text {
            flex: 1;
            text-align: center;
            margin: 0 0.1in;
        }

        .gov-line {
            font-size: 8px;
            line-height: 1.1;
            letter-spacing: 0.03em;
        }

        .gov-main {
            font-size: 8.5px;
            font-weight: bold;
            letter-spacing: 0.06em;
        }

        .decorative-line {
            text-align: center;
            font-size: 10px;
            letter-spacing: 0.12em;
            margin: 0.02in 0;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 0.08em;
            margin: 0.03in 0;
            text-align: center;
        }

        /* Content Section */
        .content {
            margin: 0.05in 0;
            font-size: 9px;
            line-height: 1.3;
            flex-grow: 1;
        }

        .salutation {
            font-weight: bold;
            margin-bottom: 0.04in;
        }

        .cert-paragraph {
            text-align: justify;
            margin-bottom: 0.04in;
            text-indent: 0.15in;
        }

        .cert-paragraph:first-of-type {
            text-indent: 0.15in;
        }

        .location-block {
            margin: 0.04in 0;
            font-size: 9px;
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
            font-size: 8px;
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
            font-size: 8.5px;
            font-weight: bold;
        }

        .sig-title {
            font-size: 7.5px;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 0.02in;
            padding-top: 0.02in;
            font-size: 7px;
            line-height: 1.2;
        }

        .tagline {
            font-style: italic;
            margin: 0.01in 0;
            font-size: 8px;
        }

        .contact {
            font-size: 7px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="seal-row">
                <div class="header-text">
                    <div class="gov-line">Republic of the Philippines</div>
                    <div class="gov-line">Province of Bukidnon</div>
                    <div class="gov-main">MUNICIPALITY OF MANOLO FORTICH</div>
                    <div class="gov-main" style="font-size: 9px;">PUBLIC EMPLOYMENT SERVICE OFFICE</div>
                </div>
            </div>
            <div class="decorative-line">▼ ▼ ▼ ▼ ▼</div>
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

        <!-- Footer -->
        <div class="footer">
            <div class="contact">peso@manolofortich.gov.ph | 0917-808-676</div>
            <div class="tagline">"Lupad Manolo Fortich"</div>
            <div class="decorative-line">▼ ▼ ▼ ▼ ▼</div>
        </div>
    </div>
</body>
</html>
