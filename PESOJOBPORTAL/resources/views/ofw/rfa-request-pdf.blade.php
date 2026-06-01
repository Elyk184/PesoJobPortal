<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>OWWA RFA</title>
    <style>
        @page {
            margin: 24px 24px 32px;
        }

        body {
            color: #0f172a;
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
        }

        .page {
            height: 1122px;
            position: relative;
            width: 794px;
        }

        .page-break {
            page-break-after: always;
        }

        .page-bg {
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        .field {
            position: absolute;
        }

        .small {
            font-size: 10px;
        }

        .wrap {
            white-space: pre-wrap;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .statement-text {
            line-height: 1.4;
            white-space: pre-wrap;
        }

        .doc-image {
            border: 1px solid #d0d7de;
            border-radius: 6px;
            max-height: 980px;
            object-fit: contain;
            width: 100%;
        }

        .missing-doc {
            color: #64748b;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="page page-bg" style="@if($page1Background) background-image: url('{{ $page1Background }}'); @endif">
        <div class="field small" style="left: 10%; top: 16.5%;">{{ $request->ecares_ticket_no }}</div>
        <div class="field small" style="left: 64%; top: 16.5%;">{{ optional($request->request_date)->format('m/d/Y') }}</div>

        <div class="field small wrap" style="left: 10%; top: 22%; max-width: 80%;">
            {{ collect($request->nature_of_case ?? [])->implode(', ') }}
            @if (! empty($request->nature_of_case_other))
                (Others: {{ $request->nature_of_case_other }})
            @endif
        </div>

        <div class="field small" style="left: 18%; top: 33.5%;">{{ $request->ofw_first_name }}</div>
        <div class="field small" style="left: 42%; top: 33.5%;">{{ $request->ofw_middle_name }}</div>
        <div class="field small" style="left: 66%; top: 33.5%;">{{ $request->ofw_last_name }}</div>
        <div class="field small" style="left: 82%; top: 33.5%;">{{ $request->contact_no }}</div>

        <div class="field small" style="left: 10%; top: 38.6%;">{{ $request->position }}</div>
        <div class="field small" style="left: 25%; top: 38.6%;">{{ $request->sex }}</div>
        <div class="field small" style="left: 38%; top: 38.6%;">{{ optional($request->birthdate)->format('m/d/Y') }}</div>
        <div class="field small" style="left: 52%; top: 38.6%;">{{ $request->age }}</div>
        <div class="field small" style="left: 63%; top: 38.6%;">{{ $request->civil_status }}</div>
        <div class="field small" style="left: 78%; top: 38.6%;">{{ $request->facebook_name }}</div>

        <div class="field small" style="left: 10%; top: 43.5%;">{{ $request->highest_education }}</div>
        <div class="field small" style="left: 50%; top: 43.5%;">{{ $request->religion }}</div>
        <div class="field small" style="left: 75%; top: 43.5%;">{{ $request->no_children }}</div>

        <div class="field small" style="left: 10%; top: 48.3%;">{{ $request->employer_name }}</div>
        <div class="field small" style="left: 10%; top: 52.8%;">{{ $request->jobsite }}</div>

        <div class="field small" style="left: 10%; top: 57.2%;">{{ $request->tel_no }}</div>
        <div class="field small" style="left: 56%; top: 57.2%;">{{ $request->monthly_salary }}</div>

        <div class="field small" style="left: 10%; top: 61.7%;">{{ $request->foreign_agency_name }}</div>
        <div class="field small" style="left: 55%; top: 61.7%;">{{ $request->foreign_agency_address }}</div>

        <div class="field small" style="left: 10%; top: 66.3%;">{{ $request->local_agency_name }}</div>

        <div class="field small" style="left: 10%; top: 70.8%;">{{ optional($request->latest_departure_date)->format('m/d/Y') }}</div>
        <div class="field small" style="left: 52%; top: 70.8%;">{{ $request->previous_employment }}</div>

        <div class="field small" style="left: 30%; top: 73.5%;">{{ $request->cause_of_death }}</div>
        <div class="field small" style="left: 66%; top: 73.5%;">{{ $request->place_of_death }}</div>
        <div class="field small" style="left: 10%; top: 75.5%;">{{ optional($request->date_of_death)->format('m/d/Y') }}</div>

        <div class="field small wrap" style="left: 10%; top: 79%; max-width: 80%;">
            {{ $request->facts_of_case }}
        </div>

        <div class="field small" style="left: 18%; top: 92.5%;">{{ $request->requesting_party_name }}</div>
        <div class="field small" style="left: 68%; top: 92.5%;">{{ $request->relationship_to_ofw }}</div>
        <div class="field small" style="left: 18%; top: 96.5%;">{{ $request->complete_address }}</div>
        <div class="field small" style="left: 68%; top: 96.5%;">{{ $request->requesting_party_contact }}</div>
    </div>

    <div class="page page-break">
        <div class="section-title">Contract Document</div>
        @if ($contractDoc)
            <img class="doc-image" src="{{ $contractDoc }}" alt="Contract Document">
        @else
            <div class="missing-doc">No contract document uploaded.</div>
        @endif
    </div>

    <div class="page">
        <div class="section-title">Passport Document</div>
        @if ($passportDoc)
            <img class="doc-image" src="{{ $passportDoc }}" alt="Passport Document">
        @else
            <div class="missing-doc">No passport document uploaded.</div>
        @endif
    </div>
</body>
</html>
