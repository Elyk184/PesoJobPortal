<?php

namespace Tests\Feature\Employer;

use App\Models\CompanyProfile;
use App\Models\JobApplication;
use App\Models\PesoJob;
use App\Models\RecommendedApplicant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApplicantRecommendationTest extends TestCase
{
    use RefreshDatabase;

    private User $employer1;
    private User $employer2;
    private User $jobseeker;
    private PesoJob $job;
    private JobApplication $application;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test users
        $this->employer1 = User::factory()->create(['role' => 'employer', 'name' => 'Employer 1']);
        $this->employer2 = User::factory()->create(['role' => 'employer', 'name' => 'Employer 2']);
        $this->jobseeker = User::factory()->create(['role' => 'jobseeker', 'name' => 'Job Seeker']);

        // Create company profile for employer
        CompanyProfile::create([
            'user_id' => $this->employer1->id,
            'company_name' => 'Company 1',
            'business_type' => 'Technology',
            'verification_status' => 'verified',
        ]);

        // Create a job by employer1
        $this->job = PesoJob::create([
            'employer_id' => $this->employer1->id,
            'title' => 'Software Developer',
            'location' => 'Metro Manila',
            'status' => 'active',
            'employer_name' => 'Company 1',
        ]);

        // Create job application
        $this->application = JobApplication::create([
            'user_id' => $this->jobseeker->id,
            'peso_job_id' => $this->job->id,
            'status' => 'pending',
        ]);
    }

    /**
     * Test that only employers can recommend applicants
     */
    public function test_only_employers_can_recommend_applicants(): void
    {
        $this->actingAs($this->jobseeker);

        $response = $this->post(route('employer.applications.recommend', $this->application), [
            'recommended_to_user_id' => $this->employer2->id,
            'recommendation_type' => 'employer_to_employer',
        ]);

        $response->assertForbidden();
    }

    /**
     * Test that employer can only recommend their own applicants
     */
    public function test_employer_cannot_recommend_other_employers_applicants(): void
    {
        // Create another job by employer2
        $job2 = PesoJob::create([
            'employer_id' => $this->employer2->id,
            'title' => 'Sales Manager',
            'location' => 'Cebu',
            'status' => 'active',
            'employer_name' => 'Company 2',
        ]);

        $application2 = JobApplication::create([
            'user_id' => $this->jobseeker->id,
            'peso_job_id' => $job2->id,
            'status' => 'pending',
        ]);

        $this->actingAs($this->employer1);

        $response = $this->post(route('employer.applications.recommend', $application2), [
            'recommended_to_user_id' => $this->employer2->id,
            'recommendation_type' => 'employer_to_employer',
        ]);

        $response->assertRedirect();
        $this->assertStringContainsString('own job postings', session('error'));
    }

    /**
     * Test that recommendation must be sent to a specific employer
     */
    public function test_recommendation_must_be_sent_to_specific_employer(): void
    {
        $this->actingAs($this->employer1);

        $response = $this->post(route('employer.applications.recommend', $this->application), [
            'recommended_to_user_id' => null, // No recipient
            'recommendation_type' => 'employer_to_employer',
        ]);

        $response->assertRedirect();
        $this->assertTrue($response->getSession()->has('error'));
    }

    /**
     * Test that employer can successfully recommend an applicant
     */
    public function test_employer_can_recommend_applicant(): void
    {
        $this->actingAs($this->employer1);

        $response = $this->post(route('employer.applications.recommend', $this->application), [
            'recommended_to_user_id' => $this->employer2->id,
            'recommendation_reason' => 'Excellent candidate',
            'recommendation_type' => 'employer_to_employer',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('recommended_applicants', [
            'job_application_id' => $this->application->id,
            'recommended_by_user_id' => $this->employer1->id,
            'recommended_to_user_id' => $this->employer2->id,
            'recommendation_type' => 'employer_to_employer',
            'status' => 'pending',
        ]);
    }

    /**
     * Test that employer can only see recommendations sent to them
     */
    public function test_employer_can_only_see_their_received_recommendations(): void
    {
        // Create recommendation to employer2
        RecommendedApplicant::create([
            'job_application_id' => $this->application->id,
            'peso_job_id' => $this->job->id,
            'recommended_by_user_id' => $this->employer1->id,
            'recommended_to_user_id' => $this->employer2->id,
            'recommendation_type' => 'employer_to_employer',
            'status' => 'pending',
        ]);

        // Employer1 tries to access recommendations sent to employer2
        $this->actingAs($this->employer1);
        $response = $this->get(route('employer.recommendations.received'));
        $response->assertSuccessful();
        $this->assertCount(0, $response->viewData('recommendations'));

        // Employer2 accesses their own recommendations
        $this->actingAs($this->employer2);
        $response = $this->get(route('employer.recommendations.received'));
        $response->assertSuccessful();
        $this->assertCount(1, $response->viewData('recommendations'));
    }

    /**
     * Test that only the recipient can accept a recommendation
     */
    public function test_only_recipient_can_accept_recommendation(): void
    {
        $recommendation = RecommendedApplicant::create([
            'job_application_id' => $this->application->id,
            'peso_job_id' => $this->job->id,
            'recommended_by_user_id' => $this->employer1->id,
            'recommended_to_user_id' => $this->employer2->id,
            'recommendation_type' => 'employer_to_employer',
            'status' => 'pending',
        ]);

        // Employer1 (recommender) tries to accept
        $this->actingAs($this->employer1);
        $response = $this->post(route('employer.recommendations.accept', $recommendation));
        $response->assertForbidden();

        // Employer2 (recipient) can accept
        $this->actingAs($this->employer2);
        $response = $this->post(route('employer.recommendations.accept', $recommendation), [
            'response_notes' => 'Great candidate',
        ]);
        $response->assertRedirect();

        $this->assertDatabaseHas('recommended_applicants', [
            'id' => $recommendation->id,
            'status' => 'accepted',
        ]);
    }

    /**
     * Test that employer cannot see other employer's recommendations
     */
    public function test_employer_cannot_view_other_employers_recommendations(): void
    {
        $recommendation = RecommendedApplicant::create([
            'job_application_id' => $this->application->id,
            'peso_job_id' => $this->job->id,
            'recommended_by_user_id' => $this->employer1->id,
            'recommended_to_user_id' => $this->employer2->id,
            'recommendation_type' => 'employer_to_employer',
            'status' => 'pending',
        ]);

        // Employer3 (unrelated) tries to accept/reject
        $employer3 = User::factory()->create(['role' => 'employer']);

        $this->actingAs($employer3);
        $response = $this->post(route('employer.recommendations.accept', $recommendation));
        $response->assertForbidden();
    }

    public function test_resume_preview_opens_in_browser_viewer_instead_of_downloading(): void
    {
        Storage::fake('public');

        $resumePath = 'resumes/test-resume.pdf';
        Storage::disk('public')->put($resumePath, '%PDF-1.4\n1 0 obj\n<<>>\nendobj\ntrailer\n<<>>\n%%EOF');

        $this->application->update([
            'resume_path' => $resumePath,
            'resume_original_filename' => 'test-resume.pdf',
            'resume_file_extension' => 'pdf',
        ]);

        $this->actingAs($this->employer1);

        $response = $this->get(route('employer.applications.resume.view', $this->application));

        $response->assertOk();
        $response->assertSee('iframe');
        $response->assertSee('resume-viewer');
        $response->assertSee('viewer?embedded=true');
    }
}
