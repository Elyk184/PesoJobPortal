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
            <label for="company_name_input" style="font-size:12px;font-weight:700;color:#111827;">Company / Organization</label>
            <input id="company_name_input" name="company_name" type="text" placeholder="Type company or organization" value="{{ old('company_name', $clearance->company_name ?? '') }}" style="width:100%;padding:0.5rem;border:1px solid #cbd5e1;border-radius:6px;font-family:inherit;font-size:13px;line-height:1.5;">
            @error('company_name')
                <div style="font-size:12px;color:#dc2626;">{{ $message }}</div>
            @enderror
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

            <div id="organization-line" class="body-text org-line">{{ $clearance->company_name ? strtoupper($clearance->company_name) : 'COMPANY / ORGANIZATION NAME' }}</div>

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
    <!-- Floating edit pens (one for organization, one for barangay/residence) -->
    <button id="edit-pen" title="Edit organization" aria-label="Edit organization" style="display:none;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" fill="#fff"/>
            <path d="M20.71 7.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z" fill="#fff"/>
        </svg>
    </button>
    <button id="edit-pen-barangay" title="Edit barangay" aria-label="Edit barangay" style="display:none;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" fill="#fff"/>
            <path d="M20.71 7.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z" fill="#fff"/>
        </svg>
    </button>
</body>
<script>
    (function () {
        const residenceInput = document.getElementById('residence_address_input');
        const preview = document.getElementById('residence-address-preview');
        const body = document.getElementById('residence-address-body');
        const companyInput = document.getElementById('company_name_input');
        const orgLine = document.getElementById('organization-line');

        if (!residenceInput || !preview || !body) {
            return;
        }

        const updateResidencePreview = () => {
            const value = residenceInput.value.trim();
            if (value) {
                body.textContent = value;
                body.classList.add('typed-style');
            } else {
                body.innerHTML = '<span class="placeholder-uppercase">TYPE BARANGAY HERE</span>';
                body.classList.remove('typed-style');
            }
        };

        const updateOrgPreview = () => {
            if (!orgLine || !companyInput) return;
            const v = companyInput.value.trim();
            if (v) {
                orgLine.textContent = v.toUpperCase();
                orgLine.classList.add('typed-style');
            } else {
                orgLine.textContent = 'COMPANY / ORGANIZATION NAME';
                orgLine.classList.remove('typed-style');
            }
        };

        residenceInput.addEventListener('input', updateResidencePreview);
        if (companyInput) companyInput.addEventListener('input', updateOrgPreview);
        updateResidencePreview();
        updateOrgPreview();
    })();

    // Floating edit pen logic (organization + barangay)
    (function () {
        const container = document.querySelector('.document-container');
        const orgLine = document.getElementById('organization-line');
        const penOrg = document.getElementById('edit-pen');
        const penBarangay = document.getElementById('edit-pen-barangay');
        const companyInput = document.getElementById('company_name_input');
        const residenceInput = document.getElementById('residence_address_input');
        const residenceBody = document.getElementById('residence-address-body');

        if (!container) return;

        // shared styling for pens (use fixed so positions are viewport-based)
        const pens = [penOrg, penBarangay].filter(Boolean);
        pens.forEach(p => {
            Object.assign(p.style, {
                position: 'fixed',
                width: '36px',
                height: '36px',
                borderRadius: '50%',
                background: '#0ea5a4',
                border: '2px solid #fff',
                boxShadow: '0 6px 18px rgba(0,0,0,0.16)',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                cursor: 'pointer',
                zIndex: 120,
                transition: 'transform .12s ease',
            });
            p.style.display = 'block';
        });

        // pulse animation class and highlight style
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes pulsePen { 0% { transform: scale(1); } 50% { transform: scale(1.06); } 100% { transform: scale(1); } }
            .pen-pulse { animation: pulsePen .9s ease-in-out; }
            .org-highlight { box-shadow: 0 0 0 4px rgba(14,165,164,0.12) inset; }
            .barangay-highlight { box-shadow: 0 0 0 4px rgba(59,130,246,0.12) inset; }
        `;
        document.head.appendChild(style);

        function positionPens() {
            // use viewport coordinates from getBoundingClientRect directly
            if (orgLine && penOrg) {
                const orgRect = orgLine.getBoundingClientRect();
                // center the pen horizontally above the organization text
                const top = orgRect.top + (orgRect.height / 2) - 18;
                const left = orgRect.left + (orgRect.width / 2) - 18;
                // clamp inside viewport
                const clampedTop = Math.max(8, Math.min(top, window.innerHeight - 44));
                const clampedLeft = Math.max(8, Math.min(left, window.innerWidth - 44));
                penOrg.style.top = `${clampedTop}px`;
                penOrg.style.left = `${clampedLeft}px`;
                // hide when target is offscreen
                penOrg.style.display = (orgRect.top > window.innerHeight || orgRect.bottom < 0) ? 'none' : 'block';
            }

            if (residenceBody && penBarangay) {
                const resRect = residenceBody.getBoundingClientRect();
                // place pen slightly to the left of the barangay text center
                const top = resRect.top + (resRect.height / 2) - 18;
                const left = resRect.left - 48;
                const clampedTop = Math.max(8, Math.min(top, window.innerHeight - 44));
                const clampedLeft = Math.max(8, Math.min(left, window.innerWidth - 44));
                penBarangay.style.top = `${clampedTop}px`;
                penBarangay.style.left = `${clampedLeft}px`;
                penBarangay.style.display = (resRect.top > window.innerHeight || resRect.bottom < 0) ? 'none' : 'block';
            }
        }

        // reposition a few times during initial load in case fonts or images change layout
        positionPens();
        let tries = 0;
        const interval = setInterval(() => {
            positionPens();
            tries += 1;
            if (tries > 8) clearInterval(interval);
        }, 250);

        window.addEventListener('resize', positionPens);
        window.addEventListener('scroll', positionPens);
        setTimeout(positionPens, 120);

        pens.forEach(p => {
            p.addEventListener('mouseenter', () => p.classList.add('pen-pulse'));
            p.addEventListener('mouseleave', () => p.classList.remove('pen-pulse'));
        });

        // org pen click
        if (penOrg) {
            penOrg.addEventListener('click', (e) => {
                e.preventDefault();
                if (orgLine) {
                    orgLine.classList.add('org-highlight');
                    setTimeout(() => orgLine.classList.remove('org-highlight'), 900);
                }
                if (companyInput) {
                    companyInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    companyInput.focus();
                    const val = companyInput.value || '';
                    companyInput.setSelectionRange(val.length, val.length);
                } else {
                    const msg = document.createElement('div');
                    msg.textContent = 'Open issuance form to edit organization';
                    Object.assign(msg.style, {
                        position: 'fixed', right: '1rem', top: '4rem', background: '#111827', color: '#fff', padding: '0.5rem 0.75rem', borderRadius: '6px', zIndex: 200, boxShadow: '0 8px 24px rgba(0,0,0,0.18)'
                    });
                    document.body.appendChild(msg);
                    setTimeout(() => msg.remove(), 1800);
                }
            });
        }

        // barangay pen click
        if (penBarangay) {
            penBarangay.addEventListener('click', (e) => {
                e.preventDefault();
                if (residenceBody) {
                    residenceBody.classList.add('barangay-highlight');
                    setTimeout(() => residenceBody.classList.remove('barangay-highlight'), 900);
                }
                if (residenceInput) {
                    residenceInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    residenceInput.focus();
                    const val = residenceInput.value || '';
                    residenceInput.setSelectionRange(val.length, val.length);
                } else {
                    const msg = document.createElement('div');
                    msg.textContent = 'Open issuance form to edit barangay';
                    Object.assign(msg.style, {
                        position: 'fixed', right: '1rem', top: '4rem', background: '#111827', color: '#fff', padding: '0.5rem 0.75rem', borderRadius: '6px', zIndex: 200, boxShadow: '0 8px 24px rgba(0,0,0,0.18)'
                    });
                    document.body.appendChild(msg);
                    setTimeout(() => msg.remove(), 1800);
                }
            });
        }
    })();
</script>
</html>