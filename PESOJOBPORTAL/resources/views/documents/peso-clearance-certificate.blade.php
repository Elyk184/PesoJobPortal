<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4;
            margin: 0;
            padding: 0;
        }

        html {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Times New Roman', serif;
            background: white;
            margin: 0;
            padding: 0;
            width: 210mm;
            height: 297mm;
        }

        @media print {
            * {
                margin: 0 !important;
                padding: 0 !important;
                box-sizing: border-box;
            }

            html {
                margin: 0;
                padding: 0;
                width: 210mm;
                height: 297mm;
            }

            body {
                margin: 0;
                padding: 0;
                width: 210mm;
                height: 297mm;
                background: white;
            }

            .certificate-container {
                page-break-inside: avoid;
                width: 100%;
                height: 297mm;
            }
        }

        .certificate-container {
            background: #faf8f3;
            border: 3px solid #2d5016;
            padding: 40px 30px;
            width: 100%;
            height: 297mm;
            margin: 0;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            page-break-inside: avoid;
        }

        .header {
            margin-bottom: 30px;
        }

        .seal {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
            display: inline-block;
        }

        .agency-name {
            font-size: 10px;
            letter-spacing: 2px;
            color: #666;
            margin-bottom: 5px;
        }

        .ministry-title {
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 3px;
            color: #2d5016;
            margin-bottom: 10px;
        }

        .cert-title {
            font-size: 48px;
            font-weight: bold;
            letter-spacing: 4px;
            color: #2d5016;
            margin: 30px 0;
            text-decoration: underline;
        }

        .jobseeker-name {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #2d5016;
            margin: 20px 0;
            text-decoration: underline;
        }

        .label-text {
            font-size: 10px;
            letter-spacing: 1px;
            color: #666;
            margin-bottom: 5px;
        }

        .location-info {
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #2d5016;
            margin-bottom: 30px;
            text-decoration: underline;
        }

        .content-text {
            font-size: 11px;
            line-height: 1.8;
            color: #333;
            text-align: justify;
            margin: 30px 0;
        }

        .company-section {
            margin: 40px 0;
            text-align: center;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #2d5016;
            margin: 20px 0;
            text-decoration: underline;
        }

        .signature-section {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid #ccc;
        }

        .signature-label {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .signature-name {
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .signature-title {
            font-size: 10px;
            letter-spacing: 1px;
            color: #666;
        }

        .clearance-details {
            margin-top: 30px;
            font-size: 11px;
            line-height: 2;
            color: #333;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }

        .detail-label {
            font-weight: bold;
        }

        .footer-info {
            margin-top: 40px;
            font-size: 10px;
            color: #000;
            text-align: center;
            padding: 15px 0;
            border-top: 2px solid #2d5016;
            border-bottom: 3px solid #2d5016;
        }

        .footer-quote {
            font-size: 11px;
            font-weight: bold;
            color: #2d5016;
            margin-bottom: 10px;
            font-style: italic;
        }

        .footer-contact {
            font-size: 10px;
            color: #000;
            margin: 8px 0;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Header -->
        <div class="header">
            <div class="agency-name">Republic of the Philippines</div>
            <div class="agency-name">Province of Bukidnon</div>
            <div class="ministry-title">MUNICIPAL GOVERNMENT OF MANOLO FORTICH</div>
            <div class="ministry-title">PUBLIC EMPLOYMENT SERVICE OFFICE</div>
        </div>

        <!-- Title -->
        <div class="cert-title">PESO CLEARANCE</div>

        <!-- Jobseeker Name -->
        <div class="jobseeker-name">{{ strtoupper($name) }}</div>

        <!-- Main Content -->
        <div class="content-text">
            REGISTRY THIS IS TO CERTIFY THAT the above-named person has been entered in the MANPOWER SKILLS OF MANOLO FORTICH, and maybe employed in accordance with the Labor Code of the Philippines under Presidential Decree No.: 442, as amended and defined in the IT Chapter 1, Art. 60(1), Chapter II, Art. 139 (a.h.c.)
            <br><br>
            THIS CERTIFIES FURTHER THAT based on the clearances issued by the BARANGAY (LGU AREA) herein subject person has NO DEROGATORY RECORD.
            <br><br>
            This EMPLOYMENT CLEARANCE is issued in connection with HER desire to work at:
        </div>

        <!-- Company Section -->
        <div class="company-section">
            <div class="company-name">GENERAL SERVICES MULTIPURPOSE COOPERATIVE</div>
            <div style="font-size: 10px; color: #666;">Municipal Ordinance # 2005-394, Dated July 2005</div>
        </div>

        <!-- Approval Section -->
        <div class="signature-section">
            <div class="signature-label">Approved by:</div>
            <div style="height: 60px;"></div>
            <div class="signature-name">LORRAINE A. REQUINTON</div>
            <div class="signature-title">PESO MANAGER</div>
        </div>

        <!-- Clearance Details -->
        <div class="clearance-details">
            <div class="detail-row">
                <span class="detail-label">OR NO. :</span>
                <span>{{ $clearance_number }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">DATE ISSUED:</span>
                <span>{{ $issue_date }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">VALID UNTIL:</span>
                <span>{{ $expiry_date }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-info">
            <div class="footer-quote">"Lupad Manolo Fortich"</div>
            <div class="footer-contact">
                📧 peso@manolofortich.gov.ph | 📞 0955-9546-049 | 🌐 www.facebook.com/LGU.Manolo.Fortich
            </div>
        </div>
    </div>
</body>
</html>
