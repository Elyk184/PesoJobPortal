<?php

namespace Tests\Feature\Admin;

use App\Models\PesoJob;
use App\Models\RecommendedApplicant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobseekerRecommendationRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_post_recommendation_to_jobseeker_profile_url(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $employer = User::factory()->create(['role' => 'employer']);
        $jobseeker = User::factory()->create(['role' => 'jobseeker']);

        $job = PesoJob::create([
            'employer_id' => $employer->id,
            'title' => 'Warehouse Assistant',
            'location' => 'Cebu City',
            'status' => 'active',
            'employer_name' => 'Test Employer',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.jobseekers.show', $jobseeker), [
            'employer_id' => $employer->id,
            'job_id' => $job->id,
            'message' => 'Please review this candidate.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('recommended_applicants', [
            'jobseeker_id' => $jobseeker->id,
            'peso_job_id' => $job->id,
            'recommended_by_user_id' => $admin->id,
            'recommended_to_user_id' => $employer->id,
            'recommendation_type' => 'admin_to_employer',
            'status' => 'pending',
        ]);

        $this->assertInstanceOf(RecommendedApplicant::class, RecommendedApplicant::first());
    }
}
