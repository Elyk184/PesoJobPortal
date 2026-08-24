<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\OfwController;
use App\Http\Controllers\JobseekerApprovalController;
use App\Http\Controllers\JobseekerController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('home');

Route::view('/history', 'history')->name('history');
Route::view('/history-of-excellence', 'history-excellence')->name('history-of-excellence');
Route::view('/objectives', 'objective')->name('objectives');
Route::view('/legal-mandate', 'legal-mandate')->name('legal-mandate');
Route::view('/structure', 'structure')->name('structure');
Route::view('/privacy-policy', 'privacy-policy')->name('privacy-policy');
Route::view('/terms-of-service', 'terms-of-service')->name('terms-of-service');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Jobseeker routes (protected)
Route::middleware(['auth', 'role:jobseeker'])->prefix('jobseeker')->name('jobseeker.')->group(function () {
    Route::get('/dashboard', [JobseekerController::class, 'dashboard'])->name('dashboard');
    Route::get('/browse-jobs', [JobseekerController::class, 'browseJobs'])->name('browse-jobs');
    Route::get('/vacancies', [JobseekerController::class, 'vacancies'])->name('vacancies');
    Route::get('/recommendations', [JobseekerController::class, 'recommendations'])->name('recommendations');
    Route::get('/applications', [JobseekerController::class, 'applications'])->name('applications');
    Route::get('/notifications', [JobseekerController::class, 'notifications'])->name('notifications');
    Route::get('/notifications/feed', [JobseekerController::class, 'notificationsFeed'])->name('notifications.feed');
    Route::post('/notifications/{userNotification}/read', [JobseekerController::class, 'markNotificationAsRead'])->name('notifications.read');

    Route::get('/apply/{job}', [JobseekerController::class, 'applyJob'])->name('apply-job');
    Route::post('/apply/{job}', [JobseekerController::class, 'submitApplication'])->name('submit-application');
    Route::get('/application/{application}/details', [JobseekerController::class, 'viewApplicationDetails'])->name('application.details');

    Route::get('/profile', [JobseekerController::class, 'profile'])->name('profile');
    Route::post('/profile', [JobseekerController::class, 'saveProfile'])->name('profile.save');

    Route::get('/skill-gap', [JobseekerController::class, 'skillGap'])->name('skill-gap');

    Route::get('/saved-jobs', [JobseekerController::class, 'savedJobs'])->name('saved-jobs');
    Route::post('/saved-jobs/{job}', [JobseekerController::class, 'toggleSaveJob'])->name('saved-jobs.toggle');

    Route::get('/peso-clearance', [JobseekerController::class, 'pesoClearance'])->name('peso-clearance');
    Route::post('/peso-clearance/request', [JobseekerController::class, 'requestPesoClearance'])->name('peso-clearance.request');

    Route::get('/peso-clearance/document', [JobseekerController::class, 'viewPesoClearanceDocument'])->name('peso-clearance.view-document');
    Route::get('/peso-clearance/download', [JobseekerController::class, 'downloadPesoClearanceDocument'])->name('peso-clearance.download-document');



    Route::get('/resume-builder', [JobseekerController::class, 'resumeBuilder'])->name('resume-builder');
    Route::get('/resume-builder/export', [JobseekerController::class, 'exportResumeBuilder'])->name('resume-builder.export');
    Route::post('/resume-builder', [JobseekerController::class, 'saveResumeBuilder'])->name('resume-builder.save');
    Route::delete('/resume-builder', [JobseekerController::class, 'resetResumeBuilder'])->name('resume-builder.reset');
});

// OFW routes (protected)
Route::middleware(['auth', 'role:ofw'])->prefix('ofw')->name('ofw.')->group(function () {
    Route::get('/dashboard', [OfwController::class, 'dashboard'])->name('dashboard');
    Route::get('/owwa-request', [OfwController::class, 'owwaRequest'])->name('owwa-request');
    Route::get('/rfa-form', [OfwController::class, 'rfaForm'])->name('rfa.form');
    Route::post('/rfa-download', [OfwController::class, 'downloadRfa'])->name('rfa.download');
    Route::get('/accepted-requests', [OfwController::class, 'acceptedRequests'])->name('accepted-requests');
    Route::get('/submitted-requests', [OfwController::class, 'submittedRequests'])->name('submitted-requests');
    Route::get('/submitted-requests/{submission}/download', [OfwController::class, 'downloadSubmittedRequest'])->name('submitted-requests.download');
    Route::get('/dmw-rfa', [OfwController::class, 'dmwBuilder'])->name('dmw-rfa.show');
    Route::post('/dmw-rfa/download', [OfwController::class, 'downloadDmw'])->name('dmw-rfa.download');
    Route::get('/dmw-builder', [OfwController::class, 'dmwBuilder'])->name('dmw-builder');
    Route::post('/dmw-download', [OfwController::class, 'downloadDmw'])->name('dmw-download');
});

// Employer routes (protected)
Route::middleware(['auth', 'role:employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerController::class, 'dashboard'])->name('dashboard');

    Route::get('/post-new-job', [EmployerController::class, 'postNewJobPage'])->name('jobs.post');
    Route::get('/manage-jobs', [EmployerController::class, 'manageJobsPage'])->name('jobs.manage');
    Route::get('/view-applicants', [EmployerController::class, 'viewApplicantsPage'])->name('applicants.index');

    Route::get('/request-lra-sra', [EmployerController::class, 'requestLraSraPage'])->name('recruitment.index');
    Route::get('/request-lra-sra/{recruitmentActivityRequest}', [EmployerController::class, 'viewRecruitmentActivity'])->name('recruitment.show');
    Route::get('/request-lra-sra/{recruitmentActivityRequest}/view-certificate', [EmployerController::class, 'viewRecruitmentActivityCertificate'])->name('recruitment.view-certificate');
    Route::get('/request-lra-sra/{recruitmentActivityRequest}/download-certificate', [EmployerController::class, 'downloadRecruitmentActivityCertificate'])->name('recruitment.download-certificate');
    Route::get('/submit-documents', [EmployerController::class, 'submitDocumentsPage'])->name('documents.index');

    Route::get('/company-profile', [EmployerController::class, 'companyProfilePage'])->name('company-profile');
    Route::get('/company-profile/download', [EmployerController::class, 'downloadCompanyProfile'])->name('company-profile.download');
    Route::put('/company-profile', [EmployerController::class, 'updateCompanyProfile'])->name('profile.update');

    Route::get('/notifications', [EmployerController::class, 'notificationsPage'])->name('notifications.index');

    Route::post('/jobs', [EmployerController::class, 'storeJob'])->name('jobs.store');
    Route::patch('/jobs/{job}/extend', [EmployerController::class, 'extendJob'])->name('jobs.extend');
    Route::patch('/jobs/{job}/archive', [EmployerController::class, 'archiveJob'])->name('jobs.archive');
    Route::get('/jobs/{job}/edit', [EmployerController::class, 'editJobPage'])->name('jobs.edit');
    Route::patch('/jobs/{job}', [EmployerController::class, 'updateJob'])->name('jobs.update');
    Route::post('/jobs/{job}/duplicate', [EmployerController::class, 'duplicateJob'])->name('jobs.duplicate');
    Route::patch('/jobs/{job}/filled', [EmployerController::class, 'markJobFilled'])->name('jobs.filled');


    Route::post('/recruitment-activities', [EmployerController::class, 'requestRecruitmentActivity'])
        ->name('recruitment.request');

    Route::patch('/applications/{application}', [EmployerController::class, 'updateApplicantDecision'])
        ->name('applications.update');

    Route::get('/applications/{application}', [EmployerController::class, 'showApplication'])
        ->name('applications.show');

    Route::get('/applications/{application}/resume/download', [EmployerController::class, 'downloadResume'])
        ->name('applications.resume.download');

    Route::post('/applications/{application}/feedback', [EmployerController::class, 'storeFeedback'])
        ->name('applications.feedback');

    Route::patch('/notifications/{notification}/read', [EmployerController::class, 'markNotificationRead'])
        ->name('notifications.read');

    // Applicant recommendation routes
    Route::post('/applications/{application}/recommend', [EmployerController::class, 'recommendApplicant'])
        ->name('applications.recommend');

    Route::get('/recommendations/sent', [EmployerController::class, 'viewMyRecommendations'])
        ->name('recommendations.sent');

    Route::get('/recommendations/received', [EmployerController::class, 'viewReceivedRecommendations'])
        ->name('recommendations.received');

    Route::post('/recommendations/{recommendation}/accept', [EmployerController::class, 'acceptRecommendation'])
        ->name('recommendations.accept');

    Route::post('/recommendations/{recommendation}/reject', [EmployerController::class, 'rejectRecommendation'])
        ->name('recommendations.reject');

    Route::post('/recommendations/{recommendation}/hire', [EmployerController::class, 'hireFromRecommendation'])
        ->name('recommendations.hire');

    // Follow-up and tracking routes
    Route::post('/recommendations/{recommendation}/view', [EmployerController::class, 'viewRecommendation'])
        ->name('recommendations.view');

    Route::post('/recommendations/{recommendation}/followup', [EmployerController::class, 'sendFollowup'])
        ->name('recommendations.followup');

    Route::get('/recommendations/pending-followups', [EmployerController::class, 'viewPendingFollowups'])
        ->name('recommendations.pending-followups');

    Route::post('/recommendations/{recommendation}/reviewed', [EmployerController::class, 'markRecommendationReviewed'])
        ->name('recommendations.reviewed');

    Route::post('/recommendations/{recommendation}/share', [EmployerController::class, 'shareRecommendation'])
        ->name('recommendations.share');

    Route::get('/api/recommendations/analytics', [EmployerController::class, 'getRecommendationAnalytics'])
        ->name('recommendations.analytics');
});

// Public jobs route
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs.index');

// Public company preview (click company name from jobs landing page)
Route::get('/companies/{employer}', [\App\Http\Controllers\EmployerController::class, 'companyPreview'])
    ->name('companies.preview');


Route::middleware(['auth', 'role:jobseeker'])->get('/jobs/{job}', [JobseekerController::class, 'applyJob'])->name('jobs.show');

// Admin routes (protected)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::model('application', \App\Models\JobApplication::class);

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Jobseeker Management
    Route::prefix('jobseekers')->name('jobseekers.')->group(function () {
        Route::get('/', [JobseekerApprovalController::class, 'index'])->name('index');
        Route::get('/{jobseeker}', [JobseekerApprovalController::class, 'show'])->name('show');
        Route::post('/{jobseeker}', [JobseekerApprovalController::class, 'recommendApplicant'])->name('recommend-applicant-legacy');
        Route::post('/{jobseeker}/recommend-job', [JobseekerApprovalController::class, 'recommendJob'])->name('recommend-job');
        Route::post('/{jobseeker}/recommend-applicant', [JobseekerApprovalController::class, 'recommendApplicant'])->name('recommend-applicant');
    });

    // Approvals & Verification Section
    Route::get('/employer-verification', [AdminController::class, 'employerVerification'])->name('employer-verification');
    Route::get('/employer-verification/{companyProfile}', [AdminController::class, 'viewCompanyProfile'])->name('employer-verification.detail');
    Route::post('/employer-verification/{companyProfile}/approve', [AdminController::class, 'approveCompanyProfile'])->name('employer-verification.approve');
    Route::post('/employer-verification/{companyProfile}/reject', [AdminController::class, 'rejectCompanyProfile'])->name('employer-verification.reject');

    Route::get('/job-approvals', [AdminController::class, 'jobApprovals'])->name('job-approvals');
    Route::get('/job-approvals/{job}', [AdminController::class, 'viewJob'])->name('jobs.review');
    Route::post('/job-approvals/{job}/approve', [AdminController::class, 'approveJob'])->name('jobs.approve');
    Route::post('/job-approvals/{job}/reject', [AdminController::class, 'rejectJob'])->name('jobs.reject');

    Route::get('/lra-sra-approvals', [AdminController::class, 'lraSraApprovals'])->name('lra-sra-approvals');
    Route::get('/lra-sra-approvals/{activityRequest}', [AdminController::class, 'viewLraSraRequest'])->name('lra-sra.review');
    Route::get('/lra-sra-approvals/{activityRequest}/download/{field}', [AdminController::class, 'downloadLraSraFile'])->name('lra-sra.download-file');
    Route::post('/lra-sra-approvals/{activityRequest}/generate-certification', [AdminController::class, 'generateLraSraCertification'])->name('lra-sra.generate-certification');
    Route::get('/lra-sra-approvals/{activityRequest}/view-certification', [AdminController::class, 'viewLraSraCertification'])->name('lra-sra.view-certification');
    Route::get('/lra-sra-approvals/{activityRequest}/download-certification', [AdminController::class, 'downloadLraSraCertification'])->name('lra-sra.download-certification');
    Route::post('/lra-sra-approvals/{activityRequest}/approve', [AdminController::class, 'approveLraSra'])->name('lra-sra.approve');
    Route::post('/lra-sra-approvals/{activityRequest}/reject', [AdminController::class, 'rejectLraSra'])->name('lra-sra.reject');

    Route::get('/document-verification', [AdminController::class, 'documentVerification'])->name('document-verification');
    Route::post('/document-verification/{documentId}/approve', [AdminController::class, 'approveDocument'])->name('documents.approve');
    Route::post('/document-verification/{documentId}/reject', [AdminController::class, 'rejectDocument'])->name('documents.reject');

    Route::get('/ofw-submissions', [AdminController::class, 'ofwSubmissions'])->name('ofw-submissions');
    Route::get('/ofw-submissions/{submission}/download', [AdminController::class, 'downloadOfwSubmission'])->name('ofw-submissions.download');
    Route::post('/ofw-submissions/{submission}/accept', [AdminController::class, 'acceptOfwSubmission'])->name('ofw-submissions.accept');
    Route::delete('/ofw-submissions/{submission}', [AdminController::class, 'deleteOfwSubmission'])->name('ofw-submissions.delete');

    // Management Section
    Route::view('/jobseekers-management', 'admin.jobseekers-management')->name('jobseekers-management');
    Route::get('/employers-management', [AdminController::class, 'employersManagement'])->name('employers-management');
    Route::get('/jobs-management', [AdminController::class, 'jobsManagement'])->name('jobs-management');
    Route::view('/applications-management', 'admin.applications-management')->name('applications-management');
    Route::get('/applications-analytics', [AdminController::class, 'applicationsAnalytics'])->name('applications-analytics');

    // Intelligence & Reports Section
    Route::get('/employment-stats', [AdminController::class, 'employmentStats'])->name('employment-stats');
    Route::view('/skills-gap-analysis', 'admin.skills-gap-analysis')->name('skills-gap-analysis');
    Route::view('/barangay-intelligence', 'admin.barangay-intelligence')->name('barangay-intelligence');
    Route::view('/report-builder', 'admin.report-builder')->name('report-builder');
    Route::get('/peso-clearances', [AdminController::class, 'pesoClearances'])->name('peso-clearances');
    Route::get('/peso-clearances/{clearance}', [AdminController::class, 'showPesoClearance'])->name('peso-clearances.show');
    Route::post('/peso-clearances/{clearance}/issue', [AdminController::class, 'issuePesoClearance'])->name('peso-clearances.issue');
    Route::post('/peso-clearances/{clearance}/decline', [AdminController::class, 'declinePesoClearance'])->name('peso-clearances.decline');
    Route::post('/peso-clearances/auto-generate', [AdminController::class, 'autoGenerateClearances'])->name('peso-clearances.auto-generate');
    Route::post('/peso-clearances/auto-generate-users', [AdminController::class, 'autoGenerateClearancesForUsers'])->name('peso-clearances.auto-generate-users');
    Route::get('/peso-clearance-management', [AdminController::class, 'pesoClearanceManagement'])->name('peso-clearance-management');
    Route::post('/peso-clearances/{clearance}/generate-document', [AdminController::class, 'generateClearanceDocument'])->name('peso-clearances.generate-document');
    Route::get('/peso-clearances/{clearance}/document', [AdminController::class, 'viewClearanceDocument'])->name('peso-clearances.view-document');
    Route::get('/peso-clearances/{clearance}/download', [AdminController::class, 'downloadClearanceDocument'])->name('peso-clearances.download-document');

    // Admin Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');

    // Tools & Settings Section
    Route::view('/settings', 'admin.settings')->name('settings');
    Route::view('/alerts-notifications', 'admin.alerts-notifications')->name('alerts-notifications');
    Route::view('/qr-verification', 'admin.qr-verification')->name('qr-verification');
});

// API routes for AJAX requests
Route::middleware('auth')->group(function () {
    Route::get('/api/jobs/{job}/detail', function ($job) {
        $job = \App\Models\PesoJob::findOrFail($job);
        return response()->json($job);
    });

    Route::post('/api/jobs/{job}/delete', function ($job) {
        $job = \App\Models\PesoJob::findOrFail($job);

        $validated = request()->validate([
            'reason' => 'required|string|min:10'
        ]);

        $job->update([
            'archived_at' => now(),
            'deletion_reason' => $validated['reason']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job archived successfully'
        ]);
    });
});

Route::post('/chatbot', [App\Http\Controllers\ChatbotController::class, 'chat'])->name('chatbot.chat');
