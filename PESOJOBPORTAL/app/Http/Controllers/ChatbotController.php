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

        // Restrict topics to PESO Job Portal features (config-driven)
        $allowedTopics = (array) config('chatbot.allowed_topics', []);
        $matched = false;
        foreach ($allowedTopics as $topic) {
            if (stripos($userMessage, $topic) !== false) {
                $matched = true;
                break;
            }
        }

        if (!$matched) {
            return response()->json([
                'reply' => (string) config('chatbot.fallback_reply', 'Sorry, I can only assist with PESO Job Portal features.'),
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