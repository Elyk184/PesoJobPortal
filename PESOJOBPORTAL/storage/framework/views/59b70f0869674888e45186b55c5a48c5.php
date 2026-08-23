 
<?php $__env->startSection('title', 'Request for Assistance (RFA) Form - DMW'); ?>
 
<?php $__env->startSection('dashboard-mobile-brand'); ?>
    <div class="dashboard-mobile-brand">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="PESO Logo">
        <span>OFW Portal</span>
    </div>
<?php $__env->stopSection(); ?>
 
<?php $__env->startSection('dashboard-sidebar'); ?>
    <?php echo $__env->make('dashboard.partials.ofw-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
 
<?php $__env->startPush('styles'); ?>
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
 
    /* ── Shell ── */
    .dmw-shell {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
        background: #b8c0cc;
        padding: 20px 0 36px;
        color: #000;
    }
 
    /* ── A4 page preview ── */
    .dmw-page {
        width: 210mm;
        min-height: 297mm;
        background: #fbfdfe;
        margin: 0 auto 18px;
        padding: 12mm 13mm 12mm 13mm;
        box-shadow: 0 2px 16px rgba(0,0,0,.22);
        position: relative;
    }
 
    /* ── Download bar ── */
    .dmw-dl-bar {
        width: 210mm;
        margin: 16px auto 0;
        background: #1a3a6b;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        padding: 11px 20px;
        border-radius: 6px;
    }
 
    .dmw-dl-bar .btn-dl {
        background: #f5c518;
        color: #111;
        border: none;
        padding: 9px 32px;
        font-size: 11pt;
        font-weight: bold;
        border-radius: 4px;
        cursor: pointer;
        font-family: Arial, sans-serif;
        transition: background .18s;
    }
 
    .dmw-dl-bar .btn-dl:hover { background: #ddb010; }
    .dmw-dl-bar .btn-dl:disabled { background: #ccc; cursor: not-allowed; }
    .dmw-dl-bar .dl-hint { color: #aac4f5; font-size: 9pt; font-family: Arial, sans-serif; }
    #dlProgress { display:none; color:#f5c518; font-size:9.5pt; font-style:italic; font-family:Arial,sans-serif; }
 
    /* ── HEADER ── */
    .dmw-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 4px;
    }
 
    .dmw-header-logo { width: 66px; height: 66px; object-fit: contain; flex-shrink: 0; }
    .dmw-header-bagong {
        width: 66px;
        height: 66px;
        object-fit: contain;
        flex-shrink: 0;
    }
 
    .dmw-header-center { flex: 1; text-align: center; line-height: 1.25; }
    .dmw-header-center .rep  { font-size: 8pt; }
    .dmw-header-center .dept { font-size: 16pt; font-weight: bold; font-family: 'Times New Roman', serif; }
    .dmw-header-center .addr { font-size: 6.5pt; margin-top: 2px; }
    .dmw-header-center .cont { font-size: 6pt; color: #444; }
 
    .dmw-divider { border: none; border-top: 1.5px solid #000; margin: 5px 0; }
 
    /* ── FORM TITLE ── */
    .dmw-form-title {
        text-align: center;
        font-weight: bold;
        font-size: 12pt;
        text-decoration: underline;
        margin: 7px 0 5px;
        letter-spacing: .2px;
    }
 
    /* ── MODE ROW ── */
    .dmw-mode-row {
        text-align: center;
        font-size: 9pt;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
    }
 
    .dmw-mode-row label { display: flex; align-items: center; gap: 4px; cursor: pointer; font-size: 9pt; }
    .dmw-mode-row input[type="text"] {
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        width: 120px;
        font-size: 9pt;
        font-family: Arial, sans-serif;
        background: transparent;
    }
 
    /* ── SECTION HEADERS ── */
    .dmw-sec {
        font-weight: bold;
        font-size: 9pt;
        margin: 9px 0 4px;
        letter-spacing: .1px;
    }
 
    /* ── MAIN FORM TABLE (bordered rows) ── */
    .ft {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }
 
    .ft td {
        border: 1px solid #b9d6e1;
        padding: 4px 7px;
        font-size: 9pt;
        vertical-align: middle;
        background: #eaf5f8;
    }
 
    .ft .lbl {
        background: #dceef3;
        font-weight: bold;
        white-space: nowrap;
        width: 165px;
        vertical-align: middle;
    }
 
    .ft input[type="text"],
    .ft input[type="date"],
    .ft input[type="email"] {
        width: 100%;
        border: none;
        outline: none;
        font-size: 9pt;
        font-family: Arial, sans-serif;
        background: transparent;
    }
 
    /* ── Name cell (Last / First / Middle) ── */
    .name-row { display: flex; width: 100%; }
 
    .name-col {
        flex: 1;
        padding: 3px 6px;
        border-right: 1px solid #ccc;
    }
 
    .name-col:last-child { border-right: none; }
 
    .name-col input {
        width: 100%;
        border: none;
        border-bottom: 1px solid #999;
        outline: none;
        font-size: 9pt;
        font-family: Arial, sans-serif;
        background: transparent;
        padding-bottom: 1px;
    }
 
    .name-col-lbl { font-size: 7pt; font-style: italic; color: #666; margin-top: 2px; }
 
    /* ── Sex row ── */
    .sex-row { display: flex; gap: 30px; align-items: center; }
    .sex-row label { display: flex; align-items: center; gap: 4px; font-size: 9pt; cursor: pointer; }
 
    /* ── Civil status checkboxes ── */
    .cb-wrap { display: flex; flex-wrap: wrap; gap: 4px 14px; align-items: center; }
    .cb-wrap label { display: flex; align-items: center; gap: 3px; font-size: 9pt; cursor: pointer; white-space: nowrap; }
 
    /* ── TABLE spacing fixer ── */
    .ft + .ft { margin-top: -1px; }
    .dmw-sec + .ft { }
 
    /* ─────────────────────────────────────────
       PAGE 2 — Sections C, D, E, Certification
    ───────────────────────────────────────── */
 
    /* C — Assistance types */
    .asst-outer { border: 1px solid #000; padding: 6px 10px; margin-bottom: 3px; }
 
    .asst-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        row-gap: 4px;
        column-gap: 6px;
    }
 
    .asst-grid label { display: flex; align-items: flex-start; gap: 4px; font-size: 9pt; cursor: pointer; line-height: 1.35; }
 
    .asst-others { display: flex; align-items: center; gap: 5px; margin-top: 5px; font-size: 9pt; }
    .asst-others input[type="text"] {
        flex: 1;
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        font-size: 9pt;
        font-family: Arial, sans-serif;
        background: transparent;
    }
 
    /* D — Narrative */
    .narrative-wrap { border: 1px solid #000; padding: 4px 6px; margin-bottom: 3px; }
    .narrative-wrap textarea {
        width: 100%;
        border: none;
        outline: none;
        font-family: Arial, sans-serif;
        font-size: 9pt;
        resize: none;
        height: 175px;
        background: transparent;
        background-image: repeating-linear-gradient(
            to bottom, transparent, transparent 21px, #c8c8c8 21px, #c8c8c8 22px
        );
        line-height: 22px;
        padding-top: 1px;
    }
 
    /* E — Account */
    .acct-table { width: 100%; border-collapse: collapse; margin-bottom: 2px; }
    .acct-table td { border: 1px solid #000; padding: 6px 8px; vertical-align: top; font-size: 8.5pt; }
    .acct-auth { width: 37%; font-size: 8pt; line-height: 1.55; }
    .acct-sig  { width: 22%; text-align: center; font-weight: bold; font-size: 8.5pt; }
    .acct-sig .sig-space { display: block; height: 46px; border-bottom: 1px solid #000; margin: 6px 0 3px; }
    .acct-bank { width: 41%; font-size: 8.5pt; }
 
    .bfield { display: flex; align-items: center; gap: 5px; margin-bottom: 5px; font-size: 8.5pt; }
    .bfield input[type="text"] {
        border: none;
        border-bottom: 1px solid #000;
        outline: none;
        font-size: 8.5pt;
        font-family: Arial, sans-serif;
        background: transparent;
        flex: 1;
        min-width: 0;
    }
 
    /* Certification */
    .cert-title {
        text-align: center;
        font-weight: bold;
        font-size: 10.5pt;
        text-decoration: underline;
        margin: 8px 0 5px;
    }
 
    .cert-box {
        border: 1px solid #000;
        padding: 7px 10px;
        font-size: 8pt;
        text-align: justify;
        line-height: 1.55;
        margin-bottom: 10px;
    }
 
    /* Signatures */
    .sig-row { display: flex; gap: 24px; margin-top: 16px; }
    .sig-blk { flex: 1; text-align: center; }
    .sig-line { border-bottom: 1px solid #000; display: block; height: 34px; width: 100%; margin-bottom: 3px; }
    .sig-sub  { font-size: 8pt; font-style: italic; }
 
    /* Page number */
    .pg-num { text-align: right; font-size: 8.5pt; margin-top: 10px; }
 
    /* ─────────────────────────────────────────
       PAGE 3 & 4 — Attachment pages
    ───────────────────────────────────────── */
    .attach-page {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding-top: 20px;
        min-height: 265mm;
    }
 
    .attach-hdr { text-align: center; margin-bottom: 14px; width: 100%; }
    .attach-hdr .pg-label { font-size: 11.5pt; font-weight: bold; text-decoration: underline; }
    .attach-hdr .pg-sublabel { font-size: 8.5pt; color: #555; margin-top: 3px; }
 
    .upload-zone {
        width: 100%;
        max-width: 470px;
        min-height: 310px;
        border: 2.5px dashed #999;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 24px 18px;
        cursor: pointer;
        background: #fafafa;
        position: relative;
        transition: background .18s, border-color .18s;
    }
 
    .upload-zone:hover { background: #efefef; border-color: #666; }
 
    .upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
        width: 100%;
        height: 100%;
    }
 
    .upload-icon   { font-size: 48px; color: #aaa; margin-bottom: 10px; }
    .upload-txt    { font-size: 10pt; color: #666; margin-bottom: 4px; text-align: center; }
    .upload-sub    { font-size: 8pt; color: #999; text-align: center; }
 
    .preview-img {
        max-width: 100%;
        max-height: 420px;
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
        font-family: Arial, sans-serif;
        z-index: 3;
        position: relative;
    }
 
    .remove-btn:hover { background: #a53124; }
 
    .attach-note { margin-top: 10px; font-size: 8pt; font-style: italic; color: #999; text-align: center; }
 
    /* Required badge */
    .req-badge {
        display: inline-block;
        background: #b91c1c;
        color: #fff;
        font-size: 7.5pt;
        font-weight: bold;
        padding: 2px 7px;
        border-radius: 3px;
        margin-left: 6px;
        vertical-align: middle;
        letter-spacing: .3px;
    }
 
    @media print {
        .dmw-dl-bar { display: none !important; }
    }
</style>
<?php $__env->stopPush(); ?>
 
<?php $__env->startSection('content'); ?>
<div class="dmw-shell">
 

<form method="POST"
      action="<?php echo e(route('ofw.dmw-rfa.download')); ?>"
      enctype="multipart/form-data"
      id="dmwForm">
<?php echo csrf_field(); ?>
 
<?php if($errors->any()): ?>
<div style="width:210mm;margin:0 auto 10px;background:#fef2f2;border:1px solid #fca5a5;color:#b91c1c;padding:10px 14px;font-size:11px;border-radius:4px;">
    <?php echo e($errors->first()); ?>

</div>
<?php endif; ?>
 

<div class="dmw-page">
 
    
    <div class="dmw-header">
        <img src="<?php echo e(asset('images/owwa.png')); ?>" class="dmw-header-logo" alt="OWWA">
        <div class="dmw-header-center">
            <div class="rep">Republic of the Philippines</div>
            <div class="dept">Department of Migrant Workers</div>
            <div class="addr">Blas F. Ople Building, Ortigas Avenue cor. EDSA, Mandaluyong City 1550</div>
            <div class="cont">Website: www.dmw.gov.ph &nbsp;|&nbsp; Email: feedback@dmw.gov.ph &nbsp;|&nbsp; Hotlines: (632) 952-8072 / 955-9007 / (02) 8722-3606</div>
        </div>
        <img src="<?php echo e(asset('images/Logo-Bagong-Pilipinas.png')); ?>" class="dmw-header-bagong" alt="Bagong Pilipinas">
    </div>
 
    <hr class="dmw-divider">
 
    <div class="dmw-form-title">REQUEST FOR ASSISTANCE (RFA) FORM</div>
 
    
    <div class="dmw-mode-row">
        <label><input type="checkbox" name="mode[]" value="online"> Online</label>
        <label><input type="checkbox" name="mode[]" value="walkin"> Walk-in</label>
        <label>
            <input type="checkbox" name="mode[]" value="referral"> Referral by:
            <input type="text" name="referral_by" value="<?php echo e(old('referral_by')); ?>">
        </label>
    </div>
 
    
    <div class="dmw-sec">A. &nbsp; IMPORMASYON NG OFW:</div>
 
    <table class="ft">
        <tr>
            <td class="lbl">Pangalan ng OFW :</td>
            <td>
                <div class="name-row">
                    <div class="name-col">
                        <input type="text" name="ofw_lastname" value="<?php echo e(old('ofw_lastname')); ?>">
                        <div class="name-col-lbl">Last name</div>
                    </div>
                    <div class="name-col">
                        <input type="text" name="ofw_firstname" value="<?php echo e(old('ofw_firstname')); ?>">
                        <div class="name-col-lbl">First Name</div>
                    </div>
                    <div class="name-col">
                        <input type="text" name="ofw_middlename" value="<?php echo e(old('ofw_middlename')); ?>">
                        <div class="name-col-lbl">Middle Name</div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="lbl">Birthdate:</td>
            <td><input type="date" name="ofw_birthdate" value="<?php echo e(old('ofw_birthdate')); ?>"></td>
        </tr>
        <tr>
            <td class="lbl">Sex (Kasarian):</td>
            <td>
                <div class="sex-row">
                    <label><input type="radio" name="ofw_sex" value="male" <?php echo e(old('ofw_sex')==='male'?'checked':''); ?>> &nbsp;Male/Lalaki</label>
                    <label><input type="radio" name="ofw_sex" value="female" <?php echo e(old('ofw_sex')==='female'?'checked':''); ?>> &nbsp;Female/Babae</label>
                </div>
            </td>
        </tr>
        <tr>
            <td class="lbl">Civil Status:</td>
            <td style="padding:5px 7px;">
                <div class="cb-wrap">
                    <label><input type="checkbox" name="civil_status[]" value="single" class="cscb" <?php echo e(in_array('single', old('civil_status',[]))? 'checked':''); ?>> Single / Walang Asawa</label>
                    <label><input type="checkbox" name="civil_status[]" value="married" class="cscb" <?php echo e(in_array('married', old('civil_status',[]))? 'checked':''); ?>> Married / May Asawa</label>
                    <label><input type="checkbox" name="civil_status[]" value="widow" class="cscb" <?php echo e(in_array('widow', old('civil_status',[]))? 'checked':''); ?>> Widow/Widower (Balo)</label>
                    <label><input type="checkbox" name="civil_status[]" value="separated" class="cscb" <?php echo e(in_array('separated', old('civil_status',[]))? 'checked':''); ?>> Separated / Hiwalay</label>
                    <label><input type="checkbox" name="civil_status[]" value="soloparent" class="cscb" <?php echo e(in_array('soloparent', old('civil_status',[]))? 'checked':''); ?>> Solo Parent</label>
                </div>
            </td>
        </tr>
        <tr>
            <td class="lbl">Passport / Travel Document No:</td>
            <td><input type="text" name="ofw_passport" value="<?php echo e(old('ofw_passport')); ?>"></td>
        </tr>
        <tr>
            <td class="lbl">Address sa abroad:</td>
            <td><input type="text" name="ofw_address_abroad" value="<?php echo e(old('ofw_address_abroad')); ?>"></td>
        </tr>
        <tr>
            <td class="lbl">Address sa Pilipinas</td>
            <td><input type="text" name="ofw_address_ph" value="<?php echo e(old('ofw_address_ph')); ?>"></td>
        </tr>
        <tr>
            <td class="lbl">Contact No/s. Mobile/Phone No.:</td>
            <td><input type="text" name="ofw_contact" value="<?php echo e(old('ofw_contact')); ?>"></td>
        </tr>
        <tr>
            <td class="lbl">Email / Facebook Account:</td>
            <td><input type="text" name="ofw_email" value="<?php echo e(old('ofw_email')); ?>"></td>
        </tr>
    </table>
 
    
    <div class="dmw-sec" style="margin-top:12px;">B. &nbsp; IMPORMASYON NG KAMAG-ANAK NG OFW NA HUMIHINGI NG TULONG:</div>
 
    <table class="ft">
        <tr>
            <td class="lbl">Pangalan :</td>
            <td>
                <div class="name-row">
                    <div class="name-col">
                        <input type="text" name="fam_lastname" value="<?php echo e(old('fam_lastname')); ?>">
                        <div class="name-col-lbl">Last name</div>
                    </div>
                    <div class="name-col">
                        <input type="text" name="fam_firstname" value="<?php echo e(old('fam_firstname')); ?>">
                        <div class="name-col-lbl">First Name</div>
                    </div>
                    <div class="name-col">
                        <input type="text" name="fam_middlename" value="<?php echo e(old('fam_middlename')); ?>">
                        <div class="name-col-lbl">Middle Name</div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="lbl">Birthdate:</td>
            <td><input type="date" name="fam_birthdate" value="<?php echo e(old('fam_birthdate')); ?>"></td>
        </tr>
        <tr>
            <td class="lbl">Relationship to OFW:</td>
            <td style="padding:5px 7px;">
                <div class="cb-wrap">
                    <label><input type="checkbox" name="relationship[]" value="spouse" <?php echo e(in_array('spouse', old('relationship',[]))? 'checked':''); ?>> Spouse / Asawa</label>
                    <label><input type="checkbox" name="relationship[]" value="child" <?php echo e(in_array('child', old('relationship',[]))? 'checked':''); ?>> Child / Anak</label>
                    <label><input type="checkbox" name="relationship[]" value="sibling" <?php echo e(in_array('sibling', old('relationship',[]))? 'checked':''); ?>> Sibling / Kapatid</label>
                    <label>
                        <input type="checkbox" name="relationship[]" value="others" <?php echo e(in_array('others', old('relationship',[]))? 'checked':''); ?>>
                        Others <input type="text" name="relationship_others" value="<?php echo e(old('relationship_others')); ?>"
                               style="border:none;border-bottom:1px solid #000;width:100px;outline:none;font-size:9pt;background:transparent;font-family:Arial,sans-serif;">
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <td class="lbl">ID No:</td>
            <td><input type="text" name="fam_id" value="<?php echo e(old('fam_id')); ?>"></td>
        </tr>
        <tr>
            <td class="lbl">Address sa Pilipinas</td>
            <td><input type="text" name="fam_address" value="<?php echo e(old('fam_address')); ?>"></td>
        </tr>
        <tr>
            <td class="lbl">Mobile/Phone No.:</td>
            <td><input type="text" name="fam_contact" value="<?php echo e(old('fam_contact')); ?>"></td>
        </tr>
        <tr>
            <td class="lbl">Email / Facebook Account:</td>
            <td><input type="text" name="fam_email" value="<?php echo e(old('fam_email')); ?>"></td>
        </tr>
    </table>
 
    <div class="pg-num">15</div>
</div>

 
 

<div class="dmw-page">
 
    
    <div class="dmw-sec">C. &nbsp; URI NG TULONG NA HINIHINGI (Please check):</div>
 
    <div class="asst-outer">
        <div class="asst-grid">
            <label><input type="checkbox" name="assistance[]" value="legal" <?php echo e(in_array('legal', old('assistance',[]))? 'checked':''); ?>> LEGAL ASSISTANCE</label>
            <label><input type="checkbox" name="assistance[]" value="medical" <?php echo e(in_array('medical', old('assistance',[]))? 'checked':''); ?>> MEDICAL ASSISTANCE</label>
            <label><input type="checkbox" name="assistance[]" value="repatriation" <?php echo e(in_array('repatriation', old('assistance',[]))? 'checked':''); ?>> REPATRIATION</label>
            <label><input type="checkbox" name="assistance[]" value="rescue" <?php echo e(in_array('rescue', old('assistance',[]))? 'checked':''); ?>> RESCUE / EVACUATION</label>
            <label style="grid-column:span 2;"><input type="checkbox" name="assistance[]" value="welfare" <?php echo e(in_array('welfare', old('assistance',[]))? 'checked':''); ?>> WELFARE ASSISTANCE FOR SENIOR OFW RETURNEES</label>
            <label><input type="checkbox" name="assistance[]" value="compassionate" <?php echo e(in_array('compassionate', old('assistance',[]))? 'checked':''); ?>> COMPASSIONATE VISIT</label>
            <label style="grid-column:span 2;"><input type="checkbox" name="assistance[]" value="shipment" <?php echo e(in_array('shipment', old('assistance',[]))? 'checked':''); ?>> SHIPMENT OF HUMAN REMAINS / CREMAINS</label>
            <label><input type="checkbox" name="assistance[]" value="food" <?php echo e(in_array('food', old('assistance',[]))? 'checked':''); ?>> FOOD ASSISTANCE</label>
            <label><input type="checkbox" name="assistance[]" value="transportation" <?php echo e(in_array('transportation', old('assistance',[]))? 'checked':''); ?>> TRANSPORTATION ASSISTANCE</label>
            <label><input type="checkbox" name="assistance[]" value="shelter" <?php echo e(in_array('shelter', old('assistance',[]))? 'checked':''); ?>> TEMPORARY SHELTER</label>
        </div>
        <div class="asst-others">
            <input type="checkbox" name="assistance[]" value="others" id="aoth" <?php echo e(in_array('others', old('assistance',[]))? 'checked':''); ?>>
            <label for="aoth">OTHERS</label>
            <input type="text" name="assistance_others" value="<?php echo e(old('assistance_others')); ?>">
        </div>
    </div>
 
    
    <div class="dmw-sec" style="margin-top:8px;">D. &nbsp; MAIKLING SALAYSAY TUNGKOL SA HINIHINGING TULONG:</div>
 
    <div class="narrative-wrap">
        <textarea name="narrative" placeholder="Isulat ang maikling salaysay…"><?php echo e(old('narrative')); ?></textarea>
    </div>
 
    
    <div class="dmw-sec" style="margin-top:8px;">E. &nbsp; ACCOUNT KUNG SAAN IDEDEPOSITO ANG PINANSYAL NA TULONG:</div>
 
    <table class="acct-table">
        <tr>
            <td class="acct-auth">
                In the event of the approval of my application for financial assistance, I hereby authorize the Department of Migrant Workers to credit the assistance through the account/s I have indicated on the right portion:
            </td>
            <td class="acct-sig">
                SIGNATURE OF<br>APPLICANT:
                <span class="sig-space"></span>
            </td>
            <td class="acct-bank">
                <div class="bfield">
                    <input type="checkbox" name="has_bank" value="1" <?php echo e(old('has_bank')? 'checked':''); ?>>
                    <span style="white-space:nowrap;">Bank Account No:</span>
                    <input type="text" name="bank_account_no" value="<?php echo e(old('bank_account_no')); ?>">
                </div>
                <div class="bfield">
                    <span>Bank:</span>
                    <input type="text" name="bank_name" value="<?php echo e(old('bank_name')); ?>" style="max-width:80px;">
                    <span>Branch:</span>
                    <input type="text" name="bank_branch" value="<?php echo e(old('bank_branch')); ?>" style="max-width:72px;">
                </div>
                <div class="bfield">
                    <span style="white-space:nowrap;">Account Name:</span>
                    <input type="text" name="bank_account_name" value="<?php echo e(old('bank_account_name')); ?>">
                </div>
            </td>
        </tr>
    </table>
 
    
    <div class="cert-title">CERTIFICATION</div>
 
    <div class="cert-box">
        I hereby certify that the information given, and all statements made herein are true and correct. Likewise, I hereby authorize DMW to collect, record, organize, update/modify, consult, use, consolidate, block, erase or destruct my personal data as part of my information. I hereby affirm my right to: (a) be informed; (b) object to processing, (c) access, (d) rectify, suspend or withdraw my personal data; (e) damages; and (f) data portability pursuant to the provision of R.A. No. 10173 (Data Privacy Act of 2012).
    </div>
 
    <div class="sig-row">
        <div class="sig-blk">
            <span class="sig-line"></span>
            <div class="sig-sub">Signature over Printed Name</div>
        </div>
        <div class="sig-blk">
            <span class="sig-line"></span>
            <div class="sig-sub">Date Signed</div>
        </div>
    </div>
 
    <div class="pg-num">16</div>
</div>

 
 

<div class="dmw-page">
    <div class="attach-page">
        <div class="attach-hdr">
            <div class="pg-label">Page 3 — Employment Contract <span class="req-badge">REQUIRED</span></div>
            <div class="pg-sublabel">Attach a clear photo or scanned copy of your Employment Contract</div>
        </div>
 
        <div class="upload-zone" id="contractZone">
            <input type="file" name="contract" id="contractFile" accept="image/*"
                   onchange="previewFile(this,'contractPreview','contractZone','contractRemove','contractHolder')">
            <div id="contractHolder" style="display:flex;flex-direction:column;align-items:center;">
                <div class="upload-icon">📄</div>
                <div class="upload-txt">Click or drag &amp; drop to upload</div>
                <div class="upload-sub">Employment Contract photo — JPG, PNG (max 10 MB)</div>
            </div>
            <img id="contractPreview" class="preview-img" alt="Contract Preview">
        </div>
        <button type="button" class="remove-btn" id="contractRemove"
                onclick="removeFile('contractFile','contractPreview','contractZone','contractRemove','contractHolder')">
            ✕ Remove
        </button>
        <div class="attach-note">* This attachment is required to submit the form</div>
    </div>
    <div class="pg-num">17</div>
</div>

 
 

<div class="dmw-page">
    <div class="attach-page">
        <div class="attach-hdr">
            <div class="pg-label">Page 4 — Passport / Travel Document <span class="req-badge">REQUIRED</span></div>
            <div class="pg-sublabel">Attach a clear photo or scanned copy of the data page of your Passport</div>
        </div>
 
        <div class="upload-zone" id="passportZone">
            <input type="file" name="passport" id="passportFile" accept="image/*"
                   onchange="previewFile(this,'passportPreview','passportZone','passportRemove','passportHolder')">
            <div id="passportHolder" style="display:flex;flex-direction:column;align-items:center;">
                <div class="upload-icon">🛂</div>
                <div class="upload-txt">Click or drag &amp; drop to upload</div>
                <div class="upload-sub">Passport data page photo — JPG, PNG (max 10 MB)</div>
            </div>
            <img id="passportPreview" class="preview-img" alt="Passport Preview">
        </div>
        <button type="button" class="remove-btn" id="passportRemove"
                onclick="removeFile('passportFile','passportPreview','passportZone','passportRemove','passportHolder')">
            ✕ Remove
        </button>
        <div class="attach-note">* This attachment is required to submit the form</div>
    </div>
    <div class="pg-num">18</div>
</div>

 

<div class="dmw-dl-bar">
    <button type="submit" class="btn-dl" id="dlBtn">⬇ Download PDF</button>
    <span id="dlProgress">Generating PDF, please wait…</span>
    <span class="dl-hint">Fill out all fields, then download</span>
</div>
 
</form>
</div>
<?php $__env->stopSection(); ?>
 
<?php $__env->startPush('scripts'); ?>
<script>
/* ── Image upload preview ── */
function previewFile(input, previewId, zoneId, removeBtnId, holderId) {
    var file = input.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function (e) {
        var preview = document.getElementById(previewId);
        var zone    = document.getElementById(zoneId);
        var btn     = document.getElementById(removeBtnId);
        var holder  = document.getElementById(holderId);
        preview.src = e.target.result;
        preview.style.display = 'block';
        holder.style.display  = 'none';
        btn.style.display     = 'inline-block';
        zone.style.border     = '2.5px solid #16a34a';
        zone.style.background = '#f0fdf4';
    };
    reader.readAsDataURL(file);
}
 
function removeFile(fileId, previewId, zoneId, removeBtnId, holderId) {
    document.getElementById(fileId).value = '';
    var preview = document.getElementById(previewId);
    var zone    = document.getElementById(zoneId);
    var btn     = document.getElementById(removeBtnId);
    var holder  = document.getElementById(holderId);
    preview.src = '';
    preview.style.display = 'none';
    holder.style.display  = 'flex';
    btn.style.display     = 'none';
    zone.style.border     = '2.5px dashed #999';
    zone.style.background = '#fafafa';
}
 
/* ── Civil status: single-select ── */
document.querySelectorAll('.cscb').forEach(function (cb) {
    cb.addEventListener('change', function () {
        if (this.checked) {
            document.querySelectorAll('.cscb').forEach(function (o) {
                if (o !== cb) o.checked = false;
            });
        }
    });
});
 
/* ── Submit feedback ── */
document.getElementById('dmwForm').addEventListener('submit', function () {
    var btn  = document.getElementById('dlBtn');
    var prog = document.getElementById('dlProgress');
    btn.disabled = true;
    btn.textContent = 'Generating…';
    prog.style.display = 'inline';
});
</script>
<?php $__env->stopPush(); ?>
 







<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/ofw/dmwbuilder.blade.php ENDPATH**/ ?>