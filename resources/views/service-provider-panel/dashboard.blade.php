@extends('service-provider-panel.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

    @php
    $userId = auth()->user()->id;

    // ✅ Upcoming — Live auctions jisme vendor ne register nahi kiya
    $upcomingAuctions = \App\Models\JobPost::where('auction_status', 'live')
        ->whereDoesntHave('bids', fn($q) => $q->where('vendor_id', $userId))
        ->count();

    // ✅ Active — Live auctions jisme vendor bid kar raha hai
    $activeAuctions = \App\Models\JobBid::where('vendor_id', $userId)
        ->whereHas('jobPost', fn($q) => $q->where('auction_status', 'live'))
        ->count();

    // ✅ Total — vendor ne jitne bhi auctions mein participate kiya
    $totalAuctions = \App\Models\JobBid::where('vendor_id', $userId)->count();

    // ✅ Closed — auction khatam hua but vendor hire nahi hua
    $closedAuctions = \App\Models\JobBid::where('vendor_id', $userId)
        ->whereHas('jobPost', function($q) use ($userId) {
            $q->whereIn('status', ['closed', 'assigned', 'completed'])
              ->where('assigned_to', '!=', $userId);
        })
        ->count();

    // ✅ Won — vendor hire hua (assigned)
    $wonAuctions = \App\Models\JobPost::where('assigned_to', $userId)
        ->where('status', 'assigned')
        ->count();

    // ✅ Completed — hire + kaam complete
    $completedAuctions = \App\Models\JobPost::where('assigned_to', $userId)
        ->where('status', 'completed')
        ->count();
    @endphp

    <div class="row g-3">

        {{-- Welcome Card --}}
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100"
                 style="background:linear-gradient(135deg,#1e3a8a,#2563eb);border-radius:16px;overflow:hidden;">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                    <div>
                        <p class="mb-1" style="color:rgba(255,255,255,0.7);font-size:13px;">Welcome Back</p>
                        <h5 class="fw-bold text-white mb-1">{{ auth()->user()->name }}</h5>
                        <span style="background:rgba(255,255,255,0.15);color:#fff;font-size:11px;padding:3px 10px;border-radius:20px;">
                            Service Provider
                        </span>
                    </div>
                    <img src="{{ asset('images/customer-support.png') }}" style="width:80px;opacity:0.9;" alt="">
                </div>
            </div>
        </div>

        {{-- Upcoming — Live but not registered --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('service-providers.request-job-posts.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 stat-card"
                     style="border-radius:16px;border-left:4px solid #2563eb !important;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div style="width:42px;height:42px;background:#fffbeb;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-alarm fs-5" style="color:#f59e0b;"></i>
                            </div>
                            <span style="font-size:10px;background:#fffbeb;color:#f59e0b;padding:2px 8px;border-radius:20px;font-weight:600;">
                                Register Now
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1 text-dark">{{ $upcomingAuctions }}</h3>
                        <p class="text-muted small mb-0">Upcoming — Live (Not Registered)</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Active — Bidding in live auctions --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('vendor.bids') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 stat-card"
                     style="border-radius:16px;border-left:4px solid #2563eb !important;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div style="width:42px;height:42px;background:#ecfdf5;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-broadcast fs-5" style="color:#10b981;"></i>
                            </div>
                            <span style="font-size:10px;background:#ecfdf5;color:#10b981;padding:2px 8px;border-radius:20px;font-weight:600;">
                                ● Live
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1 text-dark">{{ $activeAuctions }}</h3>
                        <p class="text-muted small mb-0">Active — Bidding Now</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Total Participated --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('vendor.bids') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 stat-card"
                     style="border-radius:16px;border-left:4px solid #2563eb !important;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div style="width:42px;height:42px;background:#f5f3ff;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-grid fs-5" style="color:#8b5cf6;"></i>
                            </div>
                            <i class="bi bi-arrow-right text-muted"></i>
                        </div>
                        <h3 class="fw-bold mb-1 text-dark">{{ $totalAuctions }}</h3>
                        <p class="text-muted small mb-0">Total Auctions Participated</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Closed — Auction ended, NOT hired --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('service-providers.my-jobs.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 stat-card"
                     style="border-radius:16px;border-left:4px solid #2563eb !important;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div style="width:42px;height:42px;background:#f9fafb;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-archive fs-5" style="color:#6b7280;"></i>
                            </div>
                            <span style="font-size:10px;background:#f9fafb;color:#6b7280;padding:2px 8px;border-radius:20px;font-weight:600;">
                                Not Selected
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1 text-dark">{{ $closedAuctions }}</h3>
                        <p class="text-muted small mb-0">Closed — Not Hired</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Won — Hired --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('service-providers.my-jobs.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 stat-card"
                     style="border-radius:16px;border-left:4px solid #2563eb !important;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div style="width:42px;height:42px;background:#fffbeb;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-trophy fs-5" style="color:#f59e0b;"></i>
                            </div>
                            <span style="font-size:10px;background:#fffbeb;color:#f59e0b;padding:2px 8px;border-radius:20px;font-weight:600;">
                                🏆 Won
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1 text-dark">{{ $wonAuctions }}</h3>
                        <p class="text-muted small mb-0">Auctions Won (Hired)</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Completed --}}
        <!-- <div class="col-lg-4 col-md-6">
            <a href="{{ route('service-providers.my-jobs.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 stat-card"
                     style="border-radius:16px;border-left:4px solid #2563eb !important;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div style="width:42px;height:42px;background:#eff6ff;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-patch-check fs-5" style="color:#2563eb;"></i>
                            </div>
                            <span style="font-size:10px;background:#eff6ff;color:#2563eb;padding:2px 8px;border-radius:20px;font-weight:600;">
                                ✅ Done
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1 text-dark">{{ $completedAuctions }}</h3>
                        <p class="text-muted small mb-0">Completed Auctions</p>
                    </div>
                </div>
            </a>
        </div> -->

    </div>
</div>

<style>
.stat-card { transition: transform 0.2s, box-shadow 0.2s; }
.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.10) !important;
}
</style>
@endsection