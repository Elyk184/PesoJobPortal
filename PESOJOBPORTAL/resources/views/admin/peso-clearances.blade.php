@extends('layouts.admin-dashboard')

@section('title', 'PESO Clearances | PESO Admin')

<?php
    $pageTitle = 'PESO Clearances';
    $pageSubtitle = 'Generate and manage PESO clearance documents';
    $pageIcon = 'bi-file-pdf';
?>

@section('content')
<div class="admin-dashboard">
    <style>
        .clearance-shell { display: grid; gap: 1rem; }
        .clearance-summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; }
        .clearance-stat { background: white; border-radius: 16px; padding: 1.15rem; box-shadow: 0 6px 18px rgba(13,31,60,0.06); border: 1px solid #e7edf5; }
        .clearance-stat-label { font-size: 12px; text-transform: uppercase; letter-spacing: 0.6px; color: #6b7280; font-weight: 700; margin-bottom: 0.35rem; }
        .clearance-stat-value { font-size: 2rem; font-weight: 800; color: #0d1f3c; line-height: 1; }
        .clearance-stat-note { font-size: 13px; color: #6b7280; margin-top: 0.4rem; }
        .clearance-table { width: 100%; background: white; border-radius: 18px; box-shadow: 0 6px 18px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e7edf5; }
        .clearance-table-head { padding: 1.1rem 1.25rem; border-bottom: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
        .clearance-table-head h3 { margin: 0; font-size: 1rem; font-weight: 800; color: #0d1f3c; }
        .clearance-table-head p { margin: 0; color: #6b7280; font-size: 0.9rem; }
        .clearance-table-wrap { overflow-x: auto; }
        .clearance-table table { width: 100%; border-collapse: collapse; }
        .clearance-table thead { background: #f8fafc; border-bottom: 2px solid #e5e7eb; }
        .clearance-table th { padding: 1rem 1.1rem; text-align: left; font-weight: 800; color: #0d1f3c; font-size: 12px; text-transform: uppercase; letter-spacing: 0.6px; white-space: nowrap; }
        .clearance-table td { padding: 1rem 1.1rem; vertical-align: middle; font-size: 14px; border-bottom: 1px solid #f0f4f8; }
        .clearance-table tbody tr:hover { background: #f9fbff; }
        .status-badge { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.5rem 0.8rem; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .status-issued { background: #d1fae5; color: #065f46; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-expired { background: #fee2e2; color: #991b1b; }
        .btn-small { padding: 0.55rem 0.9rem; border: none; border-radius: 999px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; }
        .btn-view { background: #3b82f6; color: white; }
        .btn-view:hover { background: #2563eb; }
        .clearance-empty { background: #fff; border: 1px dashed #dbe4ee; border-radius: 14px; padding: 2rem; text-align: center; color: #64748b; }
    </style>

    <div class="clearance-shell">
        <!-- Auto-generation Section -->
        <div style="background: white; border-radius: 18px; padding: 1.5rem; box-shadow: 0 6px 18px rgba(13,31,60,0.06); border: 1px solid #e7edf5; border-left: 5px solid #3b82f6;">
            <div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <div>
                    <h4 style="margin: 0 0 0.5rem 0; color: #0d1f3c; font-weight: 800;">Auto-Generate PESO Clearances</h4>
                    <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">Automatically create pending clearances for jobseekers who don't have one yet.</p>
                </div>
                <form method="POST" action="{{ route('admin.peso-clearances.auto-generate') }}" style="display: flex; gap: 0.5rem;">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm" style="padding: 0.55rem 1.2rem; border-radius: 999px; font-weight: 700;">
                        <i class="bi bi-lightning-charge"></i> Generate For All Jobseekers
                    </button>
                </form>
            </div>
        </div>

        <div class="clearance-summary">
            <div class="clearance-stat">
                <div class="clearance-stat-label">Pending</div>
                <div class="clearance-stat-value">{{ $clearances->where('status', 'pending')->count() }}</div>
                <div class="clearance-stat-note">Requests waiting for admin issuance</div>
            </div>
            <div class="clearance-stat">
                <div class="clearance-stat-label">Issued</div>
                <div class="clearance-stat-value">{{ $clearances->where('status', 'active')->count() }}</div>
                <div class="clearance-stat-note">Active clearances on record</div>
            </div>
            <div class="clearance-stat">
                <div class="clearance-stat-label">Expired</div>
                <div class="clearance-stat-value">{{ $clearances->where('status', 'expired')->count() }}</div>
                <div class="clearance-stat-note">Renewal or reissue may be needed</div>
            </div>
        </div>

        <div class="clearance-table">
            <div class="clearance-table-head">
                <div>
                    <h3>PESO Clearance Queue</h3>
                    <p>Review pending requests and issue clearance documents from this list.</p>
                </div>
                <span class="badge text-bg-warning rounded-pill px-3 py-2">{{ $clearances->where('status', 'pending')->count() }} pending</span>
            </div>

            <div class="clearance-table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Clearance #</th>
                            <th>Name</th>
                            <th>Requested / Issued</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clearances as $clearance)
                            @php
                                $status = $clearance->status ?? 'pending';
                                $statusClass = $status === 'pending' ? 'status-pending' : ($status === 'expired' ? 'status-expired' : 'status-issued');
                                $statusLabel = ucfirst($status);
                            @endphp
                            <tr>
                                <td><strong>{{ $clearance->clearance_number }}</strong></td>
                                <td>{{ $clearance->user?->name ?? 'Unknown' }}</td>
                                <td>
                                    @if ($clearance->status === 'pending')
                                        {{ $clearance->request_date ? $clearance->request_date->format('d M Y') : 'N/A' }}
                                    @else
                                        {{ $clearance->issue_date ? $clearance->issue_date->format('d M Y') : 'N/A' }}
                                    @endif
                                </td>
                                <td><span class="status-badge {{ $statusClass }}"><i class="bi bi-dot me-1"></i>{{ $statusLabel }}</span></td>
                                <td class="text-end">
                                    @if ($clearance->status === 'pending')
                                        <form method="POST" action="{{ route('admin.peso-clearances.issue', $clearance) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-small btn-view"><i class="bi bi-check2-circle"></i>Issue</button>
                                        </form>
                                    @else
                                        <button class="btn-small btn-view"><i class="bi bi-eye"></i>View</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No PESO clearances found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @if (method_exists($clearances, 'links'))
        <div class="mt-3">
            {{ $clearances->links() }}
        </div>
    @endif
</div>

@endsection
