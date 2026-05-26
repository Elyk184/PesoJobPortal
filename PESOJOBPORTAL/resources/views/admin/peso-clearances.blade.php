@extends('layouts.admin-dashboard')

@section('title', 'PESO Clearances | PESO Admin')

<?php
    $pageTitle = 'PESO Clearances';
    $pageSubtitle = 'Generate and manage PESO clearance documents';
    $pageIcon = 'bi-file-pdf';
?>

@section('content')
<div style="padding: 2rem;">
    <!-- Card Section -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 2rem; margin-bottom: 2rem; border-left: 4px solid #3b82f6;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 style="margin: 0; font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">PESO Clearance Management</h2>
                <p style="margin: 0; color: #6b7280; font-size: 0.95rem;">Generate new clearances or view existing documents</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <form method="POST" action="{{ route('admin.peso-clearances.generate-document', $clearances->first()) }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);">
                        <i class="bi bi-lightning-charge"></i> Generate
                    </button>
                </form>
                <a href="{{ route('admin.peso-clearances.view-document', $clearances->first()) }}" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s; box-shadow: 0 2px 4px rgba(6, 182, 212, 0.3);">
                    <i class="bi bi-eye"></i> View Latest
                </a>
            </div>
        </div>
    </div>

    <!-- Requests Table -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
        <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <h3 style="margin: 0; font-size: 1.125rem; font-weight: 700; color: #1f2937;">Pending Requests</h3>
        </div>
    <div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
        <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <h3 style="margin: 0; font-size: 1.125rem; font-weight: 700; color: #1f2937;">Pending Requests</h3>
        </div>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                    <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: #374151; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">Applicant Name</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: #374151; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">Address</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: #374151; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">Date Requested</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: #374151; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clearances as $clearance)
                <tr style="border-bottom: 1px solid #e5e7eb; transition: background 0.2s; hover: {background: #f9fafb;}">
                    <td style="padding: 1.25rem 1.5rem; color: #374151; font-weight: 500;">{{ $clearance->user?->name ?? 'N/A' }}</td>
                    <td style="padding: 1.25rem 1.5rem; color: #6b7280;">{{ $clearance->user?->address ?? 'N/A' }}</td>
                    <td style="padding: 1.25rem 1.5rem; color: #6b7280;">{{ $clearance->created_at?->format('m/d/Y') ?? 'N/A' }}</td>
                    <td style="padding: 1.25rem 1.5rem; display: flex; gap: 0.75rem;">
                        <button onclick="issueRequest({{ $clearance->id }})" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 0.5rem 1rem; border: none; border-radius: 6px; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.3s; box-shadow: 0 1px 3px rgba(16, 185, 129, 0.2);">
                            ✓ Issue
                        </button>
                        <button onclick="declineRequest({{ $clearance->id }})" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 0.5rem 1rem; border: none; border-radius: 6px; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.3s; box-shadow: 0 1px 3px rgba(239, 68, 68, 0.2);">
                            ✕ Decline
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 2rem; text-align: center; color: #6b7280;">
                        <i class="bi bi-inbox" style="font-size: 2rem; margin-bottom: 0.5rem; display: block; color: #d1d5db;"></i>
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
