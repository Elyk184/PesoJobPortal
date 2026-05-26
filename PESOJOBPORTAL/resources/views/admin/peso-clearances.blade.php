@extends('layouts.admin-dashboard')

@section('title', 'PESO Clearances | PESO Admin')

<?php
    $pageTitle = 'PESO Clearances';
    $pageSubtitle = 'Generate and manage PESO clearance documents';
    $pageIcon = 'bi-file-pdf';
?>

@section('content')
<div style="padding: 2rem; display: flex; gap: 1rem; margin-bottom: 2rem;">
    <form method="POST" action="{{ route('admin.peso-clearances.generate-document', $clearances->first()) }}" style="display: inline;">
        @csrf
        <button type="submit" style="padding: 0.75rem 1.5rem; background: #10b981; color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">
            <i class="bi bi-lightning-charge"></i> Generate
        </button>
    </form>
    <a href="{{ route('admin.peso-clearances.view-document', $clearances->first()) }}" style="padding: 0.75rem 1.5rem; background: #06b6d4; color: white; text-decoration: none; border-radius: 8px; font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem;">
        <i class="bi bi-eye"></i> View
    </a>
</div>

<div style="padding: 0 2rem;">
    <h3 style="margin-bottom: 1rem; font-size: 1.25rem; font-weight: 700;">User Requests</h3>
    <div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f3f4f6; border-bottom: 1px solid #e5e7eb;">
                    <th style="padding: 1rem; text-align: left; font-weight: 700; color: #374151;">Applicant Name</th>
                    <th style="padding: 1rem; text-align: left; font-weight: 700; color: #374151;">Address</th>
                    <th style="padding: 1rem; text-align: left; font-weight: 700; color: #374151;">Date Requested</th>
                    <th style="padding: 1rem; text-align: left; font-weight: 700; color: #374151;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clearances as $clearance)
                <tr style="border-bottom: 1px solid #e5e7eb; transition: background 0.2s;">
                    <td style="padding: 1rem; color: #374151;">{{ $clearance->user?->name ?? 'N/A' }}</td>
                    <td style="padding: 1rem; color: #374151;">{{ $clearance->user?->address ?? 'N/A' }}</td>
                    <td style="padding: 1rem; color: #374151;">{{ $clearance->created_at?->format('m/d/Y') ?? 'N/A' }}</td>
                    <td style="padding: 1rem; display: flex; gap: 0.5rem;">
                        <button onclick="issueRequest({{ $clearance->id }})" style="background: #10b981; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: background 0.2s;">
                            Issue
                        </button>
                        <button onclick="declineRequest({{ $clearance->id }})" style="background: #ef4444; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: background 0.2s;">
                            Decline
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 2rem; text-align: center; color: #6b7280;">
                        No clearance requests found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function issueRequest(clearanceId) {
    if (confirm('Issue clearance for this request?')) {
        console.log('Issuing clearance:', clearanceId);
        alert('Clearance issued successfully!');
    }
}

function declineRequest(clearanceId) {
    if (confirm('Decline this clearance request?')) {
        console.log('Declining clearance:', clearanceId);
        alert('Clearance request declined!');
    }
}
</script>
@endsection
