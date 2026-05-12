@extends('admin-panel.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>
.dash-wrap { font-family: 'Outfit', sans-serif; }
.stat-card {
    background: #fff; border-radius: 16px; border: 1px solid #e5e7eb;
    padding: 1.4rem; height: 100%; transition: transform 0.2s, box-shadow 0.2s;
    text-decoration: none; display: block; color: inherit;
}
.stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.09); color: inherit; }
.stat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; margin-bottom: 1rem;
}
.stat-count { font-size: 2rem; font-weight: 800; line-height: 1; margin-bottom: 4px; color: #111827; }
.stat-label { font-size: 13px; color: #6b7280; font-weight: 500; }
.stat-arrow { color: #d1d5db; font-size: 14px; }
.section-title {
    font-size: 13px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
    color: #9ca3af; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;
}
.section-title::after { content: ''; flex: 1; height: 1px; background: #e5e7eb; }
</style>

<div class="dash-wrap px-3">
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Admin Dashboard</h4>
        <p class="text-muted small mb-0">{{ now()->format('l, d F Y') }}</p>
    </div>

    @php
        $now = now();

        $adminCounts           = \App\Models\User::where('role','admin')->count();
        $serviceProviderCounts = \App\Models\User::where('role','service-provider')->count();
        $userCounts            = \App\Models\User::where('role','user')->count();

        // ✅ Upcoming — auction_status = 'pending' (matches table filter)
        $newJobCounts = \App\Models\JobPost::where('auction_status','pending')->count();

        // ✅ Under Verification — closed auction, not yet assigned
        $underVerifyCounts = \App\Models\JobPost::where('auction_status','closed')
                                ->whereNull('assigned_to')
                                ->where('status','under verification')
                                ->count();

        // ✅ Live — auction_status = 'open' AND auction_end > now (not expired)
        $liveAuctionCounts = \App\Models\JobPost::where('auction_status','open')
                                ->where('auction_end', '>', $now)
                                ->count();

        // ✅ Closed / Hired — assigned_to set hai
        $closedAuctionCounts = \App\Models\JobPost::where('auction_status','closed')
                                ->whereNotNull('assigned_to')
                                ->where('status','assigned')
                                ->count();

        // ✅ Completed
        $completedCounts = \App\Models\JobPost::where('status','completed')->count();

        $totalBids          = \App\Models\JobBid::count();
        $totalRegistrations = \App\Models\Payment::where('payment_for','job_registration')
                                ->where('status','complete')->count();
        $pendingRefunds     = \App\Models\Payment::where('refund_status','pending')->count();
    @endphp

    <div class="row g-3 mb-2">
        {{-- Welcome --}}
        <div class="col-lg-4 col-md-6">
            <div style="background:linear-gradient(135deg,#111827,#1e3a8a);border-radius:16px;padding:1.5rem;height:100%;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <p style="color:rgba(255,255,255,0.55);font-size:13px;margin-bottom:6px;">Welcome Back</p>
                    <h5 style="color:#fff;font-weight:800;margin-bottom:8px;">{{ auth()->user()->name }}</h5>
                    <span style="background:rgba(255,255,255,0.12);color:rgba(255,255,255,0.8);font-size:11px;padding:4px 12px;border-radius:20px;font-weight:600;">Administrator</span>
                </div>
                <img src="{{ asset('images/customer-support.png') }}" style="width:75px;opacity:0.85;" alt="">
            </div>
        </div>

        {{-- Total Admins --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('admins.index') }}" class="stat-card" style="border-left:4px solid #2563eb;">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-icon" style="background:#eef2ff;"><i class="bi bi-shield-check" style="color:#6366f1;"></i></div>
                    <i class="bi bi-arrow-right stat-arrow"></i>
                </div>
                <div class="stat-count">{{ $adminCounts }}</div>
                <div class="stat-label">Total Admins</div>
            </a>
        </div>

        {{-- Service Providers --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('serviceproviders.index') }}" class="stat-card" style="border-left:4px solid #2563eb;">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-icon" style="background:#f0f9ff;"><i class="bi bi-people" style="color:#0ea5e9;"></i></div>
                    <i class="bi bi-arrow-right stat-arrow"></i>
                </div>
                <div class="stat-count">{{ $serviceProviderCounts }}</div>
                <div class="stat-label">Service Providers</div>
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        {{-- Total Users --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('users.index') }}" class="stat-card" style="border-left:4px solid #2563eb;">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-icon" style="background:#ecfdf5;"><i class="bi bi-person" style="color:#10b981;"></i></div>
                    <i class="bi bi-arrow-right stat-arrow"></i>
                </div>
                <div class="stat-count">{{ $userCounts }}</div>
                <div class="stat-label">Total Users</div>
            </a>
        </div>

        {{-- Total Bids --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('admin.manage-bids.index') }}" class="stat-card" style="border-left:4px solid #2563eb;">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-icon" style="background:#fffbeb;"><i class="bi bi-hammer" style="color:#f59e0b;"></i></div>
                    <i class="bi bi-arrow-right stat-arrow"></i>
                </div>
                <div class="stat-count">{{ $totalBids }}</div>
                <div class="stat-label">Total Bids Placed</div>
            </a>
        </div>

        {{-- Paid Registrations --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('admin.auction.room') }}" class="stat-card" style="border-left:4px solid #2563eb;">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-icon" style="background:#f5f3ff;"><i class="bi bi-receipt" style="color:#8b5cf6;"></i></div>
                    <i class="bi bi-arrow-right stat-arrow"></i>
                </div>
                <div class="stat-count">{{ $totalRegistrations }}</div>
                <div class="stat-label">Paid Registrations</div>
            </a>
        </div>
    </div>

    <div class="section-title">Auctions Progress</div>

    <div class="row g-3 mb-4">

        {{-- Upcoming --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('job-posts.index') }}?status=upcoming" class="stat-card" style="border-left:4px solid #3b82f6;">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-icon" style="background:#eff6ff;">
                        <i class="bi bi-briefcase" style="color:#3b82f6;"></i>
                    </div>
                    <span style="font-size:10px;background:#eff6ff;color:#3b82f6;padding:2px 8px;border-radius:20px;font-weight:600;">Upcoming</span>
                </div>
                <div class="stat-count">{{ $newJobCounts }}</div>
                <div class="stat-label">Upcoming Auctions</div>
            </a>
        </div>

        {{-- Under Verification --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('job-posts.index') }}?status=under_verification" class="stat-card" style="border-left:4px solid #f59e0b;">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-icon" style="background:#fffbeb;">
                        <i class="bi bi-hourglass-split" style="color:#f59e0b;"></i>
                    </div>
                    <span style="font-size:10px;background:#fffbeb;color:#f59e0b;padding:2px 8px;border-radius:20px;font-weight:600;">Pending</span>
                </div>
                <div class="stat-count">{{ $underVerifyCounts }}</div>
                <div class="stat-label">Under Verification</div>
            </a>
        </div>

        {{-- Live ── only non-expired --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('job-posts.index') }}?status=live" class="stat-card" style="border-left:4px solid #10b981;">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-icon" style="background:#ecfdf5;">
                        <i class="bi bi-broadcast" style="color:#10b981;"></i>
                    </div>
                    <span style="font-size:10px;background:#ecfdf5;color:#10b981;padding:2px 8px;border-radius:20px;font-weight:600;">● Live</span>
                </div>
                <div class="stat-count">{{ $liveAuctionCounts }}</div>
                <div class="stat-label">Live Auctions</div>
            </a>
        </div>

        {{-- Closed / Hired --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('job-posts.index') }}?status=closed" class="stat-card" style="border-left:4px solid #6b7280;">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-icon" style="background:#f9fafb;">
                        <i class="bi bi-archive" style="color:#6b7280;"></i>
                    </div>
                    <span style="font-size:10px;background:#f9fafb;color:#6b7280;padding:2px 8px;border-radius:20px;font-weight:600;">Closed</span>
                </div>
                <div class="stat-count">{{ $closedAuctionCounts }}</div>
                <div class="stat-label">Closed (Hired)</div>
            </a>
        </div>

        {{-- Completed --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('job-posts.index') }}?status=completed" class="stat-card" style="border-left:4px solid #2563eb;">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-icon" style="background:#eff6ff;">
                        <i class="bi bi-patch-check" style="color:#2563eb;"></i>
                    </div>
                    <span style="font-size:10px;background:#eff6ff;color:#2563eb;padding:2px 8px;border-radius:20px;font-weight:600;">Done</span>
                </div>
                <div class="stat-count">{{ $completedCounts }}</div>
                <div class="stat-label">Completed Auctions</div>
            </a>
        </div>

        {{-- Pending Refunds --}}
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('billing.payments.index') }}?refund=pending" class="stat-card" style="border-left:4px solid #dc2626;">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-icon" style="background:#fef2f2;">
                        <i class="bi bi-arrow-counterclockwise" style="color:#dc2626;"></i>
                    </div>
                    <span style="font-size:10px;background:#fef2f2;color:#dc2626;padding:2px 8px;border-radius:20px;font-weight:600;">Pending</span>
                </div>
                <div class="stat-count">{{ $pendingRefunds }}</div>
                <div class="stat-label">Pending Refunds</div>
            </a>
        </div>

    </div>
</div>
@endsection