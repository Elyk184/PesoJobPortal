@extends('layouts.dashboard')

@section('title', 'Association | Submitted Requests')

@section('dashboard-mobile-brand')
    <div class="dashboard-mobile-brand">
        <img src="{{ asset('images/logo.png') }}" alt="PESO Logo">
        <span>Association Portal</span>
    </div>
@endsection

@section('dashboard-sidebar')
    @include('dashboard.partials.association-nav')
@endsection

@section('content')
    <section aria-label="Submitted requests">
        <div class="dashboard-topbar">
            <div>
                <div class="dashboard-topbar-title">Submitted Requests</div>
                <div class="dashboard-topbar-subtitle">All your association requests and their current status</div>
            </div>
        </div>

        <div class="dashboard-section-card p-3 p-lg-4">
            @if($submittedRequests->isEmpty())
                <p class="text-muted mb-0">No requests submitted yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Subject</th>
                                <th>Association</th>
                                <th>Type</th>
                                <th>Contact Person</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submittedRequests as $req)
                                <tr>
                                    <td>{{ $req->subject }}</td>
                                    <td>{{ $req->association_name }}</td>
                                    <td>{{ $req->request_type }}</td>
                                    <td>{{ $req->contact_person }}</td>
                                    <td>
                                        <span class="badge text-bg-{{ match($req->status) { 'submitted' => 'warning', 'accepted' => 'success', 'rejected' => 'danger', 'open' => 'primary', 'under_review' => 'warning', 'resolved' => 'success', default => 'secondary' } }}">
                                            {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $req->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>
@endsection
