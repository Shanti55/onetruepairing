@php
    use Carbon\Carbon;

    // 1. Check if already bid
    $alreadyBid = \App\Models\JobBid::where('job_post_id', $job->id)
        ->where('service_provider_id', auth()->id())
        ->exists();

    // 2. Check if job is expired (Compare current time with job end time)
    // Maan lijiye aapka column name 'end_date' hai
    $isExpired = Carbon::now()->greaterThan($job->end_date); 
@endphp

<div class="d-flex gap-2">

    @if($isExpired)
        {{-- Agar time khatam ho gaya hai toh 'Closed' dikhao --}}
        <span class="btn btn-sm btn-danger disabled">
            <i class="bi bi-clock-history"></i> Auction Ended
        </span>

    @elseif($alreadyBid)
        {{-- Agar pehle hi bid kar chuke hain --}}
        <span class="btn btn-sm btn-secondary disabled">
            <i class="bi bi-check-circle"></i> Already Bidded
        </span>

    @else
        {{-- Agar sab sahi hai toh 'Bid Now' button dikhao --}}
        <button type="button" 
                class="btn btn-sm btn-primary BidNowBtn" 
                data-job-id="{{ $job->id }}">
            <i class="bi bi-cash-coin"></i> Bid Now
        </button>
    @endif

</div>