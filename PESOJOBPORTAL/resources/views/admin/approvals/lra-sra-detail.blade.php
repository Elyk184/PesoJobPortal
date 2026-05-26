@extends('layouts.admin-dashboard')

@section('title', strtoupper($activityRequest->activity_type) . ' Request - Review')

<?php
    $pageTitle = strtoupper($activityRequest->activity_type) . ' Request Review';
    $pageSubtitle = 'Review and ' . ($activityRequest->status === 'pending' ? 'approve or reject' : 'view') . ' the LRA/SRA request documents';
    $pageIcon = 'bi-clipboard-check';
?>

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-card">
        <div class="mb-4">
            <a href="{{ route('admin.lra-sra-approvals') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Back to Approvals
            </a>
        </div>

        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Request Overview -->
                <div class="card border-0 shadow-lg mb-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #f0f4ff 100%); overflow: hidden;">
                    <div style="position: absolute; top: 0; right: 0; width: 150px; height: 150px; background: linear-gradient(135deg, {{ $activityRequest->activity_type === 'lra' ? '#3b82f6' : '#ec4899' }} 0%, transparent 100%); opacity: 0.1; border-radius: 50%; transform: translate(50px, -50px);"></div>
                    <div class="card-body p-4" style="position: relative;">
                        <div class="row">
                            <div class="col-md-3">
                                <div style="padding: 1rem; background: white; border-radius: 0.75rem; border-left: 4px solid {{ $activityRequest->activity_type === 'lra' ? '#3b82f6' : '#ec4899' }};">
                                    <small class="text-muted d-block mb-2" style="font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;"><i class="bi bi-tag me-1"></i>Activity Type</small>
                                    <span class="badge" style="background: linear-gradient(135deg, {{ $activityRequest->activity_type === 'lra' ? '#3b82f6' : '#ec4899' }} 0%, {{ $activityRequest->activity_type === 'lra' ? '#2563eb' : '#db2777' }} 100%); padding: 0.5rem 0.75rem; font-size: 0.9rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                        <i class="bi bi-file-earmark me-1"></i>{{ strtoupper($activityRequest->activity_type) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div style="padding: 1rem; background: white; border-radius: 0.75rem; border-left: 4px solid #10b981;">
                                    <small class="text-muted d-block mb-2" style="font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;"><i class="bi bi-building me-1"></i>Employer</small>
                                    <strong style="color: #1f2937; font-size: 0.95rem;">{{ $activityRequest->employer?->name ?? 'N/A' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div style="padding: 1rem; background: white; border-radius: 0.75rem; border-left: 4px solid #f59e0b;">
                                    <small class="text-muted d-block mb-2" style="font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;"><i class="bi bi-calendar me-1"></i>Submitted</small>
                                    <strong style="color: #1f2937; font-size: 0.95rem;">{{ $activityRequest->created_at->format('M d, Y') }}</strong>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div style="padding: 1rem; background: white; border-radius: 0.75rem; border-left: 4px solid @if($activityRequest->status === 'pending')#f59e0b@elseif($activityRequest->status === 'approved')#10b981@else#ef4444@endif;">
                                    <small class="text-muted d-block mb-2" style="font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;"><i class="bi bi-info-circle me-1"></i>Status</small>
                                    <span class="badge" style="background: linear-gradient(135deg, @if($activityRequest->status === 'pending')#f59e0b 0%, #f97316 100%@elseif($activityRequest->status === 'approved')#10b981 0%, #059669 100%@else#ef4444 0%, #dc2626 100%@endif); padding: 0.5rem 0.75rem; font-size: 0.9rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                        {{ ucfirst($activityRequest->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents -->
                <div class="card border-0 shadow-lg mb-4" style="border-top: 4px solid #ef4444;">
                    <div class="card-header bg-light border-0 py-3" style="background: linear-gradient(135deg, #fef2f2 0%, #ffe4e6 100%); border-bottom: 2px solid #fee2e2;">
                        <h5 class="mb-0"><i class="bi bi-file-earmark-pdf me-2" style="color: #ef4444;"></i><span style="color: #991b1b;">Documents</span></h5>
                    </div>
                    <div class="card-body" style="padding: 0;">
                        <div class="row g-0">
                            <div class="col-lg-3 col-md-6">
                                <div class="border rounded p-4 text-center h-100 transition-all" style="background: linear-gradient(135deg, #fef2f2 0%, #fffbfa 100%); border: 2px solid #fee2e2; cursor: pointer; transition: all 0.3s ease; position: relative; overflow: hidden;">
                                    <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: linear-gradient(135deg, #ef4444 0%, transparent 100%); opacity: 0.05; border-radius: 50%; transform: translate(30px, -30px);"></div>
                                    <i class="bi bi-file-pdf" style="font-size: 3rem; color: #ef4444; position: relative; z-index: 1;"></i>
                                    <p class="mt-3 mb-2 small"><strong style="color: #1f2937;">Letter of Intent</strong></p>
                                    @if($activityRequest->letter_of_intent_path)
                                        <a href="{{ asset('storage/' . $activityRequest->letter_of_intent_path) }}"
                                           class="btn btn-sm mt-2" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none;" target="_blank">
                                            <i class="bi bi-download me-1"></i>Download
                                        </a>
                                    @else
                                        <small class="text-muted d-block mt-2" style="font-style: italic;">Not provided</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- SRA Specific Documents -->
            @if($activityRequest->activity_type === 'sra')
            <div class="card border-0 shadow-lg mb-4" style="border-top: 4px solid #8b5cf6;">
                <div class="card-header bg-light border-0 py-3" style="background: linear-gradient(135deg, #f3e8ff 0%, #ede9fe 100%); border-bottom: 2px solid #e9d5ff;">
                    <h5 class="mb-0"><i class="bi bi-file-earmark me-2" style="color: #8b5cf6;"></i><span style="color: #6d28d9;">SRA Specific Documents</span></h5>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="row g-0">
                        @php $sraDocuments = [
                            ['name' => 'DMW Certificate', 'field' => 'dmw_certificate_path', 'icon' => 'bi-file-pdf'],
                            ['name' => 'Recruitment Officer ID', 'field' => 'recruitment_officer_id_path', 'icon' => 'bi-file-pdf'],
                            ['name' => 'Job Order Balance', 'field' => 'job_order_balance_path', 'icon' => 'bi-file-pdf'],
                            ['name' => 'Deployment Report', 'field' => 'deployment_report_path', 'icon' => 'bi-file-pdf'],
                            ['name' => 'Affidavit of Undertaking', 'field' => 'affidavit_undertaking_path', 'icon' => 'bi-file-pdf'],
                            ['name' => 'SRA Authority', 'field' => 'sra_authority_file_path', 'icon' => 'bi-file-pdf'],
                        ]; @endphp

                        @foreach($sraDocuments as $doc)
                        <div class="col-lg-3 col-md-6">
                            <div class="border rounded p-4 text-center h-100" style="background: linear-gradient(135deg, #f3e8ff 0%, #faf5ff 100%); border: 2px solid #e9d5ff; transition: all 0.3s ease; position: relative; overflow: hidden;">
                                <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: linear-gradient(135deg, #8b5cf6 0%, transparent 100%); opacity: 0.05; border-radius: 50%; transform: translate(30px, -30px);"></div>
                                <i class="bi {{ $doc['icon'] }}" style="font-size: 2.5rem; color: #8b5cf6; position: relative; z-index: 1;"></i>
                                <p class="mt-2 mb-2 small"><strong style="color: #1f2937;">{{ $doc['name'] }}</strong></p>
                                @if($activityRequest->{$doc['field']})
                                    <a href="{{ asset('storage/' . $activityRequest->{$doc['field']}) }}"
                                       class="btn btn-sm mt-2" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; border: none;" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                @else
                                    <small class="text-muted d-block mt-2" style="font-style: italic;">Not provided</small>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- LRA Specific Documents -->
            @if($activityRequest->activity_type === 'lra')
            <div class="card border-0 shadow-lg mb-4" style="border-top: 4px solid #06b6d4;">
                <div class="card-header bg-light border-0 py-3" style="background: linear-gradient(135deg, #ecfdf5 0%, #f0fdfa 100%); border-bottom: 2px solid #ccfbf1;">
                    <h5 class="mb-0"><i class="bi bi-file-earmark me-2" style="color: #06b6d4;"></i><span style="color: #0369a1;">LRA Specific Documents</span></h5>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="row g-0">
                        <div class="col-lg-3 col-md-6">
                            <div class="border rounded p-4 text-center h-100" style="background: linear-gradient(135deg, #ecfdf5 0%, #f0fdfa 100%); border: 2px solid #ccfbf1; position: relative; overflow: hidden;">
                                <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: linear-gradient(135deg, #06b6d4 0%, transparent 100%); opacity: 0.05; border-radius: 50%; transform: translate(30px, -30px);"></div>
                                <i class="bi bi-file-pdf" style="font-size: 2.5rem; color: #06b6d4; position: relative; z-index: 1;"></i>
                                <p class="mt-2 mb-2 small"><strong style="color: #1f2937;">Business Permit</strong></p>
                                @if($activityRequest->business_permit_path)
                                    <a href="{{ asset('storage/' . $activityRequest->business_permit_path) }}"
                                       class="btn btn-sm mt-2" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; border: none;" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                @else
                                    <small class="text-muted d-block mt-2" style="font-style: italic;">Not provided</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="border rounded p-4 text-center h-100" style="background: linear-gradient(135deg, #ecfdf5 0%, #f0fdfa 100%); border: 2px solid #ccfbf1; position: relative; overflow: hidden;">
                                <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: linear-gradient(135deg, #06b6d4 0%, transparent 100%); opacity: 0.05; border-radius: 50%; transform: translate(30px, -30px);"></div>
                                <i class="bi bi-file-pdf" style="font-size: 2.5rem; color: #06b6d4; position: relative; z-index: 1;"></i>
                                <p class="mt-2 mb-2 small"><strong style="color: #1f2937;">Recruitment Officer ID</strong></p>
                                @if($activityRequest->lra_recruitment_officer_id_path)
                                    <a href="{{ asset('storage/' . $activityRequest->lra_recruitment_officer_id_path) }}"
                                       class="btn btn-sm mt-2" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; border: none;" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                @else
                                    <small class="text-muted d-block mt-2" style="font-style: italic;">Not provided</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Vacancies Section -->
            <div class="card border-0 shadow-lg mb-4" style="border-top: 4px solid #3b82f6;">
                <div class="card-header bg-light border-0 py-3" style="background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border-bottom: 2px solid #bfdbfe;">
                    <h5 class="mb-0"><i class="bi bi-briefcase me-2" style="color: #3b82f6;"></i><span style="color: #1e40af;">Job Vacancies</span></h5>
                </div>
                <div class="card-body" style="padding: 0;">
                    @if($activityRequest->job_vacancies_path && $activityRequest->job_vacancies_text)
                        <div class="row g-0">
                            <div class="col-md-6">
                                <div class="border rounded p-4 text-center h-100" style="background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border: 2px solid #bfdbfe; position: relative; overflow: hidden;">
                                    <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: linear-gradient(135deg, #3b82f6 0%, transparent 100%); opacity: 0.05; border-radius: 50%; transform: translate(30px, -30px);"></div>
                                    <i class="bi bi-file-pdf" style="font-size: 2.5rem; color: #3b82f6; position: relative; z-index: 1;"></i>
                                    <p class="mt-2 mb-2 small"><strong style="color: #1f2937;">Job Vacancies File</strong></p>
                                    <a href="{{ asset('storage/' . $activityRequest->job_vacancies_path) }}"
                                       class="btn btn-sm mt-2" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none;" target="_blank">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-4" style="background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border: 2px solid #bfdbfe; position: relative; overflow: hidden;">
                                    <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: linear-gradient(135deg, #3b82f6 0%, transparent 100%); opacity: 0.05; border-radius: 50%; transform: translate(30px, -30px);"></div>
                                    <h6 style="color: #1e40af; margin-bottom: 0.75rem; position: relative; z-index: 1;"><i class="bi bi-chat-left-text me-2"></i>Job Vacancies Details</h6>
                                    <div style="background: white; padding: 1rem; border-radius: 0.5rem; max-height: 250px; overflow-y: auto; font-size: 0.9rem; color: #1f2937; white-space: pre-wrap; word-break: break-word; border: 1px solid #dbeafe;">
                                        {{ $activityRequest->job_vacancies_text }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($activityRequest->job_vacancies_path)
                        <div class="border rounded p-4 text-center" style="background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border: 2px solid #bfdbfe; position: relative; overflow: hidden;">
                            <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: linear-gradient(135deg, #3b82f6 0%, transparent 100%); opacity: 0.05; border-radius: 50%; transform: translate(30px, -30px);"></div>
                            <i class="bi bi-file-pdf" style="font-size: 2.5rem; color: #3b82f6; position: relative; z-index: 1;"></i>
                            <p class="mt-2 mb-2 small"><strong style="color: #1f2937;">Job Vacancies File</strong></p>
                            <a href="{{ asset('storage/' . $activityRequest->job_vacancies_path) }}"
                               class="btn btn-sm mt-2" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none;" target="_blank">
                                <i class="bi bi-download me-1"></i>Download
                            </a>
                        </div>
                    @elseif($activityRequest->job_vacancies_text)
                        <div class="border rounded p-4" style="background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border: 2px solid #bfdbfe; position: relative; overflow: hidden;">
                            <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: linear-gradient(135deg, #3b82f6 0%, transparent 100%); opacity: 0.05; border-radius: 50%; transform: translate(30px, -30px);"></div>
                            <h6 style="color: #1e40af; margin-bottom: 0.75rem; position: relative; z-index: 1;"><i class="bi bi-chat-left-text me-2"></i>Job Vacancies Details</h6>
                            <div style="background: white; padding: 1rem; border-radius: 0.5rem; max-height: 350px; overflow-y: auto; font-size: 0.9rem; color: #1f2937; white-space: pre-wrap; word-break: break-word; border: 1px solid #dbeafe;">
                                {{ $activityRequest->job_vacancies_text }}
                            </div>
                        </div>
                    @else
                        <div style="padding: 2rem; text-align: center; background: #f9fafb; border-radius: 0.5rem;">
                            <i class="bi bi-inbox" style="font-size: 2rem; color: #d1d5db;"></i>
                            <p class="mt-2 text-muted">Not provided</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif
            @endif

            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-3">
            @if($activityRequest->status === 'pending')
                <!-- Request Summary Card -->
                <div class="card border-0 shadow-sm mb-3" style="background: linear-gradient(135deg, #f0f4ff 0%, #f9f5ff 100%); border-left: 4px solid #6366f1;">
                    <div class="card-body p-3">
                        <div class="text-center pb-2 border-bottom border-opacity-25">
                            <div style="font-size: 0.7rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 0.5rem;">Request Type</div>
                            <div class="badge" style="font-size: 0.85rem; padding: 0.4rem 0.8rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);">
                                <i class="bi bi-file-earmark me-1"></i>{{ strtoupper($activityRequest->activity_type) }}
                            </div>
                        </div>
                        <div class="mt-2" style="font-size: 0.85rem;">
                            <div class="mb-2 pb-2 border-bottom border-opacity-25">
                                <p style="font-size: 0.7rem; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 0.3rem;"><i class="bi bi-building me-1"></i>Submitted by</p>
                                <p class="mb-0" style="font-size: 0.9rem; font-weight: 600; color: #1f2937;">{{ $activityRequest->employer?->name }}</p>
                            </div>
                            <div>
                                <p style="font-size: 0.7rem; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 0.3rem;"><i class="bi bi-calendar me-1"></i>Submitted on</p>
                                <p class="mb-0" style="font-size: 0.9rem; color: #374151;">{{ optional($activityRequest->created_at)->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Certification Card -->
                <div class="card border-0 shadow-lg mb-3" style="background: linear-gradient(135deg, #f0fdf4 0%, #f0fdf4 100%); border-left: 4px solid #10b981; border-top: 2px solid #10b981;">
                    <div class="card-header border-0 py-2 px-3 border-bottom border-success border-opacity-25" style="background: transparent;">
                        <h6 class="mb-0" style="font-weight: 700; color: #065f46; letter-spacing: 0.3px; font-size: 0.9rem;"><i class="bi bi-certificate me-2"></i>CERTIFICATION</h6>
                    </div>
                    <div class="card-body p-3">
                        @if($activityRequest->certification_path)
                            <!-- Certification Generated -->
                            <div style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 1px solid #bbf7d0; border-radius: 0.5rem; padding: 0.75rem; margin-bottom: 0.75rem;">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-check-circle-fill me-2" style="color: #059669; font-size: 1rem;"></i>
                                    <span style="font-weight: 600; color: #065f46; font-size: 0.85rem;">Certification Generated</span>
                                </div>
                                <div style="font-size: 0.75rem; color: #047857; margin-left: 1.5rem;">
                                    <p style="margin-bottom: 0.3rem;"><strong>Generated:</strong> {{ \Carbon\Carbon::parse($activityRequest->certification_generated_at)->format('M d, Y H:i') }}</p>
                                    <p style="margin-bottom: 0;"><strong>By:</strong> {{ $activityRequest->certificationGeneratedBy?->name ?? 'System' }}</p>
                                </div>
                                <div class="d-grid gap-2" style="margin-top: 0.75rem;">
                                    <a href="{{ route('admin.lra-sra.view-certification', $activityRequest) }}" target="_blank"
                                       class="btn btn-sm" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; border: none; font-weight: 600; font-size: 0.8rem;">
                                        <i class="bi bi-eye me-1"></i>View
                                    </a>
                                    <form method="POST" action="{{ route('admin.lra-sra.generate-certification', $activityRequest) }}" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm w-100" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none; font-weight: 600; font-size: 0.8rem;">
                                            <i class="bi bi-arrow-repeat me-1"></i>Regenerate
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Generate Certification -->
                            <div style="background: #fef3c7; border: 1px solid #fcd34d; border-radius: 0.5rem; padding: 0.75rem; margin-bottom: 0.75rem;">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-exclamation-circle-fill me-2" style="color: #b45309; font-size: 1rem;"></i>
                                    <span style="font-weight: 600; color: #92400e; font-size: 0.85rem;">Certification Pending</span>
                                </div>
                                <p style="font-size: 0.75rem; color: #78350f; margin-left: 1.5rem; margin-bottom: 0.5rem;">Generate a certification document before approving this request.</p>
                                <form method="POST" action="{{ route('admin.lra-sra.generate-certification', $activityRequest) }}" class="d-grid">
                                    @csrf
                                    <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none; font-weight: 600; font-size: 0.8rem;">
                                        <i class="bi bi-file-earmark-pdf me-1"></i>Generate Certification
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Card -->
                <div class="card border-0 shadow-lg sticky-top" style="top: 20px; background: linear-gradient(135deg, #fff7ed 0%, #fef3c7 100%); border-left: 4px solid #f59e0b; border-top: 2px solid #f59e0b;">
                    <div class="card-header border-0 py-2 px-3 border-bottom border-warning border-opacity-25" style="background: transparent;">
                        <h6 class="mb-0" style="font-weight: 700; color: #92400e; letter-spacing: 0.3px; font-size: 0.9rem;"><i class="bi bi-shield-check me-2"></i>REVIEW</h6>
                    </div>
                    <div class="card-body p-3">
                        <div style="background-color: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 0.35rem; padding: 0.5rem; margin-bottom: 0.75rem;" role="alert">
                            <small style="color: #1e40af; font-weight: 500; font-size: 0.75rem;"><i class="bi bi-info-circle me-1"></i>Generate certification first, then approve.</small>
                        </div>
                        <form method="POST" class="d-grid gap-2">
                            @csrf
                            <button type="submit" formaction="{{ route('admin.lra-sra.approve', $activityRequest) }}"
                                    class="btn btn-sm" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; font-weight: 600; padding: 0.5rem 0.75rem; font-size: 0.85rem;" {{ !$activityRequest->certification_path ? 'disabled' : '' }}>
                                <i class="bi bi-check-circle me-1"></i>Approve
                            </button>
                            <button type="button" class="btn btn-sm" style="background: white; color: #dc2626; border: 2px solid #fca5a5; font-weight: 600; padding: 0.5rem 0.75rem; font-size: 0.85rem;" data-bs-toggle="modal"
                                    data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle me-1"></i>Reject
                            </button>
                        </form>
                        <div style="margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid rgba(0,0,0,0.05);">
                            <p style="font-size: 0.7rem; color: #6b7280; text-align: center; margin-bottom: 0;"><i class="bi bi-exclamation-triangle me-1" style="color: #f59e0b;"></i><strong style="color: #f59e0b;">PENDING</strong></p>
                        </div>
                    </div>
                </div>

                <!-- Status Info Card -->
                <div class="card border-0 shadow-sm" style="overflow: hidden;">
                    <div class="card-header border-0 py-2 px-3 border-bottom" style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);">
                        <h6 class="mb-0" style="font-weight: 700; color: #374151; letter-spacing: 0.3px; font-size: 0.9rem;"><i class="bi bi-info-circle me-2"></i>COMPANY</h6>
                    </div>
                    <div class="card-body p-3 small">
                        <div class="mb-3">
                            <p class="text-muted mb-1" style="font-size: 0.7rem;"><i class="bi bi-globe me-1"></i>BUSINESS</p>
                            <p class="mb-0" style="font-weight: 600;">{{ $activityRequest->employer->profile?->line_of_business ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="text-muted mb-1" style="font-size: 0.7rem;"><i class="bi bi-people me-1"></i>WORKFORCE</p>
                            <p class="mb-0" style="font-weight: 600;">{{ $activityRequest->employer->profile?->workforce_size ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.7rem;"><i class="bi bi-telephone me-1"></i>CONTACT</p>
                            <p class="mb-0" style="font-weight: 600; word-break: break-word;">{{ $activityRequest->employer->profile?->establishment_phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Request Summary Card -->
                <div class="card border-0 shadow-sm mb-3" style="background: linear-gradient(135deg, #f0f4ff 0%, #f9f5ff 100%); border-left: 4px solid #6366f1;">
                    <div class="card-body p-3">
                        <div class="text-center pb-2 border-bottom border-opacity-25">
                            <div style="font-size: 0.7rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 0.5rem;">Request Type</div>
                            <div class="badge" style="font-size: 0.85rem; padding: 0.4rem 0.8rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);">
                                <i class="bi bi-file-earmark me-1"></i>{{ strtoupper($activityRequest->activity_type) }}
                            </div>
                        </div>
                        <div class="mt-2" style="font-size: 0.85rem;">
                            <div class="mb-2 pb-2 border-bottom border-opacity-25">
                                <p style="font-size: 0.7rem; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 0.3rem;"><i class="bi bi-building me-1"></i>Submitted by</p>
                                <p class="mb-0" style="font-size: 0.9rem; font-weight: 600; color: #1f2937;">{{ $activityRequest->employer?->name }}</p>
                            </div>
                            <div>
                                <p style="font-size: 0.7rem; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 0.3rem;"><i class="bi bi-calendar me-1"></i>Submitted on</p>
                                <p class="mb-0" style="font-size: 0.9rem; color: #374151;">{{ optional($activityRequest->created_at)->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Info Card -->
                <div class="card border-0 shadow-sm" style="overflow: hidden;">
                    <div class="card-header border-0 py-2 px-3 border-bottom" style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);">
                        <h6 class="mb-0" style="font-weight: 700; color: #374151; letter-spacing: 0.3px; font-size: 0.9rem;"><i class="bi bi-info-circle me-2"></i>STATUS</h6>
                    </div>
                    <div class="card-body p-0">
                        @if($activityRequest->status === 'approved')
                            <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-left: 4px solid #10b981; padding: 0.75rem;">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill me-2" style="font-size: 1.2rem; color: #059669; flex-shrink: 0;"></i>
                                    <div style="flex: 1; min-width: 0;">
                                        <p style="font-weight: 700; color: #065f46; font-size: 0.9rem; margin-bottom: 0.5rem;">Approved</p>
                                        <div style="background: white; border-radius: 0.3rem; padding: 0.5rem; font-size: 0.75rem; color: #374151;">
                                            <div style="display: grid; grid-template-columns: auto 1fr; gap: 0.25rem 0.5rem; word-break: break-word;">
                                                <span style="font-weight: 600; color: #059669;"><i class="bi bi-calendar-event" style="font-size: 0.7rem;"></i></span>
                                                <span>{{ optional($activityRequest->approved_at)->format('M d, Y') }}</span>
                                                <span style="font-weight: 600; color: #059669;"><i class="bi bi-person-check" style="font-size: 0.7rem;"></i></span>
                                                <span style="word-break: break-word;">{{ $activityRequest->approvedBy?->name ?? 'System' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($activityRequest->status === 'rejected')
                            <div style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border-left: 4px solid #ef4444; padding: 0.75rem;">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-x-circle-fill me-2" style="font-size: 1.2rem; color: #dc2626; flex-shrink: 0;"></i>
                                    <div style="flex: 1; min-width: 0;">
                                        <p style="font-weight: 700; color: #7f1d1d; font-size: 0.9rem; margin-bottom: 0.5rem;">Rejected</p>
                                        <div style="background: white; border-radius: 0.3rem; padding: 0.5rem; font-size: 0.75rem; color: #374151;">
                                            <p style="font-weight: 600; color: #dc2626; margin-bottom: 0.3rem;"><i class="bi bi-exclamation-circle" style="font-size: 0.7rem;"></i> Reason:</p>
                                            <p style="margin-bottom: 0; color: #7f1d1d; font-style: italic; word-break: break-word; line-height: 1.3;">{{ $activityRequest->notes ?? 'No reason provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
</div>

<!-- Rejection Modal -->
@if($activityRequest->status === 'pending')
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.lra-sra.reject', $activityRequest) }}">
                    @csrf
                    <div class="modal-body">
                        <small class="text-muted">{{ strtoupper($activityRequest->activity_type) }} - {{ $activityRequest->employer?->name }}</small>
                        <div class="mb-0 mt-3">
                            <label for="rejection_notes" class="form-label">Reason <span class="text-danger">*</span></label>
                            <textarea id="rejection_notes" name="notes" class="form-control" rows="4"
                                      placeholder="Explain why..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@endsection
