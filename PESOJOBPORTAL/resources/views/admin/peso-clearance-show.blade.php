@extends('layouts.admin-dashboard')

@section('title', 'PESO Clearance Request | Admin')

@section('content')
@php
    $status = strtolower($clearance->status ?? 'pending');
    $statusLabel = ucfirst($status);
    $statusClass = match ($status) {
        'pending' => 'bg-warning text-dark',
        'approved', 'active', 'issued' => 'bg-success',
        'rejected', 'declined' => 'bg-danger',
        default => 'bg-secondary',
    };
@endphp

<div class="admin-dashboard">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-lg-5">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <div class="text-uppercase text-muted small fw-semibold mb-1">PESO Clearance</div>
                    <h3 class="mb-2">Request Details</h3>
                    <div class="text-muted">Review the uploaded documents and issue the clearance from the same page.</div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <span class="badge {{ $statusClass }} px-3 py-2">{{ $statusLabel }}</span>
                    <span class="badge bg-light text-dark border px-3 py-2">Request #{{ $clearance->id }}</span>
                </div>
            </div>

            <div class="row g-4 align-items-start">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4">Request Details</h5>

                            <dl class="row mb-0 gy-2">
                                <dt class="col-sm-4 text-muted fw-normal">Requester</dt>
                                <dd class="col-sm-8 mb-0 fw-semibold">{{ $clearance->user?->name ?? 'Unknown' }}</dd>

                                <dt class="col-sm-4 text-muted fw-normal">Requested</dt>
                                <dd class="col-sm-8 mb-0">{{ $clearance->request_date ? $clearance->request_date->format('F d, Y h:i A') : 'N/A' }}</dd>

                                <dt class="col-sm-4 text-muted fw-normal">Status</dt>
                                <dd class="col-sm-8 mb-0"><span class="badge {{ $statusClass }}">{{ $statusLabel }}</span></dd>

                                @if($clearance->remarks)
                                    <dt class="col-sm-4 text-muted fw-normal">Remarks</dt>
                                    <dd class="col-sm-8 mb-0">{{ $clearance->remarks }}</dd>
                                @endif
                            </dl>

                            <div class="mt-4">
                                @if ($clearance->peso_clearance_assurance_receipt_path)
                                    <div class="mb-4 p-3 border rounded-3 bg-light">
                                        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                                            <strong>Assurance Receipt</strong>
                                            <a href="{{ asset('storage/' . $clearance->peso_clearance_assurance_receipt_path) }}" target="_blank" class="small text-decoration-none">Open in new tab</a>
                                        </div>
                                        @php
                                            $assuranceUrl = asset('storage/' . $clearance->peso_clearance_assurance_receipt_path);
                                            $assuranceExt = strtolower(pathinfo($clearance->peso_clearance_assurance_receipt_path, PATHINFO_EXTENSION));
                                        @endphp

                                        <div>
                                            @if(in_array($assuranceExt, ['jpg','jpeg','png','gif']))
                                                <a href="{{ $assuranceUrl }}" target="_blank" class="d-block text-center"><img src="{{ $assuranceUrl }}" alt="Assurance Receipt" class="img-fluid rounded-3 border bg-white" style="max-height:300px; object-fit:contain;"></a>
                                            @elseif($assuranceExt === 'pdf')
                                                <div class="border rounded-3 overflow-hidden bg-white"><iframe src="{{ $assuranceUrl }}" style="width:100%; height:320px;" frameborder="0"></iframe></div>
                                            @else
                                                <a href="{{ $assuranceUrl }}" target="_blank" class="btn btn-outline-secondary btn-sm">Open File</a>
                                            @endif
                                        </div>

                                        <a href="{{ $assuranceUrl }}" download class="small d-inline-block mt-3">Download file</a>
                                    </div>
                                @endif

                                @if ($clearance->barangay_clearance_path)
                                    <div class="mb-0 p-3 border rounded-3 bg-light">
                                        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                                            <strong>Barangay Clearance</strong>
                                            <a href="{{ asset('storage/' . $clearance->barangay_clearance_path) }}" target="_blank" class="small text-decoration-none">Open in new tab</a>
                                        </div>
                                        @php
                                            $barangayUrl = asset('storage/' . $clearance->barangay_clearance_path);
                                            $barangayExt = strtolower(pathinfo($clearance->barangay_clearance_path, PATHINFO_EXTENSION));
                                        @endphp

                                        <div>
                                            @if(in_array($barangayExt, ['jpg','jpeg','png','gif']))
                                                <a href="{{ $barangayUrl }}" target="_blank" class="d-block text-center"><img src="{{ $barangayUrl }}" alt="Barangay Clearance" class="img-fluid rounded-3 border bg-white" style="max-height:300px; object-fit:contain;"></a>
                                            @elseif($barangayExt === 'pdf')
                                                <div class="border rounded-3 overflow-hidden bg-white"><iframe src="{{ $barangayUrl }}" style="width:100%; height:320px;" frameborder="0"></iframe></div>
                                            @else
                                                <a href="{{ $barangayUrl }}" target="_blank" class="btn btn-outline-secondary btn-sm">Open File</a>
                                            @endif
                                        </div>

                                        <a href="{{ $barangayUrl }}" download class="small d-inline-block mt-3">Download file</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm position-sticky" style="top: 1rem;">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-2">Issue Clearance</h5>
                            <p class="text-muted small mb-4">Fill in the clearance details before issuing the document.</p>

                            <form method="POST" action="{{ route('admin.peso-clearances.issue', $clearance) }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Clearance Number</label>
                                    <input type="text" name="clearance_number" class="form-control" value="{{ old('clearance_number', $clearance->clearance_number ?? '') }}" placeholder="00000">
                                    @error('clearance_number')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Issue Date</label>
                                    <input type="datetime-local" name="issue_date" class="form-control" value="{{ old('issue_date') ?? (\Carbon\Carbon::now()->format('Y-m-d\\TH:i')) }}">
                                    @error('issue_date')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') ?? (\Carbon\Carbon::now()->addYear()->format('Y-m-d')) }}">
                                    @error('expiry_date')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <a href="{{ route('admin.peso-clearances') }}" class="btn btn-outline-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Issue Clearance</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
