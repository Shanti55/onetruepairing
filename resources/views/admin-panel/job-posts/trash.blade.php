@extends('admin-panel.layouts.app')

@section('content')
<style>
.trash-wrap { font-family: 'Outfit', sans-serif; }
.trash-card {
    background: #fff; border-radius: 14px;
    border: 1px solid #f1f5f9; overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}
</style>

<div class="trash-wrap px-3">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-semibold mb-0">
            <i class="bi bi-trash3 me-2 text-danger"></i>Job Posts — Trash
        </h5>
        <div class="d-flex gap-2">
            {{-- ✅ Notifications Trash link --}}
            <a href="{{ route('admins.notifications.trash') }}"
               class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-bell me-1"></i>Notifications Trash
            </a>
            <a href="{{ route('job-posts.index') }}" class="btn btn-sm btn-light border">
                <i class="bi bi-arrow-left me-1"></i>Back to Jobs
            </a>
        </div>
    </div>

    <div class="alert border-0 rounded-3 small mb-3"
         style="background:#fefce8;color:#854d0e;border-left:4px solid #fbbf24 !important;border-left-style:solid !important;">
        <i class="bi bi-info-circle me-2"></i>
        Jobs deleted <strong>30+ days ago</strong> are permanently removed automatically.
        You can restore or permanently delete from here.
    </div>

    <div class="trash-card">
        <div class="table-responsive">
            <table id="trash-table" class="table table-hover align-middle mb-0">
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
@endsection

@push('js')
<script type="module">
$(function () {

    var table = $('#trash-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('job-posts.trash') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false },
            { data: 'job_id',      name: 'id',           orderable: false },
            { data: 'title',       name: 'title' },
            { data: 'deleted_at',  name: 'deleted_at',   orderable: false },
            { data: 'action',      name: 'action',        orderable: false },
        ],
        language: {
            emptyTable: '<div class="text-center py-4"><i class="bi bi-trash3 fs-2 text-muted d-block mb-2"></i><span class="text-muted">Trash is empty</span></div>',
            processing: '<div class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary"></div></div>',
        }
    });

    // ── Restore ───────────────────────────────────────────────────────────
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
                table.draw(false);
            },
            error  : function () {
                btn.prop('disabled', false).html('<i class="bi bi-arrow-counterclockwise me-1"></i>Restore');
                showToast('Restore failed.', 'danger');
            }
        });
    });

    // ── Force Delete ──────────────────────────────────────────────────────
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
                table.draw(false);
            },
            error  : function () {
                btn.prop('disabled', false).html('<i class="bi bi-trash3 me-1"></i>Delete Forever');
                showToast('Delete failed.', 'danger');
            }
        });
    });

    // ── Toast ─────────────────────────────────────────────────────────────
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
            $('body').append(
                '<div id="toast-container" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:9999;"></div>'
            );
        }
        $('#toast-container').append(toast);
        new bootstrap.Toast(toast[0], { delay: 3000 }).show();
        toast[0].addEventListener('hidden.bs.toast', () => toast.remove());
    }

});
</script>
@endpush