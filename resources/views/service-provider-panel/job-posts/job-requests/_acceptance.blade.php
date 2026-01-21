@php
$alreadyBid = \App\Models\JobBid::where('job_post_id', $job->id)
    ->where('service_provider_id', auth()->id())
    ->exists();
@endphp

<div class="d-flex gap-2">

@if($alreadyBid)
    <span class="btn btn-sm btn-secondary disabled">
        <i class="bi bi-check-circle"></i> Bid Placed
    </span>
@else
    <button type="button"
            class="btn btn-sm btn-primary placeBidBtn"
            data-job-id="{{ $job->id }}">
        <i class="bi bi-cash-coin"></i> Place Bid
    </button>
@endif

</div>
