@extends('layouts.admin-dashboard')

@section('title', 'OFW Form Submissions | PESO Admin')

<?php
    $pageTitle = 'OFW Requests';
    $pageSubtitle = 'Review OWWA RFA and DMW RFA PDFs submitted by OFW users';
    $pageIcon = 'bi-file-earmark-pdf';

    $filters = [
        'all'       => 'All Requests',
        'rfa'       => 'OWWA RFA',
        'dmw'       => 'DMW RFA',
        'submitted' => 'Submitted Requests',
        'accepted'  => 'Accepted Requests',
    ];
?>

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-card">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex flex-wrap gap-2 mb-4">
            @foreach($filters as $filterKey => $filterLabel)
                <a href="{{ route('admin.ofw-submissions', ['filter' => $filterKey]) }}"
                   class="btn btn-sm {{ $filter === $filterKey ? 'btn-primary' : 'btn-outline-primary' }}">
                    {{ $filterLabel }}
                    <span class="badge {{ $filter === $filterKey ? 'text-bg-light text-primary' : 'text-bg-primary' }} ms-1">
                        {{ $ofwStats[$filterKey] ?? 0 }}
                    </span>
                </a>
            @endforeach
        </div>

        @if($submissions->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Submitted By</th>
                            <th>Form Type</th>
                            <th>Status</th>
                            <th>File Name</th>
                            <th>Submitted At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $submission)
                            <tr>
                                <td>{{ $submission->user?->name ?? 'Unknown User' }}</td>
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
                                        <a href="{{ route('admin.ofw-submissions.download', $submission) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-download me-1"></i>Download PDF
                                        </a>

                                        @if($submission->status !== 'accepted')
                                            <form method="POST" action="{{ route('admin.ofw-submissions.accept', $submission) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="bi bi-check2-circle me-1"></i>Accept
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST" action="{{ route('admin.ofw-submissions.delete', $submission) }}"
                                              onsubmit="return confirm('Delete this submission? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $submissions->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-info mb-0">No OFW DMW/RFA submissions yet.</div>
        @endif
    </div>
</div>
@endsection
