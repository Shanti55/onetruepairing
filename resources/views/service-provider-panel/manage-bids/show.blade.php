@extends('service-provider-panel.layouts.app')

@section('title', 'Bid Details')

@section('content')
<div class="px-3">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('vendor.bids') }}" class="btn btn-sm btn-light border">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
        <h5 class="fw-semibold mb-0">Bid Details</h5>
    </div>

    <div class="row g-3">

        {{-- Job Info --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm" style="border-radius:14px;">
                <div class="card-header border-0 py-3 px-4"
                     style="background:#f8fafc;border-radius:14px 14px 0 0;">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-briefcase me-2 text-primary"></i>Job Information
                    </h6>
                </div>
                <div class="card-body p-4">
                    <table class="table table-borderless small">
                        <tr>
                            <td class="text-muted fw-semibold" style="width:40%;">Job ID</td>
                            <td class="fw-bold text-primary">
                                EL#{{ str_pad($bid->jobPost->id ?? 0, 5, '0', STR_PAD_LEFT) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Title</td>
                            <td class="fw-bold">{{ $bid->jobPost->title ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Location</td>
                            <td>{{ $bid->jobPost->city ?? $bid->jobPost->location ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Budget</td>
                            <td class="fw-bold text-success">
                                ₹{{ number_format($bid->jobPost->cost ?? 0, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Duration</td>
                            <td>
                                {{ $bid->jobPost->duration_value ?? 'N/A' }}
                                {{ $bid->jobPost->duration_type ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Auction Start</td>
                            <td>
                                {{ $bid->jobPost->auction_start
                                    ? \Carbon\Carbon::parse($bid->jobPost->auction_start)->format('d M Y, h:i A')
                                    : 'Not Set' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Auction End</td>
                            <td>
                                {{ $bid->jobPost->auction_end
                                    ? \Carbon\Carbon::parse($bid->jobPost->auction_end)->format('d M Y, h:i A')
                                    : 'Not Set' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Categories</td>
                            <td>
                                @foreach($bid->jobPost->categories ?? [] as $cat)
                                    <span class="badge bg-light text-dark border me-1">{{ $cat->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Bid Info --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm" style="border-radius:14px;">
                <div class="card-header border-0 py-3 px-4"
                     style="background:#f8fafc;border-radius:14px 14px 0 0;">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-hammer me-2 text-primary"></i>My Bid
                    </h6>
                </div>
                <div class="card-body p-4">

                    {{-- My Bid Amount --}}
                    <div class="text-center mb-4">
                        <div class="text-muted small mb-1">My Bid Amount</div>
                        <div class="fw-bold" style="font-size:2rem;color:#111827;">
                            ₹{{ number_format($bid->amount, 2) }}
                        </div>

                        @php
                            $lowestBid = \App\Models\JobBid::where('job_post_id', $bid->job_post_id)->min('amount');
                            $isLowest  = $bid->amount == $lowestBid;
                            $status    = $bid->jobPost ? $bid->jobPost->getRawOriginal('status') : null;
                            $isWinner  = $bid->jobPost && $bid->jobPost->assigned_to == auth()->id();
                        @endphp

                        @if($isWinner && $status === 'assigned')
                            <span class="badge bg-success mt-2 px-3 py-2">🏆 You Won This Auction!</span>
                        @elseif($isLowest)
                            <span class="badge bg-primary mt-2 px-3 py-2">
                                <i class="bi bi-arrow-down-circle me-1"></i>Lowest Bid
                            </span>
                        @endif
                    </div>

                    <table class="table table-borderless small">
                        <tr>
                            <td class="text-muted fw-semibold">Lowest Bid</td>
                            <td class="fw-bold text-success">
                                ₹{{ number_format($lowestBid, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Bid Placed</td>
                            <td>{{ $bid->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Auction Status</td>
                            <td>
                                @if($bid->jobPost && $bid->jobPost->auction_status === 'live')
                                    <span class="badge bg-success">● Live</span>
                                @elseif($bid->jobPost && $bid->jobPost->auction_status === 'closed')
                                    <span class="badge bg-secondary">Closed</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Result</td>
                            <td>
                                @if($isWinner && $status === 'assigned')
                                    <span class="badge bg-success">🏆 Won</span>
                                @elseif(in_array($status, ['assigned', 'closed', 'completed']) && !$isWinner)
                                    <span class="badge bg-secondary">Not Selected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @if($bid->message)
                        <tr>
                            <td class="text-muted fw-semibold">Note</td>
                            <td>{{ $bid->message }}</td>
                        </tr>
                        @endif
                    </table>

                    {{-- View Job Button --}}
                    @if($bid->jobPost)
                    <a href="{{ route('frontend.jobs.show', ['id' => $bid->job_post_id]) }}"
                       class="btn btn-outline-primary w-100 mt-2" target="_blank">
                        <i class="bi bi-eye me-1"></i>View Job Details
                    </a>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>
@endsection