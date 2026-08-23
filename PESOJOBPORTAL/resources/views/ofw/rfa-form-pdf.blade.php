<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OWWA RFA Form</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111; }
        h1, h2, h3, p { margin: 0 0 8px; }
        .header { text-align: center; margin-bottom: 12px; }
        .header-logo { width: 64px; height: 64px; object-fit: contain; margin-bottom: 6px; }
        .section { border: 1px solid #111; padding: 10px; margin-bottom: 10px; }
        .label { font-weight: bold; }
        .row { margin-bottom: 6px; }
        .small { font-size: 9px; color: #444; }
        ul { margin: 4px 0 0 18px; padding: 0; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/owwa.png') }}" alt="OWWA" class="header-logo">
        <h2>OVERSEAS WORKERS WELFARE ADMINISTRATION</h2>
        <h3>REQUEST FOR ASSISTANCE FORM</h3>
        <p class="small">Generated {{ $generated_at->format('Y-m-d H:i') }}</p>
    </div>

    <div class="section">
        <div class="row"><span class="label">E-Cares Ticket Number:</span> {{ $e_cares_ticket_number ?? '' }}</div>
        <div class="row"><span class="label">Date:</span> {{ $date ?? '' }}</div>
        <div class="row">
            <span class="label">Nature of Case / Request:</span>
            @if(!empty($case_labels))
                <ul>
                    @foreach($case_labels as $caseLabel)
                        <li>{{ $caseLabel }}</li>
                    @endforeach
                </ul>
            @else
                <span>None</span>
            @endif
        </div>
        @if(!empty($nature_of_case_other))
            <div class="row"><span class="label">Others:</span> {{ $nature_of_case_other }}</div>
        @endif
    </div>

    <div class="section">
        <div class="row"><span class="label">OFW Name:</span> {{ trim(($ofw_first ?? '') . ' ' . ($ofw_middle ?? '') . ' ' . ($ofw_last ?? '')) }}</div>
        <div class="row"><span class="label">Contact No.:</span> {{ $contact_no ?? '' }}</div>
        <div class="row"><span class="label">Position:</span> {{ $position ?? '' }}</div>
        <div class="row"><span class="label">Sex:</span> {{ $sex ?? '' }}</div>
        <div class="row"><span class="label">Birthdate:</span> {{ $birthdate ?? '' }}</div>
        <div class="row"><span class="label">Age:</span> {{ $age ?? '' }}</div>
        <div class="row"><span class="label">Civil Status:</span> {{ $civil_status ?? '' }}</div>
        <div class="row"><span class="label">Facebook Name:</span> {{ $facebook_name ?? '' }}</div>
        <div class="row"><span class="label">Highest Educational Attainment:</span> {{ $highest_education ?? '' }}</div>
        <div class="row"><span class="label">Religion:</span> {{ $religion ?? '' }}</div>
        <div class="row"><span class="label">No. of Children:</span> {{ $children_count ?? '' }}</div>
        <div class="row"><span class="label">Name of Employer:</span> {{ $employer_name ?? '' }}</div>
        <div class="row"><span class="label">Jobsite:</span> {{ $jobsite ?? '' }}</div>
        <div class="row"><span class="label">Tel. No. / Fax No.:</span> {{ $tel_fax ?? '' }}</div>
        <div class="row"><span class="label">Monthly Salary:</span> {{ $monthly_salary ?? '' }}</div>
        <div class="row"><span class="label">Foreign Recruitment Agency:</span> {{ $foreign_recruitment_agency ?? '' }}</div>
        <div class="row"><span class="label">Agency Address / Tel.:</span> {{ $agency_address_tel ?? '' }}</div>
        <div class="row"><span class="label">Local Agency:</span> {{ $local_agency ?? '' }}</div>
        <div class="row"><span class="label">Latest Departure From the Philippines:</span> {{ $latest_departure ?? '' }}</div>
        <div class="row"><span class="label">Previous Employment Country:</span> {{ $previous_employment_country ?? '' }}</div>
        <div class="row"><span class="label">Death Date:</span> {{ $death_date ?? '' }}</div>
        <div class="row"><span class="label">Cause of Death:</span> {{ $death_cause ?? '' }}</div>
        <div class="row"><span class="label">Place of Death:</span> {{ $death_place ?? '' }}</div>
        <div class="row"><span class="label">Facts of the Case:</span><br>{!! nl2br(e($facts_of_case ?? '')) !!}</div>
    </div>

    <div class="section">
        <div class="row"><span class="label">Requesting Party:</span> {{ $requesting_party ?? '' }}</div>
        <div class="row"><span class="label">Relationship to OFW:</span> {{ $relationship_to_ofw ?? '' }}</div>
        <div class="row"><span class="label">Complete Address:</span> {{ $complete_address ?? '' }}</div>
        <div class="row"><span class="label">Phone No. / Email Address:</span> {{ $phone_email ?? '' }}</div>
    </div>

    <div class="section">
        <div class="row"><span class="label">Attachments:</span></div>
        <div class="row">Employment Contract: {{ $contract_name ?? 'None uploaded' }}</div>
        <div class="row">Passport: {{ $passport_name ?? 'None uploaded' }}</div>
    </div>
</body>
</html>