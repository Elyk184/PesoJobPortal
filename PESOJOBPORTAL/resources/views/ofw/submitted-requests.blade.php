@extends('layouts.dashboard')

@section('title', 'Submitted Requests')

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
    <h1 class="h4 fw-bold mb-2">Submitted Requests</h1>
    <p class="text-muted mb-4">Your submitted DMW and OWWA RFA form PDFs are listed below.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($submittedRequests->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Form Type</th>
                        <th>Status</th>
                        <th>File Name</th>
                        <th>Submitted At</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submittedRequests as $submission)
                        <tr>
                            <td>
                                <span class="badge text-bg-primary">
                                    {{ $submission->form_type === 'rfa' ? 'OWWA RFA' : 'DMW RFA' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $submission->status === 'accepted' ? 'text-bg-success' : 'text-bg-warning text-dark' }}">
                                    {{ ucfirst($submission->status ?? 'submitted') }}
                                </span>
                            </td>
                            <td>{{ $submission->pdf_filename }}</td>
                            <td>{{ optional($submission->created_at)->format('M d, Y h:i A') }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('ofw.submitted-requests.download', $submission) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download me-1"></i>Download PDF
                                    </a>

                                    @if($submission->status !== 'accepted')
                                        <form method="POST"
                                              action="{{ route('ofw.submitted-requests.delete', $submission) }}"
                                              onsubmit="return confirm('Delete this submission? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $submittedRequests->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-info mb-0">You have no submitted DMW/RFA forms yet.</div>
    @endif
</section>
@endsection
