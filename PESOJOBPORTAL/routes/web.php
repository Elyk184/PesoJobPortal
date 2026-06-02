<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\OfwController;
use App\Http\Controllers\JobseekerController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\RfaController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);

Route::view('/history', 'history')->name('history');
Route::view('/history-of-excellence', 'history-excellence')->name('history-of-excellence');
Route::view('/objectives', 'objective')->name('objectives');
Route::view('/legal-mandate', 'legal-mandate')->name('legal-mandate');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::middleware(['auth', 'role:ofw'])->prefix('ofw')->name('ofw.')->group(function () {
    Route::get('/', [OfwController::class, 'dashboard'])->name('dashboard');
    Route::get('/accepted-requests', [OfwController::class, 'acceptedRequests'])->name('accepted-requests');
    Route::get('/owwa-request', [OfwController::class, 'owwaRequest'])->name('owwa-request');
    Route::get('/submitted-requests', [OfwController::class, 'submittedRequests'])->name('submitted-requests');
    Route::get('/rfa', [RfaController::class, 'create'])->name('rfa.form');
    Route::post('/rfa/download', [RfaController::class, 'download'])->name('rfa.download');
    Route::get('/dmw-builder', [OfwController::class, 'dmwBuilder'])->name('dmw-builder');
    Route::post('/dmw-builder', [OfwController::class, 'saveDmwBuilder'])->name('dmw-builder.save');
    Route::match(['get', 'post'], '/dmw-download', [OfwController::class, 'downloadDmwForm'])->name('dmw-download');
    Route::post('/attachments/upload', [OfwController::class, 'uploadAttachment'])->name('attachments.upload');
    Route::post('/attachments/delete', [OfwController::class, 'deleteAttachment'])->name('attachments.delete');
    Route::post('/dmw-submit', [OfwController::class, 'submitDmwForm'])->name('dmw-submit');
    Route::post('/dmw-calibrate', [OfwController::class, 'saveDmwCoords'])->name('dmw-calibrate');
});

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
    Route::get('/recommendations', [JobseekerController::class, 'recommendations'])->name('recommendations');
    Route::get('/applications', [JobseekerController::class, 'applications'])->name('applications');
    Route::get('/notifications', [JobseekerController::class, 'notifications'])->name('notifications');
    Route::get('/notifications/feed', [JobseekerController::class, 'notificationsFeed'])->name('notifications.feed');
    Route::post('/notifications/{userNotification}/read', [JobseekerController::class, 'markNotificationAsRead'])->name('notifications.read');
    Route::get('/profile', [JobseekerController::class, 'profile'])->name('profile');
    Route::post('/profile', [JobseekerController::class, 'saveProfile'])->name('profile.save');
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

Route::redirect('/rfa', '/ofw/rfa');

// Admin routes (protected)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/notifications', [AdminController::class, 'storeNotification'])->name('notifications.store');
    Route::post('/recommendations/push', [AdminController::class, 'pushRecommendations'])->name('recommendations.push');
});

Route::post('/chatbot', [App\Http\Controllers\ChatbotController::class, 'chat'])
    ->name('chatbot.chat');
