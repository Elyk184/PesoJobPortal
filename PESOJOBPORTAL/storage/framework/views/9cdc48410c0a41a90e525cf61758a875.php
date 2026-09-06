<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>WAS Registration - Admin Copy</title>
<style>
@page { size: A4 portrait; margin: 10mm 14mm; }
* { box-sizing: border-box; margin: 0; padding: 0; }
html, body { width: 210mm; }
body { font-family: 'Times New Roman', Times, serif; color: #000; font-size: 9pt; }

.page { width: 100%; max-width: 182mm; min-height: 277mm; overflow: hidden; page-break-after: always; position: relative; }
.page:last-child { page-break-after: auto; }

/* ── HEADER (mirrors .form-header in workers-association-form.css) ── */
.top-row { display: table; width: 100%; table-layout: fixed; }
.top-row > div { display: table-cell; vertical-align: top; }
.logo-cell { width: 80px; text-align: center; }
.logo-cell img { width: 60px; height: auto; }
.blr-form-no { font-size: 7pt; text-align: center; margin-top: 2px; }
.head-center { text-align: center; }
.republic-text { font-size: 8.5pt; }
.dept-text { font-size: 11pt; font-weight: bold; margin-top: 1px; }
.regional-text { font-size: 9pt; margin-top: 1px; }
.underline-val { text-decoration: underline; font-weight: bold; }
.form-code { text-align: right; color: #c00; font-size: 7pt; width: 110px; }

/* ── FORM TITLE ── */
.form-title { text-align: center; background: #f0f0f0; border: 1.5px solid #000; padding: 3px 6px; margin: 4px 0 0; }
.form-title h1 { font-size: 11pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.03em; }
.title-abbr { font-style: italic; }

/* ── PART LABELS / NOTES ── */
.part-label { display: table; width: 100%; table-layout: fixed; background: #c8c8c8; border: 1px solid #000; border-top: none; padding: 2px 5px; font-size: 7.5pt; }
.part-label > div { display: table-cell; vertical-align: middle; }
.part-heading { font-weight: bold; font-size: 8pt; }
.part-label .right-box { text-align: right; font-size: 7.5pt; white-space: nowrap; }
.part-note { border: 1px solid #000; border-top: none; padding: 2px 5px; font-size: 7pt; font-style: italic; background: #fff; }

/* ── ROW GROUPS / FIELDS ── */
.row-group { display: table; width: 100%; table-layout: fixed; border: 1px solid #000; border-top: none; }
.row-group > .field-group { display: table-cell; vertical-align: top; padding: 2px 5px; }
.field-group label { font-size: 7.5pt; font-weight: bold; display: block; margin-bottom: 2px; }
.fval { border-bottom: 1px solid #555; min-height: 12px; font-size: 9pt; padding: 2px 0; }

.contact-group { border-left: 1px solid #000; width: 230px; }
.contact-row { font-size: 7.5pt; margin-bottom: 3px; }
.contact-row span.ck-label { display: inline-block; min-width: 70px; }
.contact-row .fval { display: inline-block; width: 62%; font-size: 8pt; min-height: 10px; margin: 0; }

.name-subfields { display: table; width: 100%; table-layout: fixed; }
.name-subfields > div { display: table-cell; padding-right: 6px; vertical-align: bottom; }
.name-col-mi { width: 50px; }
.sub-label { font-size: 6.5pt; color: #444; text-align: center; margin-top: 1px; }

.gender-field { width: 180px; }

.place-field { width: auto; }
.members-field { border-left: 1px solid #000; width: 160px; }
.members-row { font-size: 8.5pt; margin-top: 4px; }
.members-row span.ml { display: inline-block; min-width: 55px; }
.members-box-val { border: 1px solid #888; display: inline-block; width: 55px; text-align: right; padding: 1px 3px; font-size: 9pt; }
.members-total { border-top: 1px solid #000; padding-top: 4px; margin-top: 4px; font-weight: bold; }

/* ── occupation ── */
.occupation-section { border: 1px solid #000; border-top: none; padding: 3px 6px; }
.occupation-label { font-size: 7.5pt; font-weight: bold; margin-bottom: 2px; }
.occupation-label em { font-weight: normal; }
.occupation-group { margin-bottom: 1px; font-size: 8pt; line-height: 1.35; }
.chk { display: inline-block; width: 9px; height: 9px; border: 1.1px solid #000; margin-right: 3px; vertical-align: middle; position: relative; top: -1px; }
.chk.on::after { content: "\2713"; position: absolute; left: -1px; top: -3px; font-size: 9px; line-height: 9px; }
.inline-text { border-bottom: 1px solid #555; display: inline-block; width: 80px; font-size: 8pt; }
.inline-text-long { border-bottom: 1px solid #555; display: inline-block; width: 200px; font-size: 8pt; }

/* ── attestation ── */
.attestation-section { border: 1px solid #000; border-top: none; padding: 5px 10px; }
.attest-text { font-size: 9pt; margin-bottom: 8px; }
.signature-block { text-align: right; margin-bottom: 8px; }
.signature-line-group { display: inline-block; min-width: 220px; text-align: center; }
.sig-line { border-bottom: 1px solid #000; height: 16px; }
.sig-label { font-size: 8.5pt; font-weight: bold; margin-top: 2px; }
.sig-sublabel { font-size: 7.5pt; font-style: italic; }

.notary-block { font-size: 8.5pt; margin-bottom: 5px; }
.notary-row { margin-bottom: 2px; }
.notary-val { border-bottom: 1px solid #555; display: inline-block; padding: 0 2px; }
.notary-public-label { text-align: center; font-size: 9pt; font-weight: bold; margin: 8px 0; text-decoration: underline; }

.doc-fields { font-size: 8.5pt; }
.doc-row { margin-bottom: 3px; }
.doc-val { border-bottom: 1px solid #555; display: inline-block; width: 90px; }

/* ── requirements / checklist (Part II support) ── */
.requirements-section { border: 1px solid #000; border-top: none; padding: 7px 10px; }
.checklist-item { font-size: 8pt; margin-bottom: 5px; }
.checklist-item .fname { font-style: italic; color: #333; }

/* ── action / part III ── */
.action-section { border: 1px solid #000; border-top: none; padding: 7px 10px; }
.action-section > p.a-title { font-size: 8.5pt; font-weight: bold; margin-bottom: 5px; }
.proc-note { font-size: 7.5pt; font-style: italic; color: #444; }

/* ── page footer ── */
.pg-num { position: absolute; bottom: 0; right: 0; font-size: 8.5pt; }

/* ── attachment pages ── */
.attach-page { text-align: center; padding-top: 14px; }
.attach-title { font-size: 11.5pt; font-weight: bold; text-decoration: underline; }
.attach-subtitle { font-size: 8pt; color: #555; margin-top: 3px; margin-bottom: 12px; }
.attach-img-wrap { width: 100%; min-height: 200mm; border: 1px solid #999; padding: 6mm; text-align: center; overflow: hidden; }
.attach-img-wrap img { max-width: 100%; max-height: 188mm; }
.attach-missing { color: #999; font-style: italic; font-size: 9pt; padding-top: 85mm; }
</style>
</head>
<body>

<?php
    $attachments = [];
    if (!empty($submission['constitution_document'])) {
        $attachments[] = ['title' => 'Constitution and By-laws', 'image' => $submission['constitution_document']];
    }
    if (!empty($submission['financial_report'])) {
        $attachments[] = ['title' => 'Annual Financial Report', 'image' => $submission['financial_report']];
    }
    foreach (($submission['additional_documents'] ?? []) as $idx => $path) {
        $attachments[] = ['title' => 'Additional Supporting Document ' . ($idx + 1), 'image' => $path];
    }
    $occupation = $submission['occupation'] ?? [];
?>


<div class="page">
    <div class="top-row">
        <div class="logo-cell">
            <?php if(!empty($dole_logo)): ?><img src="<?php echo e($dole_logo); ?>" alt="DOLE Logo"><?php endif; ?>
            <div class="blr-form-no">BLR Form No. 4, Series 2016</div>
        </div>
        <div class="head-center">
            <p class="republic-text">Republic of the Philippines</p>
            <p class="dept-text">DEPARTMENT OF LABOR AND EMPLOYMENT</p>
            <p class="regional-text">Regional Office No. <span class="underline-val"><?php echo e($submission['regional_office'] ?? '__'); ?></span></p>
        </div>
        <div class="form-code">PM-__-___.11-F-01, R.01</div>
    </div>

    <div class="form-title">
        <h1>APPLICATION FOR REGISTRATION OF WORKER'S ASSOCIATION <span class="title-abbr">(WAs)</span></h1>
    </div>

    <div class="part-label">
        <div class="part-heading">PART I. INFORMATION ABOUT THE REPORTING ORGANIZATION</div>
        <div class="right-box">Date Accomplished <em>(mm/dd/yyyy)</em> &nbsp;<b><?php echo e($submission['date_accomplished'] ?? ''); ?></b></div>
    </div>
    <div class="part-note">To be accomplished by the applicant. Supply all required information. Misrepresentation, false information filed in this application or any supporting document is a ground for denial or cancellation of registration.</div>

    <div class="row-group">
        <div class="field-group" style="width:68%;">
            <label>Name of Applicant Association</label>
            <div class="fval"><?php echo e($submission['association_name'] ?? ''); ?></div>
        </div>
        <div class="field-group contact-group">
            <label>Contact Nos.</label>
            <div class="contact-row"><span class="ck-label">E-mail:</span><span class="fval"><?php echo e($submission['email'] ?? ''); ?></span></div>
            <div class="contact-row"><span class="ck-label">Landline No:</span><span class="fval"><?php echo e($submission['contact_no'] ?? ''); ?></span></div>
            <div class="contact-row"><span class="ck-label">Mobile No:</span><span class="fval"><?php echo e($submission['contact_mobile'] ?? ''); ?></span></div>
        </div>
    </div>

    <div class="row-group">
        <div class="field-group" style="width:100%;">
            <label>Address</label>
            <div class="fval"><?php echo e($submission['address'] ?? ''); ?></div>
        </div>
    </div>

    <div class="row-group">
        <div class="field-group" style="width:68%;">
            <label>Name of President</label>
            <div class="name-subfields">
                <div><div class="fval"><?php echo e($submission['president_first_name'] ?? ''); ?></div><div class="sub-label">(First Name)</div></div>
                <div class="name-col-mi"><div class="fval"><?php echo e($submission['president_middle_name'] ?? ''); ?></div><div class="sub-label">(M.I.)</div></div>
                <div><div class="fval"><?php echo e($submission['president_last_name'] ?? ''); ?></div><div class="sub-label">(Last Name)</div></div>
            </div>
        </div>
        <div class="field-group contact-group">
            <label>Contact Nos.</label>
            <div class="contact-row"><span class="ck-label">E-mail:</span><span class="fval"><?php echo e($submission['president_email'] ?? ''); ?></span></div>
            <div class="contact-row"><span class="ck-label">Landline No:</span><span class="fval"><?php echo e($submission['president_landline'] ?? ''); ?></span></div>
            <div class="contact-row"><span class="ck-label">Mobile No:</span><span class="fval"><?php echo e($submission['president_mobile'] ?? ''); ?></span></div>
        </div>
    </div>

    <div class="row-group">
        <div class="field-group" style="width:100%;">
            <label>Address</label>
            <div class="fval"><?php echo e($submission['president_address'] ?? ''); ?></div>
        </div>
    </div>

    <div class="row-group">
        <div class="field-group gender-field">
            <label>Gender</label>
            <div class="fval"><?php echo e($submission['gender'] ?? ''); ?></div>
        </div>
        <div class="field-group" style="width:100%;"></div>
    </div>

    <div class="row-group">
        <div class="field-group" style="width:50%;">
            <label>Date Organized <em>(mm/dd/yyyy)</em></label>
            <div class="fval"><?php echo e($submission['date_organized'] ?? ''); ?></div>
        </div>
        <div class="field-group" style="width:50%;">
            <label>Date of CBL Ratification <em>(mm/dd/yyyy)</em></label>
            <div class="fval"><?php echo e($submission['date_cbl_ratification'] ?? ''); ?></div>
        </div>
    </div>

    <div class="row-group">
        <div class="field-group place-field" style="width:68%;">
            <label>Place/s of Operation</label>
            <div class="fval" style="min-height: 30px;"><?php echo e($submission['place_of_operation'] ?? ''); ?></div>
        </div>
        <div class="field-group members-field">
            <label>No. of Association Members</label>
            <div class="members-row"><span class="ml">Male</span><span class="members-box-val"><?php echo e($submission['male_members'] ?? ''); ?></span></div>
            <div class="members-row"><span class="ml">Female</span><span class="members-box-val"><?php echo e($submission['female_members'] ?? ''); ?></span></div>
            <div class="members-row members-total">TOTAL <span style="float:right;"><?php echo e($submission['total_members'] ?? ((int)($submission['male_members'] ?? 0) + (int)($submission['female_members'] ?? 0))); ?></span></div>
        </div>
    </div>

    <div class="occupation-section">
        <p class="occupation-label">Occupation of Members: <em>Please check appropriate category</em></p>
        <div class="occupation-group">
            <span class="chk<?php echo e(in_array('Agricultural Workers', $occupation) ? ' on' : ''); ?>"></span> Agricultural Workers (
            <span class="chk<?php echo e(in_array('Farmers', $occupation) ? ' on' : ''); ?>"></span> Farmers
            <span class="chk<?php echo e(in_array('Fisherfolk', $occupation) ? ' on' : ''); ?>"></span> Fisherfolk
            <span class="chk<?php echo e(in_array('Artisans', $occupation) ? ' on' : ''); ?>"></span> Artisans
            <span class="chk<?php echo e(in_array('Cottage', $occupation) ? ' on' : ''); ?>"></span> Cottage
            <span class="chk<?php echo e(in_array('Others', $occupation) ? ' on' : ''); ?>"></span> Others
            <span class="inline-text"><?php echo e($submission['occupation_ag_others_specify'] ?? ''); ?></span> )
        </div>
        <div class="occupation-group">
            <span class="chk<?php echo e(in_array('Small Transport Workers', $occupation) ? ' on' : ''); ?>"></span> Small Transport Workers (Drivers:
            <span class="chk<?php echo e(in_array('Jeepney', $occupation) ? ' on' : ''); ?>"></span> Jeepney
            <span class="chk<?php echo e(in_array('FX', $occupation) ? ' on' : ''); ?>"></span> FX
            <span class="chk<?php echo e(in_array('Tricycle', $occupation) ? ' on' : ''); ?>"></span> Tricycle
            <span class="chk<?php echo e(in_array('Pedicab', $occupation) ? ' on' : ''); ?>"></span> Pedicab )
        </div>
        <div class="occupation-group"><span class="chk<?php echo e(in_array('Home-based / Homeworkers', $occupation) ? ' on' : ''); ?>"></span> Home-based / Homeworkers</div>
        <div class="occupation-group"><span class="chk<?php echo e(in_array('Small Construction Workers', $occupation) ? ' on' : ''); ?>"></span> Small Construction Workers</div>
        <div class="occupation-group">
            <span class="chk<?php echo e(in_array('Vendors', $occupation) ? ' on' : ''); ?>"></span> Vendors (
            <span class="chk<?php echo e(in_array('Market', $occupation) ? ' on' : ''); ?>"></span> Market
            <span class="chk<?php echo e(in_array('Sidewalk', $occupation) ? ' on' : ''); ?>"></span> Sidewalk
            <span class="chk<?php echo e(in_array('Ambulant', $occupation) ? ' on' : ''); ?>"></span> Ambulant )
        </div>
        <div class="occupation-group"><span class="chk<?php echo e(in_array('Small-scale Miners', $occupation) ? ' on' : ''); ?>"></span> Small-scale Miners</div>
        <div class="occupation-group">
            <span class="chk<?php echo e(in_array('Other', $occupation) ? ' on' : ''); ?>"></span> Others / Own-Account, Please specify
            <span class="inline-text-long"><?php echo e($submission['occupation_other_text'] ?? ''); ?></span>
        </div>
    </div>

    <div class="attestation-section">
        <p class="attest-text">I attest to the truth of the foregoing.</p>
        <div class="signature-block">
            <div class="signature-line-group">
                <div class="sig-line"><?php echo e($submission['president_signature'] ?? ''); ?></div>
                <p class="sig-label">President</p>
                <p class="sig-sublabel">(Signature over printed name)</p>
            </div>
        </div>
        <div class="notary-block">
            <div class="notary-row">Subscribed and sworn to before me at <span class="notary-val" style="width:200px;"><?php echo e($submission['signature_location'] ?? ''); ?></span>, Philippines,</div>
            <div class="notary-row">this <span class="notary-val" style="width:40px;"><?php echo e($submission['sworn_day'] ?? ''); ?></span> day of <span class="notary-val" style="width:120px;"><?php echo e($submission['sworn_month'] ?? ''); ?></span> 20<span class="notary-val" style="width:30px;"><?php echo e($submission['sworn_year'] ?? ''); ?></span> with I.D. No. <span class="notary-val" style="width:130px;"><?php echo e($submission['id_no'] ?? ''); ?></span></div>
            <div class="notary-row">issued by <span class="notary-val" style="width:200px;"><?php echo e($submission['id_issued_by'] ?? ''); ?></span> on <span class="notary-val" style="width:120px;"><?php echo e($submission['id_issued_on'] ?? ''); ?></span></div>
        </div>
        <div class="notary-public-label">NOTARY PUBLIC</div>
        <div class="doc-fields">
            <div class="doc-row">Doc No. <span class="doc-val"><?php echo e($submission['doc_no'] ?? ''); ?></span></div>
            <div class="doc-row">Page No. <span class="doc-val"><?php echo e($submission['page_no'] ?? ''); ?></span></div>
            <div class="doc-row">Book No. <span class="doc-val"><?php echo e($submission['book_no'] ?? ''); ?></span></div>
            <div class="doc-row">Series of <span class="doc-val"><?php echo e($submission['series_of'] ?? ''); ?></span></div>
        </div>
    </div>
    <div class="pg-num">1</div>
</div>


<?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="page">
    <div class="attach-page">
        <div class="attach-title">Supporting Document — <?php echo e($att['title']); ?></div>
        <div class="attach-subtitle">Uploaded by the applicant association</div>
        <div class="attach-img-wrap">
            <?php if(!empty($att['image'])): ?>
                <img src="<?php echo e($att['image']); ?>" alt="<?php echo e($att['title']); ?>">
            <?php else: ?>
                <div class="attach-missing">No image attached.</div>
            <?php endif; ?>
        </div>
    </div>
    <div class="pg-num"><?php echo e($i + 2); ?></div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</body>
</html><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\admin\associations-pdf.blade.php ENDPATH**/ ?>