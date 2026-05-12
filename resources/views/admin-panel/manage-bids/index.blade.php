@extends('admin-panel.layouts.app')

@section('content')
<style>
/* ── Uses same Outfit font as admin panel ── */
.bids-page { font-family: 'Outfit', sans-serif; }

/* ── Page Header ── */
.bids-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 10px;
}
.bids-page-title {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.bids-page-title .title-icon {
    width: 38px; height: 38px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 16px;
}

/* ── Stat Cards ── */
.bid-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 20px;
}
@media(max-width:768px) {
    .bid-stats-grid { grid-template-columns: repeat(2,1fr); }
}
@media(max-width:480px) {
    .bid-stats-grid { grid-template-columns: 1fr 1fr; }
}

.bstat-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #f1f5f9;
    padding: 18px 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    transition: box-shadow .2s, transform .2s;
    display: flex;
    align-items: center;
    gap: 14px;
}
.bstat-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    transform: translateY(-2px);
}
.bstat-icon {
    width: 46px; height: 46px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 19px;
    flex-shrink: 0;
}
.bstat-info .bstat-value {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.1;
}
.bstat-info .bstat-label {
    font-size: 11.5px;
    font-weight: 500;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-top: 2px;
}

/* ── Table Card ── */
.bids-table-wrap {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    overflow: hidden;
}
.bids-table-wrap .table thead th {
    background: #f8fafc;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .7px;
    padding: 13px 16px;
    border-bottom: 1px solid #f1f5f9;
    white-space: nowrap;
}
.bids-table-wrap .table tbody td {
    padding: 13px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f8fafc;
    font-size: 13.5px;
    color: #334155;
}
.bids-table-wrap .table tbody tr:last-child td { border-bottom: none; }
.bids-table-wrap .table tbody tr:hover { background: #fafbff; }

/* ── Job Name ── */
.job-name-cell {
    font-weight: 600;
    color: #1e293b;
    font-size: 13.5px;
}
.job-id-cell {
    font-size: 11.5px;
    color: #94a3b8;
    margin-top: 2px;
}

/* ── Bid Count ── */
.bid-count-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #ede9fe;
    color: #6d28d9;
    padding: 4px 11px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
}

/* ── Amount ── */
.bid-amount-cell {
    font-weight: 700;
    color: #15803d;
    font-size: 14px;
}
.bid-amount-cell.no-bid {
    color: #94a3b8;
    font-size: 12.5px;
    font-weight: 400;
}

/* ── Status ── */
.auction-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.s-live     { background:#dcfce7; color:#15803d; }
.s-pending  { background:#fef3c7; color:#b45309; }
.s-closed   { background:#f3f4f6; color:#374151; }
.s-assigned { background:#ede9fe; color:#6d28d9; }
.live-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: currentColor;
    animation: blink-dot 1.4s infinite;
}
@keyframes blink-dot {
    0%,100% { opacity:1; } 50% { opacity:.2; }
}

/* ── View Bids Button ── */
.view-bids-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 15px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff !important;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
    border: none;
}
.view-bids-btn:hover {
    box-shadow: 0 4px 14px rgba(99,102,241,.35);
    transform: translateY(-1px);
}

/* ── DataTables controls ── */
#manage-bids-table_wrapper .dataTables_filter input,
#manage-bids-table_wrapper .dataTables_length select {
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    padding: 5px 12px;
    font-size: 13px;
    font-family: 'Outfit', sans-serif;
    outline: none;
    transition: border-color .2s;
}
#manage-bids-table_wrapper .dataTables_filter input:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.12);
}

/* ── Fade-in ── */
.bstat-card { animation: bsf .35s ease both; }
.bstat-card:nth-child(1) { animation-delay:.04s; }
.bstat-card:nth-child(2) { animation-delay:.08s; }
.bstat-card:nth-child(3) { animation-delay:.12s; }
.bstat-card:nth-child(4) { animation-delay:.16s; }
.bids-table-wrap { animation: bsf .4s .2s ease both; }
@keyframes bsf {
    from { opacity:0; transform:translateY(12px); }
    to   { opacity:1; transform:translateY(0); }
}
</style>

<div class="bids-page px-2">

    {{-- ── Header ── --}}
    <div class="bids-page-header">
        <h5 class="bids-page-title">
            <span class="title-icon"><i class="bi bi-hammer"></i></span>
            Manage Bids
        </h5>
        <span class="badge px-3 py-2"
              style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;font-size:12px;border-radius:20px;">
            <span class="live-dot d-inline-block me-1" style="background:#15803d;"></span>
            Live Tracking
        </span>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="bid-stats-grid">
        <div class="bstat-card">
            <div class="bstat-icon" style="background:#ede9fe;">
                <i class="bi bi-briefcase-fill" style="color:#6d28d9;"></i>
            </div>
            <div class="bstat-info">
                <div class="bstat-value" id="stat-total-jobs">—</div>
                <div class="bstat-label">Total Jobs</div>
            </div>
        </div>
        <div class="bstat-card">
            <div class="bstat-icon" style="background:#fef3c7;">
                <i class="bi bi-hammer" style="color:#b45309;"></i>
            </div>
            <div class="bstat-info">
                <div class="bstat-value" id="stat-total-bids">—</div>
                <div class="bstat-label">Total Bids</div>
            </div>
        </div>
        <div class="bstat-card">
            <div class="bstat-icon" style="background:#dcfce7;">
                <i class="bi bi-broadcast" style="color:#15803d;"></i>
            </div>
            <div class="bstat-info">
                <div class="bstat-value" id="stat-live">—</div>
                <div class="bstat-label">Live Auctions</div>
            </div>
        </div>
        <div class="bstat-card">
            <div class="bstat-icon" style="background:#dbeafe;">
                <i class="bi bi-person-check-fill" style="color:#1d4ed8;"></i>
            </div>
            <div class="bstat-info">
                <div class="bstat-value" id="stat-hired">—</div>
                <div class="bstat-label">Hired</div>
            </div>
        </div>
    </div>

    {{-- ── Table ── --}}
    <div class="bids-table-wrap">
        <div class="table-responsive">
            <table id="manage-bids-table" class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Job</th>
                        <th>Total Bids</th>
                        <th>Lowest Bid</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('js')
<script>
$(function () {
    $('#manage-bids-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url    : "{{ route('admin.manage-bids.index') }}",
            dataSrc: function (json) {
                if (json.stats) {
                    $('#stat-total-jobs').text(json.stats.total_jobs ?? '0');
                    $('#stat-total-bids').text(json.stats.total_bids ?? '0');
                    $('#stat-live').text(json.stats.live             ?? '0');
                    $('#stat-hired').text(json.stats.hired           ?? '0');
                } else {
                    // Fallback: recordsTotal se total jobs
                    $('#stat-total-jobs').text(json.recordsTotal ?? '0');
                }
                return json.data;
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false },
            { data: 'title',       name: 'title' },
            { data: 'total_bids',  name: 'total_bids',  orderable: false },
            { data: 'lowest_bid',  name: 'lowest_bid',  orderable: false },
            { data: 'status',      name: 'status',      orderable: false },
            { data: 'action',      name: 'action',      orderable: false },
        ],
        language: {
            emptyTable: '<div class="text-center py-5"><i class="bi bi-inbox fs-2 text-muted d-block mb-2"></i><span class="text-muted">No bids found</span></div>',
            processing: '<div class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary"></div></div>',
        }
    });
});
</script>
@endpush