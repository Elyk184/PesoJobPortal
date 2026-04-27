@extends('layouts.admin')

@section('title', 'PESO Clearances | PESO Admin')

@section('admin-content')
@include('admin.layouts.topbar', ['title' => 'PESO Clearances', 'subtitle' => 'Manage PESO clearances', 'icon' => 'bi-clipboard'])

<div class="admin-dashboard">
    <style>
        .clearance-table { width: 100%; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); overflow: hidden; }
        .clearance-table table { width: 100%; border-collapse: collapse; }
        .clearance-table thead { background: #f3f4f6; border-bottom: 2px solid #e5e7eb; }
        .clearance-table th { padding: 1rem; text-align: left; font-weight: 700; color: #0d1f3c; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .clearance-table td { padding: 1rem; vertical-align: middle; font-size: 14px; border-bottom: 1px solid #f0f0f0; }
        .clearance-table tbody tr:hover { background: #f9fafb; }
        .status-badge { display: inline-block; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .status-issued { background: #d1fae5; color: #065f46; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-expired { background: #fee2e2; color: #991b1b; }
        .btn-small { padding: 0.5rem 1rem; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-block; }
        .btn-view { background: #3b82f6; color: white; }
        .btn-view:hover { background: #2563eb; }
    </style>

    <div class="clearance-table">
        <table>
            <thead>
                <tr>
                    <th>Clearance #</th>
                    <th>Name</th>
                    <th>Requested / Issued</th>
                    <th>Status</th>
                    <th>Actions</th>
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
                        <td><span class="status-badge {{ $statusClass }}"><i class="bi bi-check-circle me-1"></i>{{ $statusLabel }}</span></td>
                        <td>
                            @if ($clearance->status === 'pending')
                                <form method="POST" action="{{ route('admin.peso-clearances.issue', $clearance) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-small btn-view"><i class="bi bi-check2-circle me-1"></i>Issue</button>
                                </form>
                            @else
                                <button class="btn-small btn-view"><i class="bi bi-eye me-1"></i>View</button>
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

    @if (method_exists($clearances, 'links'))
        <div class="mt-3">
            {{ $clearances->links() }}
        </div>
    @endif
</div>

@endsection
