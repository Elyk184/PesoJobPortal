@extends('layouts.dashboard')

@section('title', 'Request for Assistance (RFA) Form - DMW')

@section('dashboard-mobile-brand')
    <div class="dashboard-mobile-brand">
        <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
        <span>OFW Portal</span>
    </div>
@endsection

@section('dashboard-sidebar')
    @include('dashboard.partials.ofw-nav')
@endsection

@push('styles')
<style>
        /* ─────────────────────────────────────────────
           RESET & BASE
        ───────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        .dmw-builder-shell {
            font-family: Arial, sans-serif;
            font-size: 10.5pt;
            background: #b0b8c8;
            color: #000;
            padding: 18px 0 26px;
        }

        /* ─────────────────────────────────────────────
           DOWNLOAD BAR (hidden from PDF)
        ───────────────────────────────────────────── */
        .download-bar {
            background: #1a3a6b;
            text-align: center;
            padding: 11px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            max-width: 210mm;
            margin: 14px auto 0;
            border-radius: 6px;
        }

        .download-bar .btn-download {
            background: #f5c518;
            color: #1a1a1a;
            border: none;
            padding: 8px 30px;
            font-size: 11pt;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            letter-spacing: 0.3px;
            transition: background 0.2s;
        }

        .download-bar .btn-download:hover { background: #e0b210; }

        .download-bar .btn-download:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .download-bar span {
            color: #aac4f5;
            font-size: 9pt;
        }

        #downloadProgress {
            display: none;
            color: #f5c518;
            font-size: 9.5pt;
            font-style: italic;
        }

        /* ─────────────────────────────────────────────
           A4 PAGE  (210mm × 297mm)
        ───────────────────────────────────────────── */
        .page {
            width: 210mm;
            min-height: 297mm;
            background: #fff;
            margin: 18px auto;
            padding: 13mm 14mm 13mm 14mm;
            box-shadow: 0 2px 14px rgba(0,0,0,.22);
            position: relative;
            page-break-after: always;
        }

        /* ─────────────────────────────────────────────
           HEADER
        ───────────────────────────────────────────── */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 5px;
            gap: 6px;
        }

        .header-logo {
            width: 64px;
            height: 64px;
            object-fit: contain;
            flex-shrink: 0;
        }

        /* Bagong Pilipinas logo is wider/rectangular — constrain it smaller */
.header-logo-bagong {
            width: 80px;
            height: 80px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .header-center {
            flex: 1;
            text-align: center;
        }

        .header-center .republic   { font-size: 8.5pt; }
        .header-center .dept-name  { font-size: 15pt; font-weight: bold; font-family: 'Times New Roman', serif; line-height: 1.15; }
        .header-center .address    { font-size: 7pt; margin-top: 2px; }
        .header-center .contact    { font-size: 6.5pt; color: #333; }

        hr.divider { border: none; border-top: 1.2px solid #000; margin: 5px 0; }

        /* ─────────────────────────────────────────────
           FORM TITLE & TYPE ROW
        ───────────────────────────────────────────── */
        .form-title {
            text-align: center;
            font-weight: bold;
            font-size: 11.5pt;
            text-decoration: underline;
            margin: 8px 0 5px;
            letter-spacing: .3px;
        }

        .form-type-row {
            text-align: center;
            font-size: 9pt;
            margin-bottom: 8px;
        }

        .form-type-row label { margin: 0 9px; cursor: pointer; }
        .form-type-row input[type="checkbox"] { margin-right: 3px; vertical-align: middle; }

        .referral-input {
            border: none;
            border-bottom: 1px solid #000;
            width: 130px;
            outline: none;
            font-size: 9pt;
        }

        /* ─────────────────────────────────────────────
           SECTION HEADER
        ───────────────────────────────────────────── */
        .section-header {
            font-weight: bold;
            font-size: 9pt;
            text-decoration: underline;
            margin: 9px 0 4px;
        }

        /* ─────────────────────────────────────────────
           FORM TABLE
        ───────────────────────────────────────────── */
        .form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }

        .form-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
            font-size: 9pt;
        }

        .label-cell {
            background: #efefef;
            font-weight: bold;
            white-space: nowrap;
            width: 30%;
            vertical-align: middle;
        }

        .input-cell input[type="text"],
        .input-cell input[type="date"],
        .input-cell input[type="email"] {
            width: 100%;
            border: none;
            outline: none;
            font-size: 9pt;
            font-family: Arial, sans-serif;
            background: transparent;
        }

        /* ── Name fields (3-col split) ── */
        .name-fields {
            display: flex;
            gap: 0;
        }

        .name-field {
            flex: 1;
            padding: 0 4px;
            border-right: 1px solid #ccc;
        }

        .name-field:last-child { border-right: none; }

        .name-field input {
            width: 100%;
            border: none;
            border-bottom: 1px solid #aaa;
            outline: none;
            font-size: 9pt;
            font-family: Arial, sans-serif;
            background: transparent;
        }

        .name-field-label {
            font-size: 6.5pt;
            font-style: italic;
            color: #555;
            margin-top: 1px;
        }

        /* ── Checkbox groups ── */
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 4px 16px;
            align-items: center;
        }

        .checkbox-group label,
        .sex-row label {
            display: flex;
            align-items: center;
            gap: 3px;
            font-size: 9pt;
            cursor: pointer;
            white-space: nowrap;
        }

        .sex-row { display: flex; gap: 36px; align-items: center; }

        /* ─────────────────────────────────────────────
           PAGE 2 — SECTION C
        ───────────────────────────────────────────── */
        .assistance-types {
            width: 100%;
            border: 1px solid #000;
            padding: 7px 10px;
            margin-bottom: 3px;
        }

        .assistance-row {
            display: flex;
            gap: 10px;
            margin-bottom: 4px;
            flex-wrap: wrap;
        }

        .assistance-row label {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 9pt;
            cursor: pointer;
            flex: 1;
            min-width: 170px;
        }

        .others-row {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 9pt;
            margin-top: 2px;
        }

        .others-input {
            border: none;
            border-bottom: 1px solid #000;
            flex: 1;
            outline: none;
            font-size: 9pt;
        }

        /* ─────────────────────────────────────────────
           SECTION D — Narrative
        ───────────────────────────────────────────── */
        .narrative-box {
            width: 100%;
            border: 1px solid #000;
            padding: 5px 6px;
            margin-bottom: 3px;
        }

        .narrative-box textarea {
            width: 100%;
            border: none;
            outline: none;
            font-family: Arial, sans-serif;
            font-size: 9pt;
            resize: none;
            min-height: 190px;
            background: transparent;
            background-image: repeating-linear-gradient(
                to bottom, transparent, transparent 21px, #ccc 21px, #ccc 22px
            );
            line-height: 22px;
            padding-top: 1px;
        }

        /* ─────────────────────────────────────────────
           SECTION E — Account
        ───────────────────────────────────────────── */
        .account-table { width: 100%; border-collapse: collapse; margin-bottom: 3px; }

        .account-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            font-size: 8.5pt;
            vertical-align: top;
        }

        .account-table .auth-text  { width: 38%; font-size: 8pt; }
        .account-table .sig-cell   { width: 24%; text-align: center; font-weight: bold; font-size: 8.5pt; }
        .account-table .bank-cell  { width: 38%; }

        .sig-space { height: 52px; display: block; }

        .bank-field {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
            font-size: 8.5pt;
            gap: 4px;
        }

        .bank-field input[type="text"] {
            border: none;
            border-bottom: 1px solid #000;
            outline: none;
            font-size: 8.5pt;
            flex: 1;
            min-width: 0;
            background: transparent;
        }

        /* ─────────────────────────────────────────────
           CERTIFICATION
        ───────────────────────────────────────────── */
        .certification-title {
            text-align: center;
            font-weight: bold;
            font-size: 10.5pt;
            text-decoration: underline;
            margin: 9px 0 5px;
        }

        .certification-box {
            border: 1px solid #000;
            padding: 7px 10px;
            font-size: 8.5pt;
            text-align: justify;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        /* ─────────────────────────────────────────────
           SIGNATURE
        ───────────────────────────────────────────── */
        .signature-section { display: flex; gap: 20px; margin-top: 18px; }

        .sig-block { flex: 1; text-align: center; }

        .sig-line {
            border-bottom: 1px solid #000;
            width: 100%;
            height: 38px;
            display: block;
            margin-bottom: 3px;
        }

        .sig-label { font-size: 8pt; font-style: italic; }

        /* ─────────────────────────────────────────────
           PAGE NUMBER
        ───────────────────────────────────────────── */
        .page-number { text-align: right; font-size: 9pt; margin-top: 12px; }

        /* ─────────────────────────────────────────────
           PAGES 3 & 4 — ATTACHMENT
        ───────────────────────────────────────────── */
        .attachment-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 300mm;
        }

        .attachment-header { width: 100%; text-align: center; margin-bottom: 18px; }

        .attachment-header .page-label {
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 3px;
        }

        .attachment-header .page-sublabel { font-size: 9pt; color: #444; }

        .upload-area {
            width: 100%;
            max-width: 500px;
            min-height: 320px;
            border: 2.5px dashed #999;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 28px 20px;
            cursor: pointer;
            background: #fafafa;
            position: relative;
            transition: background .2s, border-color .2s;
        }

        .upload-area:hover { background: #f0f0f0; border-color: #666; }

        .upload-area input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .upload-icon   { font-size: 50px; margin-bottom: 10px; color: #aaa; }
        .upload-text   { font-size: 10pt; color: #666; margin-bottom: 4px; text-align: center; }
        .upload-subtext{ font-size: 8pt; color: #999; text-align: center; }

        .preview-image {
            max-width: 100%;
            max-height: 440px;
            object-fit: contain;
            display: none;
            border-radius: 4px;
            position: relative;
            z-index: 0;
        }

        .remove-btn {
            display: none;
            margin-top: 10px;
            padding: 5px 18px;
            background: #c0392b;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 9pt;
            z-index: 2;
            position: relative;
        }

        .remove-btn:hover { background: #a93226; }

        .attachment-note {
            margin-top: 12px;
            font-size: 8pt;
            font-style: italic;
            color: #888;
            text-align: center;
        }

        /* ─────────────────────────────────────────────
           PRINT — hide bar; everything else renders via html2pdf
        ───────────────────────────────────────────── */
        @media print {
            .download-bar { display: none !important; }
        }
    </style>
@endpush

@section('content')
<div class="dmw-builder-shell">

<form method="POST" action="{{ route('ofw.dmw-download') }}" enctype="multipart/form-data">
    @csrf

    {{-- Signature date for the PDF --}}
    <input type="hidden" name="signature_date" value="{{ now()->toDateString() }}">

<div id="dmwPdfPages">

{{-- ══════════════════════════════════════════════════════ --}}
{{-- PAGE 1 --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="page" id="page1">

    <div class="header">
        {{-- DMW logo --}}
        <img src="{{ asset('images/migrant-logo.png') }}" alt="DMW Logo" class="header-logo">

        <div class="header-center">
            <div class="republic">Republic of the Philippines</div>
            <div class="dept-name">Department of Migrant Workers</div>
            <div class="address">Blas F. Ople Building, Ortigas Avenue cor. EDSA, Mandaluyong City 1550</div>
            <div class="contact">Website: www.dmw.gov.ph &nbsp;|&nbsp; Email: feedback@dmw.gov.ph &nbsp;|&nbsp; Hotlines: (632) 952-8072 / 955-9007 / (02) 8722-3606</div>
        </div>

        {{-- Bagong Pilipinas logo --}}
        <img src="{{ asset('images/bagong-pilipinas-logo.png') }}" alt="Bagong Pilipinas" class="header-logo-bagong">
    </div>

    <hr class="divider">

    <div class="form-title">REQUEST FOR ASSISTANCE (RFA) FORM</div>

    <div class="form-type-row">
        <label><input type="checkbox" name="mode" value="online"> Online</label>
        <label><input type="checkbox" name="mode" value="walkin"> Walk-in</label>
        <label>
            <input type="checkbox" name="mode" value="referral"> Referral by:
            <input type="text" class="referral-input" name="referral_by">
        </label>
    </div>

    {{-- ── SECTION A ── --}}
    <div class="section-header">A.&nbsp;&nbsp;IMPORMASYON NG OFW:</div>

    {{-- Pangalan ng OFW --}}
    <table class="form-table">
        <tr>
            <td class="label-cell">Pangalan ng OFW :</td>
            <td class="input-cell">
                <div class="name-fields">
                    <div class="name-field">
                        <input type="text" name="ofw_lastname">
                        <div class="name-field-label">Last name</div>
                    </div>
                    <div class="name-field">
                        <input type="text" name="ofw_firstname">
                        <div class="name-field-label">First Name</div>
                    </div>
                    <div class="name-field">
                        <input type="text" name="ofw_middlename">
                        <div class="name-field-label">Middle Name</div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table class="form-table">
        <tr>
            <td class="label-cell">Birthdate:</td>
            <td class="input-cell"><input type="date" name="ofw_birthdate"></td>
        </tr>
    </table>

    <table class="form-table">
        <tr>
            <td class="label-cell">Sex (Kasarian):</td>
            <td class="input-cell">
                <div class="sex-row">
                    <label><input type="radio" name="ofw_sex" value="male"> Male / Lalaki</label>
                    <label><input type="radio" name="ofw_sex" value="female"> Female / Babae</label>
                </div>
            </td>
        </tr>
    </table>

    <table class="form-table">
        <tr>
            <td class="label-cell">Civil Status:</td>
            <td class="input-cell" style="padding:5px 6px;">
                <div class="checkbox-group">
                    <label><input type="checkbox" name="civil_status" value="single"> Single / Walang Asawa</label>
                    <label><input type="checkbox" name="civil_status" value="married"> Married / May Asawa</label>
                    <label><input type="checkbox" name="civil_status" value="widow"> Widow/Widower (Balo)</label>
                    <label><input type="checkbox" name="civil_status" value="separated"> Separated / Hiwalay</label>
                    <label><input type="checkbox" name="civil_status" value="soloparent"> Solo Parent</label>
                </div>
            </td>
        </tr>
    </table>

    <table class="form-table">
        <tr>
            <td class="label-cell">Passport / Travel Document No:</td>
            <td class="input-cell"><input type="text" name="ofw_passport"></td>
        </tr>
    </table>

    <table class="form-table">
        <tr>
            <td class="label-cell">Address sa abroad:</td>
            <td class="input-cell"><input type="text" name="ofw_address_abroad"></td>
        </tr>
    </table>

    <table class="form-table">
        <tr>
            <td class="label-cell">Address sa Pilipinas</td>
            <td class="input-cell"><input type="text" name="ofw_address_ph"></td>
        </tr>
    </table>

    <table class="form-table">
        <tr>
            <td class="label-cell">Contact No/s. Mobile/Phone No.:</td>
            <td class="input-cell"><input type="text" name="ofw_contact"></td>
        </tr>
    </table>

    <table class="form-table">
        <tr>
            <td class="label-cell">Email / Facebook Account:</td>
            <td class="input-cell"><input type="text" name="ofw_email"></td>
        </tr>
    </table>

    {{-- ── SECTION B ── --}}
    <div class="section-header" style="margin-top:12px;">B.&nbsp;&nbsp;IMPORMASYON NG KAMAG-ANAK NG OFW NA HUMIHINGI NG TULONG:</div>

    <table class="form-table">
        <tr>
            <td class="label-cell">Pangalan :</td>
            <td class="input-cell">
                <div class="name-fields">
                    <div class="name-field">
                        <input type="text" name="fam_lastname">
                        <div class="name-field-label">Last name</div>
                    </div>
                    <div class="name-field">
                        <input type="text" name="fam_firstname">
                        <div class="name-field-label">First Name</div>
                    </div>
                    <div class="name-field">
                        <input type="text" name="fam_middlename">
                        <div class="name-field-label">Middle Name</div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table class="form-table">
        <tr>
            <td class="label-cell">Birthdate:</td>
            <td class="input-cell"><input type="date" name="fam_birthdate"></td>
        </tr>
    </table>

    <table class="form-table">
        <tr>
            <td class="label-cell">Relationship to OFW:</td>
            <td class="input-cell" style="padding:5px 6px;">
                <div class="checkbox-group">
                    <label><input type="checkbox" name="relationship" value="spouse"> Spouse / Asawa</label>
                    <label><input type="checkbox" name="relationship" value="child"> Child / Anak</label>
                    <label><input type="checkbox" name="relationship" value="sibling"> Sibling / Kapatid</label>
                    <label>
                        <input type="checkbox" name="relationship" value="others"> Others:
                        <input type="text" name="relationship_others"
                               style="border:none;border-bottom:1px solid #000;width:110px;outline:none;font-size:9pt;background:transparent;">
                    </label>
                </div>
            </td>
        </tr>
    </table>

    <table class="form-table">
        <tr>
            <td class="label-cell">ID No:</td>
            <td class="input-cell"><input type="text" name="fam_id"></td>
        </tr>
    </table>

    <table class="form-table">
        <tr>
            <td class="label-cell">Address sa Pilipinas</td>
            <td class="input-cell"><input type="text" name="fam_address"></td>
        </tr>
    </table>

    <table class="form-table">
        <tr>
            <td class="label-cell">Mobile/Phone No.:</td>
            <td class="input-cell"><input type="text" name="fam_contact"></td>
        </tr>
    </table>

    <table class="form-table">
        <tr>
            <td class="label-cell">Email / Facebook Account:</td>
            <td class="input-cell"><input type="text" name="fam_email"></td>
        </tr>
    </table>

    <div class="page-number">15</div>
</div>
{{-- END PAGE 1 --}}


{{-- ══════════════════════════════════════════════════════ --}}
{{-- PAGE 2 --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="page" id="page2">

    {{-- SECTION C --}}
    <div class="section-header">C.&nbsp;&nbsp;URI NG TULONG NA HINIHINGI (Please check):</div>

    <div class="assistance-types">
        <div class="assistance-row">
            <label><input type="checkbox" name="assistance[]" value="legal"> LEGAL ASSISTANCE</label>
            <label><input type="checkbox" name="assistance[]" value="medical"> MEDICAL ASSISTANCE</label>
            <label><input type="checkbox" name="assistance[]" value="repatriation"> REPATRIATION</label>
        </div>
        <div class="assistance-row">
            <label><input type="checkbox" name="assistance[]" value="rescue"> RESCUE / EVACUATION</label>
            <label><input type="checkbox" name="assistance[]" value="welfare"> WELFARE ASSISTANCE FOR SENIOR OFW RETURNEES</label>
        </div>
        <div class="assistance-row">
            <label><input type="checkbox" name="assistance[]" value="compassionate"> COMPASSIONATE VISIT</label>
            <label><input type="checkbox" name="assistance[]" value="shipment"> SHIPMENT OF HUMAN REMAINS / CREMAINS</label>
        </div>
        <div class="assistance-row">
            <label><input type="checkbox" name="assistance[]" value="food"> FOOD ASSISTANCE</label>
            <label><input type="checkbox" name="assistance[]" value="transportation"> TRANSPORTATION ASSISTANCE</label>
            <label><input type="checkbox" name="assistance[]" value="shelter"> TEMPORARY SHELTER</label>
        </div>
        <div class="others-row">
            <input type="checkbox" name="assistance[]" value="others" id="other_check">
            <label for="other_check">OTHERS</label>
            <input type="text" class="others-input" name="assistance_others">
        </div>
    </div>

    {{-- SECTION D --}}
    <div class="section-header" style="margin-top:10px;">D.&nbsp;&nbsp;MAIKLING SALAYSAY TUNGKOL SA HINIHINGING TULONG:</div>

    <div class="narrative-box">
        <textarea name="narrative" placeholder="Isulat ang maikling salaysay tungkol sa hinihinging tulong..."></textarea>
    </div>

    {{-- SECTION E --}}
    <div class="section-header" style="margin-top:10px;">E.&nbsp;&nbsp;ACCOUNT KUNG SAAN IDEDEPOSITO ANG PINANSYAL NA TULONG:</div>

    <table class="account-table">
        <tr>
            <td class="auth-text">
                In the event of the approval of my application for financial assistance, I hereby authorize the Department of Migrant Workers to credit the assistance through the account/s I have indicated on the right portion:
            </td>
            <td class="sig-cell">
                SIGNATURE OF<br>APPLICANT:
                <span class="sig-space"></span>
            </td>
            <td class="bank-cell">
                <div class="bank-field">
                    <input type="checkbox" name="has_bank" value="1">
                    <span style="white-space:nowrap;">Bank Account No:</span>
                    <input type="text" name="bank_account_no">
                </div>
                <div class="bank-field">
                    <span>Bank:</span>
                    <input type="text" name="bank_name" style="max-width:85px;">
                    <span>Branch:</span>
                    <input type="text" name="bank_branch" style="max-width:75px;">
                </div>
                <div class="bank-field">
                    <span style="white-space:nowrap;">Account Name:</span>
                    <input type="text" name="bank_account_name">
                </div>
            </td>
        </tr>
    </table>

    {{-- CERTIFICATION --}}
    <div class="certification-title">CERTIFICATION</div>

    <div class="certification-box">
        I hereby certify that the information given, and all statements made herein are true and correct. Likewise, I hereby authorize DMW to collect, record, organize, update/modify, consult, use, consolidate, block, erase or destruct my personal data as part of my information. I hereby affirm my right to: (a) be informed; (b) object to processing, (c) access, (d) rectify, suspend or withdraw my personal data; (e) damages; and (f) data portability pursuant to the provision of R.A. No. 10173 (Data Privacy Act of 2012).
    </div>

    <div class="signature-section">
        <div class="sig-block">
            <span class="sig-line"></span>
            <div class="sig-label">Signature over Printed Name</div>
        </div>
        <div class="sig-block">
            <span class="sig-line"></span>
            <div class="sig-label">Date Signed</div>
        </div>
    </div>

    <div class="page-number">16</div>
</div>
{{-- END PAGE 2 --}}


{{-- ══════════════════════════════════════════════════════ --}}
{{-- PAGE 3 — CONTRACT PICTURE ATTACHMENT --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="page" id="page3">
    <div class="attachment-page">

        <div class="attachment-header">
            <div class="page-label">Page 3 — Employment Contract</div>
            <div class="page-sublabel">Attach a clear photo or scanned copy of your Employment Contract</div>
        </div>

        <div class="upload-area" id="contractArea">
            <input type="file" name="contract_attachment" id="contractFile" accept="image/*"
                   onchange="previewFile(this,'contractPreview','contractArea','contractRemove','contractPlaceholder')">

            <div id="contractPlaceholder" style="display:flex;flex-direction:column;align-items:center;">
                <div class="upload-icon">📄</div>
                <div class="upload-text">Click to upload or drag &amp; drop</div>
                <div class="upload-subtext">Employment Contract photo (JPG, PNG)</div>
            </div>

            <img id="contractPreview" class="preview-image" alt="Contract">
        </div>

        <button class="remove-btn" id="contractRemove"
                onclick="removeFile('contractFile','contractPreview','contractArea','contractRemove','contractPlaceholder')">
            ✕ Remove
        </button>

        <div class="attachment-note">Accepted: JPG, PNG &nbsp;|&nbsp; Max size: 10 MB</div>
    </div>

    <div class="page-number">17</div>
</div>
{{-- END PAGE 3 --}}


{{-- ══════════════════════════════════════════════════════ --}}
{{-- PAGE 4 — PASSPORT PICTURE ATTACHMENT --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="page" id="page4">
    <div class="attachment-page">

        <div class="attachment-header">
            <div class="page-label">Page 4 — Passport / Travel Document</div>
            <div class="page-sublabel">Attach a clear photo or scanned copy of the data page of your Passport</div>
        </div>

        <div class="upload-area" id="passportArea">
            <input type="file" name="passport_attachment" id="passportFile" accept="image/*"
                   onchange="previewFile(this,'passportPreview','passportArea','passportRemove','passportPlaceholder')">

            <div id="passportPlaceholder" style="display:flex;flex-direction:column;align-items:center;">
                <div class="upload-icon">🛂</div>
                <div class="upload-text">Click to upload or drag &amp; drop</div>
                <div class="upload-subtext">Passport data page photo (JPG, PNG)</div>
            </div>

            <img id="passportPreview" class="preview-image" alt="Passport">
        </div>

        <button class="remove-btn" id="passportRemove"
                onclick="removeFile('passportFile','passportPreview','passportArea','passportRemove','passportPlaceholder')">
            ✕ Remove
        </button>

        <div class="attachment-note">Accepted: JPG, PNG &nbsp;|&nbsp; Max size: 10 MB</div>
    </div>

    <div class="page-number">18</div>
</div>
{{-- END PAGE 4 --}}

</div>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- DOWNLOAD BAR --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="download-bar">
    <button class="btn-download" id="btnDownload" type="submit">
        ⬇ Download as PDF
    </button>
    <span id="downloadProgress" style="display:none;">Generating PDF, please wait…</span>
    <span id="downloadHint">Fill out required fields before downloading</span>
</div>

</div>
</form>
@endsection

@push('scripts')
<script>
/* ──────────────────────────────────────────────────────
   IMAGE UPLOAD PREVIEW
────────────────────────────────────────────────────── */
function previewFile(input, previewId, areaId, removeId, placeholderId) {
    const file = input.files[0];
    if (!file) return;

    const preview     = document.getElementById(previewId);
    const area        = document.getElementById(areaId);
    const removeBtn   = document.getElementById(removeId);
    const placeholder = document.getElementById(placeholderId);

    const reader = new FileReader();
    reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
        placeholder.style.display = 'none';
        removeBtn.style.display = 'inline-block';
        area.style.border = '2.5px solid #2c7a2c';
        area.style.background = '#f0fff0';
    };
    reader.readAsDataURL(file);
}

function removeFile(fileId, previewId, areaId, removeId, placeholderId) {
    document.getElementById(fileId).value = '';
    const preview     = document.getElementById(previewId);
    const area        = document.getElementById(areaId);
    const removeBtn   = document.getElementById(removeId);
    const placeholder = document.getElementById(placeholderId);

    preview.src = '';
    preview.style.display = 'none';
    placeholder.style.display = 'flex';
    removeBtn.style.display = 'none';
    area.style.border = '2.5px dashed #999';
    area.style.background = '#fafafa';
}

/* ──────────────────────────────────────────────────────
   SINGLE-SELECT civil status checkboxes
────────────────────────────────────────────────────── */
document.querySelectorAll('input[name="civil_status"]').forEach(function (cb) {
    cb.addEventListener('change', function () {
        if (this.checked) {
            document.querySelectorAll('input[name="civil_status"]').forEach(function (o) {
                if (o !== cb) o.checked = false;
            });
        }
    });
});

// Single-select for relationship checkboxes
document.querySelectorAll('input[name="relationship"]').forEach(function (cb) {
    cb.addEventListener('change', function () {
        if (this.checked) {
            document.querySelectorAll('input[name="relationship"]').forEach(function (o) {
                if (o !== cb) o.checked = false;
            });
        }
    });
});
</script>
@endpush
