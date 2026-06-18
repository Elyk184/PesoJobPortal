<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company Profile</title>
    <style>
        @page {
            margin: 16px 20px;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #172033;
            font-size: 10px;
            line-height: 1.28;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 9px;
            padding: 10px 12px;
            border-left: 5px solid #1f4f97;
            background: #f4f8ff;
        }

        .brand {
            display: table-cell;
            vertical-align: middle;
            width: 68%;
        }

        .brand h1 {
            margin: 0;
            font-size: 18px;
            color: #12243f;
        }

        .brand p {
            margin: 3px 0 0;
            color: #52647c;
            font-size: 10px;
            font-weight: 700;
        }

        .stamp {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
            color: #52647c;
            font-size: 9px;
        }

        .stamp strong {
            display: block;
            margin-bottom: 2px;
            color: #12243f;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .profile-block {
            margin-bottom: 8px;
            padding: 0;
            border: 1px solid #d7e3f4;
            border-radius: 8px;
            background: #ffffff;
            page-break-inside: avoid;
            overflow: hidden;
        }

        .section-title {
            margin: 0;
            padding: 6px 8px;
            color: #ffffff;
            background: #1f4f97;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .summary-table,
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 9px;
        }

        .summary-logo {
            width: 82px;
            vertical-align: top;
            text-align: center;
        }

        .summary-info {
            vertical-align: top;
            border-left: 1px solid #e1e9f4;
        }

        .logo {
            width: 68px;
            height: 68px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #dbe6f5;
        }

        .logo-placeholder {
            display: inline-block;
            width: 68px;
            height: 68px;
            line-height: 68px;
            border-radius: 10px;
            border: 1px solid #dbe6f5;
            background: #edf4ff;
            color: #1f4f97;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
        }

        .logo-caption {
            margin-top: 4px;
            color: #52647c;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .details-column {
            width: 50%;
            vertical-align: top;
        }

        .details-column:first-child {
            padding-right: 6px;
        }

        .details-column:last-child {
            padding-left: 6px;
        }

        .info-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .info-grid td {
            padding: 5px 8px;
            vertical-align: top;
            border-bottom: 1px solid #edf2f8;
        }

        .label {
            width: 39%;
            color: #52647c;
            font-weight: 700;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .value {
            width: 61%;
            color: #12243f;
            font-weight: 600;
        }

        .address {
            margin: 0;
        }

        .preline {
            white-space: pre-line;
        }

        .summary-text {
            margin: 0;
            color: #12243f;
            font-weight: 600;
            text-align: justify;
        }

        .summary-heading {
            margin: 0 0 4px;
            color: #1f4f97;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .muted {
            color: #6c7a90;
        }
    </style>
</head>
<body>
    <?php
        $hasLogoFile = !empty($logoFullPath) && file_exists($logoFullPath);
        $companyName = $companyProfile?->company_name ?? $employer->name;
        $companyInformation = filled($companyProfile?->company_information)
            ? \Illuminate\Support\Str::limit($companyProfile->company_information, 700)
            : 'N/A';
        $formatValue = fn ($value) => filled($value) ? \Illuminate\Support\Str::headline(str_replace('_', ' ', $value)) : 'N/A';
        $fullAddress = trim(implode(', ', array_filter([
            $companyProfile?->street_village ?? null,
            $companyProfile?->barangay ?? null,
            $companyProfile?->city_municipality ?? null,
            $companyProfile?->province ?? null,
        ]))) ?: 'N/A';
    ?>

    <div class="header">
        <div class="brand">
            <h1>Company Profile</h1>
            <p><?php echo e($companyName); ?></p>
        </div>
        <div class="stamp">
            <strong>Generated</strong>
            <?php echo e($generatedAt->format('M d, Y h:i A')); ?> PHT
        </div>
    </div>

    <div class="profile-block">
        <table class="summary-table">
            <tr>
                <td class="summary-logo">
                    <?php if($hasLogoFile): ?>
                        <img class="logo" src="<?php echo e($logoFullPath); ?>" alt="Company logo">
                    <?php else: ?>
                        <div class="logo-placeholder"><?php echo e(strtoupper(substr($companyName ?? 'P', 0, 1))); ?></div>
                    <?php endif; ?>
                    <div class="logo-caption">Company Logo</div>
                </td>
                <td class="summary-info">
                    <h2 class="summary-heading">Company Information</h2>
                    <p class="summary-text preline"><?php echo e($companyInformation); ?></p>
                </td>
            </tr>
        </table>
    </div>

    <table class="details-table">
        <tr>
            <td class="details-column">
                <div class="profile-block">
                    <h2 class="section-title">Business Details</h2>
                    <table class="info-grid">
                        <tr>
                            <td class="label">Company Name</td>
                            <td class="value"><?php echo e($companyName); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Business Name</td>
                            <td class="value"><?php echo e($companyProfile?->business_name ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Year Established</td>
                            <td class="value"><?php echo e($companyProfile?->established_year ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Trade Name</td>
                            <td class="value"><?php echo e($companyProfile?->trade_name ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Acronym</td>
                            <td class="value"><?php echo e($companyProfile?->acronym_abbreviation ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Office Type</td>
                            <td class="value"><?php echo e($formatValue($companyProfile?->office_type)); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Employer Type</td>
                            <td class="value"><?php echo e($formatValue($companyProfile?->employer_type_detail)); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Workforce Size</td>
                            <td class="value"><?php echo e($formatValue($companyProfile?->workforce_size)); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Line of Business</td>
                            <td class="value"><?php echo e($companyProfile?->line_of_business ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td class="label">TIN</td>
                            <td class="value"><?php echo e($companyProfile?->tin ?? 'N/A'); ?></td>
                        </tr>
                    </table>
                </div>
            </td>
            <td class="details-column">
                <div class="profile-block">
                    <h2 class="section-title">Establishment Details</h2>
                    <table class="info-grid">
                        <tr>
                            <td class="label">Address</td>
                            <td class="value">
                                <p class="address"><?php echo e($fullAddress); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Owner / President</td>
                            <td class="value"><?php echo e($companyProfile?->establishment_contact_person ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Contact Person</td>
                            <td class="value"><?php echo e($companyProfile?->contact_person_name ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Position</td>
                            <td class="value"><?php echo e($companyProfile?->establishment_contact_position ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Telephone</td>
                            <td class="value"><?php echo e($companyProfile?->establishment_phone ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Mobile</td>
                            <td class="value"><?php echo e($companyProfile?->contact_person_phone ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td class="label">E-mail</td>
                            <td class="value"><?php echo e($companyProfile?->establishment_email ?? 'N/A'); ?></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views/dashboard/employer/company-profile-pdf.blade.php ENDPATH**/ ?>