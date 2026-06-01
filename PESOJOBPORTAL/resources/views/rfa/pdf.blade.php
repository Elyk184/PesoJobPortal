<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Request for Assistance Form</title>
    <style>
        @page { size: legal portrait; margin: 0; }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 8.5px;
            color: #111;
            line-height: 1.1;
            margin: 0;
            padding: 0;
        }

        .page {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .page-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: fill;
        }

        .field {
            position: absolute;
            z-index: 1;
            color: #111;
            text-shadow: 0 0 0.2px #fff;
        }

        .field-sm {
            font-size: 8.5px;
        }

        .field-wrap {
            white-space: pre-wrap;
            word-break: break-word;
        }

        .page2,
        .page3 {
            box-sizing: border-box;
            padding: 0;
        }

        .doc-title {
            font-size: 10px;
            font-weight: 700;
            margin: 0;
            text-align: center;
            text-transform: uppercase;
            position: absolute;
            left: 0;
            right: 0;
            top: 8px;
            z-index: 2;
        }

        .doc-frame {
            position: absolute;
            inset: 24px 18px 18px 18px;
            border: 1px solid #000;
            box-sizing: border-box;
            overflow: hidden;
        }

        .doc-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .doc-placeholder {
            position: absolute;
            inset: 0;
            color: #222;
            font-size: 12px;
            line-height: 1.5;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 12px;
        }

        .doc-filename {
            margin-top: 8px;
            font-size: 10px;
            color: #555;
            word-break: break-word;
        }
    </style>
</head>
<body>
    <div class="page">
        @if (!empty($page1Background) && file_exists($page1Background))
            <img class="page-bg" src="{{ $page1Background }}" alt="RFA background">
        @endif

        @php
            $selectedCases = collect($caseSelections ?? [])
                ->map(function ($key) use ($caseOptions) {
                    return $caseOptions[$key] ?? null;
                })
                ->filter()
                ->values();
        @endphp

        <div class="field field-sm" style="left: 10%; top: 16.5%; width: 32%;">{{ $e_cares_ticket_number ?? '' }}</div>
        <div class="field field-sm" style="left: 64%; top: 16.5%; width: 26%;">{{ $date ?? '' }}</div>

        <div class="field field-sm" style="left: 9.5%; top: 21.7%; width: 80%;">
            <table style="width:100%; border-collapse:collapse; table-layout:fixed; font-size:8px;">
                @php
                    $caseKeys = array_keys($caseOptions);
                    $col1 = array_slice($caseKeys, 0, 5);
                    $col2 = array_slice($caseKeys, 5, 5);
                    $col3 = array_slice($caseKeys, 10);
                @endphp
                <tr>
                    <td style="width: 33%; vertical-align: top; padding-right: 4px;">
                        @foreach ($col1 as $key)
                            <div>[ {!! in_array($key, $caseSelections ?? [], true) ? '&#10003;' : '&nbsp;' !!} ] {{ $caseOptions[$key] ?? '' }}</div>
                        @endforeach
                    </td>
                    <td style="width: 33%; vertical-align: top; padding-right: 4px;">
                        @foreach ($col2 as $key)
                            <div>[ {!! in_array($key, $caseSelections ?? [], true) ? '&#10003;' : '&nbsp;' !!} ] {{ $caseOptions[$key] ?? '' }}</div>
                        @endforeach
                    </td>
                    <td style="width: 34%; vertical-align: top;">
                        @foreach ($col3 as $key)
                            <div>[ {!! in_array($key, $caseSelections ?? [], true) ? '&#10003;' : '&nbsp;' !!} ] {{ $caseOptions[$key] ?? '' }}</div>
                        @endforeach
                        <div>[ {!! !empty($nature_of_case_other) ? '&#10003;' : '&nbsp;' !!} ] Others: {{ $nature_of_case_other ?? '' }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="field field-sm" style="left: 18%; top: 33.5%; width: 22%;">{{ $ofw_first ?? '' }}</div>
        <div class="field field-sm" style="left: 42%; top: 33.5%; width: 18%;">{{ $ofw_middle ?? '' }}</div>
        <div class="field field-sm" style="left: 66%; top: 33.5%; width: 17%;">{{ $ofw_last ?? '' }}</div>
        <div class="field field-sm" style="left: 82%; top: 33.5%; width: 13%;">{{ $contact_no ?? '' }}</div>

        <div class="field field-sm" style="left: 10%; top: 38.6%; width: 13%;">{{ $position ?? '' }}</div>
        <div class="field field-sm" style="left: 25%; top: 38.6%; width: 7%;">{{ $sex ?? '' }}</div>
        <div class="field field-sm" style="left: 38%; top: 38.6%; width: 12%;">{{ $birthdate ?? '' }}</div>
        <div class="field field-sm" style="left: 52%; top: 38.6%; width: 6%;">{{ $age ?? '' }}</div>
        <div class="field field-sm" style="left: 63%; top: 38.6%; width: 16%;">{{ $civil_status ?? '' }}</div>
        <div class="field field-sm" style="left: 78%; top: 38.6%; width: 17%;">{{ $facebook_name ?? '' }}</div>

        <div class="field field-sm" style="left: 10%; top: 43.5%; width: 38%;">{{ $highest_education ?? '' }}</div>
        <div class="field field-sm" style="left: 50%; top: 43.5%; width: 26%;">{{ $religion ?? '' }}</div>
        <div class="field field-sm" style="left: 75%; top: 43.5%; width: 18%;">{{ $children_count ?? '' }}</div>

        <div class="field field-sm" style="left: 10%; top: 48.3%; width: 86%;">{{ $employer_name ?? '' }}</div>
        <div class="field field-sm" style="left: 10%; top: 52.8%; width: 86%;">{{ $jobsite ?? '' }}</div>

        <div class="field field-sm" style="left: 10%; top: 57.2%; width: 40%;">{{ $tel_fax ?? '' }}</div>
        <div class="field field-sm" style="left: 56%; top: 57.2%; width: 28%;">{{ $monthly_salary ?? '' }}</div>

        <div class="field field-sm" style="left: 10%; top: 61.7%; width: 41%;">{{ $foreign_recruitment_agency ?? '' }}</div>
        <div class="field field-sm" style="left: 55%; top: 61.7%; width: 39%;">{{ $agency_address_tel ?? '' }}</div>

        <div class="field field-sm" style="left: 10%; top: 66.3%; width: 86%;">{{ $local_agency ?? '' }}</div>

        <div class="field field-sm" style="left: 10%; top: 70.8%; width: 40%;">{{ $latest_departure ?? '' }}</div>
        <div class="field field-sm" style="left: 52%; top: 70.8%; width: 40%;">{{ $previous_employment_country ?? '' }}</div>

        <div class="field field-sm" style="left: 10%; top: 73.5%; width: 20%;">{{ $death_date ?? '' }}</div>
        <div class="field field-sm" style="left: 30%; top: 73.5%; width: 34%;">{{ $death_cause ?? '' }}</div>
        <div class="field field-sm" style="left: 66%; top: 73.5%; width: 24%;">{{ $death_place ?? '' }}</div>

        <div class="field field-sm field-wrap" style="left: 10%; top: 79%; max-width: 80%; height: 12%; overflow: hidden;">{{ $facts_of_case ?? '' }}</div>

        <div class="field field-sm" style="left: 18%; top: 92.5%; width: 32%; text-align: center;">{{ $requesting_party ?? '' }}</div>
        <div class="field field-sm" style="left: 68%; top: 92.5%; width: 26%; text-align: center;">{{ $relationship_to_ofw ?? '' }}</div>
        <div class="field field-sm" style="left: 18%; top: 96.5%; width: 32%; text-align: center;">{{ $complete_address ?? '' }}</div>
        <div class="field field-sm" style="left: 68%; top: 96.5%; width: 26%; text-align: center;">{{ $phone_email ?? '' }}</div>
    </div>

    <div class="page page2">
        <div class="doc-title">Page 2 - Employment Contract</div>
        <div class="doc-frame">
            @if (($attachments['contract']['available'] ?? false) && ($attachments['contract']['is_image'] ?? false) && !empty($attachments['contract']['data_uri']))
                <img class="doc-image" src="{{ $attachments['contract']['data_uri'] }}" alt="Contract Attachment">
            @else
                <div class="doc-placeholder">
                    <div>Employment contract preview is not available in this generated PDF.</div>
                    @if (!empty($attachments['contract']['filename']))
                        <div class="doc-filename">{{ $attachments['contract']['filename'] }}</div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="page page3">
        <div class="doc-title">Page 3 - Passport</div>
        <div class="doc-frame">
            @if (($attachments['passport']['available'] ?? false) && ($attachments['passport']['is_image'] ?? false) && !empty($attachments['passport']['data_uri']))
                <img class="doc-image" src="{{ $attachments['passport']['data_uri'] }}" alt="Passport Attachment">
            @else
                <div class="doc-placeholder">
                    <div>Passport preview is not available in this generated PDF.</div>
                    @if (!empty($attachments['passport']['filename']))
                        <div class="doc-filename">{{ $attachments['passport']['filename'] }}</div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</body>
</html>