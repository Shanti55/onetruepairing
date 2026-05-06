@extends('admin-panel.layouts.app')

@section('title', 'Notifications Trash')

@section('content')
<div class="px-3">

    <div class="d-flex align-items-center justify-content-between mb-4 pb-3"
         style="border-bottom:1px solid #f1f5f9;">
        <h5 style="font-weight:700;color:#111827;margin:0;display:flex;align-items:center;gap:10px;">
            <i class="bi bi-trash3 text-danger"></i> Notifications Trash
        </h5>
        <div class="d-flex gap-2">
            {{-- ✅ Restore All --}}
            @if($notifications->count() > 0)
            <button id="restoreAllBtn"
                    style="background:#f0fdf4;border:1px solid #bbf7d0;color:#16a34a;font-size:12px;font-weight:600;padding:7px 14px;border-radius:8px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                <i class="bi bi-arrow-counterclockwise"></i> Restore All
            </button>
            @endif
            <a href="{{ route('admins.notifications.index') }}"
               style="background:#f8fafc;border:1px solid #e2e8f0;color:#475569;font-size:12px;font-weight:600;padding:7px 14px;border-radius:8px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                <i class="bi bi-arrow-left"></i> Back to Notifications
            </a>
        </div>
    </div>

    <div class="alert border-0 rounded-3 small mb-3"
         style="background:#fefce8;color:#854d0e;border-left:4px solid #fbbf24 !important;">
        <i class="bi bi-info-circle me-2"></i>
        Notifications in trash are <strong>permanently deleted after 15 days</strong> automatically.
        You can restore or permanently delete from here.
    </div>

    <div style="background:#fff;border-radius:14px;border:1px solid #f1f5f9;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.04);">
        @forelse($notifications as $notification)
        <div class="d-flex align-items-start gap-3 p-3 border-bottom"
             id="trash-notif-{{ $notification->id }}"
             style="opacity:0.8;transition:opacity 0.2s;">

            {{-- Icon --}}
            <div style="width:40px;height:40px;border-radius:10px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi {{ $notification->data['icon'] ?? 'bi-bell' }} text-secondary"></i>
            </div>

            <div class="flex-grow-1">
                <div style="font-size:13.5px;font-weight:600;color:#64748b;margin-bottom:3px;">
                    {!! $notification->data['title'] ?? 'Notification' !!}
                </div>
                <div style="font-size:12px;color:#94a3b8;margin-bottom:6px;">
                    {!! $notification->data['message'] ?? '' !!}
                </div>

                @if(isset($notification->data['highlight']))
                    <div style="display:inline-block;background:#fef2f2;color:#dc2626;font-size:11px;font-weight:600;padding:2px 10px;border-radius:20px;margin-bottom:6px;">
                        {{ $notification->data['highlight'] }}
                    </div>
                @endif

                <div class="d-flex gap-2 align-items-center flex-wrap">
                    <span style="font-size:11px;color:#cbd5e1;display:flex;align-items:center;gap:4px;">
                        <i class="bi bi-clock"></i>
                        Deleted {{ \Carbon\Carbon::parse($notification->deleted_at)->diffForHumans() }}
                    </span>

                    {{-- Restore --}}
                    <button class="restore-notif-btn"
                            data-id="{{ $notification->id }}"
                            style="font-size:11px;font-weight:600;padding:3px 10px;border-radius:6px;border:1px solid #bbf7d0;color:#16a34a;background:#f0fdf4;cursor:pointer;">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                    </button>

                    {{-- Delete Forever --}}
                    <button class="force-delete-notif-btn"
                            data-id="{{ $notification->id }}"
                            style="font-size:11px;font-weight:600;padding:3px 10px;border-radius:6px;border:1px solid #fee2e2;color:#dc2626;background:#fff5f5;cursor:pointer;">
                        <i class="bi bi-trash3 me-1"></i>Delete Forever
                    </button>
                </div>
            </div>
        </div>
        @empty
            <div style="text-align:center;padding:4rem 2rem;">
                <div style="width:72px;height:72px;background:#f8fafc;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:28px;color:#cbd5e1;">
                    <i class="bi bi-trash3"></i>
                </div>
                <h6 style="color:#374151;font-weight:700;margin-bottom:6px;">Trash is empty!</h6>
                <p style="color:#94a3b8;font-size:13px;margin:0;">No deleted notifications here.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($notifications->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $notifications->links() }}
    </div>
    @endif

</div>
@endsection

@push('js')
<script type="module">
$(function () {

    // ── Restore single ────────────────────────────────────────────────────
    $('body').on('click', '.restore-notif-btn', function () {
        const id  = $(this).data('id');
        const row = $('#trash-notif-' + id);
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i>');
        $.ajax({
            url  : `/admin/notifications/${id}/restore`,
            type : 'POST',
            data : { _token: '{{ csrf_token() }}' },
            success: function () {
                row.fadeOut(300, function() { $(this).remove(); });
                showToast('Notification restored!', 'success');
            },
            error: function () {
                btn.prop('disabled', false)
                   .html('<i class="bi bi-arrow-counterclockwise me-1"></i>Restore');
                showToast('Restore failed.', 'danger');
            }
        });
    });

    // ── Force delete single ───────────────────────────────────────────────
    $('body').on('click', '.force-delete-notif-btn', function () {
        if (!confirm('Permanently delete? Cannot be undone.')) return;
        const id  = $(this).data('id');
        const row = $('#trash-notif-' + id);
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i>');
        $.ajax({
            url  : `/admin/notifications/${id}/force-delete`,
            type : 'DELETE',
            data : { _token: '{{ csrf_token() }}' },
            success: function () {
                row.fadeOut(300, function() { $(this).remove(); });
                showToast('Permanently deleted!', 'success');
            },
            error: function () {
                btn.prop('disabled', false)
                   .html('<i class="bi bi-trash3 me-1"></i>Delete Forever');
                showToast('Delete failed.', 'danger');
            }
        });
    });

    // ── Restore All ───────────────────────────────────────────────────────
    $('#restoreAllBtn').on('click', function () {
        if (!confirm('Restore all notifications from trash?')) return;
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Restoring...');
        $.ajax({
            url  : '{{ route("admins.notifications.restoreAll") }}',
            type : 'POST',
            data : { _token: '{{ csrf_token() }}' },
            success: function () {
                showToast('All notifications restored!', 'success');
                setTimeout(() => window.location.reload(), 800);
            },
            error: function () {
                btn.prop('disabled', false)
                   .html('<i class="bi bi-arrow-counterclockwise me-1"></i>Restore All');
                showToast('Failed to restore.', 'danger');
            }
        });
    });

    // ── Toast ─────────────────────────────────────────────────────────────
    function showToast(message, type) {
        const bg    = type === 'success' ? 'bg-success' : 'bg-danger';
        const toast = $(`
            <div class="toast align-items-center text-white ${bg} border-0 shadow"
                 role="alert" style="min-width:240px;">
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