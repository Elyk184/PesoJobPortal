# Jobseeker Profile Migration Guide

## Overview
This migration creates a dedicated `jobseeker_profiles` table to separate jobseeker-specific profile data from the generic `user_profiles` table. This allows for better data organization and jobseeker-specific features like profile completion tracking.

## Changes Made

### 1. New Files Created
- **Migration:** `database/migrations/2026_05_26_000001_create_jobseeker_profiles_table.php`
- **Model:** `app/Models/JobseekerProfile.php`

### 2. Model Changes
- **JobseekerController.php**: Updated to use `JobseekerProfile` instead of `UserProfile`
- **User.php**: Added `jobseekerProfile()` relationship method
- **JobseekerApprovalController.php**: Updated to load `jobseekerProfile` relationship

### 3. New Database Schema
The `jobseeker_profiles` table includes:
- Personal information (JSON)
- Address information (JSON)
- Education, training, experience, eligibility (JSON)
- Skills, languages, disability (JSON)
- Employment status and job preferences (JSON)
- Profile completion tracking:
  - `profile_completed` (boolean) - Set to true when 100% complete
  - `completion_percentage` (integer) - Calculated completion score

## Migration Steps

### Step 1: Run the Migration
```bash
cd PESOJOBPORTAL
php artisan migrate
```

### Step 2: (Optional) Migrate Existing Data
If you have existing profiles in the `user_profiles` table that need to be migrated to `jobseeker_profiles`, run:

```bash
php artisan tinker
```

Then paste this code:
```php
use App\Models\User;
use App\Models\JobseekerProfile;

User::where('role', 'jobseeker')->get()->each(function ($user) {
    if ($user->profile) {
        JobseekerProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'personal_information' => $user->profile->personal_information,
                'present_address' => $user->profile->present_address,
                'permanent_address' => $user->profile->permanent_address,
                'resume_name' => $user->profile->resume_name,
                'resume_email' => $user->profile->resume_email,
                'phone' => $user->profile->phone,
                'address' => $user->profile->address,
                'resume_path' => $user->profile->resume_path,
                'photo_path' => $user->profile->photo_path,
                'skills' => $user->profile->skills,
                'education' => $user->profile->education,
                'training' => $user->profile->training,
                'experience' => $user->profile->experience,
                'eligibility' => $user->profile->eligibility,
                'other_skills' => $user->profile->other_skills,
                'languages' => $user->profile->languages,
                'employment_status' => $user->profile->employment_status,
                'job_preferences' => $user->profile->job_preferences,
                'disability' => $user->profile->disability,
                'objective' => $user->profile->objective,
            ]
        );
    }
});

// Exit tinker
exit
```

### Step 3: Verify the Database
Check that the `jobseeker_profiles` table exists and has records:

```bash
php artisan tinker
```

```php
use App\Models\JobseekerProfile;
JobseekerProfile::count();  // Should show number of profiles
```

## Key Features

### Profile Completion Tracking
When a jobseeker saves their profile, the system now automatically calculates:
- **completion_percentage**: Based on filled fields (personal info, address, education, etc.)
- **profile_completed**: Boolean flag set to true when completion_percentage reaches 100

### Accessing Jobseeker Profiles
```php
// In controllers or models
$user = User::find(1);
$profile = $user->jobseekerProfile;  // NEW - use this
// $profile = $user->profile;          // OLD - no longer for jobseekers
```

## Database Schema

```sql
CREATE TABLE jobseeker_profiles (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT UNSIGNED UNIQUE NOT NULL,
  
  -- Personal Information
  personal_information JSON,
  
  -- Address
  present_address JSON,
  permanent_address JSON,
  
  -- Display Fields
  resume_name VARCHAR(255),
  resume_email VARCHAR(255),
  phone VARCHAR(255),
  address TEXT,
  
  -- Documents
  resume_path VARCHAR(255),
  photo_path VARCHAR(255),
  
  -- Profile Sections (JSON)
  skills JSON,
  education JSON,
  training JSON,
  experience JSON,
  eligibility JSON,
  other_skills JSON,
  languages JSON,
  employment_status JSON,
  job_preferences JSON,
  disability JSON,
  
  -- Profile Tracking
  objective TEXT,
  profile_completed BOOLEAN DEFAULT FALSE,
  completion_percentage INT DEFAULT 0,
  
  -- Timestamps
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  
  -- Foreign Keys
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## Troubleshooting

### Migration Fails
If you get an error running the migration:
1. Ensure MySQL/MariaDB is running: `net start MySQL80` (Windows) or `brew services start mysql` (Mac)
2. Check database connection in `.env` file
3. Run `php artisan migrate:status` to see current migration state

### Profile Data Not Showing
1. Ensure migration ran successfully: `php artisan migrate:status`
2. Verify data exists: `php artisan tinker` then `JobseekerProfile::count()`
3. Clear Laravel cache: `php artisan cache:clear`

## Rollback (If Needed)
To revert to the previous system:
```bash
php artisan migrate:rollback
```

This will drop the `jobseeker_profiles` table and revert to using `user_profiles`.

## Notes
- The old `user_profiles` table will remain but won't be used for jobseekers
- You can optionally keep it for employer profiles or remove it later
- All new jobseeker profile saves will go to `jobseeker_profiles`
- The system automatically calculates profile completion percentage on save
