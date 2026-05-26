<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PESO Clearance - {{ $clearance->clearance_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background: #f5f5f5;
            padding: 1rem;
        }
        
        .document-container {
            max-width: 850px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            width: 8.5in;
            height: 11in;
            padding: 1.2in;
            position: relative;
            overflow: hidden;
        }
        
        .content {
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            text-align: center;
            margin-bottom: 0.8rem;
            padding-bottom: 0.6rem;
        }
        
        .header-line {
            font-size: 11px;
            font-weight: 600;
            color: #000;
            letter-spacing: 0.5px;
            line-height: 1.3;
        }
        
        .header-line.peso-office {
            font-size: 14px;
            font-weight: 700;
        }
        
        .title {
            font-size: 42px;
            font-weight: 560;
            color: #000;
            margin: -2.5rem 0 0.15rem 0;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-align: center;
        }
        
        .subtitle {
            font-size: 12px;
            font-weight: 700;
            color: #000;
            margin-bottom: 1rem;
            text-transform: uppercase;
        }
        
        .info-section {
            margin: 0.1rem 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
        }
        
        .info-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #000;
            margin-bottom: 0.3rem;
            font-family: 'Georgia', 'Times New Roman', serif;
        }
        
        .info-value {
            font-size: 30px;
            font-weight: 600;
            color: #000;
            text-decoration: underline;
            font-family: 'Georgia', 'Times New Roman', serif;
            padding-bottom: 0.5rem;
        }
        
        .subject-line {
            font-size: 12px;
            font-weight: 600;
            margin: 0.8rem 0 0.5rem 0;
            text-transform: uppercase;
            text-align: center;
        }
        
        .body-text {
            font-size: 13px;
            line-height: 1.8;
            text-align: justify;
            margin: 0.25rem 0;
            color: #000;
            font-family: 'Georgia', 'Times New Roman', serif;
        }
        
        .clearance-statement {
            background: transparent;
            padding: 0.5rem 0;
            margin: 0.25rem auto;
            border-left: none;
            font-size: 13px;
            line-height: 1.8;
            font-weight: 400
            text-align: justify;
            font-family: 'Georgia', 'Times New Roman', serif;
        }
        
        .footer-section {
            margin-top: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-top: 1.5rem;
        }
        
        .signature-block {
            text-align: center;
        }
        
        .signature-line {
            border-top: none;
            margin-top: 2rem;
            padding-top: 0.3rem;
            font-size: 12px;
            font-weight: 600;
            font-family: 'Georgia', 'Times New Roman', serif;
        }
        
        .office-info {
            margin-top: 1.5rem;
            font-size: 12px;
            line-height: 1.6;
            color: #000;
            border-top: none;
            padding-top: 0;
            font-family: 'Georgia', 'Times New Roman', serif;
        }
        
        .logo {
            position: absolute;
            top: 0.75in;
            right: 1.2in;
            width: 120px;
            height: auto;
        }
        
        .logo-left {
            position: absolute;
            top: 0.95in;
            left: 1.2in;
            width: 100px;
            height: auto;
        }
        
        .clearance-number {
            font-size: 12px;
            font-weight: 700;
            margin: 0.5rem 0;
            letter-spacing: 1px;
            font-family: 'Georgia', 'Times New Roman', serif;
        }
        
        .print-button {
            position: fixed;
            top: 1rem;
            right: 1rem;
            padding: 0.75rem 1.5rem;
            background: #003366;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            z-index: 100;
        }
        
        .print-button:hover {
            background: #002244;
        }
        
        .back-button {
            position: fixed;
            top: 1rem;
            left: 1rem;
            padding: 0.75rem 1.5rem;
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            z-index: 100;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .back-button:hover {
            background: #4b5563;
        }
        
        .approved-by {
            font-size: 11px;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            font-family: 'Georgia', 'Times New Roman', serif;
        }
        
        .or-number {
            font-size: 12px;
            font-weight: 600;
            margin: 0.3rem 0;
            font-family: 'Georgia', 'Times New Roman', serif;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .document-container {
                max-width: 100%;
                box-shadow: none;
                width: 100%;
                height: auto;
                margin: 0;
                padding: 1in;
            }
            
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <a href="{{ route('admin.peso-clearances') }}" class="back-button">← Back</a>
    <button class="print-button" onclick="window.print()">🖨️ Print</button>
    
    <div class="document-container">
        <img src="{{ asset('images/logo.png') }}" alt="Manolo Fortich Seal" class="logo-left">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(resource_path('logos/BAGONG-PILIPINAS-LOGO-1-1.png'))) }}" alt="Bagong Pilipinas Logo" class="logo">
        <div class="content">
            <div class="header">
                <div class="header-line">Republic of the Philippines</div>
                <div class="header-line">Province of Bukidnon</div>
                <div class="header-line">MUNICIPALITY OF MANOLO FORTICH</div>
                <div class="header-line peso-office">PUBLIC EMPLOYMENT SERVICE OFFICE</div>
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(resource_path('logos/ip-img.png'))) }}" alt="Divider" style="width: 100%; max-width: 400px; height: auto; margin-top: -0.5rem;">
            </div>
            
            <div class="title">PESO CLEARANCE</div>
            
            <div class="info-section">
                <div>
                    
                    <div class="info-value">{{ strtoupper($clearance->user?->name ?? 'APPLICANT NAME') }}</div>
                <div class="info-label">Name</div>
                </div>
            </div>
            
            <div class="info-section">
                <div style="width: 100%; margin-top: 0.2rem;">
                    {{--  <div class="info-label">Address</div>  --}}
                    <div style="font-size: 24px; font-weight: 600; text-decoration: underline;">{{ $clearance->user?->address ?? 'Manolo Fortich, Bukidnon' }}</div>
                </div>
            </div>
            
            
            <div class="clearance-statement">
                <strong>REGISTRY THIS IS TO CERTIFY THAT</strong> the above-named person has been entered in the MANPOWER SKILLS REGISTRY of MANOLO FORTICH, and may be employed in accordance with the Labor Code of the Philippines under Presidential Decree No. 442, as amended and defined in the ff. Chapter 1, Art. 60-61, Chapter II, Art. 139 (a,b,c).
            </div>
            
            <div class="body-text">
                <strong>THIS CERTIFIES FURTHER THAT</strong> based on the clearances issued by the BARANGAY AUTHORITIES and LOCAL GOVERNMENT UNIT, the herein subject person has <strong>NO DEROGATORY RECORD</strong> and is cleared for employment purposes.
            </div>
            
            <div class="body-text">
                This EMPLOYMENT CLEARANCE is issued in connection with the desire to work and pursue lawful employment as per Presidential Decree No. 442 and in accordance with Municipal Ordinance No. 2005-394, Dated July 2005.
            </div>
            
            <div class="approved-by">Approved by:</div>
            <div class="footer-section">
                <div class="signature-block">
                    <div class="signature-line">LORRAINE A. REQUINTON</div>
                    <div style="font-size: 10px; margin-top: 0.2rem;">PESO MANAGER</div>
                </div>
                <div style="text-align: right;">
                    <?php $orNumber = sprintf('%07d', $clearance->id * 12345 % 9999999); ?>
                    <div class="or-number">OR NO.: {{ $orNumber }}</div>
                    <div class="or-number">DATE ISSUED: {{ now()->format('m/d/Y') }}</div>
                    <div style="margin-top: 0.5rem; text-align: right;">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode('OR:' . $orNumber . ' - ' . $clearance->clearance_number) }}" alt="QR Code" style="width: 80px; height: 80px; border: 1px solid #000;">
                    </div>
                </?php>
            </div>
            
            <div class="office-info">
                <div class="clearance-number">Clearance #: {{ $clearance->clearance_number }}</div>
                <div>"Lupad Manolo Fortich"</div>
                <div>peso@manolofortich.gov.ph | 0955-9546-049</div>
                <div>www.facebook.com/LGUManoloFortich</div>
            </div>
        </div>
    </div>
</body>
</html>
