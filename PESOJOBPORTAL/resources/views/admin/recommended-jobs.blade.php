@extends('layouts.dashboard')

@section('title', 'Recommended Jobs | Admin')

@section('content')
<section class="container-fluid py-4">
    <div class="dashboard-section-card p-3 p-lg-4 mb-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-center">
            <div>
                <h2 class="h4 fw-bold mb-1">Recommended Jobs CRUD</h2>
                <p class="mb-0 text-muted">Create, update, and delete stored job recommendations.</p>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-12 col-xl-4">
            <div class="dashboard-section-card p-3 p-lg-4 h-100">
                <h3 class="h6 fw-bold mb-3">Create Recommendation</h3>
                <form method="POST" action="{{ route('admin.recommended-jobs.store') }}" class="vstack gap-3">
                    @csrf
                    <div>
                        <label class="form-label fw-semibold">Jobseeker</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Select jobseeker</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Job Post</label>
                        <select name="job_id" class="form-select" required>
                            <option value="">Select job</option>
                            @foreach ($jobs as $job)
                                <option value="{{ $job->id }}">{{ $job->title }} - {{ $job->employer_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Match Score</label>
                        <input type="number" name="match_score" class="form-control" min="0" max="100" step="0.01" placeholder="85">
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Reason</label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Why this job is recommended"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Recommendation</button>
                </form>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="dashboard-section-card p-3 p-lg-4">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Jobseeker</th>
                                <th>Job</th>
                                <th>Score</th>
                                <th>Reason</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recommendedJobs as $item)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $item->user?->name ?? 'Unknown' }}</div>
                                        <div class="text-muted small">{{ $item->user?->email }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $item->job?->title ?? 'Unknown job' }}</div>
                                        <div class="text-muted small">{{ $item->job?->employer_name }} | {{ $item->job?->location }}</div>
                                    </td>
                                    <td>{{ number_format((float) $item->match_score, 2) }}%</td>
                                    <td>{{ $item->reason }}</td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#edit-{{ $item->id }}">Edit</button>
                                        <form method="POST" action="{{ route('admin.recommended-jobs.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Delete this recommendation?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr class="collapse" id="edit-{{ $item->id }}">
                                    <td colspan="5">
                                        <form method="POST" action="{{ route('admin.recommended-jobs.update', $item) }}" class="row g-3 p-3 border rounded bg-light">
                                            @csrf
                                            @method('PUT')
                                            <div class="col-12 col-md-3">
                                                <label class="form-label fw-semibold">Jobseeker</label>
                                                <select name="user_id" class="form-select" required>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}" @selected($item->user_id === $user->id)>{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="form-label fw-semibold">Job Post</label>
                                                <select name="job_id" class="form-select" required>
                                                    @foreach ($jobs as $job)
                                                        <option value="{{ $job->id }}" @selected($item->job_id === $job->id)>{{ $job->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <label class="form-label fw-semibold">Score</label>
                                                <input type="number" name="match_score" class="form-control" min="0" max="100" step="0.01" value="{{ $item->match_score }}">
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <label class="form-label fw-semibold">Reason</label>
                                                <input type="text" name="reason" class="form-control" value="{{ $item->reason }}">
                                            </div>
                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No recommended jobs yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $recommendedJobs->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection