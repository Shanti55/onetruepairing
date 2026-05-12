@extends('admin-panel.layouts.app')

@section('content')
<style>
.trash-wrap { font-family: 'Outfit', sans-serif; }

.trash-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #f1f5f9;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}

/* ── Custom Tab Pills ── */
.trash-tabs {
    display: flex;
    gap: 6px;
    background: #f8f9fc;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 5px;
    width: fit-content;
}

.trash-tab-btn {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 7px 18px;
    border: none;
    border-radius: 7px;
    font-size: 13.5px;
    font-weight: 500;
    color: #6b7280;
    background: transparent;
    cursor: pointer;
    transition: all .2s ease;
    white-space: nowrap;
}

.trash-tab-btn:hover {
    background: #fff;
    color: #374151;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}

.trash-tab-btn.active {
    background: #fff;
    color: #1d4ed8;
    box-shadow: 0 2px 8px rgba(0,0,0,0.10);
    font-weight: 600;
}

.trash-tab-btn .tab-icon { font-size: 15px; }

.trash-tab-btn .tab-badge {
    font-size: 10.5px;
    font-weight: 700;
    padding: 1px 6px;
    border-radius: 20px;
    background: #fee2e2;
    color: #b91c1c;
    min-width: 18px;
    text-align: center;
}

.trash-tab-btn.active .tab-badge {
    background: #dbeafe;
    color: #1d4ed8;
}

/* ── Tab Pane ── */
.trash-tab-pane { display: none; }
.trash-tab-pane.active { display: block; }
</style>

<div class="trash-wrap px-3">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <h5 class="fw-semibold mb-0">
            <i class="bi bi-trash3 me-2 text-danger"></i>Trash
        </h5>
        <a href="{{ route('job-posts.index') }}" class="btn btn-sm btn-light border">
            <i class="bi bi-arrow-left me-1"></i>Back to Jobs
        </a>
    </div>

    {{-- Info Banner --}}
    <div class="alert border-0 rounded-3 small mb-3"
         style="background:#fefce8;color:#854d0e;border-left:4px solid #fbbf24 !important;">
        <i class="bi bi-info-circle me-2"></i>
        Items deleted <strong>30+ days ago</strong> are permanently removed automatically.
        You can restore or permanently delete from here.
    </div>

    {{-- Custom Tabs --}}
    <div class="trash-tabs mb-3">
        <button class="trash-tab-btn active" data-tab="jobs-tab">
            <i class="bi bi-briefcase tab-icon"></i>
            Job Posts
            <span class="tab-badge" id="jobs-count">—</span>
        </button>
        <button class="trash-tab-btn" data-tab="notif-tab">
            <i class="bi bi-bell tab-icon"></i>
            Notifications
            <span class="tab-badge" id="notif-count">—</span>
        </button>
    </div>

    {{-- ═══════════════════ Tab: Job Posts ═══════════════════ --}}
    <div class="trash-tab-pane active" id="jobs-tab">
        <div class="trash-card">
            <div class="table-responsive">
                <table id="jobs-trash-table" class="table table-hover align-middle mb-0">
                    <thead style="background:#f8f9fc;">
                        <tr>
                            <th class="px-3 py-3">#</th>
                            <th class="py-3">Job ID</th>
                            <th class="py-3">Title</th>
                            <th class="py-3">Deleted</th>
                            <th class="py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ═══════════════════ Tab: Notifications ═══════════════════ --}}
    <div class="trash-tab-pane" id="notif-tab">
        <div class="trash-card">
            <div class="table-responsive">
                <table id="notif-trash-table" class="table table-hover align-middle mb-0">
                    <thead style="background:#f8f9fc;">
                        <tr>
                            <th class="px-3 py-3">#</th>
                            <th class="py-3">Title</th>
                            <th class="py-3">Message</th>
                            <th class="py-3">Deleted</th>
                            <th class="py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('js')
<script type="module">
$(function () {

    // ── Common language config ────────────────────────────────────────────
    const dtLang = {
        emptyTable : '<div class="text-center py-4"><i class="bi bi-trash3 fs-2 text-muted d-block mb-2"></i><span class="text-muted">Trash is empty</span></div>',
        processing : '<div class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary"></div></div>',
    };

    // ── Jobs DataTable ────────────────────────────────────────────────────
    var jobsTable = $('#jobs-trash-table').DataTable({
        processing : true,
        serverSide : true,
        ajax       : "{{ route('job-posts.trash') }}",
        columns    : [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false },
            { data: 'job_id',      name: 'id',           orderable: false },
            { data: 'title',       name: 'title' },
            { data: 'deleted_at',  name: 'deleted_at',   orderable: false },
            { data: 'action',      name: 'action',        orderable: false },
        ],
        language : dtLang,
        drawCallback: function(s) {
            $('#jobs-count').text(s.json?.recordsTotal ?? '0');
        }
    });

    // ── Notifications DataTable ───────────────────────────────────────────
    var notifTable = $('#notif-trash-table').DataTable({
        processing : true,
        serverSide : true,
    ajax: "{{ route('admins.notifications.trash.datatable') }}",  
        columns    : [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false },
            { data: 'title',       name: 'title' },
            { data: 'message',     name: 'message',      orderable: false },
            { data: 'deleted_at',  name: 'deleted_at',   orderable: false },
            { data: 'action',      name: 'action',        orderable: false },
        ],
        language : dtLang,
        drawCallback: function(s) {
            $('#notif-count').text(s.json?.recordsTotal ?? '0');
        }
    });

    // ── Tab switching ─────────────────────────────────────────────────────
    $('.trash-tab-btn').on('click', function () {
        const target = $(this).data('tab');

        // Buttons
        $('.trash-tab-btn').removeClass('active');
        $(this).addClass('active');

        // Panes
        $('.trash-tab-pane').removeClass('active');
        $('#' + target).addClass('active');

        // Redraw visible table so columns adjust correctly
        if (target === 'jobs-tab') {
            jobsTable.columns.adjust().draw(false);
        } else {
            notifTable.columns.adjust().draw(false);
        }
    });

    // ── Restore — Job Post ────────────────────────────────────────────────
    $('body').on('click', '.restore-btn', function () {
        const id  = $(this).data('id');
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i>');
        $.ajax({
            url    : `/admin/job-posts/${id}/restore`,
            type   : 'POST',
            data   : { _token: '{{ csrf_token() }}' },
            success: function (res) {
                showToast(res.message, 'success');
                jobsTable.draw(false);
            },
            error  : function () {
                btn.prop('disabled', false).html('<i class="bi bi-arrow-counterclockwise me-1"></i>Restore');
                showToast('Restore failed.', 'danger');
            }
        });
    });

    // ── Force Delete — Job Post ───────────────────────────────────────────
    $('body').on('click', '.force-delete-btn', function () {
        if (!confirm('Permanently delete? This cannot be undone.')) return;
        const id  = $(this).data('id');
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i>');
        $.ajax({
            url    : `/admin/job-posts/${id}/force-delete`,
            type   : 'DELETE',
            data   : { _token: '{{ csrf_token() }}' },
            success: function (res) {
                showToast(res.message, 'success');
                jobsTable.draw(false);
            },
            error  : function () {
                btn.prop('disabled', false).html('<i class="bi bi-trash3 me-1"></i>Delete Forever');
                showToast('Delete failed.', 'danger');
            }
        });
    });

    // ── Restore — Notification ────────────────────────────────────────────
    $('body').on('click', '.notif-restore-btn', function () {
        const id  = $(this).data('id');
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i>');
        $.ajax({
            url    : `/admin/notifications/${id}/restore`,   // ← apna restore route
            type   : 'POST',
            data   : { _token: '{{ csrf_token() }}' },
            success: function (res) {
                showToast(res.message, 'success');
                notifTable.draw(false);
            },
            error  : function () {
                btn.prop('disabled', false).html('<i class="bi bi-arrow-counterclockwise me-1"></i>Restore');
                showToast('Restore failed.', 'danger');
            }
        });
    });

    // ── Force Delete — Notification ───────────────────────────────────────
    $('body').on('click', '.notif-force-delete-btn', function () {
        if (!confirm('Permanently delete? This cannot be undone.')) return;
        const id  = $(this).data('id');
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i>');
        $.ajax({
            url    : `/admin/notifications/${id}/force-delete`,  // ← apna force-delete route
            type   : 'DELETE',
            data   : { _token: '{{ csrf_token() }}' },
            success: function (res) {
                showToast(res.message, 'success');
                notifTable.draw(false);
            },
            error  : function () {
                btn.prop('disabled', false).html('<i class="bi bi-trash3 me-1"></i>Delete Forever');
                showToast('Delete failed.', 'danger');
            }
        });
    });

    // ── Toast helper ──────────────────────────────────────────────────────
    function showToast(message, type) {
        const bg    = type === 'success' ? 'bg-success' : 'bg-danger';
        const toast = $(`
            <div class="toast align-items-center text-white ${bg} border-0 shadow"
                 role="alert" style="min-width:260px;">
                <div class="d-flex">
                    <div class="toast-body fw-semibold">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                            data-bs-dismiss="toast"></button>
                </div>
            </div>`);
        if (!$('#toast-container').length) {
            $('body').append('<div id="toast-container" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:9999;"></div>');
        }
        $('#toast-container').append(toast);
        new bootstrap.Toast(toast[0], { delay: 3000 }).show();
        toast[0].addEventListener('hidden.bs.toast', () => toast.remove());
    }

});
</script>
@endpush