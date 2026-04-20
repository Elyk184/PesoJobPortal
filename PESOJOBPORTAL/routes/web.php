<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobseekerApprovalController;
use App\Http\Controllers\JobseekerController;
use App\Http\Controllers\JobsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/history', 'history')->name('history');
Route::view('/history-of-excellence', 'history-excellence')->name('history-of-excellence');
Route::view('/objectives', 'objective')->name('objectives');
Route::view('/legal-mandate', 'legal-mandate')->name('legal-mandate');
Route::view('/structure', 'structure')->name('structure');

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
    Route::get('/vacancies', [JobseekerController::class, 'vacancies'])->name('vacancies');
    Route::get('/applications', [JobseekerController::class, 'applications'])->name('applications');
    Route::get('/profile', [JobseekerController::class, 'profile'])->name('profile');
    Route::get('/resume-builder', [JobseekerController::class, 'resumeBuilder'])->name('resume-builder');
    Route::get('/resume-builder/export', [JobseekerController::class, 'exportResumeBuilder'])->name('resume-builder.export');
    Route::post('/resume-builder', [JobseekerController::class, 'saveResumeBuilder'])->name('resume-builder.save');
    Route::delete('/resume-builder', [JobseekerController::class, 'resetResumeBuilder'])->name('resume-builder.reset');
});

// Employer routes (protected)
Route::middleware(['auth', 'role:employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerController::class, 'dashboard'])->name('dashboard');
});

// Public jobs route
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs.index');

// Admin routes (protected)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Jobseeker Approvals
    Route::prefix('jobseekers')->name('jobseekers.')->group(function () {
        Route::get('/', [JobseekerApprovalController::class, 'index'])->name('index');
        Route::get('/{jobseeker}', [JobseekerApprovalController::class, 'show'])->name('show');
        Route::post('/{jobseeker}/approve', [JobseekerApprovalController::class, 'approve'])->name('approve');
        Route::post('/{jobseeker}/reject', [JobseekerApprovalController::class, 'reject'])->name('reject');
    });
    
    // Approvals & Verification Section
    Route::view('/employer-verification', 'admin.employer-verification')->name('employer-verification');
    Route::view('/job-approvals', 'admin.job-approvals')->name('job-approvals');
    Route::view('/lra-sra-approvals', 'admin.lra-sra-approvals')->name('lra-sra-approvals');
    Route::view('/document-verification', 'admin.document-verification')->name('document-verification');
    
    // Management Section
    Route::view('/jobseekers-management', 'admin.jobseekers-management')->name('jobseekers-management');
    Route::view('/employers-management', 'admin.employers-management')->name('employers-management');
    Route::view('/jobs-management', 'admin.jobs-management')->name('jobs-management');
    Route::view('/applications-management', 'admin.applications-management')->name('applications-management');
    
    // Intelligence & Reports Section
    Route::view('/employment-stats', 'admin.employment-stats')->name('employment-stats');
    Route::view('/skills-gap-analysis', 'admin.skills-gap-analysis')->name('skills-gap-analysis');
    Route::view('/barangay-intelligence', 'admin.barangay-intelligence')->name('barangay-intelligence');
    Route::view('/report-builder', 'admin.report-builder')->name('report-builder');
    Route::view('/peso-clearances', 'admin.peso-clearances')->name('peso-clearances');
    
    // Tools & Settings Section
    Route::view('/settings', 'admin.settings')->name('settings');
    Route::view('/alerts-notifications', 'admin.alerts-notifications')->name('alerts-notifications');
    Route::view('/qr-verification', 'admin.qr-verification')->name('qr-verification');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::post('/chatbot', [App\Http\Controllers\ChatbotController::class, 'chat'])
    ->name('chatbot.chat');
