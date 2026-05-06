@extends('admin-panel.layouts.app')

@section('title', 'Notifications')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap');
.notif-page { font-family: 'Outfit', sans-serif; }

.notif-header {
    display: flex; align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f1f5f9;
}
.notif-header h5 {
    font-size: 1.1rem; font-weight: 700;
    color: #111827; margin: 0;
    display: flex; align-items: center; gap: 10px;
}
.notif-count-badge {
    background: #dc2626; color: #fff;
    font-size: 11px; font-weight: 700;
    padding: 2px 8px; border-radius: 20px;
}
.mark-all-btn {
    background: #f8fafc; border: 1px solid #e2e8f0;
    color: #475569; font-size: 12px; font-weight: 600;
    padding: 7px 16px; border-radius: 8px;
    cursor: pointer; transition: all 0.2s;
    text-decoration: none;
    display: inline-flex; align-items: center; gap: 6px;
}
.mark-all-btn:hover { background: #111827; border-color: #111827; color: #fff; }

.notif-wrap {
    background: #fff; border-radius: 14px;
    border: 1px solid #f1f5f9; overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}
.notif-item {
    display: flex; align-items: flex-start;
    gap: 14px; padding: 16px 20px;
    border-bottom: 1px solid #f8fafc;
    transition: background 0.15s;
    position: relative;
}
.notif-item:last-child { border-bottom: none; }
.notif-item:hover { background: #fafbff; }
.notif-item.unread { background: #fff; }
.notif-item.read   { background: #fafafa; }
.notif-item.unread::before {
    content: '';
    position: absolute; left: 0; top: 0; bottom: 0;
    width: 3px; background: #2563eb;
    border-radius: 0 2px 2px 0;
}

.notif-icon {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
}
.notif-icon.default  { background: #eff6ff; color: #2563eb; }
.notif-icon.outbid   { background: #fef2f2; color: #dc2626; }
.notif-icon.live     { background: #f0fdf4; color: #16a34a; }
.notif-icon.winner   { background: #fefce8; color: #ca8a04; }
.notif-icon.result   { background: #f8fafc; color: #64748b; }
.notif-icon.trash    { background: #fef2f2; color: #dc2626; }
.notif-icon.closed   { background: #f1f5f9; color: #475569; }

.notif-content { flex: 1; min-width: 0; }
.notif-title {
    font-size: 13.5px; font-weight: 700;
    color: #111827; margin-bottom: 3px; line-height: 1.4;
}
.notif-item.read .notif-title { color: #64748b; font-weight: 600; }
.notif-message { font-size: 12.5px; color: #94a3b8; line-height: 1.5; margin-bottom: 6px; }
.notif-highlight {
    display: inline-block; background: #fef2f2;
    color: #dc2626; font-size: 11.5px; font-weight: 600;
    padding: 2px 10px; border-radius: 20px; margin-bottom: 6px;
}
.notif-meta { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.notif-time { font-size: 11px; color: #cbd5e1; display: flex; align-items: center; gap: 4px; }

.notif-action-btn {
    font-size: 11px; font-weight: 600;
    padding: 3px 10px; border-radius: 6px;
    text-decoration: none; transition: all 0.15s;
    border: 1px solid; display: inline-flex;
    align-items: center; gap: 4px;
    cursor: pointer; background: none;
}
.read-btn { color: #64748b; border-color: #e2e8f0; }
.read-btn:hover { background: #111827; color: #fff; border-color: #111827; }
.view-btn { color: #2563eb; border-color: #bfdbfe; background: #eff6ff; }
.view-btn:hover { background: #2563eb; color: #fff; border-color: #2563eb; }

.unread-dot {
    width: 7px; height: 7px; background: #2563eb;
    border-radius: 50%; flex-shrink: 0; margin-top: 4px;
}

.empty-state { text-align: center; padding: 4rem 2rem; }
.empty-icon {
    width: 72px; height: 72px; background: #f8fafc;
    border-radius: 50%; display: flex;
    align-items: center; justify-content: center;
    margin: 0 auto 1rem; font-size: 28px; color: #cbd5e1;
}

.notif-pagination {
    display: flex; align-items: center;
    justify-content: space-between;
    margin-top: 1.5rem; flex-wrap: wrap; gap: 10px;
}
.pagination-info { font-size: 12.5px; color: #94a3b8; }
.pagination-links { display: flex; align-items: center; gap: 4px; }
.pagination-links a, .pagination-links span {
    display: inline-flex; align-items: center; justify-content: center;
    width: 34px; height: 34px; border-radius: 8px;
    font-size: 13px; font-weight: 600;
    text-decoration: none; border: 1px solid #e2e8f0;
    color: #374151; transition: all 0.15s;
}
.pagination-links a:hover { background: #111827; color: #fff; border-color: #111827; }
.pagination-links span.current { background: #111827; color: #fff; border-color: #111827; }
.pagination-links span.disabled { opacity: 0.4; cursor: not-allowed; }
</style>

<div class="notif-page px-3">

    <div class="notif-header">
        <h5>
            <i class="bi bi-bell-fill text-primary"></i>
            Notifications
            @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="notif-count-badge">
                    {{ auth()->user()->unreadNotifications->count() }} new
                </span>
            @endif
        </h5>
        <div class="d-flex gap-2">
            @if(auth()->user()->unreadNotifications->count() > 0)
                <button class="mark-all-btn" id="markAllReadBtn">
                    <i class="bi bi-check2-all"></i> Mark all read
                </button>
            @endif
            <button class="mark-all-btn" id="deleteAllReadBtn"
                    style="color:#dc2626;border-color:#fee2e2;">
                <i class="bi bi-trash3"></i> Delete all read
            </button>
        </div>
    </div>

    <div class="notif-wrap">
        @forelse($notifications as $notification)
            @php
                $type = $notification->data['type'] ?? 'default';
                $iconMap = [
                    'outbid_warning'        => ['class'=>'outbid',  'icon'=>'bi-lightning-charge-fill'],
                    'auction_live'          => ['class'=>'live',    'icon'=>'bi-broadcast'],
                    'auction_starting_soon' => ['class'=>'live',    'icon'=>'bi-alarm'],
                    'auction_ending_soon'   => ['class'=>'outbid',  'icon'=>'bi-hourglass-split'],
                    'auction_winner'        => ['class'=>'winner',  'icon'=>'bi-trophy-fill'],
                    'auction_result'        => ['class'=>'result',  'icon'=>'bi-clock-history'],
                    'auction_auto_closed'   => ['class'=>'closed',  'icon'=>'bi-clock-history'],
                    'jobs_auto_trashed'     => ['class'=>'trash',   'icon'=>'bi-trash3'],
                    'default'               => ['class'=>'default', 'icon'=>'bi-bell-fill'],
                ];
                $ic = $iconMap[$type] ?? $iconMap['default'];
            @endphp

            <div class="notif-item {{ $notification->unread() ? 'unread' : 'read' }}"
                 id="notif-{{ $notification->id }}">

                <div class="notif-icon {{ $ic['class'] }}">
                    <i class="bi {{ $notification->data['icon'] ?? $ic['icon'] }}"></i>
                </div>

                <div class="notif-content">
                    <div class="notif-title">{!! $notification->data['title'] ?? 'Notification' !!}</div>
                    <div class="notif-message">{!! $notification->data['message'] ?? '' !!}</div>

                    @if(isset($notification->data['highlight']))
                        <div class="notif-highlight">{{ $notification->data['highlight'] }}</div>
                    @endif

                    @if(isset($notification->data['winner']))
                        <div style="font-size:12px;color:#64748b;margin-bottom:6px;">
                            <i class="bi bi-person-check-fill text-success me-1"></i>
                            Winner: <strong>{{ $notification->data['winner'] }}</strong>
                            @if(isset($notification->data['job_title']))
                                &nbsp;·&nbsp; {{ $notification->data['job_title'] }}
                            @endif
                        </div>
                    @endif

                    <div class="notif-meta">
                        <span class="notif-time">
                            <i class="bi bi-clock"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </span>

                        @if($notification->unread())
                            <button class="notif-action-btn read-btn mark-read-btn"
                                    data-id="{{ $notification->id }}">
                                <i class="bi bi-check2"></i> Mark read
                            </button>
                        @endif

                        @if(isset($notification->data['action_url']))
                            <a href="{{ $notification->data['action_url'] }}"
                               class="notif-action-btn view-btn">
                                <i class="bi bi-arrow-right"></i> View
                            </a>
                        @endif

                        {{-- ✅ Delete button --}}
                        <button class="notif-action-btn delete-notif-btn"
                                data-id="{{ $notification->id }}"
                                style="color:#dc2626;border-color:#fee2e2;background:#fff5f5;">
                            <i class="bi bi-trash3"></i> Delete
                        </button>
                    </div>
                </div>

                @if($notification->unread())
                    <div class="unread-dot"></div>
                @endif
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon"><i class="bi bi-bell-slash"></i></div>
                <h6 style="color:#374151;font-weight:700;margin-bottom:6px;">All caught up!</h6>
                <p style="color:#94a3b8;font-size:13px;margin:0;">No notifications yet.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($notifications->hasPages())
    <div class="notif-pagination">
        <div class="pagination-info">
            Showing {{ $notifications->firstItem() }}–{{ $notifications->lastItem() }}
            of {{ $notifications->total() }} notifications
        </div>
        <div class="pagination-links">
            @if($notifications->onFirstPage())
                <span class="disabled"><i class="bi bi-chevron-left" style="font-size:12px;"></i></span>
            @else
                <a href="{{ $notifications->previousPageUrl() }}">
                    <i class="bi bi-chevron-left" style="font-size:12px;"></i>
                </a>
            @endif

            @foreach($notifications->getUrlRange(1, $notifications->lastPage()) as $page => $url)
                @if($page == $notifications->currentPage())
                    <span class="current">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            @if($notifications->hasMorePages())
                <a href="{{ $notifications->nextPageUrl() }}">
                    <i class="bi bi-chevron-right" style="font-size:12px;"></i>
                </a>
            @else
                <span class="disabled"><i class="bi bi-chevron-right" style="font-size:12px;"></i></span>
            @endif
        </div>
    </div>
    @endif

</div>
@endsection

@push('js')
<script type="module">
$(function () {

    // ── Mark single as read ───────────────────────────────────────────────
    $('body').on('click', '.mark-read-btn', function () {
        const id  = $(this).data('id');
        const row = $('#notif-' + id);
        $.ajax({
            url  : `/admin/notifications/${id}/read`,
            type : 'POST',
            data : { _token: '{{ csrf_token() }}' },
            success: function () {
                row.removeClass('unread').addClass('read');
                row.css('border-left', 'none');
                row.find('.unread-dot').fadeOut(200, function() { $(this).remove(); });
                row.find('.notif-title').css({'color':'#64748b','font-weight':'600'});
                row.find('.mark-read-btn').fadeOut(200, function() { $(this).remove(); });
            }
        });
    });

    // ── Mark all as read ──────────────────────────────────────────────────
    $('#markAllReadBtn').on('click', function () {
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Processing...');
        $.ajax({
            url  : '{{ route("admins.notifications.markAllRead") }}',
            type : 'POST',
            data : { _token: '{{ csrf_token() }}' },
            success: function () {
                $('.notif-item.unread').removeClass('unread').addClass('read').css('border-left','none');
                $('.unread-dot').fadeOut(200, function() { $(this).remove(); });
                $('.mark-read-btn').fadeOut(200, function() { $(this).remove(); });
                $('.notif-count-badge').fadeOut(300, function() { $(this).remove(); });
                btn.fadeOut(300, function() { $(this).remove(); });
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="bi bi-check2-all me-1"></i>Mark all as read');
            }
        });
    });

    // ✅ ── Delete single notification ─────────────────────────────────────
    $('body').on('click', '.delete-notif-btn', function () {
        const id  = $(this).data('id');
        const row = $('#notif-' + id);
        $.ajax({
            url  : `/admin/notifications/${id}/delete`,
            type : 'DELETE',
            data : { _token: '{{ csrf_token() }}' },
            success: function () {
                row.fadeOut(300, function() {
                    $(this).remove();
                });
            }
        });
    });

    // ✅ ── Delete all read notifications ──────────────────────────────────
    $('#deleteAllReadBtn').on('click', function () {
        if (!confirm('Delete all read notifications? This cannot be undone.')) return;
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Deleting...');
        $.ajax({
            url  : '{{ route("admins.notifications.deleteAllRead") }}',
            type : 'DELETE',
            data : { _token: '{{ csrf_token() }}' },
            success: function (res) {
                $('.notif-item.read').fadeOut(300, function() { $(this).remove(); });
                btn.prop('disabled', false).html('<i class="bi bi-trash3 me-1"></i>Delete all read');
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="bi bi-trash3 me-1"></i>Delete all read');
            }
        });
    });

});
</script>
@endpush