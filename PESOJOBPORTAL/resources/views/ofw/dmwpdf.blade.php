<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DMW Request for Assistance (RFA) Form</title>
    <style>
        /* ─────────────────────────────────────────────
           PAGE & BASE
        ───────────────────────────────────────────── */
        @page {
            size: A4 portrait;
            margin: 13mm 14mm 13mm 14mm;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            color: #000;
            line-height: 1.3;
        }

        /* ─────────────────────────────────────────────
           HEADER
        ───────────────────────────────────────────── */
        .header {
            width: 100%;
            text-align: center;
            margin-bottom: 3px;
        }

        .header-table {
            width: 100%;
            border: none;
            border-collapse: collapse;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
            padding: 0;
        }

        .header-logo-cell {
            width: 64px;
            text-align: center;
        }

        .header-logo-cell-right {
            width: 80px;
            text-align: center;
        }

        .header-logo {
            width: 60px;
            height: 60px;
        }

        .header-logo-bagong {
            width: 72px;
            height: 72px;
        }

        .header-center {
            text-align: center;
        }

        .republic   { font-size: 8pt; }
        .dept-name  { font-size: 14pt; font-weight: bold; font-family: 'Times New Roman', serif; line-height: 1.15; }
        .address    { font-size: 7pt; margin-top: 1px; }
        .contact    { font-size: 6pt; color: #333; }

        hr.divider {
            border: none;
            border-top: 1.2px solid #000;
            margin: 4px 0;
        }

        /* ─────────────────────────────────────────────
           FORM TITLE & TYPE ROW
        ───────────────────────────────────────────── */
        .form-title {
            text-align: center;
            font-weight: bold;
            font-size: 11pt;
            text-decoration: underline;
            margin: 6px 0 4px;
        }

        .form-type-row {
            text-align: center;
            font-size: 8.5pt;
            margin-bottom: 6px;
        }

        .cb { font-family: 'DejaVu Sans', sans-serif; font-size: 10pt; }

        .referral-line {
            display: inline;
            border-bottom: 1px solid #000;
            min-width: 100px;
            padding: 0 4px;
        }

        /* ─────────────────────────────────────────────
           SECTION HEADER
        ───────────────────────────────────────────── */
        .section-header {
            font-weight: bold;
            font-size: 8.5pt;
            text-decoration: underline;
            margin: 7px 0 3px;
        }

        /* ─────────────────────────────────────────────
           FORM TABLE
        ───────────────────────────────────────────── */
        .form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1px;
        }

        .form-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            vertical-align: top;
            font-size: 8.5pt;
        }

        .label-cell {
            background: #efefef;
            font-weight: bold;
            white-space: nowrap;
            width: 30%;
            vertical-align: middle;
        }

        .value-cell {
            width: 70%;
        }

        /* ── Name fields (3-col split) ── */
        .name-table {
            width: 100%;
            border-collapse: collapse;
        }

        .name-table td {
            border: none;
            border-right: 1px solid #ccc;
            padding: 0 4px;
            vertical-align: top;
            width: 33.33%;
        }

        .name-table td:last-child {
            border-right: none;
        }

        .name-value {
            font-size: 9pt;
            border-bottom: 1px solid #aaa;
            min-height: 14px;
            padding-bottom: 1px;
        }

        .name-label {
            font-size: 6pt;
            font-style: italic;
            color: #555;
            margin-top: 1px;
        }

        /* ── Checkbox groups ── */
        .checkbox-group-inline {
            font-size: 8.5pt;
        }

        .checkbox-item {
            display: inline;
            margin-right: 10px;
        }

        /* ─────────────────────────────────────────────
           PAGE 2 — SECTION C
        ───────────────────────────────────────────── */
        .page-break {
            page-break-before: always;
        }

        .assistance-box {
            width: 100%;
            border: 1px solid #000;
            padding: 5px 8px;
            margin-bottom: 2px;
        }

        .assistance-table {
            width: 100%;
            border-collapse: collapse;
        }

        .assistance-table td {
            border: none;
            padding: 2px 4px;
            font-size: 8.5pt;
            vertical-align: middle;
            width: 33.33%;
        }

        .others-line {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 200px;
            padding: 0 4px;
        }

        /* ─────────────────────────────────────────────
           SECTION D — Narrative
        ───────────────────────────────────────────── */
        .narrative-box {
            width: 100%;
            border: 1px solid #000;
            padding: 5px 6px;
            margin-bottom: 2px;
            min-height: 160px;
            font-size: 9pt;
            line-height: 1.6;
        }

        /* ─────────────────────────────────────────────
           SECTION E — Account
        ───────────────────────────────────────────── */
        .account-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }

        .account-table td {
            border: 1px solid #000;
            padding: 5px 7px;
            font-size: 8pt;
            vertical-align: top;
        }

        .sig-space { height: 42px; display: block; }

        .bank-field {
            margin-bottom: 4px;
            font-size: 8pt;
        }

        .bank-underline {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 80px;
            padding: 0 3px;
        }

        /* ─────────────────────────────────────────────
           CERTIFICATION
        ───────────────────────────────────────────── */
        .certification-title {
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
            text-decoration: underline;
            margin: 7px 0 4px;
        }

        .certification-box {
            border: 1px solid #000;
            padding: 6px 8px;
            font-size: 8pt;
            text-align: justify;
            line-height: 1.45;
            margin-bottom: 8px;
        }

        /* ─────────────────────────────────────────────
           SIGNATURE
        ───────────────────────────────────────────── */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
        }

        .signature-table td {
            border: none;
            text-align: center;
            width: 50%;
            padding: 0 20px;
            vertical-align: bottom;
        }

        .sig-line-block {
            border-bottom: 1px solid #000;
            height: 34px;
            display: block;
            margin-bottom: 2px;
        }

        .sig-label { font-size: 7.5pt; font-style: italic; }

        /* ─────────────────────────────────────────────
           PAGE NUMBER
        ───────────────────────────────────────────── */
        .page-number {
            text-align: right;
            font-size: 8.5pt;
            margin-top: 8px;
        }

        /* ─────────────────────────────────────────────
           ATTACHMENT PAGES
        ───────────────────────────────────────────── */
        .attachment-page-content {
            text-align: center;
            padding-top: 20mm;
        }

        .attachment-title {
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 4px;
        }

        .attachment-subtitle {
            font-size: 9pt;
            color: #444;
            margin-bottom: 16px;
        }

        .attachment-img {
            max-width: 100%;
            max-height: 220mm;
        }

        .attachment-note {
            font-size: 7.5pt;
            font-style: italic;
            color: #888;
            margin-top: 10px;
        }
    </style>
</head>
<body>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- PAGE 1 --}}
{{-- ══════════════════════════════════════════════════════ --}}

{{-- HEADER --}}
<table class="header-table">
    <tr>
        <td class="header-logo-cell">
            @if(file_exists(public_path('images/migrant-logo.png')))
                <img src="{{ public_path('images/migrant-logo.png') }}" class="header-logo" alt="DMW">
            @endif
        </td>
        <td class="header-center">
            <div class="republic">Republic of the Philippines</div>
            <div class="dept-name">Department of Migrant Workers</div>
            <div class="address">Blas F. Ople Building, Ortigas Avenue cor. EDSA, Mandaluyong City 1550</div>
            <div class="contact">Website: www.dmw.gov.ph &nbsp;|&nbsp; Email: feedback@dmw.gov.ph &nbsp;|&nbsp; Hotlines: (632) 952-8072 / 955-9007 / (02) 8722-3606</div>
        </td>
        <td class="header-logo-cell-right">
            @if(file_exists(public_path('images/bagong-pilipinas-logo.png')))
                <img src="{{ public_path('images/bagong-pilipinas-logo.png') }}" class="header-logo-bagong" alt="Bagong Pilipinas">
            @endif
        </td>
    </tr>
</table>

<hr class="divider">

<div class="form-title">REQUEST FOR ASSISTANCE (RFA) FORM</div>

<div class="form-type-row">
    @php
        $mode = $formData['request_type'] ?? '';
    @endphp
    <span class="checkbox-item"><span class="cb">{{ $mode === 'online' ? '☑' : '☐' }}</span> Online</span>
    <span class="checkbox-item"><span class="cb">{{ $mode === 'walkin' ? '☑' : '☐' }}</span> Walk-in</span>
    <span class="checkbox-item"><span class="cb">{{ $mode === 'referral' ? '☑' : '☐' }}</span> Referral by: <span class="referral-line">{{ $formData['referral_by'] ?? '' }}</span></span>
</div>

{{-- ── SECTION A ── --}}
<div class="section-header">A.&nbsp;&nbsp;IMPORMASYON NG OFW:</div>

{{-- OFW Name --}}
<table class="form-table">
    <tr>
        <td class="label-cell">Pangalan ng OFW :</td>
        <td class="value-cell">
            <table class="name-table">
                <tr>
                    <td>
                        <div class="name-value">{{ $formData['name_last'] ?? '' }}</div>
                        <div class="name-label">Last name</div>
                    </td>
                    <td>
                        <div class="name-value">{{ $formData['name_first'] ?? '' }}</div>
                        <div class="name-label">First Name</div>
                    </td>
                    <td>
                        <div class="name-value">{{ $formData['name_middle'] ?? '' }}</div>
                        <div class="name-label">Middle Name</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table class="form-table">
    <tr>
        <td class="label-cell">Birthdate:</td>
        <td class="value-cell">{{ $formData['birthdate'] ?? '' }}</td>
    </tr>
</table>

<table class="form-table">
    <tr>
        <td class="label-cell">Sex (Kasarian):</td>
        <td class="value-cell">
            @php $sex = strtolower($formData['sex'] ?? ''); @endphp
            <span class="checkbox-item"><span class="cb">{{ $sex === 'male' ? '☑' : '☐' }}</span> Male / Lalaki</span>
            <span class="checkbox-item"><span class="cb">{{ $sex === 'female' ? '☑' : '☐' }}</span> Female / Babae</span>
        </td>
    </tr>
</table>

<table class="form-table">
    <tr>
        <td class="label-cell">Civil Status:</td>
        <td class="value-cell">
            @php
                $cs = strtolower($formData['civil_status'] ?? '');
            @endphp
            <span class="checkbox-item"><span class="cb">{{ $cs === 'single' ? '☑' : '☐' }}</span> Single / Walang Asawa</span>
            <span class="checkbox-item"><span class="cb">{{ $cs === 'married' ? '☑' : '☐' }}</span> Married / May Asawa</span>
            <span class="checkbox-item"><span class="cb">{{ $cs === 'widow' ? '☑' : '☐' }}</span> Widow/Widower (Balo)</span>
            <span class="checkbox-item"><span class="cb">{{ $cs === 'separated' ? '☑' : '☐' }}</span> Separated / Hiwalay</span>
            <span class="checkbox-item"><span class="cb">{{ $cs === 'soloparent' ? '☑' : '☐' }}</span> Solo Parent</span>
        </td>
    </tr>
</table>

<table class="form-table">
    <tr>
        <td class="label-cell">Passport / Travel Document No:</td>
        <td class="value-cell">{{ $formData['passport_number'] ?? '' }}</td>
    </tr>
</table>

<table class="form-table">
    <tr>
        <td class="label-cell">Address sa abroad:</td>
        <td class="value-cell">{{ $formData['address_abroad'] ?? '' }}</td>
    </tr>
</table>

<table class="form-table">
    <tr>
        <td class="label-cell">Address sa Pilipinas</td>
        <td class="value-cell">{{ $formData['address_ph'] ?? '' }}</td>
    </tr>
</table>

<table class="form-table">
    <tr>
        <td class="label-cell">Contact No/s. Mobile/Phone No.:</td>
        <td class="value-cell">{{ $formData['phone'] ?? '' }}</td>
    </tr>
</table>

<table class="form-table">
    <tr>
        <td class="label-cell">Email / Facebook Account:</td>
        <td class="value-cell">{{ $formData['email'] ?? '' }}</td>
    </tr>
</table>

{{-- ── SECTION B ── --}}
<div class="section-header" style="margin-top: 8px;">B.&nbsp;&nbsp;IMPORMASYON NG KAMAG-ANAK NG OFW NA HUMIHINGI NG TULONG:</div>

<table class="form-table">
    <tr>
        <td class="label-cell">Pangalan :</td>
        <td class="value-cell">
            <table class="name-table">
                <tr>
                    <td>
                        <div class="name-value">{{ $formData['relative_last'] ?? '' }}</div>
                        <div class="name-label">Last name</div>
                    </td>
                    <td>
                        <div class="name-value">{{ $formData['relative_first'] ?? '' }}</div>
                        <div class="name-label">First Name</div>
                    </td>
                    <td>
                        <div class="name-value">{{ $formData['relative_middle'] ?? '' }}</div>
                        <div class="name-label">Middle Name</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table class="form-table">
    <tr>
        <td class="label-cell">Birthdate:</td>
        <td class="value-cell">{{ $formData['relative_birthdate'] ?? '' }}</td>
    </tr>
</table>

<table class="form-table">
    <tr>
        <td class="label-cell">Relationship to OFW:</td>
        <td class="value-cell">
            @php $rel = strtolower($formData['relative_relationship'] ?? ''); @endphp
            <span class="checkbox-item"><span class="cb">{{ $rel === 'spouse' ? '☑' : '☐' }}</span> Spouse / Asawa</span>
            <span class="checkbox-item"><span class="cb">{{ $rel === 'child' ? '☑' : '☐' }}</span> Child / Anak</span>
            <span class="checkbox-item"><span class="cb">{{ $rel === 'sibling' ? '☑' : '☐' }}</span> Sibling / Kapatid</span>
            <span class="checkbox-item"><span class="cb">{{ str_starts_with($rel, 'other') ? '☑' : '☐' }}</span> Others: <span class="referral-line">{{ $formData['relationship_others'] ?? '' }}</span></span>
        </td>
    </tr>
</table>

<table class="form-table">
    <tr>
        <td class="label-cell">ID No:</td>
        <td class="value-cell">{{ $formData['relative_id_no'] ?? '' }}</td>
    </tr>
</table>

<table class="form-table">
    <tr>
        <td class="label-cell">Address sa Pilipinas</td>
        <td class="value-cell">{{ $formData['relative_address_ph'] ?? '' }}</td>
    </tr>
</table>

<table class="form-table">
    <tr>
        <td class="label-cell">Mobile/Phone No.:</td>
        <td class="value-cell">{{ $formData['relative_mobile'] ?? '' }}</td>
    </tr>
</table>

<table class="form-table">
    <tr>
        <td class="label-cell">Email / Facebook Account:</td>
        <td class="value-cell">{{ $formData['relative_email'] ?? '' }}</td>
    </tr>
</table>

<div class="page-number">15</div>


{{-- ══════════════════════════════════════════════════════ --}}
{{-- PAGE 2 --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="page-break"></div>

{{-- SECTION C --}}
<div class="section-header">C.&nbsp;&nbsp;URI NG TULONG NA HINIHINGI (Please check):</div>

@php
    $assistanceList = is_array($formData['assistance'] ?? null) ? array_map('strtolower', $formData['assistance']) : [];
@endphp

<div class="assistance-box">
    <table class="assistance-table">
        <tr>
            <td><span class="cb">{{ in_array('legal', $assistanceList) ? '☑' : '☐' }}</span> LEGAL ASSISTANCE</td>
            <td><span class="cb">{{ in_array('medical', $assistanceList) ? '☑' : '☐' }}</span> MEDICAL ASSISTANCE</td>
            <td><span class="cb">{{ in_array('repatriation', $assistanceList) ? '☑' : '☐' }}</span> REPATRIATION</td>
        </tr>
        <tr>
            <td><span class="cb">{{ in_array('rescue', $assistanceList) ? '☑' : '☐' }}</span> RESCUE / EVACUATION</td>
            <td colspan="2"><span class="cb">{{ in_array('welfare', $assistanceList) ? '☑' : '☐' }}</span> WELFARE ASSISTANCE FOR SENIOR OFW RETURNEES</td>
        </tr>
        <tr>
            <td><span class="cb">{{ in_array('compassionate', $assistanceList) ? '☑' : '☐' }}</span> COMPASSIONATE VISIT</td>
            <td colspan="2"><span class="cb">{{ in_array('shipment', $assistanceList) ? '☑' : '☐' }}</span> SHIPMENT OF HUMAN REMAINS / CREMAINS</td>
        </tr>
        <tr>
            <td><span class="cb">{{ in_array('food', $assistanceList) ? '☑' : '☐' }}</span> FOOD ASSISTANCE</td>
            <td><span class="cb">{{ in_array('transportation', $assistanceList) ? '☑' : '☐' }}</span> TRANSPORTATION ASSISTANCE</td>
            <td><span class="cb">{{ in_array('shelter', $assistanceList) ? '☑' : '☐' }}</span> TEMPORARY SHELTER</td>
        </tr>
        <tr>
            <td colspan="3">
                <span class="cb">{{ in_array('others', $assistanceList) ? '☑' : '☐' }}</span> OTHERS: <span class="others-line">{{ $formData['assistance_others_text'] ?? ($formData['assistance_others'] ?? '') }}</span>
            </td>
        </tr>
    </table>
</div>

{{-- SECTION D --}}
<div class="section-header" style="margin-top: 8px;">D.&nbsp;&nbsp;MAIKLING SALAYSAY TUNGKOL SA HINIHINGING TULONG:</div>

<div class="narrative-box">
    {!! nl2br(e($formData['request_details'] ?? ($formData['narrative'] ?? ''))) !!}
</div>

{{-- SECTION E --}}
<div class="section-header" style="margin-top: 8px;">E.&nbsp;&nbsp;ACCOUNT KUNG SAAN IDEDEPOSITO ANG PINANSYAL NA TULONG:</div>

<table class="account-table">
    <tr>
        <td style="width: 38%; font-size: 7.5pt;">
            In the event of the approval of my application for financial assistance, I hereby authorize the Department of Migrant Workers to credit the assistance through the account/s I have indicated on the right portion:
        </td>
        <td style="width: 24%; text-align: center; font-weight: bold; font-size: 8pt;">
            SIGNATURE OF<br>APPLICANT:
            <span class="sig-space"></span>
        </td>
        <td style="width: 38%;">
            <div class="bank-field">
                <span class="cb">{{ !empty($formData['bank_account_no']) ? '☑' : '☐' }}</span>
                Bank Account No: <span class="bank-underline">{{ $formData['bank_account_no'] ?? '' }}</span>
            </div>
            <div class="bank-field">
                Bank: <span class="bank-underline">{{ $formData['bank_name'] ?? '' }}</span>
                &nbsp; Branch: <span class="bank-underline">{{ $formData['bank_branch'] ?? '' }}</span>
            </div>
            <div class="bank-field">
                Account Name: <span class="bank-underline">{{ $formData['account_name'] ?? ($formData['bank_account_name'] ?? '') }}</span>
            </div>
        </td>
    </tr>
</table>

{{-- CERTIFICATION --}}
<div class="certification-title">CERTIFICATION</div>

<div class="certification-box">
    I hereby certify that the information given, and all statements made herein are true and correct. Likewise, I hereby authorize DMW to collect, record, organize, update/modify, consult, use, consolidate, block, erase or destruct my personal data as part of my information. I hereby affirm my right to: (a) be informed; (b) object to processing, (c) access, (d) rectify, suspend or withdraw my personal data; (e) damages; and (f) data portability pursuant to the provision of R.A. No. 10173 (Data Privacy Act of 2012).
</div>

<table class="signature-table">
    <tr>
        <td>
            <span class="sig-line-block">{{ $formData['signature_printed'] ?? '' }}</span>
            <div class="sig-label">Signature over Printed Name</div>
        </td>
        <td>
            <span class="sig-line-block">{{ $formData['signature_date'] ?? '' }}</span>
            <div class="sig-label">Date Signed</div>
        </td>
    </tr>
</table>

<div class="page-number">16</div>


{{-- ══════════════════════════════════════════════════════ --}}
{{-- ATTACHMENT PAGES --}}
{{-- ══════════════════════════════════════════════════════ --}}
@if(!empty($attachments))
    @foreach($attachments as $index => $attachmentPath)
        @php
            $fullPath = storage_path('app/public/' . $attachmentPath);
            $exists = file_exists($fullPath);
            $mime = $exists ? (mime_content_type($fullPath) ?: '') : '';
            $isImage = $exists && str_starts_with($mime, 'image/');
            $pageNum = $index + 3;
            $label = $index === 0 ? 'Employment Contract' : ($index === 1 ? 'Passport / Travel Document' : 'Attachment ' . ($index + 1));
        @endphp

        <div class="page-break"></div>
        <div class="attachment-page-content">
            <div class="attachment-title">Page {{ $pageNum }} — {{ $label }}</div>
            <div class="attachment-subtitle">
                @if($index === 0)
                    Attached: Employment Contract
                @elseif($index === 1)
                    Attached: Passport / Travel Document
                @else
                    Attached document
                @endif
            </div>

            @if($isImage)
                <img src="{{ $fullPath }}" class="attachment-img" alt="{{ $label }}">
            @elseif($exists)
                <div class="attachment-note">[Attached file: {{ basename($attachmentPath) }}]</div>
            @else
                <div class="attachment-note">[File not found: {{ basename($attachmentPath) }}]</div>
            @endif
        </div>

        <div class="page-number">{{ 14 + $pageNum }}</div>
    @endforeach
@endif

</body>
</html>
