<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmployerController;
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
});

// Employer routes (protected)
Route::middleware(['auth', 'role:employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerController::class, 'dashboard'])->name('dashboard');
    Route::get('/post-new-job', [EmployerController::class, 'postNewJobPage'])->name('jobs.post');
    Route::get('/manage-jobs', [EmployerController::class, 'manageJobsPage'])->name('jobs.manage');
    Route::get('/view-applicants', [EmployerController::class, 'viewApplicantsPage'])->name('applicants.index');
    Route::get('/request-lra-sra', [EmployerController::class, 'requestLraSraPage'])->name('recruitment.index');
    Route::get('/submit-documents', [EmployerController::class, 'submitDocumentsPage'])->name('documents.index');
    Route::get('/company-profile', [EmployerController::class, 'companyProfilePage'])->name('company-profile');
    Route::put('/company-profile', [EmployerController::class, 'updateCompanyProfile'])->name('profile.update');
    Route::get('/notifications', [EmployerController::class, 'notificationsPage'])->name('notifications.index');

    Route::post('/jobs', [EmployerController::class, 'storeJob'])->name('jobs.store');
    Route::patch('/jobs/{job}/extend', [EmployerController::class, 'extendJob'])->name('jobs.extend');
    Route::patch('/jobs/{job}/archive', [EmployerController::class, 'archiveJob'])->name('jobs.archive');
    Route::post('/jobs/{job}/duplicate', [EmployerController::class, 'duplicateJob'])->name('jobs.duplicate');
    Route::patch('/jobs/{job}/filled', [EmployerController::class, 'markJobFilled'])->name('jobs.filled');

    Route::post('/recruitment-activities', [EmployerController::class, 'requestRecruitmentActivity'])
        ->name('recruitment.request');

    Route::patch('/applications/{application}', [EmployerController::class, 'updateApplicantDecision'])
        ->name('applications.update');

    Route::patch('/notifications/{notification}/read', [EmployerController::class, 'markNotificationRead'])
        ->name('notifications.read');
});

// Public jobs route
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs.index');

// Admin routes (protected)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::post('/chatbot', [App\Http\Controllers\ChatbotController::class, 'chat'])
    ->name('chatbot.chat');
