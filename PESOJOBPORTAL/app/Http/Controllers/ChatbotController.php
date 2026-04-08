<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $userMessage = $request->input('message');

        // Restrict topics: registration, employer portal, admin, jobseeker features
        $allowedTopics = [
            // Authentication
            'login', 'log in', 'logout', 'log out',
            // Registration
            'registration', 'register', 'sign up', 'create account',
            // Password
            'forgot password', 'reset password', 'change password',
            // Verification
            'account verification', 'email verification',
            // Profile
            'profile', 'profile update', 'edit profile',
            // Resume
            'resume', 'CV', 'upload resume',
            // Skills & Experience
            'skills', 'experience', 'personal information',
            // Job Listings
            'job listing', 'job listings', 'job vacancies',
            // Job Search
            'job search', 'find jobs', 'search jobs',
            // Job Details
            'job details', 'job description',
            // Latest/Available Jobs
            'latest jobs', 'available jobs',
            // Applications
            'apply', 'job application', 'apply for job',
            'application status', 'application update',
            'submitted applications', 'my applications',
            'withdraw application',
            // Employer Portal
            'employer portal', 'employer login',
            // Company
            'company profile', 'company info',
            // Job Posting
            'job posting', 'post a job',
            // Applicants
            'manage applicants',
            // Admin
            'admin', 'administrator',
            'admin portal', 'admin login',
            // Admin Actions
            'approve jobs', 'verify employer',
            'manage users', 'reports',
            // News & Events
            'news', 'updates', 'announcements',
            'events', 'job fairs', 'hiring events',
            // PESO
            'PESO programs', 'PESO services',
            // Guidance & Training
            'career guidance', 'livelihood programs', 'training and seminars',
        ];
        $matched = false;
        foreach ($allowedTopics as $topic) {
            if (stripos($userMessage, $topic) !== false) {
                $matched = true;
                break;
            }
        }

        if (!$matched) {
            return response()->json([
                'reply' => 'Sorry, I can only assist with registration, employer portal, admin questions, job applications, job listings, job details, application status, or profile updates.',
            ]);
        }

        // System context for Gemini
        $systemContext = "You are a chatbot for the PESO system. The system allows users to register for accounts, apply for jobs, employers to access the employer portal to post jobs and manage applicants, and admins to manage users and system settings. Registration requires user details and email verification. Jobseekers can browse job listings, view job details, submit job applications, track their application status, and update their profiles. Employers can post jobs, view applicants, manage job postings, update company profiles, and communicate with jobseekers. Admins can approve registrations, manage employer and jobseeker accounts, oversee system operations, generate reports, and configure system settings. Answer questions strictly based on these system features and workflows, including job applications, job listings, job details, application status, and profile updates for jobseekers.";
        $prompt = $systemContext . "\nUser question: " . $userMessage;
        $service = new GeminiService();
        $aiResponse = $service->generatedContent($prompt);

        // Improved error handling for debugging
        if (str_contains($aiResponse, 'error')) {
            return response()->json([
                'reply' => $aiResponse,
                'error' => true,
            ], 500);
        }

        return response()->json([
            'reply' => $aiResponse,
        ]);
    }
}