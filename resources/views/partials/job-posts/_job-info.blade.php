<div class="row mb-2">
    <div class="col-lg-4 mt-2">
        <p class="card-title text-muted mb-0"><small>Title</small></p>
        <h6 class="card-text">{{ $job->title }}</h6>
    </div>
    <div class="col-lg-4 mt-2">
        <p class="card-title text-muted mb-0"><small>Location</small></p>
        <h6 class="card-text">{{ $job->location }}</h6>
    </div>
    <div class="col-lg-4 mt-2">
        <p class="card-title text-muted mb-0"><small>Cost</small></p>
        <h6 class="card-text">{{ $job->cost }}</h6>
    </div>
    <div class="col-lg-4 mt-2">
        <p class="card-title text-muted mb-0"><small>Duration</small></p>
        <h6 class="card-text"> {{ $job->duration_value }} {{ $job->duration_type }}</h6>
    </div>
    <div class="col-lg-4 mt-2">
        <p class="card-title text-muted mb-0"><small>Duration</small></p>
        @php
            $categories = $job->categories()->count() > 0 ? $job->categories()->get() : null;
        @endphp
        @if(isset($categories))
            <div class="me-1">
                @foreach($categories as $category)
                    <span class="badge soft-secondary align-middle"><i class="bi bi-tags text-muted me-1"></i>{{ $category->name }}</span>
                @endforeach
            </div>
        @endif
    </div>
    <div class="col-lg-4 mt-2">
        <p class="card-title text-muted mb-0"><small>Status</small></p>
        <span class="badge {{ $job->status->color() }}">{{ ucfirst($job->status->value) }}</span>
    </div>
    <div class="col-lg-4 mt-2">
        <p class="card-title text-muted mb-0"><small>Progress</small></p>
        @include('partials.job-posts._job-progress-bar')
    </div>
</div>
