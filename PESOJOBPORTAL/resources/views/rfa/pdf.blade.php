<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Request for Assistance Form</title>
    <style>
        @page { 
            size: legal portrait; 
            margin: 20px; 
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
            color: #111;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }

        /* Form Container */
        .rfa-sheet {
            padding: 20px;
            border: 1.5px solid #111;
        }

        /* Table Resets for Layouts */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
            table-layout: fixed;
        }
        td {
            vertical-align: bottom;
            padding: 2px 4px;
        }

        /* Header */
        .header-table {
            border: 1.5px solid #111;
            margin-bottom: 12px;
        }
        .header-logo {
            width: 75px;
            text-align: center;
            vertical-align: middle;
            padding: 5px;
        }
        .header-logo img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 2px solid #555;
        }
        .header-center {
            text-align: center;
            vertical-align: middle;
            padding: 5px;
        }
        .header-center p {
            margin: 2px 0;
            font-size: 10.5px;
        }
        .header-center .bold {
            font-weight: 700;
            font-size: 11px;
        }
        .header-center .title {
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            margin-top: 5px;
        }
        .header-stamp {
            width: 90px;
            text-align: center;
            vertical-align: middle;
            padding: 5px;
        }
        .stamp-box {
            border: 2px solid #b91c1c;
            color: #b91c1c;
            font-weight: 700;
            font-size: 10px;
            text-transform: uppercase;
            padding: 6px 4px;
            line-height: 1.2;
        }

        /* Section Bars */
        .section-bar {
            font-weight: 700;
            font-size: 10.5px;
            text-transform: uppercase;
            border-top: 1px solid #111;
            border-bottom: 1px solid #111;
            padding: 5px 0;
            margin: 12px 0 8px;
        }

        /* Fields */
        .field-label {
            font-size: 10px;
            font-weight: 700;
            display: block;
            margin-bottom: 2px;
        }
        .field-value {
            border-bottom: 1px solid #555;
            font-size: 11px;
            min-height: 14px;
            word-wrap: break-word;
        }
        .field-value-box {
            border: 1px solid #555;
            padding: 6px;
            min-height: 50px;
            font-size: 11px;
        }

        /* Checkboxes */
        .cb-table td {
            vertical-align: top;
            font-size: 10.5px;
            padding: 2px;
            line-height: 1.4;
        }
        /* Uses DejaVu Sans explicitly to fix the "?" DOMPDF issue */
        .check-icon {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            font-weight: bold;
        }

        /* Notice Block */
        .notice {
            border: 1px solid #111;
            padding: 8px 12px;
            margin: 12px 0;
            font-size: 10px;
            font-style: italic;
            text-align: center;
            line-height: 1.4;
        }

        /* Signatures */
        .sig-label {
            font-size: 10px;
            font-weight: 700;
            text-align: center;
            margin-top: 4px;
        }

        /* Pages */
        .page {
            page-break-after: always;
            padding-top: 20px;
        }
        .page:last-child {
            page-break-after: auto;
        }
        .doc-title {
            font-size: 11px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .doc-frame {
            border: 1px solid #000;
            padding: 10px;
            height: 850px;
            text-align: center;
        }
        .doc-image {
            max-width: 100%;
            max-height: 830px;
            object-fit: contain;
        }
        .doc-placeholder {
            padding-top: 400px;
            color: #222;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="rfa-sheet">
        
        <table class="header-table">
            <tr>
                <td class="header-logo">
                    <img src="{{ public_path('images/owwa-logo.png') }}" alt="OWWA Logo">
                </td>
                <td class="header-center">
                    <p>DEPARTMENT OF LABOR AND EMPLOYMENT</p>
                    <p class="bold">OVERSEAS WORKERS WELFARE ADMINISTRATION</p>
                    <p>Regional Welfare Office No. 10</p>
                    <p>Cagayan de Oro City</p>
                    <p class="title">Request for Assistance Form</p>
                </td>
                <td class="header-stamp">
                    <div class="stamp-box">THIS FORM IS<br>NOT FOR SALE</div>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width: 50%;">
                    <span class="field-label">E-Cares Ticket Number:</span>
                    <div class="field-value">{{ $e_cares_ticket_number ?? '' }}</div>
                </td>
                <td style="width: 50%;">
                    <span class="field-label">Date:</span>
                    <div class="field-value">{{ $date ?? '' }}</div>
                </td>
            </tr>
        </table>

        <div class="section-bar">Nature of Case / Request</div>
        <table class="cb-table">
            @php
                $selections = $caseSelections ?? [];
                $otherSelected = in_array('others', $selections, true) || !empty($nature_of_case_other);
                $caseKeys = array_keys($caseOptions);
                $col1 = array_slice($caseKeys, 0, 5);
                $col2 = array_slice($caseKeys, 5, 5);
                $col3 = array_slice($caseKeys, 10);
                
                // Set DOMPDF safe checkmark
                $checkMark = '<span class="check-icon">&#10003;</span>';
            @endphp
            <tr>
                <td style="width: 33%;">
                    @foreach ($col1 as $key)
                        <div>[ {!! in_array($key, $selections, true) ? $checkMark : '&nbsp;&nbsp;' !!} ] {{ $caseOptions[$key] ?? '' }}</div>
                    @endforeach
                </td>
                <td style="width: 33%;">
                    @foreach ($col2 as $key)
                        <div>[ {!! in_array($key, $selections, true) ? $checkMark : '&nbsp;&nbsp;' !!} ] {{ $caseOptions[$key] ?? '' }}</div>
                    @endforeach
                </td>
                <td style="width: 34%;">
                    @foreach ($col3 as $key)
                        <div>[ {!! in_array($key, $selections, true) ? $checkMark : '&nbsp;&nbsp;' !!} ] {{ $caseOptions[$key] ?? '' }}</div>
                    @endforeach
                    <div>
                        [ {!! $otherSelected ? $checkMark : '&nbsp;&nbsp;' !!} ] Others: 
                        <span style="border-bottom: 1px solid #555; display: inline-block; width: 65%;">{{ $nature_of_case_other ?? '' }}</span>
                    </div>
                </td>
            </tr>
        </table>

        <div class="section-bar">OFW's Background and Employment Record</div>
        
        <table>
            <tr>
                <td style="width: 25%;"><span class="field-label">Name of OFW: [ First ]</span><div class="field-value">{{ $ofw_first ?? '' }}</div></td>
                <td style="width: 25%;"><span class="field-label">[ Middle ]</span><div class="field-value">{{ $ofw_middle ?? '' }}</div></td>
                <td style="width: 25%;"><span class="field-label">[ Last ]</span><div class="field-value">{{ $ofw_last ?? '' }}</div></td>
                <td style="width: 25%;"><span class="field-label">Contact No.</span><div class="field-value">{{ $contact_no ?? '' }}</div></td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width: 20%;"><span class="field-label">Position:</span><div class="field-value">{{ $position ?? '' }}</div></td>
                <td style="width: 20%;"><span class="field-label">Sex:</span><div class="field-value">{{ $sex ?? '' }}</div></td>
                <td style="width: 20%;"><span class="field-label">Birthdate:</span><div class="field-value">{{ $birthdate ?? '' }}</div></td>
                <td style="width: 20%;"><span class="field-label">Age:</span><div class="field-value">{{ $age ?? '' }}</div></td>
                <td style="width: 20%;"><span class="field-label">Civil Status:</span><div class="field-value">{{ $civil_status ?? '' }}</div></td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width: 33%;"><span class="field-label">Facebook Name:</span><div class="field-value">{{ $facebook_name ?? '' }}</div></td>
                <td style="width: 34%;"><span class="field-label">Highest Educational Attainment:</span><div class="field-value">{{ $highest_education ?? '' }}</div></td>
                <td style="width: 33%;"><span class="field-label">Religion:</span><div class="field-value">{{ $religion ?? '' }}</div></td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width: 50%;"><span class="field-label">No. of Children:</span><div class="field-value">{{ $children_count ?? '' }}</div></td>
                <td style="width: 50%;"><span class="field-label">Name of Employer:</span><div class="field-value">{{ $employer_name ?? '' }}</div></td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width: 100%;"><span class="field-label">Jobsite:</span><div class="field-value">{{ $jobsite ?? '' }}</div></td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width: 50%;"><span class="field-label">Tel. No. / Fax No.:</span><div class="field-value">{{ $tel_fax ?? '' }}</div></td>
                <td style="width: 50%;"><span class="field-label">Monthly Salary:</span><div class="field-value">{{ $monthly_salary ?? '' }}</div></td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width: 100%;"><span class="field-label">Name of Foreign Recruitment Agency:</span><div class="field-value">{{ $foreign_recruitment_agency ?? '' }}</div></td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width: 50%;"><span class="field-label">Address and Tel. No.:</span><div class="field-value">{{ $agency_address_tel ?? '' }}</div></td>
                <td style="width: 50%;"><span class="field-label">Name of Local Agency:</span><div class="field-value">{{ $local_agency ?? '' }}</div></td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width: 50%;"><span class="field-label">Date of Latest Departure From the Philippines:</span><div class="field-value">{{ $latest_departure ?? '' }}</div></td>
                <td style="width: 50%;"><span class="field-label">OFW's Previous Employment (Please Specify Country):</span><div class="field-value">{{ $previous_employment_country ?? '' }}</div></td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width: 33%;"><span class="field-label">For Death Case: Date of Death:</span><div class="field-value">{{ $death_date ?? '' }}</div></td>
                <td style="width: 34%;"><span class="field-label">Cause of Death:</span><div class="field-value">{{ $death_cause ?? '' }}</div></td>
                <td style="width: 33%;"><span class="field-label">Place of Death:</span><div class="field-value">{{ $death_place ?? '' }}</div></td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width: 100%;">
                    <span class="field-label">Facts of the Case [Isalaysay ang Inyong Request]:</span>
                    <div class="field-value-box">{!! nl2br(e($facts_of_case ?? '')) !!}</div>
                </td>
            </tr>
        </table>

        <div class="notice">
            In case of my failure to follow up OWWA on development within two (2) months from the date of filing,
            it is contracted that the case has been resolved already, the same shall be achieved.
        </div>

        <div class="section-bar">Requesting Party</div>

        <table style="margin-top: 15px;">
            <tr>
                <td style="width: 50%; padding: 0 10px;">
                    <div style="border-bottom: 1px solid #111; min-height: 20px; text-align: center; font-size: 11px; padding-bottom: 2px;">
                        {{ $requesting_party ?? '' }}
                    </div>
                    <div class="sig-label">Name &amp; Signature of Requesting Party</div>
                </td>
                <td style="width: 50%; padding: 0 10px;">
                    <div style="border-bottom: 1px solid #111; min-height: 20px; text-align: center; font-size: 11px; padding-bottom: 2px;">
                        {{ $relationship_to_ofw ?? '' }}
                    </div>
                    <div class="sig-label">Relationship to OFW</div>
                </td>
            </tr>
        </table>

        <table style="margin-top: 15px;">
            <tr>
                <td style="width: 50%; padding: 0 10px;">
                    <div style="border-bottom: 1px solid #111; min-height: 20px; text-align: center; font-size: 11px; padding-bottom: 2px;">
                        {{ $complete_address ?? '' }}
                    </div>
                    <div class="sig-label">Complete Address</div>
                </td>
                <td style="width: 50%; padding: 0 10px;">
                    <div style="border-bottom: 1px solid #111; min-height: 20px; text-align: center; font-size: 11px; padding-bottom: 2px;">
                        {{ $phone_email ?? '' }}
                    </div>
                    <div class="sig-label">Phone No. / Email Address</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="page">
        <div class="doc-title">Page 2 - Employment Contract</div>
        <div class="doc-frame">
            @php
                $contract = $attachments['contract'] ?? [];
            @endphp

            @if (($contract['available'] ?? false) && ($contract['is_image'] ?? false) && !empty($contract['data_uri']))
                <img class="doc-image" src="{{ $contract['data_uri'] }}" alt="Contract Attachment">
            @elseif ($contract['available'] ?? false)
                <div class="doc-placeholder">
                    <div>Employment contract attachment added.</div>
                    <div style="margin-top:8px;">
                        <span style="font-size:10px;font-weight:700;">{{ $contract['filename'] ?? 'PDF' }}</span>
                    </div>
                </div>
            @else
                <div class="doc-placeholder">
                    <div>Employment contract not provided.</div>
                </div>
            @endif
        </div>
    </div>

    <div class="page">
        <div class="doc-title">Page 3 - Passport</div>
        <div class="doc-frame">
            @php
                $passport = $attachments['passport'] ?? [];
            @endphp

            @if (($passport['available'] ?? false) && ($passport['is_image'] ?? false) && !empty($passport['data_uri']))
                <img class="doc-image" src="{{ $passport['data_uri'] }}" alt="Passport Attachment">
            @elseif ($passport['available'] ?? false)
                <div class="doc-placeholder">
                    <div>Passport attachment added.</div>
                    <div style="margin-top:8px;">
                        <span style="font-size:10px;font-weight:700;">{{ $passport['filename'] ?? 'PDF' }}</span>
                    </div>
                </div>
            @else
                <div class="doc-placeholder">
                    <div>Passport not provided.</div>
                </div>
            @endif
        </div>
    </div>

</body>
</html>