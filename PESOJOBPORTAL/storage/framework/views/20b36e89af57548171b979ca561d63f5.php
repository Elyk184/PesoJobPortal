<?php $__env->startSection('title', 'Association | Registration Form'); ?>

<?php $__env->startSection('dashboard-mobile-brand'); ?>
    <div class="dashboard-mobile-brand">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="PESO Logo">
        <span>Association Portal</span>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard-sidebar'); ?>
    <?php echo $__env->make('dashboard.partials.association-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section aria-label="Worker's Association Registration Form">
        <div class="dashboard-topbar">
            <div>
                <div class="dashboard-topbar-title">Application for Registration</div>
                <div class="dashboard-topbar-subtitle">Worker's Association (WA) Registration Form</div>
            </div>
        </div>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('status')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <?php echo e(session('status')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <link rel="stylesheet" href="<?php echo e(asset('css/workers-association-form.css')); ?>">

        <div class="dashboard-section-card p-4 mb-4">
            <div class="page-wrapper">
                <form method="POST" action="<?php echo e(route('association.registration.submit')); ?>" enctype="multipart/form-data" class="form-page">
                    <?php echo csrf_field(); ?>

                    
                    <div class="form-header">
                        <div class="header-logo">
                             <img src="<?php echo e(asset('images/dolee.png')); ?>" alt="DOLE Logo" class="logo-img">
                            <div class="blr-form-no">
                                <span>BLR Form No. 4, Series 2016</span>
                            </div>
                        </div>
                        <div class="header-text">
                            <p class="republic-text">Republic of the Philippines</p>
                            <p class="dept-text">DEPARTMENT OF LABOR AND EMPLOYMENT</p>
                            <p class="regional-text">Regional Office No. <span class="underline-val">__</span></p>
                        </div>
                        <div class="form-code">
                            <span>PM-__-___.11-F-01, R.01</span>
                        </div>
                    </div>

                    
                    <div class="form-title">
                        <h1>APPLICATION FOR REGISTRATION OF WORKER'S ASSOCIATION <span class="title-abbr">(WAs)</span></h1>
                    </div>

                    
                    <div class="part-label">
                        <span class="part-heading">PART I. INFORMATION ABOUT THE REPORTING ORGANIZATION</span>
                        <div class="date-accomplished-box">
                            <label>Date Accomplished <em>(mm/dd/yyyy)</em></label>
                            <input type="text" name="date_accomplished" placeholder="mm/dd/yyyy" value="<?php echo e(old('date_accomplished')); ?>">
                        </div>
                    </div>

                    <div class="part-note">
                        To be accomplished by the applicant. Supply all required information. Misrepresentation, false information filed in this
                        application or any supporting document is a ground for denial or cancellation of registration.
                    </div>

                    
                    <div class="row-group two-col">
                        <div class="field-group">
                            <label>Name of Applicant Association</label>
                            <input type="text" name="association_name" value="<?php echo e(old('association_name')); ?>" required>
                        </div>
                        <div class="field-group contact-group">
                            <label>Contact Nos.</label>
                            <div class="contact-fields">
                                <div class="contact-row">
                                    <span>E-mail:</span>
                                    <input type="email" name="email" value="<?php echo e(old('email')); ?>">
                                </div>
                                <div class="contact-row">
                                    <span>Landline No:</span>
                                    <input type="text" name="contact_no" value="<?php echo e(old('contact_no')); ?>">
                                </div>
                                <div class="contact-row">
                                    <span>Mobile No:</span>
                                    <input type="text" name="contact_mobile" value="<?php echo e(old('contact_mobile')); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="row-group">
                        <div class="field-group full-width">
                            <label>Address</label>
                            <input type="text" name="address" value="<?php echo e(old('address')); ?>" required>
                        </div>
                    </div>

                    
                    <div class="row-group two-col">
                        <div class="field-group">
                            <label>Name of President</label>
                            <div class="name-subfields">
                                <div class="name-col">
                                    <input type="text" name="president_first_name" value="<?php echo e(old('president_first_name')); ?>" required>
                                    <span class="sub-label">(First Name)</span>
                                </div>
                                <div class="name-col name-col-mi">
                                    <input type="text" name="president_middle_name" value="<?php echo e(old('president_middle_name')); ?>">
                                    <span class="sub-label">(M.I.)</span>
                                </div>
                                <div class="name-col">
                                    <input type="text" name="president_last_name" value="<?php echo e(old('president_last_name')); ?>" required>
                                    <span class="sub-label">(Last Name)</span>
                                </div>
                            </div>
                        </div>
                        <div class="field-group contact-group">
                            <label>Contact Nos.</label>
                            <div class="contact-fields">
                                <div class="contact-row">
                                    <span>E-mail:</span>
                                    <input type="email" name="president_email" value="<?php echo e(old('president_email')); ?>">
                                </div>
                                <div class="contact-row">
                                    <span>Landline No:</span>
                                    <input type="text" name="president_landline" value="<?php echo e(old('president_landline')); ?>">
                                </div>
                                <div class="contact-row">
                                    <span>Mobile No:</span>
                                    <input type="text" name="president_mobile" value="<?php echo e(old('president_mobile')); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="row-group">
                        <div class="field-group full-width">
                            <label>Address</label>
                            <input type="text" name="president_address" value="<?php echo e(old('president_address')); ?>" required>
                        </div>
                    </div>

                    
                    <div class="row-group">
                        <div class="field-group gender-field">
                            <label>Gender</label>
                            <input type="text" name="gender" value="<?php echo e(old('gender')); ?>">
                        </div>
                    </div>

                    
                    <div class="row-group two-col-equal">
                        <div class="field-group">
                            <label>Date Organized <em>(mm/dd/yyyy)</em></label>
                            <input type="text" name="date_organized" placeholder="mm/dd/yyyy" value="<?php echo e(old('date_organized')); ?>" required>
                        </div>
                        <div class="field-group">
                            <label>Date of CBL Ratification <em>(mm/dd/yyyy)</em></label>
                            <input type="text" name="date_cbl_ratification" placeholder="mm/dd/yyyy" value="<?php echo e(old('date_cbl_ratification')); ?>">
                        </div>
                    </div>

                    
                    <div class="row-group places-members">
                        <div class="field-group place-field">
                            <label>Place/s of Operation</label>
                            <textarea name="place_of_operation" rows="3" required><?php echo e(old('place_of_operation')); ?></textarea>
                        </div>
                        <div class="field-group members-field">
                            <label>No. of Association Members</label>
                            <div class="members-table">
                                <div class="members-row">
                                    <span>Male</span>
                                    <input type="number" name="male_members" min="0" value="<?php echo e(old('male_members')); ?>" required>
                                </div>
                                <div class="members-row">
                                    <span>Female</span>
                                    <input type="number" name="female_members" min="0" value="<?php echo e(old('female_members')); ?>" required>
                                </div>
                                <div class="members-row members-total">
                                    <span>TOTAL</span>
                                    <input type="number" name="total_members" min="0" readonly value="<?php echo e(old('total_members', old('male_members', 0)+old('female_members', 0))); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="occupation-section">
                        <p class="occupation-label">Occupation of Members: <em>Please check appropriate category</em></p>

                        <div class="occupation-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="occupation[]" value="Agricultural Workers" <?php echo e(in_array('Agricultural Workers', old('occupation', [])) ? 'checked' : ''); ?>> Agricultural Workers (
                                <input type="checkbox" name="occupation[]" value="Farmers" <?php echo e(in_array('Farmers', old('occupation', [])) ? 'checked' : ''); ?>> Farmers
                                <input type="checkbox" name="occupation[]" value="Fisherfolk" <?php echo e(in_array('Fisherfolk', old('occupation', [])) ? 'checked' : ''); ?>> Fisherfolk
                                <input type="checkbox" name="occupation[]" value="Artisans" <?php echo e(in_array('Artisans', old('occupation', [])) ? 'checked' : ''); ?>> Artisans
                                <input type="checkbox" name="occupation[]" value="Cottage" <?php echo e(in_array('Cottage', old('occupation', [])) ? 'checked' : ''); ?>> Cottage
                                <input type="checkbox" name="occupation[]" value="Others" <?php echo e(in_array('Others', old('occupation', [])) ? 'checked' : ''); ?>> Others
                                <input type="text" name="occupation_ag_others_specify" class="inline-text" value="<?php echo e(old('occupation_ag_others_specify')); ?>"> )
                            </label>
                        </div>

                        <div class="occupation-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="occupation[]" value="Small Transport Workers" <?php echo e(in_array('Small Transport Workers', old('occupation', [])) ? 'checked' : ''); ?>> Small Transport Workers (Drivers:
                                <input type="checkbox" name="occupation[]" value="Jeepney" <?php echo e(in_array('Jeepney', old('occupation', [])) ? 'checked' : ''); ?>> Jeepney
                                <input type="checkbox" name="occupation[]" value="FX" <?php echo e(in_array('FX', old('occupation', [])) ? 'checked' : ''); ?>> FX
                                <input type="checkbox" name="occupation[]" value="Tricycle" <?php echo e(in_array('Tricycle', old('occupation', [])) ? 'checked' : ''); ?>> Tricycle
                                <input type="checkbox" name="occupation[]" value="Pedicab" <?php echo e(in_array('Pedicab', old('occupation', [])) ? 'checked' : ''); ?>> Pedicab )
                            </label>
                        </div>

                        <div class="occupation-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="occupation[]" value="Home-based / Homeworkers" <?php echo e(in_array('Home-based / Homeworkers', old('occupation', [])) ? 'checked' : ''); ?>> Home-based / Homeworkers
                            </label>
                        </div>

                        <div class="occupation-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="occupation[]" value="Small Construction Workers" <?php echo e(in_array('Small Construction Workers', old('occupation', [])) ? 'checked' : ''); ?>> Small Construction Workers
                            </label>
                        </div>

                        <div class="occupation-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="occupation[]" value="Vendors" <?php echo e(in_array('Vendors', old('occupation', [])) ? 'checked' : ''); ?>> Vendors (
                                <input type="checkbox" name="occupation[]" value="Market" <?php echo e(in_array('Market', old('occupation', [])) ? 'checked' : ''); ?>> Market
                                <input type="checkbox" name="occupation[]" value="Sidewalk" <?php echo e(in_array('Sidewalk', old('occupation', [])) ? 'checked' : ''); ?>> Sidewalk
                                <input type="checkbox" name="occupation[]" value="Ambulant" <?php echo e(in_array('Ambulant', old('occupation', [])) ? 'checked' : ''); ?>> Ambulant )
                            </label>
                        </div>

                        <div class="occupation-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="occupation[]" value="Small-scale Miners" <?php echo e(in_array('Small-scale Miners', old('occupation', [])) ? 'checked' : ''); ?>> Small-scale Miners
                            </label>
                        </div>

                        <div class="occupation-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="occupation[]" value="Other" id="occ_other" onchange="toggleOtherOccupation()" <?php echo e(in_array('Other', old('occupation', [])) ? 'checked' : ''); ?>> Others / Own-Account, Please specify
                                <input type="text" name="occupation_other_text" id="occupation_other_text" class="inline-text-long" value="<?php echo e(old('occupation_other_text')); ?>" <?php echo e(in_array('Other', old('occupation', [])) ? '' : 'style="display:none;"'); ?>>
                            </label>
                        </div>

                        
                        <input type="hidden" name="occupation_required" value="1">
                    </div>

                    
                    <div class="attestation-section">
                        <p class="attest-text">I attest to the truth of the foregoing.</p>

                        <div class="signature-block">
                            <div class="signature-line-group">
                                <div class="sig-line"></div>
                                <p class="sig-label"><strong>President</strong></p>
                                <p class="sig-sublabel">(Signature over printed name)</p>
                            </div>
                        </div>

                        <input type="hidden" name="declaration" value="1">

                        <div class="notary-block">
                            <div class="notary-row">
                                <span>Subscribed and sworn to before me at</span>
                                <input type="text" name="signature_location" class="notary-input-long" value="<?php echo e(old('signature_location')); ?>">
                                <span>, Philippines,</span>
                            </div>
                            <div class="notary-row">
                                <span>this</span>
                                <input type="text" name="sworn_day" class="notary-input-short" value="<?php echo e(old('sworn_day')); ?>">
                                <span>day of</span>
                                <input type="text" name="sworn_month" class="notary-input-medium" value="<?php echo e(old('sworn_month')); ?>">
                                <span>20</span>
                                <input type="text" name="sworn_year" class="notary-input-tiny" value="<?php echo e(old('sworn_year')); ?>">
                                <span>with I.D. No.</span>
                                <input type="text" name="id_no" class="notary-input-medium" value="<?php echo e(old('id_no')); ?>">
                            </div>
                            <div class="notary-row">
                                <span>issued by</span>
                                <input type="text" name="id_issued_by" class="notary-input-long" value="<?php echo e(old('id_issued_by')); ?>">
                                <span>on</span>
                                <input type="text" name="id_issued_on" class="notary-input-medium" value="<?php echo e(old('id_issued_on')); ?>">
                            </div>
                        </div>

                        <div class="notary-public-label">NOTARY PUBLIC</div>

                        <div class="doc-fields">
                            <div class="doc-row">
                                <span>Doc No.</span>
                                <input type="text" name="doc_no" class="doc-input" value="<?php echo e(old('doc_no')); ?>">
                            </div>
                            <div class="doc-row">
                                <span>Page No.</span>
                                <input type="text" name="page_no" class="doc-input" value="<?php echo e(old('page_no')); ?>">
                            </div>
                            <div class="doc-row">
                                <span>Book No.</span>
                                <input type="text" name="book_no" class="doc-input" value="<?php echo e(old('book_no')); ?>">
                            </div>
                            <div class="doc-row">
                                <span>Series of</span>
                                <input type="text" name="series_of" class="doc-input" value="<?php echo e(old('series_of')); ?>">
                            </div>
                        </div>

                        
                        <input type="text" name="president_signature" value="<?php echo e(old('president_signature')); ?>" class="notary-input-long" placeholder="President signature over printed name" style="margin-top:10px;" required>
                        <input type="date" name="signature_date" value="<?php echo e(old('signature_date', date('Y-m-d'))); ?>" style="display:none;">
                    </div>

                    
                    <div class="page-break"></div>

                    
                    <div class="part-label part-label-ii">
                        <span class="part-heading">PART II. PROCESSING OF REQUIREMENTS</span>
                        <div class="date-received-box">
                            <label>Date Received:</label>
                            <input type="text" name="date_received" placeholder="mm/dd/yyyy" value="<?php echo e(old('date_received')); ?>">
                        </div>
                    </div>
                    <div class="part-note">(To be accomplished by the processor in the FO)</div>

                    
                    <div class="part-label part-label-iii">
                        <span class="part-heading">PART III. ACTION ON THE APPLICATION</span>
                    </div>
                    <div class="action-section">
                        <p><strong>A. Approval/Denial</strong></p>
                        <p style="font-size:7.5pt;font-style:italic;font-weight:normal;">(Processor fields omitted in this electronic submission view.)</p>

                        <div class="submit-wrapper">
                            <button type="submit" class="submit-btn">Submit Application</button>
                        </div>

                        <div style="display:flex;justify-content:center;gap:12px;margin-top:10px;">
                            <a href="<?php echo e(route('association.dashboard')); ?>" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </div>

                    
                    <div class="requirements-section" style="margin-top:0;">
                        <p style="font-size:8.5pt;font-weight:bold;margin-bottom:8px;">Supporting Documents</p>
                        <div class="checklist-item">
                            <span class="checkbox-bracket">[ ]</span>
                            <span>Constitution and By-laws</span>
                            <input type="file" name="constitution_document" accept=".pdf,.jpg,.jpeg,.png" style="margin-left:10px;">
                        </div>
                        <div class="checklist-item">
                            <span class="checkbox-bracket">[ ]</span>
                            <span>Annual Financial Report</span>
                            <input type="file" name="financial_report" accept=".pdf,.jpg,.jpeg,.png" style="margin-left:10px;">
                        </div>
                        <div class="checklist-item">
                            <span class="checkbox-bracket">[ ]</span>
                            <span>Additional supporting documents (optional)</span>
                            <input type="file" name="additional_documents[]" accept=".pdf,.jpg,.jpeg,.png" multiple style="margin-left:10px;">
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <script>
            const maleInput = document.querySelector('input[name="male_members"]');
            const femaleInput = document.querySelector('input[name="female_members"]');
            const totalInput = document.querySelector('input[name="total_members"]');

            function updateTotal() {
                const male = parseInt(maleInput.value) || 0;
                const female = parseInt(femaleInput.value) || 0;
                totalInput.value = male + female;
            }

            if (maleInput && femaleInput && totalInput) {
                maleInput.addEventListener('input', updateTotal);
                femaleInput.addEventListener('input', updateTotal);
                updateTotal();
            }

            function toggleOtherOccupation() {
                const checkbox = document.getElementById('occ_other');
                const textInput = document.getElementById('occupation_other_text');
                if (!checkbox || !textInput) return;
                textInput.style.display = checkbox.checked ? 'block' : 'none';
                if (!checkbox.checked) textInput.value = '';
            }

            document.addEventListener('DOMContentLoaded', function () {
                toggleOtherOccupation();
            });
        </script>

    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\dashboard\association\registration-form.blade.php ENDPATH**/ ?>