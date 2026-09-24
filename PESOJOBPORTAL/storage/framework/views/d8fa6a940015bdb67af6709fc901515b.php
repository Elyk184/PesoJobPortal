<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>WAS Registration - Admin Copy</title>
<style>
@page { margin: 0; }
* { box-sizing: border-box; margin: 0; padding: 0; }
html, body { margin: 0; padding: 0; font-family: 'Times New Roman', Times, serif; color: #000; font-size: 8.5pt; }

.wrap { padding: 12mm; }
.page { width: 100%; page-break-after: always; }
.page:last-child { page-break-after: auto; }
.main-page { page-break-after: always; }

/* HEADER */
.form-header { display: table; width: 100%; table-layout: fixed; margin-bottom: 6px; }
.form-header > div { display: table-cell; vertical-align: top; }
.header-logo { width: 80px; text-align: center; }
.header-logo img { width: 60px; height: auto; margin-bottom: 4px; }
.blr-form-no { font-size: 7pt; text-align: center; margin-top: 2px; }
.header-text { text-align: center; }
.republic-text { font-size: 8.5pt; margin-bottom: 1px; }
.dept-text { font-size: 11pt; font-weight: bold; margin-bottom: 1px; }
.regional-text { font-size: 9pt; }
.underline-val { text-decoration: underline; font-weight: bold; }
.form-code { text-align: right; font-size: 7pt; color: #c00; width: 110px; }

/* FORM TITLE */
.form-title { background: #f0f0f0; border: 1.5px solid #000; text-align: center; padding: 5px 8px; margin-bottom: 0; }
.form-title h1 { font-size: 11pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.03em; }
.title-abbr { font-style: italic; }

/* PART LABELS */
.part-label { display: table; width: 100%; table-layout: fixed; background: #c8c8c8; border: 1px solid #000; border-top: none; padding: 3px 6px; font-size: 7.5pt; }
.part-label > div { display: table-cell; vertical-align: middle; }
.part-heading { font-weight: bold; font-size: 8pt; }
.part-right { text-align: right; white-space: nowrap; }
.part-note { border: 1px solid #000; border-top: none; padding: 3px 6px; font-size: 7pt; font-style: italic; background: #fff; }

/* ROW GROUPS */
.row-group { display: table; width: 100%; table-layout: fixed; border: 1px solid #000; border-top: none; }
.row-group > .field-group { display: table-cell; vertical-align: top; padding: 4px 6px; }
.field-group label { font-size: 7.5pt; font-weight: bold; display: block; margin-bottom: 2px; }
.fval { border-bottom: 1px solid #555; min-height: 14px; font-size: 9pt; padding: 2px 0; }

/* CONTACT GROUP */
.contact-group { border-left: 1px solid #000; width: 230px; }
.contact-row { font-size: 7.5pt; margin-bottom: 3px; display: table; width: 100%; }
.contact-row .ck-label { display: table-cell; min-width: 70px; white-space: nowrap; font-size: 7.5pt; vertical-align: middle; }
.contact-row .fval { display: table-cell; width: 100%; font-size: 8pt; min-height: 10px; border-bottom: 1px solid #555; padding: 1px 0; vertical-align: bottom; }

/* NAME SUBFIELDS */
.name-subfields { display: table; width: 100%; table-layout: fixed; }
.name-subfields > div { display: table-cell; padding-right: 6px; vertical-align: bottom; }
.name-col-mi { width: 50px; }
.sub-label { font-size: 6.5pt; color: #444; text-align: center; margin-top: 1px; }

/* GENDER */
.gender-field { width: 180px; }

/* MEMBERS */
.members-field { border-left: 1px solid #000; width: 160px; }
.members-row { display: table; width: 100%; font-size: 8.5pt; margin-top: 4px; }
.members-row .ml { display: table-cell; min-width: 55px; }
.members-box-val { display: table-cell; border: 1px solid #888; width: 60px; text-align: right; padding: 1px 3px; font-size: 9pt; }
.members-total { border-top: 1px solid #000; padding-top: 4px; margin-top: 4px; font-weight: bold; }

/* OCCUPATION */
.occupation-section { border: 1px solid #000; border-top: none; padding: 5px 8px; }
.occupation-label { font-size: 7.5pt; font-weight: bold; margin-bottom: 5px; }
.occupation-label em { font-weight: normal; }
.occupation-group { margin-bottom: 3px; font-size: 8pt; line-height: 1.7; }
.chk { display: inline-block; width: 9px; height: 9px; border: 1.1px solid #000; margin-right: 2px; vertical-align: middle; position: relative; top: -1px; }
.chk.on::after { content: "\2713"; position: absolute; left: -1px; top: -3px; font-size: 9px; line-height: 9px; }
.inline-text { border-bottom: 1px solid #555; display: inline-block; width: 80px; font-size: 8pt; }
.inline-text-long { border-bottom: 1px solid #555; display: inline-block; width: 200px; font-size: 8pt; }

/* ATTESTATION */
.attestation-section { border: 1px solid #000; border-top: none; padding: 10px 14px; }
.attest-text { font-size: 9pt; margin-bottom: 20px; }
.signature-block { text-align: right; margin-bottom: 20px; }
.signature-line-group { display: inline-block; min-width: 220px; text-align: center; }
.sig-line { border-bottom: 1px solid #000; height: 28px; }
.sig-label { font-size: 8.5pt; font-weight: bold; margin-top: 2px; }
.sig-sublabel { font-size: 7.5pt; font-style: italic; }

.notary-block { font-size: 8.5pt; margin-bottom: 10px; }
.notary-row { margin-bottom: 5px; }
.notary-val { border-bottom: 1px solid #555; display: inline-block; padding: 0 2px; }
.notary-public-label { text-align: center; font-size: 9pt; font-weight: bold; margin: 8px 0; text-decoration: underline; }

.doc-fields { font-size: 8.5pt; }
.doc-row { margin-bottom: 3px; }
.doc-val { border-bottom: 1px solid #555; display: inline-block; width: 90px; }

/* PART II / III */
.part-label-top { border-top: 1px solid #000; }
.requirements-section { border: 1px solid #000; border-top: none; padding: 7px 10px; }
.checklist-item { font-size: 8pt; margin-bottom: 5px; }
.action-section { border: 1px solid #000; border-top: none; padding: 7px 10px; }
.a-title { font-size: 8.5pt; font-weight: bold; margin-bottom: 5px; }
.proc-note { font-size: 7.5pt; font-style: italic; color: #444; }

/* PAGE NUMBER */
.pg-num { position: absolute; bottom: 0; right: 0; font-size: 8.5pt; }

/* ATTACHMENT PAGES */
.attach-page { text-align: center; padding-top: 14px; }
.attach-title { font-size: 11.5pt; font-weight: bold; text-decoration: underline; }
.attach-subtitle { font-size: 8.5pt; color: #555; margin-top: 3px; margin-bottom: 12px; }
.attach-img-wrap { width: 100%; border: 1px solid #999; padding: 4mm; text-align: center; overflow: hidden; }
.attach-img-wrap img { max-width: 100%; height: auto; }
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
        if (!empty($path)) {
            $attachments[] = ['title' => 'Additional Supporting Document ' . ($idx + 1), 'image' => $path];
        }
    }
    $occupation = $submission['occupation'] ?? [];
?>


<div class="page main-page"><div class="wrap">

    <div class="form-header">
        <div class="header-logo">
            <?php if(!empty($dole_logo)): ?><img src="<?php echo e($dole_logo); ?>" alt="DOLE Logo"><?php endif; ?>
            <div class="blr-form-no">BLR Form No. 4, Series 2016</div>
        </div>
        <div class="header-text">
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
        <div class="part-right">Date Accomplished <em>(mm/dd/yyyy)</em> &nbsp;<b><?php echo e($submission['date_accomplished'] ?? ''); ?></b></div>
    </div>
    <div class="part-note">To be accomplished by the applicant. Supply all required information. Misrepresentation, false information filed in this application or any supporting document is a ground for denial or cancellation of registration.</div>

    
    <div class="row-group">
        <div class="field-group" style="width:auto;">
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
        <div class="field-group" style="width:auto;">
            <label>Name of President</label>
            <div class="name-subfields">
                <div>
                    <div class="fval"><?php echo e($submission['president_first_name'] ?? ''); ?></div>
                    <div class="sub-label">(First Name)</div>
                </div>
                <div class="name-col-mi">
                    <div class="fval"><?php echo e($submission['president_middle_name'] ?? ''); ?></div>
                    <div class="sub-label">(M.I.)</div>
                </div>
                <div>
                    <div class="fval"><?php echo e($submission['president_last_name'] ?? ''); ?></div>
                    <div class="sub-label">(Last Name)</div>
                </div>
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
        <div class="field-group" style="width:auto;">
            <label>Place/s of Operation</label>
            <div class="fval" style="min-height:30px;"><?php echo e($submission['place_of_operation'] ?? ''); ?></div>
        </div>
        <div class="field-group members-field">
            <label>No. of Association Members</label>
            <div class="members-row"><span class="ml">Male</span><span class="members-box-val"><?php echo e($submission['male_members'] ?? ''); ?></span></div>
            <div class="members-row"><span class="ml">Female</span><span class="members-box-val"><?php echo e($submission['female_members'] ?? ''); ?></span></div>
            <div class="members-row members-total">
                TOTAL
                <span style="float:right;"><?php echo e($submission['total_members'] ?? ((int)($submission['male_members'] ?? 0) + (int)($submission['female_members'] ?? 0))); ?></span>
            </div>
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
            <div class="notary-row">
                Subscribed and sworn to before me at
                <span class="notary-val" style="width:200px;"><?php echo e($submission['signature_location'] ?? ''); ?></span>, Philippines,
            </div>
            <div class="notary-row">
                this <span class="notary-val" style="width:40px;"><?php echo e($submission['sworn_day'] ?? ''); ?></span>
                day of <span class="notary-val" style="width:120px;"><?php echo e($submission['sworn_month'] ?? ''); ?></span>
                20<span class="notary-val" style="width:30px;"><?php echo e($submission['sworn_year'] ?? ''); ?></span>
                with I.D. No. <span class="notary-val" style="width:130px;"><?php echo e($submission['id_no'] ?? ''); ?></span>
            </div>
            <div class="notary-row">
                issued by <span class="notary-val" style="width:200px;"><?php echo e($submission['id_issued_by'] ?? ''); ?></span>
                on <span class="notary-val" style="width:120px;"><?php echo e($submission['id_issued_on'] ?? ''); ?></span>
            </div>
        </div>
        <div class="notary-public-label">NOTARY PUBLIC</div>
        <div class="doc-fields">
            <div class="doc-row">Doc No. <span class="doc-val"><?php echo e($submission['doc_no'] ?? ''); ?></span></div>
            <div class="doc-row">Page No. <span class="doc-val"><?php echo e($submission['page_no'] ?? ''); ?></span></div>
            <div class="doc-row">Book No. <span class="doc-val"><?php echo e($submission['book_no'] ?? ''); ?></span></div>
            <div class="doc-row">Series of <span class="doc-val"><?php echo e($submission['series_of'] ?? ''); ?></span></div>
        </div>
    </div>

    
    <div style="margin-top:8px;">
    <div class="part-label part-label-top">
        <div class="part-heading">PART II. PROCESSING OF REQUIREMENTS</div>
        <div class="part-right">Date Received: &nbsp;<b><?php echo e($submission['date_received'] ?? ''); ?></b></div>
    </div>
    <div class="part-note">(To be accomplished by the processor in the FO)</div>

    <div class="part-label" style="margin-top:10px;">
        <div class="part-heading">PART III. ACTION ON THE APPLICATION</div>
        <div class="part-right"></div>
    </div>
    <div class="action-section">
        <p class="a-title">A. Approval / Denial</p>
        <p class="proc-note">Processor-only fields are not shown in this applicant/admin submission copy. Refer to the case file for the processing record.</p>
    </div>

    <div class="requirements-section" style="margin-top:12px;">
        <p style="font-size:8.5pt;font-weight:bold;margin-bottom:8px;">Supporting Documents Submitted</p>
        <div class="checklist-item">
            <span class="chk<?php echo e(!empty($submission['constitution_document']) ? ' on' : ''); ?>"></span>
            Constitution and By-laws
        </div>
        <div class="checklist-item">
            <span class="chk<?php echo e(!empty($submission['financial_report']) ? ' on' : ''); ?>"></span>
            Annual Financial Report
        </div>
        <div class="checklist-item">
            <span class="chk<?php echo e(!empty($submission['additional_documents']) ? ' on' : ''); ?>"></span>
            Additional supporting documents (optional)
            <?php if(!empty($submission['additional_documents'])): ?>
                &mdash; <?php echo e(count($submission['additional_documents'])); ?> file(s) attached
            <?php endif; ?>
        </div>
    </div>

    </div><!-- end part II/III -->
</div></div><!-- end wrap + main page -->


<?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="page"><div class="wrap">
    <div class="attach-page">
        <div class="attach-title">Supporting Document &mdash; <?php echo e($att['title']); ?></div>
        <div class="attach-subtitle">Uploaded by the applicant association</div>
        <div class="attach-img-wrap">
            <?php if(!empty($att['image']) && $att['image'] !== '__pdf__'): ?>
                <img src="<?php echo e($att['image']); ?>" alt="<?php echo e($att['title']); ?>">
            <?php elseif($att['image'] === '__pdf__'): ?>
                <div class="attach-missing">PDF document attached (preview not available).</div>
            <?php else: ?>
                <div class="attach-missing">No image attached.</div>
            <?php endif; ?>
        </div>
    </div>
    <div style="text-align:right;font-size:8.5pt;margin-top:4px;"><?php echo e($i + 2); ?></div>
</div></div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/admin/associations-pdf.blade.php ENDPATH**/ ?>