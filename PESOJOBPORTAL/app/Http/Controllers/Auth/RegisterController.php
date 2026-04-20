<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegistrationForm(): View
    {
        return view('register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:admin,employer,jobseeker'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        // Ensure newly-registered employers have a profile record so employer
        // dashboard pages can safely read profile-backed fields.
        if ($validated['role'] === 'employer') {
            UserProfile::firstOrCreate(['user_id' => $user->id]);
        }

        // Auth::login($user); // Commented to redirect to login instead of auto-login
        $request->session()->regenerate();

        $roleLabel = match ($validated['role']) {
            'employer' => 'Employer',
            'admin' => 'Admin',
            default => 'Jobseeker',
        };

        return redirect()
            ->route('login')
            ->with('success', "Registration complete! Your {$roleLabel} account is ready. Please log in to continue.");
    }
}
