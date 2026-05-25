@extends('layouts.admin-dashboard')

@section('title', 'PESO Clearances | PESO Admin')

<?php
    $pageTitle = 'PESO Clearances';
    $pageSubtitle = 'Generate and manage PESO clearance documents';
    $pageIcon = 'bi-file-pdf';
?>

@section('content')
<div style="padding: 2rem; display: flex; gap: 1rem;">
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
@endsection
