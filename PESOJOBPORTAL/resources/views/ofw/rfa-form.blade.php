@extends('layouts.dashboard')

@section('title', 'Request for Assistance Form')

@section('dashboard-mobile-brand')
    <div class="dashboard-mobile-brand">
        <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
        <span>OFW Portal</span>
    </div>
@endsection

@section('dashboard-sidebar')
    @include('dashboard.partials.ofw-nav')
@endsection

@push('styles')
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .rfa-body {
        font-family: 'Times New Roman', Times, serif;
        background: #f4f4f4;
        color: #111;
    }

    .rfa-wrapper {
        max-width: 820px;
        margin: 0 auto;
        padding: 24px 16px;
    }

    .rfa-sheet {
        background: #fff;
        border: 1.5px solid #111;
        padding: 18px 20px 24px;
        box-shadow: 0 4px 18px rgba(0,0,0,.10);
    }

    .rfa-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border: 1.5px solid #111;
        padding: 10px 14px;
        margin-bottom: 12px;
    }

    .rfa-logo {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        border: 2px solid #555;
        flex-shrink: 0;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .rfa-logo img { width: 100%; height: 100%; object-fit: cover; }

    .rfa-header-center { flex: 1; text-align: center; }
    .rfa-header-center p { font-size: 10.5px; line-height: 1.6; }
    .rfa-header-center p.bold { font-weight: 700; font-size: 11px; }

    .rfa-main-title {
        font-weight: 700; font-size: 14px;
        text-transform: uppercase; letter-spacing: .05em; margin-top: 6px;
    }

    .rfa-stamp {
        border: 2.5px solid #b91c1c;
        color: #b91c1c;
        font-weight: 700; font-size: 11px;
        text-transform: uppercase;
        padding: 8px 10px; text-align: center; line-height: 1.4;
        flex-shrink: 0;
    }

    .rfa-section-bar {
        font-weight: 700; font-size: 10.5px;
        text-transform: uppercase; letter-spacing: .04em;
        border-top: 1px solid #111; border-bottom: 1px solid #111;
        padding: 5px 0; margin: 14px 0 10px;
    }

    .rfa-field { display: flex; flex-direction: column; gap: 3px; }
    .rfa-field label { font-size: 10px; font-weight: 700; }

    .rfa-field input[type="text"],
    .rfa-field input[type="date"],
    .rfa-field textarea {
        border: none;
        border-bottom: 1px solid #555;
        padding: 3px 2px;
        font-size: 11.5px;
        font-family: inherit;
        background: transparent;
        color: #111;
        outline: none;
        width: 100%;
    }

    .rfa-field textarea {
        border: 1px solid #555;
        padding: 5px 6px; resize: vertical; font-size: 11.5px;
    }

    .rfa-field input[type="file"] {
        font-size: 11px; font-family: inherit;
        border: 1px dashed #94a3b8;
        padding: 6px 8px; border-radius: 4px;
        background: #f8fafc; cursor: pointer; width: 100%;
    }

    .rfa-file-note { font-size: 10px; color: #64748b; margin-top: 3px; font-style: italic; }

    .rfa-g2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .rfa-g3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
    .rfa-g4 { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 10px; }
    .rfa-g5 { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr 1fr; gap: 8px; }

    .mt6  { margin-top: 6px; }
    .mt8  { margin-top: 8px; }
    .mt10 { margin-top: 10px; }

    .rfa-cb-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 5px 12px;
    }
    .rfa-cb-grid label {
        display: flex; align-items: flex-start;
        gap: 5px; font-size: 10.5px; cursor: pointer; line-height: 1.4;
    }
    .rfa-cb-grid input[type="checkbox"] {
        margin-top: 2px; flex-shrink: 0; accent-color: #1e3a8a;
    }

    .rfa-others-row {
        display: flex; align-items: center;
        gap: 6px; font-size: 10.5px; margin-top: 6px;
    }
    .rfa-others-row input[type="text"] {
        flex: 1; border: none; border-bottom: 1px solid #555;
        font-size: 11px; font-family: inherit; outline: none; padding: 2px;
        background: transparent;
    }

    .rfa-notice {
        border: 1px solid #111;
        padding: 8px 12px; margin: 14px 0 12px;
        font-size: 10px; font-style: italic;
        line-height: 1.6; text-align: center;
    }

    .rfa-sig-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 32px; margin-top: 10px;
    }
    .rfa-sig-block { display: flex; flex-direction: column; align-items: center; gap: 4px; }
    .rfa-sig-line { width: 100%; border-bottom: 1px solid #111; height: 28px; }
    .rfa-sig-block label { font-size: 10px; font-weight: 700; text-align: center; }

    .rfa-actions { margin-top: 20px; display: flex; justify-content: flex-end; }

    .rfa-btn-submit {
        background: #111827; color: #fff;
        border: none; padding: 10px 22px;
        font-size: 12.5px; font-weight: 700;
        font-family: inherit; letter-spacing: .04em;
        cursor: pointer; display: flex; align-items: center; gap: 8px;
    }

    .rfa-alert-danger {
        border: 1px solid #fca5a5; background: #fef2f2;
        color: #b91c1c; padding: 10px 14px;
        font-size: 12px; margin-bottom: 12px; border-radius: 2px;
    }

    @media (max-width: 640px) {
        .rfa-g2, .rfa-g3, .rfa-g4, .rfa-g5 { grid-template-columns: 1fr; }
        .rfa-cb-grid { grid-template-columns: 1fr; }
        .rfa-sig-grid { grid-template-columns: 1fr; gap: 16px; }
        .rfa-header { flex-direction: column; text-align: center; }
    }
</style>
@endpush

@section('content')
<div class="rfa-body">
<div class="rfa-wrapper">

    <form class="rfa-sheet" method="POST" action="{{ route('ofw.rfa.download') }}" enctype="multipart/form-data" id="rfaForm">
        @csrf

        @if ($errors->any())
            <div class="rfa-alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="rfa-header">
            <div class="rfa-logo">
                <img src="{{ asset('images/owwa.png') }}" alt="OWWA">
            </div>

            <div class="rfa-header-center">
                <p>DEPARTMENT OF LABOR AND EMPLOYMENT</p>
                <p class="bold">OVERSEAS WORKERS WELFARE ADMINISTRATION</p>
                <p>Regional Welfare Office No. 10</p>
                <p>Cagayan de Oro City</p>
                <p class="rfa-main-title">Request for Assistance Form</p>
            </div>

            <div class="rfa-stamp">THIS FORM IS<br>NOT FOR SALE</div>
        </div>

        <div class="rfa-g2">
            <div class="rfa-field">
                <label for="e_cares_ticket_number">E-Cares Ticket Number:</label>
                <input type="text" id="e_cares_ticket_number" name="e_cares_ticket_number" value="{{ old('e_cares_ticket_number') }}">
            </div>
            <div class="rfa-field">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}">
            </div>
        </div>

        <div class="rfa-section-bar">Nature of Case / Request</div>

        <div class="rfa-cb-grid">
            @foreach ($caseOptions as $key => $label)
                <label>
                    <input type="checkbox" name="nature_of_case[]" value="{{ $key }}" {{ in_array($key, old('nature_of_case', []), true) ? 'checked' : '' }}>
                    {{ $label }}
                </label>
            @endforeach
        </div>

        <div class="rfa-others-row">
            <input type="checkbox" name="nature_of_case[]" value="others" id="others_check" {{ in_array('others', old('nature_of_case', []), true) ? 'checked' : '' }}>
            <label for="others_check">Others:</label>
            <input type="text" name="nature_of_case_other" placeholder="Please specify..." value="{{ old('nature_of_case_other') }}">
        </div>

        <div class="rfa-section-bar">OFW's Background and Employment Record</div>

        <div class="rfa-g4">
            <div class="rfa-field">
                <label>Name of OFW: [ First ]</label>
                <input type="text" name="ofw_first" value="{{ old('ofw_first') }}">
            </div>
            <div class="rfa-field">
                <label>[ Middle ]</label>
                <input type="text" name="ofw_middle" value="{{ old('ofw_middle') }}">
            </div>
            <div class="rfa-field">
                <label>[ Last ]</label>
                <input type="text" name="ofw_last" value="{{ old('ofw_last') }}">
            </div>
            <div class="rfa-field">
                <label>Contact No.</label>
                <input type="text" name="contact_no" value="{{ old('contact_no') }}">
            </div>
        </div>

        <div class="rfa-g5 mt8">
            <div class="rfa-field"><label>Position:</label><input type="text" name="position" value="{{ old('position') }}"></div>
            <div class="rfa-field"><label>Sex:</label><input type="text" name="sex" value="{{ old('sex') }}"></div>
            <div class="rfa-field"><label>Birthdate:</label><input type="text" name="birthdate" placeholder="MM/DD/YYYY" value="{{ old('birthdate') }}"></div>
            <div class="rfa-field"><label>Age:</label><input type="text" name="age" value="{{ old('age') }}"></div>
            <div class="rfa-field"><label>Civil Status:</label><input type="text" name="civil_status" value="{{ old('civil_status') }}"></div>
        </div>

        <div class="rfa-g3 mt8">
            <div class="rfa-field"><label>Facebook Name:</label><input type="text" name="facebook_name" value="{{ old('facebook_name') }}"></div>
            <div class="rfa-field"><label>Highest Educational Attainment:</label><input type="text" name="highest_education" value="{{ old('highest_education') }}"></div>
            <div class="rfa-field"><label>Religion:</label><input type="text" name="religion" value="{{ old('religion') }}"></div>
        </div>

        <div class="rfa-g2 mt8">
            <div class="rfa-field"><label>No. of Children:</label><input type="text" name="children_count" value="{{ old('children_count') }}"></div>
            <div class="rfa-field"><label>Name of Employer:</label><input type="text" name="employer_name" value="{{ old('employer_name') }}"></div>
        </div>

        <div class="mt8 rfa-field">
            <label>Jobsite:</label>
            <input type="text" name="jobsite" value="{{ old('jobsite') }}">
        </div>

        <div class="rfa-g2 mt8">
            <div class="rfa-field"><label>Tel. No. / Fax No.:</label><input type="text" name="tel_fax" value="{{ old('tel_fax') }}"></div>
            <div class="rfa-field"><label>Monthly Salary:</label><input type="text" name="monthly_salary" value="{{ old('monthly_salary') }}"></div>
        </div>

        <div class="mt8 rfa-field">
            <label>Name of Foreign Recruitment Agency:</label>
            <input type="text" name="foreign_recruitment_agency" value="{{ old('foreign_recruitment_agency') }}">
        </div>

        <div class="rfa-g2 mt8">
            <div class="rfa-field"><label>Address and Tel. No.:</label><input type="text" name="agency_address_tel" value="{{ old('agency_address_tel') }}"></div>
            <div class="rfa-field"><label>Name of Local Agency:</label><input type="text" name="local_agency" value="{{ old('local_agency') }}"></div>
        </div>

        <div class="rfa-g2 mt8">
            <div class="rfa-field"><label>Date of Latest Departure From the Philippines:</label><input type="text" name="latest_departure" placeholder="MM/DD/YYYY" value="{{ old('latest_departure') }}"></div>
            <div class="rfa-field"><label>OFW's Previous Employment (Please Specify Country):</label><input type="text" name="previous_employment_country" value="{{ old('previous_employment_country') }}"></div>
        </div>

        <div class="rfa-g3 mt8">
            <div class="rfa-field"><label>For Death Case: Date of Death:</label><input type="text" name="death_date" placeholder="MM/DD/YYYY" value="{{ old('death_date') }}"></div>
            <div class="rfa-field"><label>Cause of Death:</label><input type="text" name="death_cause" value="{{ old('death_cause') }}"></div>
            <div class="rfa-field"><label>Place of Death:</label><input type="text" name="death_place" value="{{ old('death_place') }}"></div>
        </div>

        <div class="mt10 rfa-field">
            <label>Facts of the Case [Isalaysay ang Inyong Request]: (Use back space if necessary)</label>
            <textarea name="facts_of_case" rows="7">{{ old('facts_of_case') }}</textarea>
        </div>

        <div class="rfa-notice">
            In case of my failure to follow up OWWA on development within two (2) months from the date of filing,
            it is contracted that the case has been resolved already, the same shall be achieved.
        </div>

        <div class="rfa-section-bar">Requesting Party</div>

        <div class="rfa-g2 mt8">
            <div class="rfa-field"><label>Name & Signature of Requesting Party:</label><input type="text" name="requesting_party" value="{{ old('requesting_party') }}"></div>
            <div class="rfa-field"><label>Relationship to OFW:</label><input type="text" name="relationship_to_ofw" value="{{ old('relationship_to_ofw') }}"></div>
        </div>

        <div class="rfa-g2 mt8">
            <div class="rfa-field"><label>Complete Address:</label><input type="text" name="complete_address" value="{{ old('complete_address') }}"></div>
            <div class="rfa-field"><label>Phone No. / Email Address:</label><input type="text" name="phone_email" value="{{ old('phone_email') }}"></div>
        </div>

        <div class="rfa-section-bar">Attachments</div>

        <div class="rfa-g2 mt8">
            <div class="rfa-field">
                <label>Employment Contract (PDF/Image):</label>
                <input type="file" name="contract" accept=".pdf,image/*">
            </div>
            <div class="rfa-field">
                <label>Passport (PDF/Image):</label>
                <input type="file" name="passport" accept=".pdf,image/*">
            </div>
        </div>

        <div class="rfa-actions">
            <button type="submit" class="rfa-btn-submit">Submit to Admin</button>
        </div>
    </form>

</div>
</div>
@endsection
