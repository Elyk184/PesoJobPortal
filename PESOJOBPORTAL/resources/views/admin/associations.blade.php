@extends('layouts.admin-dashboard')

@section('title', 'Associations | PESO Admin')

<?php
    $pageTitle = 'Associations';
    $pageSubtitle = 'Review worker association registration requests';
    $pageIcon = 'bi-people-fill';

    $filters = [
        'all'       => 'All Requests',
        'submitted' => 'Submitted Requests',
        'accepted'  => 'Accepted Requests',
        'rejected'  => 'Rejected Requests',
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
                <a href="{{ route('admin.associations', ['filter' => $filterKey]) }}"
                   class="btn btn-sm {{ $filter === $filterKey ? 'btn-primary' : 'btn-outline-primary' }}">
                    {{ $filterLabel }}
                    <span class="badge {{ $filter === $filterKey ? 'text-bg-light text-primary' : 'text-bg-primary' }} ms-1">
                        {{ $stats[$filterKey] ?? 0 }}
                    </span>
                </a>
            @endforeach
        </div>

        @if($requests->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Submitted By</th>
                            <th>Association Name</th>
                            <th>Contact Person</th>
                            <th>Status</th>
                            <th>Submitted At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                            <tr>
                                <td>{{ $req->user?->name ?? 'Unknown User' }}</td>
                                <td>{{ $req->association_name }}</td>
                                <td>{{ $req->contact_person }}</td>
                                <td>
                                    <span class="badge {{ $req->status === 'accepted' ? 'text-bg-success' : ($req->status === 'rejected' ? 'text-bg-danger' : 'text-bg-warning text-dark') }}">
                                        {{ ucfirst($req->status ?? 'submitted') }}
                                    </span>
                                </td>
                                <td>{{ optional($req->created_at)->format('M d, Y h:i A') }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        @if($req->document_path)
                                            <a href="{{ asset('storage/' . $req->document_path) }}" target="_blank"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-file-earmark-text me-1"></i>View Doc
                                            </a>
                                        @endif

                                        @if($req->status !== 'accepted')
                                            <form method="POST" action="{{ route('admin.associations.accept', $req) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="bi bi-check2-circle me-1"></i>Accept
                                                </button>
                                            </form>
                                        @endif

                                        @if($req->status !== 'rejected')
                                            <form method="POST" action="{{ route('admin.associations.reject', $req) }}"
                                                  onsubmit="return confirm('Reject this association request?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-x-circle me-1"></i>Reject
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
                {{ $requests->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-info mb-0">No association registration requests yet.</div>
        @endif
    </div>
</div>
@endsection
