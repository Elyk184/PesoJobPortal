<!DOCTYPE html>
@extends('layouts.app')

@section('title', 'Job List - PESO Job Portal')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap');
body { font-family: 'Poppins', sans-serif; }
.job-hero {
    background: linear-gradient(135deg, #0f2d52 0%, #1f4b8f 100%);
    color: white;
    padding: 80px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.job-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"25\" cy=\"25\" r=\"1\" fill=\"%23ffffff\" opacity=\"0.1\"/><circle cx=\"75\" cy=\"75\" r=\"1.5\" fill=\"%23ffffff\" opacity=\"0.05\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain)\"/></svg>');
}
.job-hero h1 { font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); }
.job-hero p { font-size: 1.3rem; max-width: 600px; margin: 0 auto; opacity: 0.95; }
.job-grid { max-width: 1300px; margin: 0 auto; padding: 40px 20px; }
.job-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(15,45,82,0.15);
    transition: all 0.3s ease;
    height: 100%;
    background: white;
}
.job-card:hover { transform: translateY(-10px); box-shadow: 0 25px 50px rgba(15,45,82,0.25); }
.job-card-header { background: linear-gradient(135deg, #d72638, #e74c3c); color: white; padding: 20px; }
.job-card-body { padding: 25px; }
.job-title { font-size: 1.4rem; font-weight: 700; color: #0f2d52; margin-bottom: 10px; }
.job-meta { display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 15px; font-size: 0.95rem; }
.job-meta i { color: #d72638; }
.job-desc { color: #4b5563; line-height: 1.6; margin-bottom: 20px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.job-btn {
    background: linear-gradient(135deg, #d72638, #e74c3c);
    border: none;
    color: white;
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s;
}
.job-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(215,38,56,0.3); }
.pagination { justify-content: center; margin-top: 40px; }
.pagination .page-link { color: #0f2d52; border: 1px solid #e5e7eb; margin: 0 2px; }
.pagination .page-item.active .page-link { background: #d72638; border-color: #d72638; }
.no-jobs { text-align: center; padding: 80px 20px; color: #6b7280; }
@media (max-width: 768px) { .job-hero h1 { font-size: 2.5rem; } .job-grid { padding: 20px 15px; } }
</style>
@endpush

@section('content')
<section class="job-hero">
    <div class="container">
        <h1>Job Opportunities</h1>
        <p>Discover verified job listings from local and national employers. Find your next career step with PESO Manolo Fortich.</p>
    </div>
</section>

<div class="job-grid">
    @if($jobs->count() > 0)
        <div class="row g-4">
            @foreach($jobs as $job)
                <div class="col-lg-4 col-md-6">
                    <div class="card job-card h-100">
                        <div class="job-card-header">
                            <h5 class="mb-0 fw-bold">{{ $job->title }}</h5>
                        </div>
                        <div class="job-card-body">
                            <div class="job-meta">
                                <span><i class="bi bi-building"></i> {{ $job->employer_name }}</span>
                                <span><i class="bi bi-geo-alt"></i> {{ $job->location }}</span>
                                <span><i class="bi bi-currency-dollar"></i> {{ $job->salary_range ?? 'Competitive' }}</span>
                            </div>
                            <p class="job-desc">{{ $job->description }}</p>
                            <div class="d-flex gap-2">
                                @auth
                                    <form action="{{ route('jobseeker.applications') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="peso_job_id" value="{{ $job->id }}">
                                        <button type="submit" class="btn job-btn">Apply Now</button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn job-btn">Login to Apply</a>
                                @endauth
                                <a href="#" class="btn btn-outline-secondary">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination">
            {{ $jobs->links() }}
        </div>
    @else
        <div class="no-jobs">
            <i class="bi bi-briefcase display-1 text-muted mb-4"></i>
            <h3>No Active Jobs</h3>
            <p>Check back soon for new opportunities or register as jobseeker/employer.</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Get Started</a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Simple smooth scroll for details (placeholder)
document.querySelectorAll('.job-btn').forEach(btn => {
    if (btn.textContent.includes('Details')) {
        btn.addEventListener('click', e => {
            e.preventDefault();
            alert('Job details coming soon!');
        });
    }
});
</script>
@endpush>

