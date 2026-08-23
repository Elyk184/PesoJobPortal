<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>DMW Request for Assistance Form</title>
<style>
@page { margin: 0; }
* { box-sizing: border-box; }
body { margin: 0; font-family: Arial, Helvetica, sans-serif; color: #000; font-size: 9pt; }
.page { width: 184mm; min-height: 273mm; height: auto; margin: 0 auto; padding: 10mm 13mm 14mm; page-break-after: always; page-break-inside: avoid; position: relative; background: #fbfdfe; }
.page:last-child { page-break-after: auto; }
.dmw-content-page { display: none; }
.header { display: table; width: 100%; height: 66px; table-layout: fixed; margin-bottom: 4px; }
.header > div { display: table-cell; vertical-align: middle; text-align: center; }
.header .logo { width: 66px; text-align: left; }
.header .logo.right { width: 66px; text-align: right; }
.logo img { max-width: 66px; max-height: 66px; }
.header-center { line-height: 1.25; }
.rep { font-size: 8pt; }
.dept { font: bold 16pt/1.1 'Times New Roman', serif; }
.addr { font-size: 6.5pt; margin-top: 2px; }
.cont { font-size: 6pt; color: #444; }
.divider { border: 0; border-top: 1.5px solid #000; margin: 5px 0; }
.title { text-align: center; font-weight: bold; font-size: 12pt; text-decoration: underline; margin: 7px 0 5px; }
.mode { text-align: center; font-size: 9pt; margin-bottom: 8px; }
.sec { font-weight: bold; font-size: 9pt; margin: 9px 0 4px; }
table { width: 100%; border-collapse: collapse; }
.form td { border: 1px solid #b9d6e1; padding: 4px 7px; height: 24px; vertical-align: middle; background: #eaf5f8; }
.form .label { width: 165px; background: #dceef3; font-weight: bold; white-space: nowrap; }
.name { display: table; width: 100%; table-layout: fixed; }
.name > div { display: table-cell; padding: 3px 6px; border-right: 1px solid #c8d8de; font-size: 8pt; }
.name > div:last-child { border-right: 0; }
.line { border-bottom: 1px solid #777; height: 14px; }
.small { font-size: 7pt; font-style: italic; color: #666; margin-top: 2px; }
.check { font-size: 8.5pt; line-height: 1.55; }
.value { min-height: 14px; }
.box { border: 1px solid #000; padding: 6px 10px; }
.assist { font-size: 9pt; line-height: 1.55; }
.narrative { height: 145px; white-space: pre-wrap; line-height: 20px; background: repeating-linear-gradient(to bottom, transparent, transparent 19px, #c8c8c8 19px, #c8c8c8 20px); }
.account td { border: 1px solid #000; padding: 6px 8px; vertical-align: top; font-size: 8.5pt; }
.auth { width: 37%; font-size: 8pt !important; line-height: 1.55; }
.sig { width: 22%; text-align: center; font-weight: bold; }
.sig-space { height: 46px; border-bottom: 1px solid #000; margin-top: 6px; }
.bank { width: 41%; }
.cert-title { text-align: center; font-weight: bold; font-size: 10.5pt; text-decoration: underline; margin: 8px 0 5px; }
.cert { border: 1px solid #000; padding: 7px 10px; font-size: 8pt; text-align: justify; line-height: 1.55; }
.signatures { display: table; width: 100%; table-layout: fixed; margin-top: 16px; }
.signatures > div { display: table-cell; text-align: center; padding: 0 12px; }
.sign-line { border-bottom: 1px solid #000; height: 34px; }
.sign-label { font-size: 8pt; font-style: italic; margin-top: 3px; }
.page-number { position: absolute; right: 13mm; bottom: 10mm; font-size: 8.5pt; }
.attachment { text-align: center; padding-top: 20px; }
.attachment-title { font-size: 11.5pt; font-weight: bold; text-decoration: underline; }
.attachment-subtitle { font-size: 8.5pt; color: #555; margin-top: 3px; }
.uploaded { width: 100%; height: 190mm; margin-top: 14px; border: 1px solid #999; text-align: center; padding: 6mm; }
.uploaded img { max-width: 100%; max-height: 178mm; }
</style>
</head>
<body>
<div class="page dmw-content-page">
  <div class="header">
    <div class="logo">@if($owwa_logo)<img src="{{ $owwa_logo }}" alt="OWWA">@endif</div>
    <div class="header-center"><div class="rep">Republic of the Philippines</div><div class="dept">Department of Migrant Workers</div><div class="addr">Blas F. Ople Building, Ortigas Avenue cor. EDSA, Mandaluyong City 1550</div><div class="cont">Website: www.dmw.gov.ph | Email: feedback@dmw.gov.ph | Hotlines: (632) 952-8072 / 955-9007 / (02) 8722-3606</div></div>
    <div class="logo right">@if($bagong_logo)<img src="{{ $bagong_logo }}" alt="Bagong Pilipinas">@endif</div>
  </div>
  <hr class="divider">
  <div class="title">REQUEST FOR ASSISTANCE (RFA) FORM</div>
  <div class="mode">[{{ in_array('online', $mode ?? []) ? 'X' : ' ' }}] Online &nbsp;&nbsp;&nbsp; [{{ in_array('walkin', $mode ?? []) ? 'X' : ' ' }}] Walk-in &nbsp;&nbsp;&nbsp; [{{ in_array('referral', $mode ?? []) ? 'X' : ' ' }}] Referral by: ____________________ {{ $referral_by ?? '' }}</div>
  <div class="sec">A. &nbsp; IMPORMASYON NG OFW:</div>
  <table class="form">
    <tr><td class="label">Pangalan ng OFW :</td><td><div class="name"><div>{{ $ofw_lastname ?? '' }}<div class="small">Last name</div></div><div>{{ $ofw_firstname ?? '' }}<div class="small">First Name</div></div><div>{{ $ofw_middlename ?? '' }}<div class="small">Middle Name</div></div></div></td></tr>
    <tr><td class="label">Birthdate:</td><td>{{ $ofw_birthdate ?? '' }}</td></tr>
    <tr><td class="label">Sex (Kasarian):</td><td class="check">[{{ ($ofw_sex ?? '') === 'male' ? 'X' : ' ' }}] Male/Lalaki &nbsp;&nbsp;&nbsp; [{{ ($ofw_sex ?? '') === 'female' ? 'X' : ' ' }}] Female/Babae</td></tr>
    <tr><td class="label">Civil Status:</td><td class="check">[{{ in_array('single', $civil_status ?? []) ? 'X' : ' ' }}] Single / Walang Asawa &nbsp; [{{ in_array('married', $civil_status ?? []) ? 'X' : ' ' }}] Married / May Asawa &nbsp; [{{ in_array('widow', $civil_status ?? []) ? 'X' : ' ' }}] Widow/Widower (Balo)<br>[{{ in_array('separated', $civil_status ?? []) ? 'X' : ' ' }}] Separated / Hiwalay &nbsp; [{{ in_array('soloparent', $civil_status ?? []) ? 'X' : ' ' }}] Solo Parent</td></tr>
    <tr><td class="label">Passport / Travel Document No:</td><td>{{ $ofw_passport ?? '' }}</td></tr>
    <tr><td class="label">Address sa abroad:</td><td>{{ $ofw_address_abroad ?? '' }}</td></tr>
    <tr><td class="label">Address sa Pilipinas</td><td>{{ $ofw_address_ph ?? '' }}</td></tr>
    <tr><td class="label">Contact No/s. Mobile/Phone No.:</td><td>{{ $ofw_contact ?? '' }}</td></tr>
    <tr><td class="label">Email / Facebook Account:</td><td>{{ $ofw_email ?? '' }}</td></tr>
  </table>
  <div class="sec" style="margin-top:12px;">B. &nbsp; IMPORMASYON NG KAMAG-ANAK NG OFW NA HUMIHINGI NG TULONG:</div>
  <table class="form">
    <tr><td class="label">Pangalan :</td><td><div class="name"><div>{{ $fam_lastname ?? '' }}<div class="small">Last name</div></div><div>{{ $fam_firstname ?? '' }}<div class="small">First Name</div></div><div>{{ $fam_middlename ?? '' }}<div class="small">Middle Name</div></div></div></td></tr>
    <tr><td class="label">Birthdate:</td><td>{{ $fam_birthdate ?? '' }}</td></tr>
    <tr><td class="label">Relationship to OFW:</td><td class="check">[{{ in_array('spouse', $relationship ?? []) ? 'X' : ' ' }}] Spouse / Asawa &nbsp; [{{ in_array('child', $relationship ?? []) ? 'X' : ' ' }}] Child / Anak &nbsp; [{{ in_array('sibling', $relationship ?? []) ? 'X' : ' ' }}] Sibling / Kapatid &nbsp; [{{ in_array('others', $relationship ?? []) ? 'X' : ' ' }}] Others {{ $relationship_others ?? '' }}</td></tr>
    <tr><td class="label">ID No:</td><td>{{ $fam_id ?? '' }}</td></tr>
    <tr><td class="label">Address sa Pilipinas</td><td>{{ $fam_address ?? '' }}</td></tr>
    <tr><td class="label">Mobile/Phone No.:</td><td>{{ $fam_contact ?? '' }}</td></tr>
    <tr><td class="label">Email / Facebook Account:</td><td>{{ $fam_email ?? '' }}</td></tr>
  </table>
  <div class="page-number">15</div>
</div>
<div class="page">
  <div class="sec">C. &nbsp; URI NG TULONG NA HINIHINGI (Please check):</div>
  <div class="box assist">[{{ in_array('legal', $assistance ?? []) ? 'X' : ' ' }}] LEGAL ASSISTANCE &nbsp;&nbsp; [{{ in_array('medical', $assistance ?? []) ? 'X' : ' ' }}] MEDICAL ASSISTANCE &nbsp;&nbsp; [{{ in_array('repatriation', $assistance ?? []) ? 'X' : ' ' }}] REPATRIATION<br>[{{ in_array('rescue', $assistance ?? []) ? 'X' : ' ' }}] RESCUE / EVACUATION &nbsp;&nbsp; [{{ in_array('welfare', $assistance ?? []) ? 'X' : ' ' }}] WELFARE ASSISTANCE FOR SENIOR OFW RETURNEES<br>[{{ in_array('compassionate', $assistance ?? []) ? 'X' : ' ' }}] COMPASSIONATE VISIT &nbsp;&nbsp; [{{ in_array('shipment', $assistance ?? []) ? 'X' : ' ' }}] SHIPMENT OF HUMAN REMAINS / CREMAINS<br>[{{ in_array('food', $assistance ?? []) ? 'X' : ' ' }}] FOOD ASSISTANCE &nbsp;&nbsp; [{{ in_array('transportation', $assistance ?? []) ? 'X' : ' ' }}] TRANSPORTATION ASSISTANCE &nbsp;&nbsp; [{{ in_array('shelter', $assistance ?? []) ? 'X' : ' ' }}] TEMPORARY SHELTER<br>[{{ in_array('others', $assistance ?? []) ? 'X' : ' ' }}] OTHERS: {{ $assistance_others ?? '' }}</div>
  <div class="sec">D. &nbsp; MAIKLING SALAYSAY TUNGKOL SA HINIHINGING TULONG:</div>
  <div class="box narrative">{{ $narrative ?? '' }}</div>
  <div class="sec">E. &nbsp; ACCOUNT KUNG SAAN IDEDEPOSITO ANG PINANSYAL NA TULONG:</div>
  <table class="account"><tr><td class="auth">In the event of the approval of my application for financial assistance, I hereby authorize the Department of Migrant Workers to credit the assistance through the account/s I have indicated on the right portion:</td><td class="sig">SIGNATURE OF<br>APPLICANT:<div class="sig-space"></div></td><td class="bank">[{{ !empty($has_bank) ? 'X' : ' ' }}] Bank Account No: {{ $bank_account_no ?? '' }}<br><br>Bank: {{ $bank_name ?? '' }} &nbsp; Branch: {{ $bank_branch ?? '' }}<br><br>Account Name: {{ $bank_account_name ?? '' }}</td></tr></table>
  <div class="cert-title">CERTIFICATION</div>
  <div class="cert">I hereby certify that the information given, and all statements made herein are true and correct. Likewise, I hereby authorize DMW to collect, record, organize, update/modify, consult, use, consolidate, block, erase or destruct my personal data as part of my information. I hereby affirm my right to: (a) be informed; (b) object to processing, (c) access, (d) rectify, suspend or withdraw my personal data; (e) damages; and (f) data portability pursuant to the provision of R.A. No. 10173 (Data Privacy Act of 2012).</div>
  <div class="signatures"><div><div class="sign-line"></div><div class="sign-label">Signature over Printed Name</div></div><div><div class="sign-line"></div><div class="sign-label">Date Signed</div></div></div>
  <div class="page-number">16</div>
</div>
<div class="page"><div class="attachment"><div class="attachment-title">Page 2 - Employment Contract</div><div class="attachment-subtitle">Uploaded image attachment</div><div class="uploaded">@if($contract_image)<img src="{{ $contract_image }}" alt="Employment Contract">@endif</div></div><div class="page-number">2</div></div>
<div class="page"><div class="attachment"><div class="attachment-title">Page 3 - Passport / Travel Document</div><div class="attachment-subtitle">Uploaded image attachment</div><div class="uploaded">@if($passport_image)<img src="{{ $passport_image }}" alt="Passport">@endif</div></div><div class="page-number">3</div></div>
</body>
</html>
