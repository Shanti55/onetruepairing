@extends('service-provider-panel.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-primary mb-0">🏆 My Bidding Activity</h4>
            <p class="text-muted small">Monitor your ranks and improve your bids in real-time.</p>
        </div>
        <span class="badge bg-dark p-2">
            <i class="bi bi-broadcast text-danger me-1"></i> Live Auction
        </span>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0"> {{-- Removed padding for flush table look --}}
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Job Details</th>
                            <th>Lowest Bid (All)</th>
                            <th>Your Latest Bid</th>
                            <th>Savings</th>
                            <th>Status & Rank</th>
                            <th>Bid Date</th>
                            <th class="text-end pe-4">Action</th> {{-- Added Action --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bids as $index => $bid)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td>
                                <span class="fw-bold text-dark d-block">{{ $bid->jobPost->title ?? '-' }}</span>
                                <span class="badge bg-light text-secondary border extra-small">ID: #{{ $bid->job_post_id }}</span>
                            </td>
                            
                            <td class="text-primary fw-bold">
                                ₹{{ number_format($bid->lowest_bid ?? 0) }}
                            </td>

                            <td class="fw-bold text-dark">
                                ₹{{ number_format($bid->amount) }}
                            </td>

                            <td>
                                @if($bid->previous_amount && $bid->previous_amount > $bid->amount)
                                    <span class="text-success small fw-medium">
                                        <i class="bi bi-arrow-down-circle-fill"></i> 
                                        Dropped ₹{{ number_format($bid->previous_amount - $bid->amount) }}
                                    </span>
                                @else
                                    <span class="text-muted small">First Bid</span>
                                @endif
                            </td>

                            <td>
                                @if($bid->rank == 1)
                                    <div class="badge rounded-pill bg-success-soft text-success border border-success px-3 py-2">
                                        <i class="bi bi-trophy-fill me-1"></i> Rank #1 (Leading)
                                    </div>
                                @else
                                    <div class="badge rounded-pill bg-danger-soft text-danger border border-danger px-3 py-2">
                                        <i class="bi bi-person-dash-fill me-1"></i> Rank #{{ $bid->rank }}
                                    </div>
                                    <div class="mt-1 extra-small text-muted italic">Reduce price to lead</div>
                                @endif
                            </td>

                            <td>
                                <div class="text-dark small">{{ $bid->created_at->format('d M, Y') }}</div>
                                <div class="text-muted extra-small">{{ $bid->created_at->format('h:i A') }}</div>
                            </td>

                            <td class="text-end pe-4">
                                {{-- Quick Re-bid link: Ye vendor ko wapis job details par le jayega --}}
                                <a href="{{ url('/service-provider/jobs/requests?job_id='.$bid->job_post_id) }}" 
                                   class="btn btn-sm {{ $bid->rank == 1 ? 'btn-outline-success' : 'btn-primary' }}">
                                   {{ $bid->rank == 1 ? 'Update' : 'Beat Lowest' }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-emoji-frown display-4 text-muted"></i>
                                <p class="text-muted mt-2">You haven't placed any bids yet.</p>
                                <a href="{{ route('service-provider.jobs') }}" class="btn btn-primary btn-sm mt-2">Browse Live Jobs</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: #e8fadf; }
    .bg-danger-soft { background-color: #fceaea; }
    .extra-small { font-size: 0.7rem; }
    .text-gradient {
        background: linear-gradient(45deg, #1a2a6c, #b21f1f, #fdbb2d);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .italic { font-style: italic; }
</style>
@endsection