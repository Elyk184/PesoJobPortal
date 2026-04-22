<div class="row g-3">
    @foreach ($sampleJobs as $job)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-warning-subtle">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <h5 class="card-title fw-semibold mb-1">{{ $job['title'] }}</h5>
                        <span class="badge text-bg-warning">Sample</span>
                    </div>
                    <p class="text-muted small mb-2">{{ $job['location'] }} • {{ $job['employer_name'] }}</p>

                    @if (! empty($job['salary_range']))
                        <p class="small mb-2"><strong>Salary:</strong> {{ $job['salary_range'] }}</p>
                    @endif

                    <p class="small text-muted mb-3">{{ \Illuminate\Support\Str::limit($job['description'], 120) }}</p>

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @foreach (collect($job['requirements_list'])->take(4) as $requirement)
                            <span class="badge rounded-pill text-bg-light">{{ $requirement }}</span>
                        @endforeach
                    </div>

                    <div class="mt-auto">
                        <button class="btn btn-outline-danger w-100" type="button" disabled>
                            <i class="bi bi-send me-2"></i>Apply (coming soon)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>