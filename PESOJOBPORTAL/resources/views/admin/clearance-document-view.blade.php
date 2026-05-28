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
        :root {
            --org-gap: 1rem; /* vertical gap above organization line — adjust as needed */
        }
        
        .document-container {
            max-width: 850px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            width: 8.5in;
            height: 11in;
            padding: 1.2in;
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
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .header-line {
            font-size: 11px;
            font-weight: 600;
            color: #000;
            letter-spacing: 0.5px;
            line-height: 1.4;
            white-space: nowrap;
        }
        
        .header-line.peso-office {
            font-size: 15px;
            font-weight: 700;
            white-space: nowrap;
        }
        
        .title {
            font-size: 44px;
            font-weight: 560;
            color: #000;
            margin: 0.6rem 0 0.5rem 0;
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
            font-size: 32px;
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
            font-weight: 400;
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
            margin-top: 1.2rem;
            margin-left: -1.2in;
            margin-right: -1.2in;
            margin-bottom: 0;
            font-size: 12px;
            line-height: 1.2;
            color: #000;
            border-top: 2px solid #000;
            padding-top: 0.15rem;
            padding-bottom: 0.1rem;
            padding-left: 1.2in;
            padding-right: 1.2in;
            font-family: 'Georgia', 'Times New Roman', serif;
            text-align: center;
            position: relative;
            width: calc(100% + 2.4in);
        }

        .office-info .contact-line {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            font-size: 11.5px;
            margin-bottom: 0.1rem;
            flex-wrap: wrap;
        }

        .office-info .contact-line .contact-item {
            display: inline-flex;
            align-items: center;
            gap: 0.2rem;
        }

        .office-info .divider-img {
            display: block;
            margin: 0.1rem auto 0;
            width: 85%;
            max-width: 85%;
            height: 25px;
            object-fit: cover;
        }
        
        .logo {
            width: 90px;
            height: auto;
            flex-shrink: 0;
        }
        
        .logo-left {
            width: 90px;
            height: auto;
            flex-shrink: 0;
        }

        .header-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.3rem;
            margin-bottom: 0;
            width: 100%;
        }

        .header-wrapper .header {
            flex: 1;
            margin-bottom: 0;
            padding-bottom: 0;
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

        .capitalize-words {
            text-transform: capitalize;
        }

        .spaced-paragraph {
            margin-top: 0.75rem;
            margin-bottom: 0 !important;
        }
        
        .placeholder-uppercase {
            text-transform: uppercase;
            text-decoration: underline;
            font-weight: 700;
        }
        .typed-style {
            text-transform: uppercase;
            text-decoration: underline;
            font-weight: 700;
        }
        .org-line {
            display: block;
            text-align: center;
            font-weight: 700;
            text-decoration: underline;
            text-transform: uppercase;
            margin-top: var(--org-gap) !important;
            margin-bottom: 0 !important;
            padding: 0 !important;
            line-height: 1 !important;
            font-size: 20px;
        }
        /* Keep ordinance paragraph snug below the org-line, but add a configurable gap above the org-line */
        .body-text.spaced-paragraph + .org-line {
            margin-top: var(--org-gap) !important;
            margin-bottom: 0 !important;
        }
        .org-line + .body-text.spaced-paragraph {
            margin-top: 0 !important;
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
            
            .print-button, .back-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <a href="{{ route('admin.peso-clearances') }}" class="back-button">← Back</a>
    <button class="print-button" onclick="window.print()">🖨️ Print</button>
    @if($clearance->status === 'pending')
        <form method="POST" action="{{ route('admin.peso-clearances.issue', $clearance) }}" style="position:fixed;top:1rem;right:8.5rem;z-index:100;display:flex;flex-direction:column;gap:0.35rem;background:#fff;padding:0.75rem;border:1px solid #d1d5db;border-radius:8px;box-shadow:0 8px 24px rgba(0,0,0,0.12);width:360px;max-width:calc(100vw - 11rem);">
            @csrf
            <label for="residence_address_input" style="font-size:12px;font-weight:700;color:#111827;">Residence address</label>
            <textarea id="residence_address_input" name="residence_address" rows="3" placeholder="Type the jobseeker residence here" style="width:100%;padding:0.65rem;border:1px solid #cbd5e1;border-radius:6px;font-family:inherit;font-size:13px;line-height:1.5;resize:vertical;">{{ old('residence_address', $residenceAddress) }}</textarea>
            @error('residence_address')
                <div style="font-size:12px;color:#dc2626;">{{ $message }}</div>
            @enderror
            <button type="submit" class="print-button" style="background:#16a34a;position:static;right:auto;top:auto;width:100%;">✔ Issue Clearance</button>
        </form>
    @endif
    
    <div class="document-container">
        <div class="content">
            <div class="header-wrapper">
                <img src="{{ asset('images/logo.png') }}" alt="Manolo Fortich Seal" class="logo-left">
                <div class="header">
                    <div class="header-line">Republic of the Philippines</div>
                    <div class="header-line">Province of Bukidnon</div>
                    <div class="header-line">MUNICIPALITY OF MANOLO FORTICH</div>
                    <div class="header-line peso-office">PUBLIC EMPLOYMENT SERVICE OFFICE</div>
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(resource_path('logos/ip-img.png'))) }}" alt="Divider" style="width: 100%; height: auto; margin-top: -1.1rem; display: block;">
                </div>
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(resource_path('logos/BAGONG-PILIPINAS-LOGO-1-1.png'))) }}" alt="Bagong Pilipinas Logo" class="logo">
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
                    <div id="residence-address-preview" class="capitalize-words" style="font-size: 24px; font-weight: 600; text-decoration: underline;">{{ $autoResidenceAddress ?? 'Manolo Fortich, Bukidnon' }}</div>
                </div>
            </div>
            
            <div class="clearance-statement">
                <strong>REGISTRY THIS IS TO CERTIFY THAT</strong> the above-named person has been entered in the MANPOWER SKILLS REGISTRY of MANOLO FORTICH, and may be employed in accordance with the Labor Code of the Philippines under Presidential Decree No.: 442, as amended and defined in the ff. Chapter 1, Art. 60-61, Chapter II, Art. 139 (a,b,c).
            </div>
            
            <div class="body-text">
                <strong>THIS CERTIFIES FURTHER THAT</strong> based on the clearances issued by the BARANGAY <span id="residence-address-body" class="capitalize-words{{ $residenceAddress ? ' typed-style' : '' }}">{!! $residenceAddress ? e($residenceAddress) : '<span class="placeholder-uppercase">TYPE BARANGAY HERE</span>' !!}</span> herein subject person has <strong>NO DEROGATORY RECORD.</strong>
            </div>
            
            <div class="body-text spaced-paragraph">
                This EMPLOYMENT CLEARANCE is issued in connection with the desire of {{ $objectivePronoun }} to work at:
            </div>

            <div id="organization-line" class="body-text org-line">COMPANY / ORGANIZATION NAME</div>

            <div class="body-text spaced-paragraph">
                 Municipal Ordinance No. 2005-394, Dated July 2005
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
                </div>
            </div>
            

<div style="padding-top: 0.6rem; text-align: center; margin-bottom: 0.1rem; font-style: italic; font-weight: bold;">"Lupad Manolo Fortich"</div>

            <div class="office-info">
               
                <div class="contact-line">
                    <span class="contact-item">✉ peso@manolofortich.gov.ph</span>
                    <span>|</span>
                    <span class="contact-item">📱 0955-9546-049</span>
                    <span>|</span>
                    <span class="contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#1877F2" style="vertical-align:middle;margin-right:2px;"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.235 2.686.235v2.97h-1.514c-1.491 0-1.956.93-1.956 1.886v2.269h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/></svg>
                        www.facebook.com/LGU Manolo Fortich
                    </span>
                </div>
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(resource_path('logos/ip-img.png'))) }}" alt="Divider" class="divider-img">
            </div>
        </div>
    </div>
</body>
<script>
    (function () {
        const input = document.getElementById('residence_address_input');
        const preview = document.getElementById('residence-address-preview');
        const body = document.getElementById('residence-address-body');

        if (!input || !preview || !body) {
            return;
        }

        const updatePreview = () => {
            const value = input.value.trim();
            if (value) {
                body.textContent = value;
                body.classList.add('typed-style');
            } else {
                body.innerHTML = '<span class="placeholder-uppercase">TYPE BARANGAY HERE</span>';
                body.classList.remove('typed-style');
            }
        };

        input.addEventListener('input', updatePreview);
        updatePreview();
    })();
</script>
</html>