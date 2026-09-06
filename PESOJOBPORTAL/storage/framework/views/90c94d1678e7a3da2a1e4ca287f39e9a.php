<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>DMW Request for Assistance Form</title>
<style>
@page { margin: 0; }
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: Arial, Helvetica, sans-serif; color: #000; font-size: 9pt; }

.page { width: 184mm; height: auto; margin: 0 auto; padding: 10mm 0 12mm; page-break-after: always; page-break-inside: avoid; position: relative; }
.page:last-child { page-break-after: auto; }

/* ── HEADER ── */
.header { display: table; width: 100%; table-layout: fixed; margin-bottom: 4px; }
.header > div { display: table-cell; vertical-align: middle; }
.logo-cell { width: 62px; text-align: center; }
.logo-cell img { width: 62px; height: 62px; }
.header-center { text-align: center; line-height: 1.25; }
.rep  { font-size: 8pt; }
.dept { font-size: 14pt; font-weight: bold; font-family: 'Times New Roman', serif; }
.addr { font-size: 6.5pt; margin-top: 2px; }
.cont { font-size: 6pt; color: #444; }
.divider { border: 0; border-top: 1.5px solid #000; margin: 5px 0; }

/* ── FORM TITLE ── */
.form-title { text-align: center; font-weight: bold; font-size: 11pt; text-decoration: underline; margin: 6px 0 4px; }

/* ── MODE ROW ── */
.mode { text-align: center; font-size: 8.5pt; margin-bottom: 7px; }

/* ── SECTION HEADERS ── */
.sec { font-weight: bold; font-size: 8.5pt; margin: 7px 0 3px; }

/* ── FORM TABLE ── */
.ft { width: 100%; border-collapse: collapse; }
.ft td { border: 1px solid #b9d6e1; padding: 5px 8px; vertical-align: middle; background: #eaf5f8; font-size: 10pt; line-height: 1.4; }
.ft .lbl { width: 155px; background: #dceef3; font-weight: bold; white-space: nowrap; font-size: 9.5pt; }

/* ── Name cell ── */
.name-row { display: table; width: 100%; table-layout: fixed; }
.name-col { display: table-cell; padding: 3px 7px; border-right: 1px solid #c8d8de; }
.name-col:last-child { border-right: none; }
.name-val { border-bottom: 1px solid #777; min-height: 16px; font-size: 10pt; }
.name-lbl { font-size: 7.5pt; font-style: italic; color: #666; margin-top: 2px; }

/* ── C — Assistance ── */
.asst-outer { border: 1px solid #000; padding: 8px 12px; margin-bottom: 3px; font-size: 10pt; line-height: 1.9; }

/* ── D — Narrative ── */
.narrative-wrap { border: 1px solid #000; padding: 3px 5px; margin-bottom: 3px; }
.narrative-box { min-height: 160px; white-space: pre-wrap; font-size: 8.5pt; line-height: 20px;
    background: repeating-linear-gradient(to bottom, transparent, transparent 19px, #c8c8c8 19px, #c8c8c8 20px); }

/* ── E — Account ── */
.acct-table { width: 100%; border-collapse: collapse; margin-bottom: 2px; }
.acct-table td { border: 1px solid #000; padding: 5px 7px; vertical-align: top; font-size: 8pt; }
.acct-auth { width: 37%; line-height: 1.5; }
.acct-sig  { width: 22%; text-align: center; font-weight: bold; font-size: 8pt; }
.sig-space { height: 44px; border-bottom: 1px solid #000; margin-top: 5px; }
.acct-bank { width: 41%; font-size: 8pt; line-height: 1.85; }

/* ── Certification ── */
.cert-title { text-align: center; font-weight: bold; font-size: 10pt; text-decoration: underline; margin: 7px 0 4px; }
.cert-box { border: 1px solid #000; padding: 6px 9px; font-size: 7.5pt; text-align: justify; line-height: 1.5; margin-bottom: 8px; }

/* ── Signatures ── */
.sig-row { display: table; width: 100%; table-layout: fixed; margin-top: 14px; }
.sig-blk { display: table-cell; text-align: center; padding: 0 10px; }
.sig-line { border-bottom: 1px solid #000; height: 32px; }
.sig-sub  { font-size: 7.5pt; font-style: italic; margin-top: 3px; }

/* ── Page number ── */
.pg-num { position: absolute; right: 0; bottom: 10mm; font-size: 8.5pt; }

/* ── Attachment pages ── */
.attach-page { text-align: center; padding-top: 20px; }
.attach-title { font-size: 11pt; font-weight: bold; text-decoration: underline; }
.attach-subtitle { font-size: 8pt; color: #555; margin-top: 3px; margin-bottom: 12px; }
.attach-img-wrap { width: 100%; min-height: 218mm; border: 1px solid #999; padding: 6mm; text-align: center; }
.attach-img-wrap img { max-width: 100%; max-height: 204mm; }
.attach-missing { color: #999; font-style: italic; font-size: 9pt; padding-top: 80mm; }
</style>
</head>
<body>


<div class="page">
    <div class="header">
        <div class="logo-cell"><?php if(!empty($owwa_logo)): ?><img src="<?php echo e($owwa_logo); ?>" alt="DMW"><?php endif; ?></div>
        <div class="header-center">
            <div class="rep">Republic of the Philippines</div>
            <div class="dept">Department of Migrant Workers</div>
            <div class="addr">Blas F. Ople Building, Ortigas Avenue cor. EDSA, Mandaluyong City 1550</div>
            <div class="cont">Website: www.dmw.gov.ph &nbsp;|&nbsp; Email: feedback@dmw.gov.ph &nbsp;|&nbsp; Hotlines: (632) 952-8072 / 955-9007 / (02) 8722-3606</div>
        </div>
        <div class="logo-cell"><?php if(!empty($bagong_logo)): ?><img src="<?php echo e($bagong_logo); ?>" alt="Bagong Pilipinas"><?php endif; ?></div>
    </div>

    <hr class="divider">
    <div class="form-title">REQUEST FOR ASSISTANCE (RFA) FORM</div>

    <div class="mode">
        [<?php echo e(in_array('online',   $mode ?? []) ? '&#10003;' : ' '); ?>] Online &nbsp;&nbsp;&nbsp;
        [<?php echo e(in_array('walkin',   $mode ?? []) ? '&#10003;' : ' '); ?>] Walk-in &nbsp;&nbsp;&nbsp;
        [<?php echo e(in_array('referral', $mode ?? []) ? '&#10003;' : ' '); ?>] Referral by: <?php echo e($referral_by ?? ''); ?>

    </div>

    <div class="sec">A. &nbsp; IMPORMASYON NG OFW:</div>
    <table class="ft">
        <tr>
            <td class="lbl">Pangalan ng OFW :</td>
            <td>
                <div class="name-row">
                    <div class="name-col"><div class="name-val"><?php echo e($ofw_lastname ?? ''); ?></div><div class="name-lbl">Last name</div></div>
                    <div class="name-col"><div class="name-val"><?php echo e($ofw_firstname ?? ''); ?></div><div class="name-lbl">First Name</div></div>
                    <div class="name-col"><div class="name-val"><?php echo e($ofw_middlename ?? ''); ?></div><div class="name-lbl">Middle Name</div></div>
                </div>
            </td>
        </tr>
        <tr><td class="lbl">Birthdate:</td><td><?php echo e($ofw_birthdate ?? ''); ?></td></tr>
        <tr>
            <td class="lbl">Sex (Kasarian):</td>
            <td>[<?php echo e(($ofw_sex ?? '') === 'male' ? '&#10003;' : ' '); ?>] Male/Lalaki &nbsp;&nbsp;&nbsp; [<?php echo e(($ofw_sex ?? '') === 'female' ? '&#10003;' : ' '); ?>] Female/Babae</td>
        </tr>
        <tr>
            <td class="lbl">Civil Status:</td>
            <td>
                [<?php echo e(in_array('single',     $civil_status ?? []) ? '&#10003;' : ' '); ?>] Single / Walang Asawa &nbsp;
                [<?php echo e(in_array('married',    $civil_status ?? []) ? '&#10003;' : ' '); ?>] Married / May Asawa &nbsp;
                [<?php echo e(in_array('widow',      $civil_status ?? []) ? '&#10003;' : ' '); ?>] Widow/Widower (Balo)<br>
                [<?php echo e(in_array('separated',  $civil_status ?? []) ? '&#10003;' : ' '); ?>] Separated / Hiwalay &nbsp;
                [<?php echo e(in_array('soloparent', $civil_status ?? []) ? '&#10003;' : ' '); ?>] Solo Parent
            </td>
        </tr>
        <tr><td class="lbl">Passport / Travel Document No:</td><td><?php echo e($ofw_passport ?? ''); ?></td></tr>
        <tr><td class="lbl">Address sa abroad:</td><td><?php echo e($ofw_address_abroad ?? ''); ?></td></tr>
        <tr><td class="lbl">Address sa Pilipinas</td><td><?php echo e($ofw_address_ph ?? ''); ?></td></tr>
        <tr><td class="lbl">Contact No/s. Mobile/Phone No.:</td><td><?php echo e($ofw_contact ?? ''); ?></td></tr>
        <tr><td class="lbl">Email / Facebook Account:</td><td><?php echo e($ofw_email ?? ''); ?></td></tr>
    </table>

    <div class="sec" style="margin-top:10px;">B. &nbsp; IMPORMASYON NG KAMAG-ANAK NG OFW NA HUMIHINGI NG TULONG:</div>
    <table class="ft">
        <tr>
            <td class="lbl">Pangalan :</td>
            <td>
                <div class="name-row">
                    <div class="name-col"><div class="name-val"><?php echo e($fam_lastname ?? ''); ?></div><div class="name-lbl">Last name</div></div>
                    <div class="name-col"><div class="name-val"><?php echo e($fam_firstname ?? ''); ?></div><div class="name-lbl">First Name</div></div>
                    <div class="name-col"><div class="name-val"><?php echo e($fam_middlename ?? ''); ?></div><div class="name-lbl">Middle Name</div></div>
                </div>
            </td>
        </tr>
        <tr><td class="lbl">Birthdate:</td><td><?php echo e($fam_birthdate ?? ''); ?></td></tr>
        <tr>
            <td class="lbl">Relationship to OFW:</td>
            <td>
                [<?php echo e(in_array('spouse',  $relationship ?? []) ? '&#10003;' : ' '); ?>] Spouse / Asawa &nbsp;
                [<?php echo e(in_array('child',   $relationship ?? []) ? '&#10003;' : ' '); ?>] Child / Anak &nbsp;
                [<?php echo e(in_array('sibling', $relationship ?? []) ? '&#10003;' : ' '); ?>] Sibling / Kapatid &nbsp;
                [<?php echo e(in_array('others',  $relationship ?? []) ? '&#10003;' : ' '); ?>] Others <?php echo e($relationship_others ?? ''); ?>

            </td>
        </tr>
        <tr><td class="lbl">ID No:</td><td><?php echo e($fam_id ?? ''); ?></td></tr>
        <tr><td class="lbl">Address sa Pilipinas</td><td><?php echo e($fam_address ?? ''); ?></td></tr>
        <tr><td class="lbl">Mobile/Phone No.:</td><td><?php echo e($fam_contact ?? ''); ?></td></tr>
        <tr><td class="lbl">Email / Facebook Account:</td><td><?php echo e($fam_email ?? ''); ?></td></tr>
    </table>

    <div class="pg-num">1</div>
</div>


<div class="page">

    <div class="sec">C. &nbsp; URI NG TULONG NA HINIHINGI (Please check):</div>
    <div class="asst-outer">
        [<?php echo e(in_array('legal',          $assistance ?? []) ? '&#10003;' : ' '); ?>] LEGAL ASSISTANCE &nbsp;&nbsp;
        [<?php echo e(in_array('medical',        $assistance ?? []) ? '&#10003;' : ' '); ?>] MEDICAL ASSISTANCE &nbsp;&nbsp;
        [<?php echo e(in_array('repatriation',   $assistance ?? []) ? '&#10003;' : ' '); ?>] REPATRIATION<br>
        [<?php echo e(in_array('rescue',         $assistance ?? []) ? '&#10003;' : ' '); ?>] RESCUE / EVACUATION &nbsp;&nbsp;
        [<?php echo e(in_array('welfare',        $assistance ?? []) ? '&#10003;' : ' '); ?>] WELFARE ASSISTANCE FOR SENIOR OFW RETURNEES<br>
        [<?php echo e(in_array('compassionate',  $assistance ?? []) ? '&#10003;' : ' '); ?>] COMPASSIONATE VISIT &nbsp;&nbsp;
        [<?php echo e(in_array('shipment',       $assistance ?? []) ? '&#10003;' : ' '); ?>] SHIPMENT OF HUMAN REMAINS / CREMAINS<br>
        [<?php echo e(in_array('food',           $assistance ?? []) ? '&#10003;' : ' '); ?>] FOOD ASSISTANCE &nbsp;&nbsp;
        [<?php echo e(in_array('transportation', $assistance ?? []) ? '&#10003;' : ' '); ?>] TRANSPORTATION ASSISTANCE &nbsp;&nbsp;
        [<?php echo e(in_array('shelter',        $assistance ?? []) ? '&#10003;' : ' '); ?>] TEMPORARY SHELTER<br>
        [<?php echo e(in_array('others',         $assistance ?? []) ? '&#10003;' : ' '); ?>] OTHERS: <?php echo e($assistance_others ?? ''); ?>

    </div>

    <div class="sec" style="margin-top:7px;">D. &nbsp; MAIKLING SALAYSAY TUNGKOL SA HINIHINGING TULONG:</div>
    <div class="narrative-wrap">
        <div class="narrative-box"><?php echo e($narrative ?? ''); ?></div>
    </div>

    <div class="sec" style="margin-top:7px;">E. &nbsp; ACCOUNT KUNG SAAN IDEDEPOSITO ANG PINANSYAL NA TULONG:</div>
    <table class="acct-table">
        <tr>
            <td class="acct-auth">In the event of the approval of my application for financial assistance, I hereby authorize the Department of Migrant Workers to credit the assistance through the account/s I have indicated on the right portion:</td>
            <td class="acct-sig">SIGNATURE OF<br>APPLICANT:<div class="sig-space"></div></td>
            <td class="acct-bank">
                [<?php echo e(!empty($has_bank) ? '&#10003;' : ' '); ?>] Bank Account No: <?php echo e($bank_account_no ?? ''); ?><br>
                Bank: <?php echo e($bank_name ?? ''); ?> &nbsp; Branch: <?php echo e($bank_branch ?? ''); ?><br>
                Account Name: <?php echo e($bank_account_name ?? ''); ?>

            </td>
        </tr>
    </table>

    <div class="cert-title">CERTIFICATION</div>
    <div class="cert-box">I hereby certify that the information given, and all statements made herein are true and correct. Likewise, I hereby authorize DMW to collect, record, organize, update/modify, consult, use, consolidate, block, erase or destruct my personal data as part of my information. I hereby affirm my right to: (a) be informed; (b) object to processing, (c) access, (d) rectify, suspend or withdraw my personal data; (e) damages; and (f) data portability pursuant to the provision of R.A. No. 10173 (Data Privacy Act of 2012).</div>

    <div class="sig-row">
        <div class="sig-blk"><div class="sig-line"></div><div class="sig-sub">Signature over Printed Name</div></div>
        <div class="sig-blk"><div class="sig-line"></div><div class="sig-sub">Date Signed</div></div>
    </div>

    <div class="pg-num">2</div>
</div>


<?php if(!empty($contract_image)): ?>
<div class="page">
    <div class="attach-page">
        <div class="attach-title">Page 3 — Employment Contract <span style="background:#b91c1c;color:#fff;font-size:7pt;font-weight:bold;padding:2px 6px;margin-left:6px;">REQUIRED</span></div>
        <div class="attach-subtitle">Attached photo or scanned copy of Employment Contract</div>
        <div class="attach-img-wrap">
            <?php if(!empty($contract_image)): ?>
                <img src="<?php echo e($contract_image); ?>" alt="Employment Contract">
            <?php else: ?>
                <div class="attach-missing">No contract image attached.</div>
            <?php endif; ?>
        </div>
    </div>
    <div class="pg-num">3</div>
</div>
<?php endif; ?>


<?php if(!empty($passport_image)): ?>
<div class="page">
    <div class="attach-page">
        <div class="attach-title">Page 4 — Passport / Travel Document <span style="background:#b91c1c;color:#fff;font-size:7pt;font-weight:bold;padding:2px 6px;margin-left:6px;">REQUIRED</span></div>
        <div class="attach-subtitle">Attached photo or scanned copy of Passport data page</div>
        <div class="attach-img-wrap">
            <?php if(!empty($passport_image)): ?>
                <img src="<?php echo e($passport_image); ?>" alt="Passport">
            <?php else: ?>
                <div class="attach-missing">No passport image attached.</div>
            <?php endif; ?>
        </div>
    </div>
    <div class="pg-num">4</div>
</div>
<?php endif; ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\ofw\dmw-pdf.blade.php ENDPATH**/ ?>