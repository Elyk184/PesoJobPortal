@extends('layouts.dashboard')

@section('title', 'Accepted Requests')

@section('dashboard-mobile-brand')
    <div class="dashboard-mobile-brand">
        <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
        <span>OFW Portal</span>
    </div>
@endsection

@section('dashboard-sidebar')
    @include('dashboard.partials.ofw-nav')
@endsection

@section('content')
<section class="dashboard-section-card p-4">
    <h1 class="h4 fw-bold mb-2">Accepted Requests</h1>
    <p class="text-muted mb-4">Your OWWA RFA and DMW RFA PDFs accepted by admin are listed below.</p>

    @if($acceptedRequests->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Form Type</th>
                        <th>File Name</th>
                        <th>Accepted At</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($acceptedRequests as $submission)
                        <tr>
                            <td>
                                <span class="badge text-bg-success">
                                    {{ $submission->form_type === 'rfa' ? 'OWWA RFA' : 'DMW RFA' }}
                                </span>
                            </td>
                            <td>{{ $submission->pdf_filename }}</td>
                            <td>{{ optional($submission->accepted_at)->format('M d, Y h:i A') }}</td>
                            <td class="text-end">
                                <a href="{{ route('ofw.submitted-requests.download', $submission) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download me-1"></i>Download PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $acceptedRequests->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-info mb-0">You have no accepted OFW requests yet.</div>
    @endif
</section>
@endsection
