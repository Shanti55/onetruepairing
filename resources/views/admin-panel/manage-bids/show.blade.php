@extends('admin-panel.layouts.app')

@section('content')
<style>
.bid-show-page { font-family: 'Outfit', sans-serif; }

/* ── Header ── */
.bid-show-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 22px;
}
.bid-show-title {
    font-size: 19px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.bid-show-title .title-icon {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 15px;
    flex-shrink: 0;
}
.bid-show-sub {
    font-size: 13px;
    color: #94a3b8;
    margin: 3px 0 0 46px;
}
.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    background: #f8fafc;
    color: #475569;
    border: 1.5px solid #e2e8f0;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
}
.back-btn:hover { background: #f1f5f9; color: #1e293b; }

/* ── Empty ── */
.no-bids-wrap {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #f1f5f9;
    padding: 70px 20px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
}
.no-bids-wrap .nb-icon {
    width: 68px; height: 68px;
    background: #ede9fe;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px;
    margin: 0 auto 16px;
}

/* ── Bid Cards Grid ── */
.bids-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 16px;
}

/* ── Single Bid Card ── */
.bid-item-card {
    background: #fff;
    border-radius: 16px;
    border: 1.5px solid #f1f5f9;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    transition: all .22s ease;
    position: relative;
    overflow: hidden;
}
.bid-item-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.09);
    transform: translateY(-2px);
    border-color: #e0e7ff;
}
.bid-item-card.is-hired {
    border-color: #6ee7b7;
    box-shadow: 0 0 0 3px rgba(16,185,129,.08), 0 4px 16px rgba(0,0,0,0.06);
}
.bid-item-card.is-lowest {
    border-color: #fcd34d;
}

/* ── Top bar ── */
.card-top-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}
.rank-tag {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
    letter-spacing: .4px;
}
.rank-lowest { background:#fef3c7; color:#b45309; }
.rank-other  { background:#f1f5f9; color:#64748b; }
.hired-tag {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
    background: #dcfce7;
    color: #15803d;
}

/* ── Vendor ── */
.vendor-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}
.vendor-avt {
    width: 44px; height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff;
    font-weight: 800;
    font-size: 17px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.vendor-nm  { font-weight: 700; font-size: 14.5px; color: #1e293b; }
.vendor-em  { font-size: 12px; color: #94a3b8; margin-top: 1px; }

/* ── Amount Box ── */
.amount-box {
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.amount-box.normal  { background:#f0fdf4; border:1px solid #bbf7d0; }
.amount-box.lowest  { background:#fffbeb; border:1px solid #fcd34d; }
.amount-label { font-size: 11px; font-weight: 600; color: #64748b; text-transform:uppercase; letter-spacing:.5px; }
.amount-value { font-size: 20px; font-weight: 800; color: #15803d; }
.amount-box.lowest .amount-value { color: #b45309; }

/* ── Message ── */
.bid-msg {
    background: #f8fafc;
    border-left: 3px solid #c7d2fe;
    border-radius: 0 8px 8px 0;
    padding: 9px 12px;
    font-size: 13px;
    color: #475569;
    line-height: 1.6;
    margin-bottom: 14px;
}

/* ── Divider ── */
.slim-divider {
    height: 1px;
    background: #f1f5f9;
    margin: 14px 0;
}

/* ── PDF Btn ── */
.pdf-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 13px;
    background: #fee2e2;
    color: #b91c1c;
    border-radius: 7px;
    font-size: 12.5px;
    font-weight: 600;
    text-decoration: none;
    transition: background .2s;
}
.pdf-link:hover { background:#fecaca; color:#991b1b; }

/* ── Hire Button ── */
.hire-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    width: 100%;
    padding: 9px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff;
    border: none;
    border-radius: 9px;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s;
    font-family: 'Outfit', sans-serif;
}
.hire-btn:hover:not(:disabled) {
    box-shadow: 0 6px 16px rgba(99,102,241,.35);
    transform: translateY(-1px);
}
.hire-btn:disabled { opacity:.65; cursor:not-allowed; }

.hired-badge-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    width: 100%;
    padding: 9px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 700;
}

/* ── Animate ── */
.bid-item-card {
    animation: cardIn .35s ease both;
}
@for($i = 0; $i < 12; $i++)
.bid-item-card:nth-child({{ $i+1 }}) { animation-delay: {{ $i * 0.05 }}s; }
@endfor
@keyframes cardIn {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}
</style>

<div class="bid-show-page px-2">

    {{-- ── Header ── --}}
    <div class="bid-show-header">
        <div>
            <h5 class="bid-show-title">
                <span class="title-icon"><i class="bi bi-hammer"></i></span>
                {{ Str::limit($job->title, 45) }}
            </h5>
            <p class="bid-show-sub">
                {{ $bids->count() }} {{ Str::plural('bid', $bids->count()) }} received
                &nbsp;·&nbsp; EL#{{ str_pad($job->id, 5, '0', STR_PAD_LEFT) }}
            </p>
        </div>
        <a href="{{ route('admin.manage-bids.index') }}" class="back-btn">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- ── No Bids ── --}}
    @if($bids->isEmpty())
    <div class="no-bids-wrap">
        <div class="nb-icon">🔨</div>
        <h6 style="font-weight:700;color:#1e293b;">No bids yet</h6>
        <p class="text-muted small">Vendors haven't placed any bids on this job.</p>
    </div>

    {{-- ── Bids Grid ── --}}
    @else
    <div class="bids-grid">
        @foreach($bids as $bid)
        @php
            $isLowest = $loop->first;
            $isHired  = $job->assigned_to == $bid->vendor_id;
        @endphp
        <div class="bid-item-card {{ $isHired ? 'is-hired' : '' }} {{ $isLowest ? 'is-lowest' : '' }}">

            {{-- Top bar --}}
            <div class="card-top-bar">
                <span class="rank-tag {{ $isLowest ? 'rank-lowest' : 'rank-other' }}">
                    @if($isLowest) 🏆 Lowest Bid @else #{{ $loop->iteration }} @endif
                </span>
                @if($isHired)
                    <span class="hired-tag">
                        <i class="bi bi-check-circle-fill"></i> Hired
                    </span>
                @endif
            </div>

            {{-- Vendor --}}
            <div class="vendor-row">
                <div class="vendor-avt">
                    {{ strtoupper(substr($bid->vendor->name ?? 'V', 0, 1)) }}
                </div>
                <div>
                    <div class="vendor-nm">{{ $bid->vendor->name ?? '—' }}</div>
                    <div class="vendor-em">{{ $bid->vendor->email ?? '' }}</div>
                </div>
            </div>

            {{-- Amount --}}
            <div class="amount-box {{ $isLowest ? 'lowest' : 'normal' }}">
                <div>
                    <div class="amount-label">Bid Amount</div>
                    <div class="amount-value">₹{{ number_format($bid->amount, 2) }}</div>
                </div>
                <i class="bi bi-currency-rupee fs-4 opacity-25"></i>
            </div>

            {{-- Message --}}
            @if($bid->message)
            <div class="bid-msg">
                <i class="bi bi-chat-quote me-1 opacity-40"></i>{{ $bid->message }}
            </div>
            @endif

            <div class="slim-divider"></div>

            {{-- Quotation --}}
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted small fw-600">Quotation</span>
                @if($bid->attachment)
                    <a href="{{ asset('uploads/bids/' . $bid->attachment) }}" target="_blank" class="pdf-link">
                        <i class="bi bi-file-pdf-fill"></i> View PDF
                    </a>
                @else
                    <span class="text-muted small">No document</span>
                @endif
            </div>

            {{-- Action --}}
            @if($isHired)
                <div class="hired-badge-btn">
                    <i class="bi bi-check-circle-fill"></i> Vendor Hired
                </div>
            @else
                <button class="hire-btn"
                        data-job-id="{{ $job->id }}"
                        data-vendor-id="{{ $bid->vendor_id }}"
                        data-vendor-name="{{ $bid->vendor->name ?? '' }}">
                    <i class="bi bi-person-check-fill"></i> Hire This Vendor
                </button>
            @endif

        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection

@push('js')
<script>
$(function () {
    $('body').on('click', '.hire-btn', function () {
        const jobId      = $(this).data('job-id');
        const vendorId   = $(this).data('vendor-id');
        const vendorName = $(this).data('vendor-name');

        if (!confirm(`Hire "${vendorName}" for this job? This cannot be undone.`)) return;

        const $btn = $(this);
        $btn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-2"></i>Processing...');

        $.ajax({
            url  : "{{ route('admin.manage-bids.hire') }}",
            type : 'POST',
            data : { _token: "{{ csrf_token() }}", job_id: jobId, vendor_id: vendorId },
            success: function (res) {
                $btn.closest('.bid-item-card').addClass('is-hired');
                $btn.replaceWith(`
                    <div class="hired-badge-btn">
                        <i class="bi bi-check-circle-fill"></i> Vendor Hired
                    </div>`);

                // Toast
                const bg    = 'bg-success';
                const toast = $(`
                    <div class="toast align-items-center text-white ${bg} border-0 shadow"
                         role="alert" style="min-width:260px;">
                        <div class="d-flex">
                            <div class="toast-body fw-semibold">
                                <i class="bi bi-check-circle me-2"></i>
                                ${res.message ?? 'Hired successfully!'}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                    data-bs-dismiss="toast"></button>
                        </div>
                    </div>`);
                if (!$('#toast-container').length) {
                    $('body').append('<div id="toast-container" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:9999;"></div>');
                }
                $('#toast-container').append(toast);
                new bootstrap.Toast(toast[0], { delay: 3500 }).show();
                toast[0].addEventListener('hidden.bs.toast', () => toast.remove());
            },
            error: function (xhr) {
                $btn.prop('disabled', false).html('<i class="bi bi-person-check-fill"></i> Hire This Vendor');
                alert(xhr.responseJSON?.message ?? 'Something went wrong.');
            }
        });
    });
});
</script>
@endpush