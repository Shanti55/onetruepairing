@extends('admin-panel.layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Success/Error Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-dark fw-bold">
                <i class="bi bi-door-open-fill text-primary me-2"></i>Auction Room (Registrations)
            </h5>
            <span class="badge bg-primary-soft text-primary rounded-pill px-3">{{ $registrations->count() }} Total</span>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">User Details</th>
                            <th>Auction/Job</th>
                            <th>UTR/Transaction ID</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
                            <th>Registration Date</th>
                            <th class="text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $reg)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($reg->user->name ?? 'N/A') }}&background=random&color=fff" class="rounded-circle me-3" width="40">
                                    <div>
                                        <div class="fw-bold text-dark text-capitalize">{{ $reg->user->name ?? 'N/A' }}</div>
                                        <div class="text-muted small"><i class="bi bi-envelope me-1"></i>{{ $reg->user->email ?? 'No Email' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $reg->job->title ?? 'N/A' }}</div>
                                <span class="badge bg-light text-secondary border small">JB-{{ $reg->job_id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <code class="fw-bold text-primary bg-light px-2 py-1 rounded small">{{ $reg->transaction_id ?? 'N/A' }}</code>
                                    <button class="btn btn-sm text-muted p-0 ms-2" onclick="navigator.clipboard.writeText('{{ $reg->transaction_id }}')" title="Copy ID">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">₹{{ number_format($reg->amount, 2) }}</span>
                            </td>
                            <td>
                                @php
                                    $status = $reg->status->value ?? $reg->status;
                                    $badgeStyle = match($status) {
                                        'completed', 'complete' => 'bg-success-soft text-success border-success',
                                        'pending' => 'bg-warning-soft text-warning border-warning',
                                        'failed' => 'bg-danger-soft text-danger border-danger',
                                        default => 'bg-secondary-soft text-secondary border-secondary'
                                    };
                                @endphp
                                <span class="badge border rounded-pill px-3 {{ $badgeStyle }}">
                                    <i class="bi bi-dot me-1"></i>{{ ucfirst($status) }}
                                </span>
                            </td>
                            <td>
                                <div class="text-dark small fw-medium">{{ $reg->created_at->format('d M, Y') }}</div>
                                <div class="text-muted small" style="font-size: 0.75rem;">{{ $reg->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="text-center pe-4">
                                @if($status === 'pending')
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Approve --}}
                                        <form action="{{ route('registrations.approve', $reg->id) }}" method="POST" onsubmit="return confirm('Confirm Payment & Send Bidding Email?')">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 d-flex align-items-center shadow-sm">
                                                <i class="bi bi-check2-circle me-1"></i> Approve
                                            </button>
                                        </form>

                                        {{-- Reject --}}
                                        <form action="{{ route('registrations.reject', $reg->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this registration?')">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 d-flex align-items-center shadow-sm">
                                                <i class="bi bi-x-circle me-1"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-muted small fw-medium">
                                        <i class="bi bi-check-all text-primary me-1"></i> Processed
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox text-muted display-4"></i>
                                    <p class="mt-3 text-muted">No registrations found in the auction room.</p>
                                </div>
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
    /* Premium Soft Badges */
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-secondary-soft { background-color: rgba(108, 117, 125, 0.1); }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.01);
        transition: 0.2s;
    }
</style>
@endsection