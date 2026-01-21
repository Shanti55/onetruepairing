@php
   $categories = $job->categories()->count() > 0 ? $job->categories()->get() : null;
@endphp
<div>
    <p class="m-0 p-0">{{ $job->postedBy ? $job->postedBy->name : 'NA'}}</p>
    <p class="m-0 p-0 text-muted small">{{ $job->title }}</p>
    @if(isset($categories))
        <div class="me-1">
            @foreach($categories as $category)
                <span class="badge soft-secondary align-middle"><i class="bi bi-tags text-muted me-1"></i>{{ $category->name }}</span>
            @endforeach
        </div>
    @endif
    <div class="d-flex  m-0 p-0">

    @if(isset($job->location))
        <div class="me-1">
            <span class="badge soft-secondary align-middle"><i class="bi bi-geo-alt text-muted me-1"></i>{{ $job->location }}</span>
        </div>
    @endif
    @if(isset($job->cost) && $job->cost > 0)
        <div class="me-1">
            <span class="badge soft-secondary align-middle"><i class="bi bi-currency-rupee text-muted me-1"></i>{{ $job->cost }}</span>
        </div>
    @endif
    @if(isset($job->duration_type) && isset($job->duration_value))
        <div class="ms-1">
            <span class="badge soft-secondary align-middle"><i class="bi bi-clock-history me-1"></i>{{ $job->duration_value }} / {{ ucfirst($job->duration_type) }}</span>
        </div>
    @endif
    @if(isset($job->description))
        <div class="ms-1">
            <span class="badge soft-warning align-middle"  style="cursor: pointer"  data-bs-toggle="collapse" data-bs-target="#collapseExample_{{ $job->id }}"><i class="bi bi-info-circle me-1"></i>More Details</span>
        </div>
    @endif
    </div>
    @if(isset($job->description))
    <div class="collapse" id="collapseExample_{{ $job->id }}">
        <div class="card card-body border-0 mt-1 shadow-sm bg-light">
            <small class="text-muted">{{ $job->description }}.</small>
        </div>
    </div>
    @endif

</div>


