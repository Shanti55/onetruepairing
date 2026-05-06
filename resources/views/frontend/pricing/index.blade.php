@extends('frontend.layouts.app')

@section('title', 'Pricing | CtrlF')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=Outfit:wght@300;400;500;600&display=swap');

:root {
    --ink: #111827;
    --surface: #f9fafb;
    --card-bg: #ffffff;
    --muted: #6b7280;
    --border: #e5e7eb;
    --accent: #1d4ed8;
}

.pricing-wrap { font-family: 'Outfit', sans-serif; background: var(--surface); }

/* ─── HERO ─── */
.p-hero {
    background: #1d4ed8;
    padding: 4rem 0 6rem;
    position: relative;
    overflow: hidden;
}
.p-hero-grid {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
    background-size: 48px 48px;
    padding-top: ;
}
.p-eyebrow {
    display: inline-block;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 100px;
    padding: 5px 18px;
    font-size: 11px; font-weight: 600;
    letter-spacing: 2px; text-transform: uppercase;
    color: rgba(255,255,255,0.6);
    margin-bottom: 1.2rem;
}
.p-hero h1 {
    font-family: 'Outfit', sans-serif; /* Clean and modern font */
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    color: #ffffff; /* Dark gray/black for that clean look */
    line-height: 1.1;
    margin-bottom: 1.2rem;
    letter-spacing: -0.03em; /* Sharp look ke liye letters thode pass */
    text-transform: none; 
    padding-top: 80px;/* Pricing jesa natural look */
}
.p-hero h1 em { font-style: normal; color: #dcdee3; }
.p-hero p { color: rgba(255,255,255,0.45); font-size: 15px; max-width: 440px; }

/* ─── PLANS ─── */
.plans-grid { margin-top: -3rem; padding-bottom: 4rem; }

.plan-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--border);
    padding: 2rem;
    height: 100%;
    transition: box-shadow 0.25s, border-color 0.25s;
}
.plan-card:hover {
    box-shadow: 0 8px 32px rgba(35, 69, 240, 0.08);
    border-color: #d1d5db;
}
.plan-card.featured {
    border-color: var(--accent);
    box-shadow: 0 8px 32px rgba(29,78,216,0.1);
}
.plan-featured-badge {
    display: inline-block;
    background: var(--accent);
    color: #fff;
    font-size: 10px; font-weight: 700;
    letter-spacing: 1px; text-transform: uppercase;
    padding: 3px 12px; border-radius: 100px;
    margin-bottom: 12px;
}
.plan-name {
    font-family: 'Syne', sans-serif;
    font-size: 1.2rem; font-weight: 200;
    color: var(--ink); margin-bottom: 2px;
}
.plan-code { font-size: 12px; color: var(--muted); letter-spacing: 0.5px; }
.plan-divider { height: 1px; background: var(--border); margin: 1rem 0; }

.plan-price-row { display: flex; align-items: baseline; gap: 3px; margin-bottom: 4px; }
.plan-price-row .currency { font-size: 1rem; color: var(--muted); }
.plan-price-row .amount {
    /* Font family change karein */
    font-family: 'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; 
    
    /* Font weight ko bhi thoda kam kar sakte hain agar zyada bold lag raha ho */
    font-weight: 700; 
    
    font-size: 2.4rem;
    color: var(--ink);
    line-height: 1;
}
.plan-price-row .period { font-size: 13px; color: var(--muted); }
.plan-yearly { font-size: 12px; color: var(--muted); margin-bottom: 1.4rem; }
.plan-yearly strong { color: #15803d; }

.feat-item {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 7px 0; font-size: 13.5px; color: #374151;
    border-bottom: 1px solid #f3f4f6;
}
.feat-item:last-child { border-bottom: none; }
.feat-tick {
    width: 18px; height: 18px; border-radius: 50%;
    background: #f0fdf4; border: 1px solid #bbf7d0;
    flex-shrink: 0; display: flex; align-items: center; justify-content: center;
    margin-top: 2px;
}
.feat-tick i { font-size: 10px; color: #16a34a; }

.plan-btn {
    display: block; width: 100%; text-align: center;
    padding: 12px; border-radius: 10px;
    font-weight: 600; font-size: 14px;
    text-decoration: none;
    transition: all 0.2s; cursor: pointer;
    font-family: 'Outfit', sans-serif;
    border: 1.5px solid var(--ink);
    color: var(--ink); background: transparent;
}
.plan-btn:hover { background: var(--ink); color: #fff; }
.plan-btn.primary-btn { background: var(--accent); border-color: var(--accent); color: #fff; }
.plan-btn.primary-btn:hover { background: #1e40af; border-color: #1e40af; color: #fff; }

/* ─── EMD SECTION ─── */
.emd-wrap { padding: 4rem 0 5rem; background: var(--surface); }

.section-label {
    font-size: 11px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase;
    color: var(--muted); margin-bottom: 8px;
}
.section-h2 {
    /* Outfit font pricing table se match karta hai */
    font-family: 'Outfit', sans-serif; 
    /* Size ko thoda improve kiya taaki subheadings clear dikhein */
    font-size: clamp(1.75rem, 3vw, 2.25rem); 
    font-weight: 700; 
    color: #481df2; /* Professional dark shade */
    line-height: 1.2;
    margin-bottom: 12px; /* Spacing thodi badhayi hai cleaner look ke liye */
    letter-spacing: -0.01em;
    text-transform: capitalize;
}

/* Card */
.pro-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid var(--border);
    overflow: hidden;
}
.pro-card-head {
    background: #1049c5;
    padding: 14px 20px;
    display: flex; align-items: center; gap: 8px;
}
.pro-card-head-title {
    color: #fff; font-weight: 600;
    font-size: 13.5px;
}
.pro-card-head i { color: rgba(255,255,255,0.5); font-size: 14px; }

/* EMD Table */
.emd-tbl { width: 100%; font-size: 13.5px; border-collapse: collapse; }
.emd-tbl thead th {
    background: #1d4ed8;
    color: rgba(255,255,255,0.6);
    font-size: 10.5px; letter-spacing: 1.5px;
    text-transform: uppercase; font-weight: 600;
    padding: 11px 18px; border: none; text-align: right;
}
.emd-tbl thead th:first-child { text-align: left; }
.emd-tbl tbody tr { border-bottom: 1px solid #f3f4f6; }
.emd-tbl tbody tr:hover { background: #f9fafb; }
.emd-tbl td {
    padding: 10px 18px;
    text-align: right;
    color: var(--ink);
    font-size: 13.5px;
}
.emd-tbl td:first-child { text-align: left; font-weight: 500; }
.emd-tbl .val-emd  { color: #1d4ed8; font-weight: 600; }
.emd-tbl .val-plat { color: var(--muted); }
.emd-tbl .val-tot  { font-weight: 700; color: var(--ink); }

.pro-card-foot {
    background: #f9fafb;
    border-top: 1px solid var(--border);
    padding: 11px 18px;
    font-size: 12px; color: var(--muted);
}

/* Refund Policy */
.refund-row {
    display: flex; gap: 14px;
    padding: 16px 20px;
    border-bottom: 1px solid #f3f4f6;
}
.refund-row:last-child { border-bottom: none; }
.refund-ico {
    width: 36px; height: 36px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
    background: #f3f4f6;
}
.refund-t {
    font-size: 15px; font-weight: 700;
    color: var(--ink); margin-bottom: 3px;
}
.refund-p { font-size: 12.5px; color: var(--muted); line-height: 1.6; margin: 0; }

/* CTA strip */
.cta-strip {
    background: #1d4ed8;
    border-radius: 14px;
    padding: 2rem 2.5rem;
    margin-top: 3rem;
}
.cta-strip h4 {
    /* Font change to match pricing style */
    font-family: 'Outfit', sans-serif; 
    
    /* Size increase for better visibility */
    font-size: clamp(1.5rem, 2.5vw, 2rem); 
    
    /* Weight and letter spacing for premium feel */
    font-weight: 700; 
    color: #ffffff; 
    margin-bottom: 8px;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.cta-strip p { color: rgba(251, 247, 247, 0.45); margin: 0; font-size: 14px; }
.cta-strip-btn {
    display: inline-block;
    background: #fff; color: #111827;
    padding: 12px 28px; border-radius: 100px;
    font-weight: 700; font-size: 14px;
    text-decoration: none; transition: opacity 0.2s;
}
.cta-strip-btn:hover { opacity: 0.88; color: #2064f8; }

@media(max-width:768px) {
    .plan-card.featured { transform: none; }
    .cta-strip { padding: 1.5rem; }
}
</style>

<div class="pricing-wrap">

{{-- ── HERO ── --}}
<div class="p-hero">
    <div class="p-hero-grid"></div>
    <div class="p-hero-glow p-hero-glow-1"></div>
    <div class="p-hero-glow p-hero-glow-2"></div>
    <div class="container position-relative text-center" style="z-index:2;">
       
        <h1>Choose Your Plan.<br><em>Grow Your Business.</em></h1>
        <p class="mx-auto">No hidden charges. Pay only for what you use. Cancel anytime.</p>
    </div>
</div>

{{-- ── SUBSCRIPTION PLANS ── --}}
<div class="container plans-grid" style="position:relative;z-index:2;">
    @php
        $plans = \App\Models\SubscriptionPlan::where('status','active')->get();
    @endphp

    <div class="row gy-4 justify-content-center">
        @if(isset($plans) && $plans->count())
            @foreach($plans as $i => $plan)
            @php
                $isFeatured = ($i === 1 || $plans->count() === 1);
                $features   = json_decode($plan->features ?? '[]');
            @endphp
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                <div class="plan-card {{ $isFeatured ? 'featured' : '' }}">

                    @if($isFeatured)
                        <span class="plan-featured-badge">Most Popular</span>
                    @endif

                    {{-- Existing plan status badge --}}
                    @if(isset(auth()->user()->subscriptionPlan) && auth()->user()->subscriptionPlan->subscription_plan_id == $plan->id)
                        <div class="mb-2">
                            <span class="badge {{ auth()->user()->subscriptionPlan->active_status_formatted == 'expired' ? 'bg-danger' : 'bg-warning text-dark' }} rounded-pill px-3">
                                {{ ucwords(str_replace('_',' ',auth()->user()->subscriptionPlan->status->value)) }}
                                {{ ucfirst(auth()->user()->subscriptionPlan->active_status_formatted) }}
                            </span>
                        </div>
                    @endif

                    <div class="plan-name">{{ $plan->name }}</div>
                    <div class="plan-code">{{ $plan->plan_id }}</div>
                    <div class="plan-divider"></div>

                    {{-- Price --}}
                    <div class="plan-price-row">
                        <span class="currency">₹</span>
                        <span class="amount">{{ number_format(floor($plan->price)) }}</span>
                        <span class="period">/mo</span>
                    </div>
                    @if($plan->yearly_price)
                    <div class="plan-yearly">
                        <strong>₹{{ number_format(floor($plan->yearly_price)) }}/year</strong>
                        @if($plan->price > 0)
                        — save {{ round((($plan->price * 12 - $plan->yearly_price) / ($plan->price * 12)) * 100) }}%
                        @endif
                    </div>
                    @endif

                    {{-- Features --}}
                    @if($features && count($features) > 0)
                    <div class="mb-4">
                        @foreach($features as $feat)
                        <div class="feat-item">
                            <div class="feat-tick"><i class="bi bi-check"></i></div>
                            <span>{{ $feat }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- CTA Button --}}
                    @if(isset(auth()->user()->subscriptionPlan) && auth()->user()->subscriptionPlan->subscription_plan_id == $plan->id)
                        <a href="javascript:void(0)"
                           class="plan-btn {{ $isFeatured ? 'gold' : '' }} purchasePlanModal"
                           data-id="{{ $plan->id }}"
                           data-monthly="{{ round($plan->price) }}"
                           data-yearly="{{ round($plan->yearly_price) }}">
                            Renew / Upgrade
                        </a>
                        <p class="text-center small text-muted mt-2">
                            {{ auth()->user()->subscriptionPlan->active_status_formatted == 'active' ? 'Expires' : 'Expired' }}
                            on {{ auth()->user()->subscriptionPlan->end_date }}
                        </p>
                    @elseif(isset(auth()->user()->subscriptionPlan))
                        <a href="javascript:void(0)"
                           class="plan-btn {{ $isFeatured ? 'gold' : '' }} purchasePlanModal"
                           data-id="{{ $plan->id }}"
                           data-monthly="{{ $plan->price }}"
                           data-yearly="{{ $plan->yearly_price }}">
                            Switch to This Plan
                        </a>
                    @else
                        <a href="javascript:void(0)"
                           class="plan-btn {{ $isFeatured ? 'gold' : '' }} subscribeModal"
                           data-id="{{ $plan->id }}">
                            Start Free Trial →
                        </a>
                        <p class="text-center small text-muted mt-2">Free for 3 months</p>
                    @endif

                </div>
            </div>
            @endforeach
        @else
            <div class="col-12 text-center py-5">
                <i class="bi bi-box-seam fs-1 text-muted d-block mb-3"></i>
                <p class="text-muted">No plans available. Check back soon.</p>
            </div>
        @endif
    </div>
</div>

{{-- ── EMD & REFUND SECTION ── --}}
<div class="emd-wrap">
    <div class="container">

        <div class="text-center mb-5" data-aos="fade-up">
            
            <h2 class="section-h2">EMD & Platform Fee Structure</h2>
            <p class="text-muted" style="max-width:500px;margin:0 auto;font-size:15px;">
                EMD is <strong>10% of project value</strong> (refundable).
                Platform Fee is <strong>1% of EMD</strong> (non-refundable).
                Calculated automatically at registration.
            </p>
        </div>

        <div class="row g-4">

            {{-- Table --}}
            <div class="col-lg-12" data-aos="fade-right">
                <div class="glass-card">
                   
                    <div class="table-responsive">
                        <table class="emd-tbl">
                            <thead>
                                <tr>
                                    <th style="text-align:left;">Project Value</th>
                                    <th>EMD (10%)</th>
                                    <th>Platform (1%)</th>
                                    <th>Total Payable</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $rows = [
                                    [10000,1000,10,1010],[25000,2500,25,2525],
                                    [50000,5000,50,5050],[75000,7500,75,7575],
                                    [100000,10000,100,10100],[200000,20000,200,20200],
                                    [300000,30000,300,30300],[500000,50000,500,50500],
                                    [750000,75000,750,75750],[1000000,100000,1000,101000],
                                    [2500000,250000,2500,252500],[5000000,500000,5000,505000],
                                    [10000000,1000000,10000,1010000],
                                ];
                                @endphp
                                @foreach($rows as $r)
                                <tr>
                                    <td>₹{{ number_format($r[0]) }}</td>
                                    <td class="val-emd">₹{{ number_format($r[1]) }}</td>
                                    <td class="val-plat">₹{{ number_format($r[2]) }}</td>
                                    <td class="val-tot">₹{{ number_format($r[3]) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>

            {{-- Refund Policy --}}
            <div class="col-lg-5" data-aos="fade-left">
                <div class="glass-card h-100" style="display:flex;flex-direction:column;">
                    <div class="gc-head">
                        <i class="bi bi-shield-check gc-head-icon"></i>
                        <span class="gc-head-title">Refund Policy</span>
                    </div>
                    <div class="refund-wrap" style="flex:1;">
                        <div class="refund-row s">
                      
                            <div>
                                <div class="refund-t s">Full Refund — Bid Unsuccessful</div>
                                <p class="refund-p">Didn't win the auction? Your full EMD is returned within 7 working days. Zero deductions.</p>
                            </div>
                        </div>
                        <div class="refund-row w">
                           
                            <div>
                                <div class="refund-t w">EMD Adjusted — Winner, Job Completed</div>
                                <p class="refund-p">Won and delivered? EMD adjusts against final settlement. Only platform fee is retained.</p>
                            </div>
                        </div>
                        <div class="refund-row d">
                         
                            <div>
                                <div class="refund-t d">No Refund — Job Abandoned</div>
                                <p class="refund-p">Winning then abandoning forfeits your EMD entirely. Protects clients from dropouts.</p>
                            </div>
                        </div>
                        <div class="refund-row d">
                            
                            <div>
                                <div class="refund-t d">No Refund — Withdrawn After Live</div>
                                <p class="refund-p">Pulling out after auction goes live forfeits your EMD. Only register if you intend to bid.</p>
                            </div>
                        </div>
                    </div>
                    <div class="gc-foot">
                        <i class="bi bi-clock me-1 text-primary"></i>
                        Refunds: 5–7 working days. Disputes must be raised within 48 hours of closure.
                    </div>
                </div>
            </div>

        </div>

        {{-- CTA Strip --}}
        <div class="cta-strip" data-aos="fade-up">
            <div class="row align-items-center g-3 position-relative" style="z-index:2;">
                <div class="col-lg-8">
                    <h4>Questions about pricing or registration fees?</h4>
                    <p>Our team is available 24/7. We'll help you pick the right plan and walk you through the fee structure.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('frontend.contact') }}" class="cta-strip-btn">
                        Talk to Us →
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

</div>

@include('frontend.pricing._subscribe-modal')
@include('frontend.pricing._purchase-plan-modal')

@endsection

@push('js')
<script type="module">
$(function () {
    $('body').on('click', '.subscribeModal', function (e) {
        e.preventDefault();
        $('#subscription-plan').val($(this).data('id')).trigger('change');
        $('#subscribeModal').modal('show');
    });

    $('#subscribeForm').on('submit', function (e) {
        e.preventDefault();
        $.easyAjax({
            url: "{{ route('subscriptions.purchase') }}",
            container: '#subscribeForm', type: "POST",
            disableButton: true, blockUI: true,
            data: new FormData(this),
            onComplete: () => { $('#subscribeModal').modal('hide'); $('#subscribeForm').trigger("reset"); }
        });
    });

    $('body').on('click', '.purchasePlanModal', function (e) {
        e.preventDefault();
        $('#purchase-plan').val($(this).data('id')).trigger('change');
        $('#monthly-amt').text($(this).data('monthly'));
        $('#yearly-amt').text($(this).data('yearly'));
        $('#plan-id').val($(this).data('id'));
        $('#purchasePlanModal').modal('show');
    });

    $('#purchasePlanForm').on('submit', function (e) {
        e.preventDefault();
        $.easyAjax({
            url: "{{ route('payment.requests') }}",
            container: '#purchasePlanForm', type: "POST",
            disableButton: true, blockUI: true,
            data: new FormData(this), file: true,
            onComplete: () => { $('#purchasePlanModal').modal('hide'); $('#purchasePlanForm').trigger("reset"); }
        });
    });

    $('#billing-purchase').on('change', function () {
        if ($(this).val() == 'yearly') {
            $('#div-monthly').hide(); $('#div-yearly').show();
        } else {
            $('#div-yearly').hide(); $('#div-monthly').show();
        }
    });
});
</script>
@endpush