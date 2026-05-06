@extends('frontend.layouts.app')

@section('title', ($job->title ?? 'Auction Details') . ' | CtrlF')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
.auction-detail { font-family: 'Outfit', sans-serif; background: #f8fafc; }

/* Breadcrumb */
.auc-breadcrumb {
    background: #fff;
    border-bottom: 1px solid #e5e7eb;
    padding: 10px 0;
    font-size: 13px;
}
.auc-breadcrumb a { color: #2563eb; text-decoration: none; }
.auc-breadcrumb a:hover { text-decoration: underline; }
.auc-breadcrumb .sep { color: #9ca3af; margin: 0 6px; }

/* Nav buttons */
.lot-nav-btn {
    display: inline-block;
    background: #111827;
    color: #fff !important;
    padding: 8px 18px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none !important;
    transition: opacity 0.2s;
}
.lot-nav-btn:hover { opacity: 0.8; }
.back-catalog {
    color: #2563eb;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
}
.back-catalog:hover { text-decoration: underline; }

/* Image Section */
.main-img-box {
    background: #1a1a2e;
    border-radius: 4px;
    overflow: hidden;
    aspect-ratio: 4/3;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}
.main-img-box img {
    width: 100%; height: 100%;
    object-fit: contain;
    cursor: zoom-in;
}
.img-nav-btn {
    position: absolute;
    top: 50%; transform: translateY(-50%);
    background: rgba(0,0,0,0.5);
    border: none;
    color: #fff;
    width: 36px; height: 36px;
    border-radius: 50%;
    font-size: 16px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: background 0.2s;
    z-index: 2;
}
.img-nav-btn:hover { background: rgba(0,0,0,0.8); }
.img-nav-prev { left: 10px; }
.img-nav-next { right: 10px; }

.thumb-strip { display: flex; gap: 6px; margin-top: 8px; flex-wrap: wrap; }
.thumb-item {
    width: 70px; height: 70px;
    border-radius: 4px;
    overflow: hidden;
    border: 2px solid #e5e7eb;
    cursor: pointer;
    transition: border-color 0.2s;
}
.thumb-item.active, .thumb-item:hover { border-color: #2563eb; }
.thumb-item img { width: 100%; height: 100%; object-fit: cover; }

/* Right Panel */
.detail-panel {
    background: #ffffff;
    border-radius: 6px;
     border: 1px solid #f0f2f4;
}
.detail-panel-head {
    background: #111827;
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
}
.detail-panel-head .job-title {
    color:  #111827;
    font-size: 1rem;
    font-weight: 700;
    line-height: 1.4;
    margin: 0;
}
.lot-number {
    background: rgba(255,255,255,0.1);
    color: rgba(245, 244, 244, 0.7);
    font-size: 11px;
    padding: 3px 10px;
    border-radius: 4px;
    font-weight: 600;
    white-space: nowrap;
    letter-spacing: 0.5px;
}

.detail-body { padding: 0; }

/* Status bar */
.status-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 20px;
    border-bottom: 1px solid #e5e7eb;
}
.status-badge {
    font-weight: 700;
    font-size: 14px;
}
.status-badge.completed { color: #94a3b8; }
.status-badge.live      { color: #4ade80; }
.status-badge.upcoming  { color: #fbbf24; }

.current-bid-label { color: #6b7280; font-size: 12px; }
.current-bid-val   { color:  #111827; font-size: 16px; font-weight: 800; }

/* Info table */
.info-table { width: 100%; border-collapse: collapse; }
.info-table tr { border-bottom: 1px solid rgba(255,255,255,0.06); }
.info-table tr:last-child { border-bottom: none; }
.info-table td { padding: 10px 20px; font-size: 13.5px; vertical-align: middle; }
.info-table .lbl { color: #6b7280; width: 45%; }
.info-table .val { color: #111827; font-weight: 600; text-align: right; }
.info-table .val.green  { color: #4ade80; }
.info-table .val.yellow { color: #fbbf24; }
.info-table .val.red    { color: #f87171; }

/* CTA */
.cta-box { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.08); }
.bid-btn {
    display: block; width: 100%;
    background: #2563eb;
    color: #fff;
    text-align: center;
    padding: 13px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background 0.2s;
}
.bid-btn:hover { background: #1d4ed8; color: #fff; }
.bid-btn.disabled-btn { background: #374151; cursor: not-allowed; }
.bid-note {
    text-align: center;
    color: rgba(255,255,255,0.35);
    font-size: 11px;
    margin-top: 8px;
}

/* Description section */
.desc-section {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 4px;
    padding: 1.2rem 1.4rem;
    margin-top: 12px;
}
.desc-section h6 {
    font-weight: 700;
    font-size: 13px;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
}

/* Bid table */
.bid-history {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 4px;
    overflow: hidden;
    margin-top: 12px;
}
.bid-history-head {
    background: #fff;
    padding: 10px 16px;
    color: #fff;
    font-size: 13px;
    font-weight: 700;
}
.bid-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.bid-table thead th {
    background: #f8fafc;
    padding: 9px 14px;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}
.bid-table tbody td { padding: 9px 14px; border-bottom: 1px solid #f3f4f6; color: #374151; }
.bid-table tbody tr:last-child td { border-bottom: none; }
</style>

<div class="auction-detail">

    {{-- Breadcrumb --}}
    <div class="auc-breadcrumb">
    <div class="container d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <a href="{{ route('frontend.home') }}">Home</a>
            <span class="sep">/</span>
            <a href="{{ route('frontend.jobs.index') }}">Auctions</a>
            <span class="sep">/</span>
            <span style="color:#374151;">{{ \Str::limit($job->title ?? 'Job Details', 40) }}</span>
        </div>
        <a href="{{ route('frontend.jobs.index') }}" class="back-catalog">← Back to Catalog</a>
    </div>
</div>

    {{-- Prev / Next --}}
    <div class="container d-flex justify-content-between align-items-center py-3">
        @php
            $prevJob = \App\Models\JobPost::where('id', '<', $job->id)->orderBy('id','desc')->first();
            $nextJob = \App\Models\JobPost::where('id', '>', $job->id)->orderBy('id','asc')->first();
        @endphp
        <a href="{{ $prevJob ? route('frontend.jobs.show', $prevJob->id) : '#' }}"
           class="lot-nav-btn {{ !$prevJob ? 'opacity-50' : '' }}">
            ← Prev Lot
        </a>
        <a href="{{ $nextJob ? route('frontend.jobs.show', $nextJob->id) : '#' }}"
           class="lot-nav-btn {{ !$nextJob ? 'opacity-50' : '' }}">
            Next Lot →
        </a>
    </div>

    <div class="container pb-5">
        <div class="row g-3">

            {{-- LEFT: Image --}}
            <div class="col-lg-5">
                @php
                    $media  = $job->media ?? collect();
                    $imgs   = $media->pluck('url')->filter()->values();
                    $hasImg = $imgs->count() > 0;
                @endphp

                <div class="main-img-box" id="mainImgBox">
                    @if($hasImg)
    <button class="img-nav-btn img-nav-prev" onclick="prevImg()">&#8249;</button>
    <img src="{{ asset($imgs[0]) }}" id="mainImg" alt="{{ $job->title }}">
    <button class="img-nav-btn img-nav-next" onclick="nextImg()">&#8250;</button>
@else
    <img src="https://www.avtarfabricators.com/site_data/images/glass-work-6.jpg" 
         id="mainImg" 
         alt="Default Image"
         style="object-fit:cover;">
@endif
                </div>

                {{-- Thumbnails --}}
                @if($imgs->count() > 1)
                <div class="thumb-strip" id="thumbStrip">
                    @foreach($imgs as $i => $img)
                        <div class="thumb-item {{ $i === 0 ? 'active' : '' }}"
                             onclick="setImg('{{ asset($img) }}', {{ $i }}, this)">
                            <img src="{{ asset($img) }}" alt="">
                        </div>
                    @endforeach
                </div>
                @endif

                {{-- Description --}}
                @if($job->description)
                <div class="desc-section">
                    <h6>Description</h6>
                    <p class="text-muted small mb-0" style="line-height:1.7;">
                        {{ $job->description }}
                    </p>
                </div>
                @endif

                {{-- Categories --}}
                @if($job->categories?->count())
                <div class="desc-section">
                    <h6>Categories</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($job->categories as $cat)
                            <span class="badge bg-light text-dark border" style="font-size:12px;font-weight:500;padding:6px 12px;">
                                {{ $cat->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- RIGHT: Auction Detail Panel --}}
            <div class="col-lg-7">
                <div class="detail-panel">

                    {{-- Header --}}
                    <div class="detail-panel-head">
                        <h5 class="job-title">{{ $job->title }}</h5>
                        <span class="lot-number">
                            Lot: EL#{{ str_pad($job->id, 5, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <div class="detail-body">

                       @php
    $status       = $job->status ?? 'pending';
    $auctStatus   = $job->auction_status ?? null;

    $isClosed = in_array($status, ['closed','assigned','completed']) || $auctStatus === 'closed';
    $isLive   = $auctStatus === 'live' || $status === 'open';

    $bids        = $job->bids ?? collect();
    $totalBids   = $bids->count();
    $lowestBid   = $bids->min('amount'); // ✅ reverse auction winner
@endphp

                        {{-- Status + Current Bid --}}
                        <div class="status-bar">
                            <span class="status-badge {{ $isClosed ? 'completed' : ($isLive ? 'live' : 'upcoming') }}">
                                @if($isClosed) Completed
                                @elseif($isLive) ● Live Now
                                @else Upcoming
                                @endif
                            </span>
                            <div class="text-end">
                               <div class="current-bid-label">
    {{ $isClosed ? 'Winning Bid' : 'Lowest Bid (Best Offer)' }}
</div>
                                <div class="current-bid-val">
                                    {{ $lowestBid ? '₹' . number_format($lowestBid, 2) : 'No Bids' }}
                                </div>
                            </div>
                        </div>

                        {{-- Info rows --}}
                        <table class="info-table">
                            @if($job->auction_start)
                            <tr>
                                <td class="lbl">Start Time:</td>
                                <td class="val">{{ \Carbon\Carbon::parse($job->auction_start)->format('d M Y, h:i A') }}</td>
                            </tr>
                            @endif
                            @if($job->auction_end)
                            <tr>
                                <td class="lbl">End Time:</td>
                                <td class="val">{{ \Carbon\Carbon::parse($job->auction_end)->format('d M Y, h:i A') }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="lbl">Bid Count:</td>
                                <td class="val">{{ $totalBids }}</td>
                            </tr>
                            @if($isClosed && $job->assignedVendor)
                            <tr>
                                <td class="lbl">Winning Bidder:</td>
                                <td class="val green">
                                    {{ \Str::mask($job->assignedVendor->name ?? 'N/A', '*', 2) }}
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td class="lbl">Starting Bid:</td>
                                <td class="val">₹{{ number_format($job->cost ?? 0, 2) }}</td>
                            </tr>
                           
                            <tr>
                                <td class="lbl">Location:</td>
                                <td class="val">{{ $job->city ?? $job->area ?? 'N/A' }}{{ $job->state ? ', ' . $job->state : '' }}</td>
                            </tr>
                            <tr>
                                <td class="lbl">Duration:</td>
                                <td class="val">{{ $job->duration_value ?? 'N/A' }} {{ $job->duration_type ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="lbl">Watching:</td>
                                <td class="val yellow">{{ rand(2, 15) }}</td>
                            </tr>
                            @if($isClosed)
                            <tr>
                                <td colspan="2" style="padding:10px 20px;">
                                    <div style="color:#94a3b8;font-size:13px;text-align:right;font-weight:600;">
                                        Bidding complete
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </table>

                        {{-- CTA --}}
                        <div class="cta-box">
                            @if($isClosed)
                                <div class="bid-btn disabled-btn">
                                    <i class="bi bi-lock me-2"></i>Bidding Complete
                                </div>
                                <p class="bid-note">
                                    EMD refunds processed within 4–5 working days.
                                </p>
                            @elseif($isLive)
                                @auth
                                    @php
                                        $registered = \App\Models\Payment::where('job_id', $job->id)
                                            ->where('user_id', auth()->id())
                                            ->where('payment_for','job_registration')
                                            ->where('status','complete')
                                            ->exists();
                                    @endphp
                                    @if($registered)
                                        <a href="{{ route('vendor.bids') }}" class="bid-btn">
                                            <i class="bi bi-lightning-charge me-1"></i>Place Your Bid
                                        </a>
                                    @else
                                        <a href="{{ route('job.registration.show', $job->id) }}" class="bid-btn">
                                            <i class="bi bi-pencil-square me-1"></i>Register to Bid
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('frontend.auth.service-providers.login') }}" class="bid-btn">
                                        <i class="bi bi-box-arrow-in-right me-1"></i>Login to Register
                                    </a>
                                @endauth
                            @else
                                @auth
                                    <a href="{{ route('job.registration.show', $job->id) }}" class="bid-btn"
                                       style="background:#d97706;">
                                        <i class="bi bi-alarm me-1"></i>Register for Upcoming Auction
                                    </a>
                                @else
                                    <a href="{{ route('frontend.auth.service-providers.login') }}" class="bid-btn"
                                       style="background:#d97706;">
                                        <i class="bi bi-box-arrow-in-right me-1"></i>Login to Register
                                    </a>
                                @endauth
                            @endif
                        </div>

                    </div>
                </div>

                {{-- Bid History --}}
                @if($totalBids > 0)
                <div class="bid-history">
                    <div class="bid-history-head">
                        <i class="bi bi-clock-history me-2"></i>Bid Activity
                    </div>
                    <table class="bid-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bidder</th>
                                <th>Amount</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($job->bids->sortBy('amount')->values() as $i => $bid)
<tr style="{{ $i === 0 ? 'background:#ecfdf5;' : '' }}">
    
    <td>{{ $i + 1 }}</td>

    <td>
        {{ \Str::mask($bid->vendor->name ?? 'Vendor', '*', 2) }}

        @if($i === 0)
            <span class="badge bg-success ms-1" style="font-size:10px;">
                🏆 Lowest (Winning)
            </span>
        @endif
    </td>

    <td style="font-weight:700;color:{{ $i === 0 ? '#16a34a' : '#374151' }};">
        ₹{{ number_format($bid->amount, 2) }}
    </td>

    <td style="color:#9ca3af;">
        {{ $bid->created_at->diffForHumans() }}
    </td>

</tr>
@endforeach 
                        </tbody>
                    </table>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

<script>
@php $imgList = $imgs ?? collect(); @endphp
const imgs = @json($imgList->map(fn($i) => asset($i))->values());
let current = 0;

function setImg(src, idx, el) {
    document.getElementById('mainImg').src = src;
    current = idx;
    document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
    if(el) el.classList.add('active');
}
function prevImg() {
    if(!imgs.length) return;
    current = (current - 1 + imgs.length) % imgs.length;
    document.getElementById('mainImg').src = imgs[current];
    updateThumb();
}
function nextImg() {
    if(!imgs.length) return;
    current = (current + 1) % imgs.length;
    document.getElementById('mainImg').src = imgs[current];
    updateThumb();
}
function updateThumb() {
    const thumbs = document.querySelectorAll('.thumb-item');
    thumbs.forEach((t,i) => t.classList.toggle('active', i === current));
}
</script>
@endsection