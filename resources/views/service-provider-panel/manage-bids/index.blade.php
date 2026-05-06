@extends('service-provider-panel.layouts.app')

@section('title', 'Manage Bids')

@section('content')
<div class="px-3">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-semibold mb-0">
            <i class="bi bi-hammer me-2 text-primary"></i>Manage Bids
        </h5>
    </div>

    {{-- Stats Row --}}
    @php
        $userId     = auth()->id();
        $totalBids  = \App\Models\JobBid::where('vendor_id', $userId)->count();
        $lowestBids = \App\Models\JobBid::where('vendor_id', $userId)
            ->whereRaw('amount = (SELECT MIN(b2.amount) FROM job_bids b2 WHERE b2.job_post_id = job_bids.job_post_id)')
            ->count();
        $wonBids    = \App\Models\JobPost::where('assigned_to', $userId)->count();
    @endphp

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3" style="border-left:4px solid #8b5cf6;border-radius:12px;">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:42px;height:42px;background:#f5f3ff;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-hammer" style="color:#8b5cf6;font-size:18px;"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5">{{ $totalBids }}</div>
                        <div class="text-muted small">Total Bids Placed</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3" style="border-left:4px solid #10b981;border-radius:12px;">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:42px;height:42px;background:#ecfdf5;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-arrow-down-circle" style="color:#10b981;font-size:18px;"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5">{{ $lowestBids }}</div>
                        <div class="text-muted small">Lowest Bids</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3" style="border-left:4px solid #f59e0b;border-radius:12px;">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:42px;height:42px;background:#fffbeb;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-trophy" style="color:#f59e0b;font-size:18px;"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5">{{ $wonBids }}</div>
                        <div class="text-muted small">Auctions Won</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bids Table --}}
    <div class="card border-0 shadow-sm" style="border-radius:14px;overflow:hidden;">
        <div class="table-responsive">
            <table id="manage-bids-table" class="table table-hover align-middle mb-0">
                <thead style="background:#f8f9fc;">
                    <tr>
                        <th class="px-3 py-3">#</th>
                        <th class="py-3">Job ID</th>
                        <th class="py-3">Job Title</th>
                        <th class="py-3">My Bid</th>
                        <th class="py-3">Lowest Bid</th>
                        <th class="py-3">Auction Status</th>
                        <th class="py-3">Result</th>
                        <th class="py-3">Bid Time</th>
                        <th class="py-3">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('js')
<script type="module">
$(function () {
    $('#manage-bids-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('vendor.bids') }}",
        order: [[7, 'desc']],
        columns: [
            { data: 'DT_RowIndex',     name: 'DT_RowIndex',     orderable: false },
            { data: 'job_id',          name: 'job_id',           orderable: false },
            { data: 'job_title',       name: 'job_title',        orderable: false },
            { data: 'my_bid',          name: 'my_bid',           orderable: false },
            { data: 'lowest_bid',      name: 'lowest_bid',       orderable: false },
            { data: 'auction_status',  name: 'auction_status',   orderable: false },
            { data: 'result',          name: 'result',           orderable: false },
            { data: 'created_at',      name: 'created_at' },
            { data: 'action',          name: 'action',           orderable: false },
        ],
    });
});
</script>
@endpush