<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company Profile</title>
    <style>
        @page {
            margin: 28px 32px;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.45;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 2px solid #1f4f97;
        }

        .brand {
            display: table-cell;
            vertical-align: middle;
            width: 72%;
        }

        .brand h1 {
            margin: 0;
            font-size: 20px;
            color: #12243f;
        }

        .brand p {
            margin: 4px 0 0;
            color: #5f6f86;
        }

        .stamp {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
            color: #5f6f86;
            font-size: 11px;
        }

        .profile-block {
            margin-bottom: 16px;
            padding: 14px;
            border: 1px solid #dbe6f5;
            border-radius: 12px;
            background: #ffffff;
        }

        .section-title {
            margin: 0 0 12px;
            color: #1f4f97;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .logo-row {
            margin-bottom: 14px;
            text-align: center;
        }

        .logo {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 16px;
            border: 1px solid #dbe6f5;
        }

        .logo-placeholder {
            display: inline-block;
            width: 110px;
            height: 110px;
            line-height: 110px;
            border-radius: 16px;
            border: 1px solid #dbe6f5;
            background: #edf4ff;
            color: #1f4f97;
            font-size: 30px;
            font-weight: 700;
            text-align: center;
        }

        .info-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .info-grid td {
            padding: 6px 0;
            vertical-align: top;
        }

        .label {
            width: 34%;
            color: #5f6f86;
            font-weight: 700;
        }

        .value {
            width: 66%;
            color: #12243f;
            font-weight: 600;
        }

        .address {
            margin: 0;
        }
    </style>
</head>
<body>
    @php
        $hasLogoFile = !empty($logoFullPath) && file_exists($logoFullPath);
    @endphp

    <div class="header">
        <div class="brand">
            <h1>Company Profile</h1>
            <p>{{ $companyProfile?->company_name ?? $employer->name }}</p>
        </div>
        <div class="stamp">
            Generated {{ $generatedAt->format('M d, Y h:i A') }}
        </div>
    </div>

    <div class="profile-block">
        <h2 class="section-title">Logo</h2>
        <div class="logo-row">
            @if($hasLogoFile)
                <img class="logo" src="{{ $logoFullPath }}" alt="Company logo">
            @else
                <div class="logo-placeholder">{{ strtoupper(substr($companyProfile?->company_name ?? $employer->name ?? 'P', 0, 1)) }}</div>
            @endif
        </div>
    </div>

    <div class="profile-block">
        <h2 class="section-title">Business Details</h2>
        <table class="info-grid">
            <tr>
                <td class="label">Company Name</td>
                <td class="value">{{ $companyProfile?->company_name ?? $employer->name }}</td>
            </tr>
            <tr>
                <td class="label">Business Name</td>
                <td class="value">{{ $companyProfile?->business_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Trade Name</td>
                <td class="value">{{ $companyProfile?->trade_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Acronym / Abbreviation</td>
                <td class="value">{{ $companyProfile?->acronym_abbreviation ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Office Type</td>
                <td class="value">{{ $companyProfile?->office_type ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Employer Type</td>
                <td class="value">{{ $companyProfile?->employer_type_detail ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Workforce Size</td>
                <td class="value">{{ $companyProfile?->workforce_size ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Line of Business</td>
                <td class="value">{{ $companyProfile?->line_of_business ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">TIN</td>
                <td class="value">{{ $companyProfile?->tin ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <div class="profile-block">
        <h2 class="section-title">Establishment Details</h2>
        <table class="info-grid">
            <tr>
                <td class="label">Address</td>
                <td class="value">
                    <p class="address">
                        {{ trim(implode(', ', array_filter([
                            $companyProfile?->street_village ?? null,
                            $companyProfile?->barangay ?? null,
                            $companyProfile?->city_municipality ?? null,
                            $companyProfile?->province ?? null,
                        ]))) ?: 'N/A' }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="label">Name of Owner / President</td>
                <td class="value">{{ $companyProfile?->establishment_contact_person ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Position</td>
                <td class="value">{{ $companyProfile?->establishment_contact_position ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Telephone Number</td>
                <td class="value">{{ $companyProfile?->establishment_phone ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">E-mail Address</td>
                <td class="value">{{ $companyProfile?->establishment_email ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

</body>
</html>
