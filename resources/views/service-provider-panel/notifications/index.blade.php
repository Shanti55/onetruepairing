@extends('service-provider-panel.layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="px-3">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-semibold mb-0">Notifications</h5>
        <div id="mark-all-btn-container">
            @if(auth()->user()->unreadNotifications->count() > 0)
                <a href="{{ route('notifications.markAllRead') }}"
                   class="btn btn-sm btn-light border text-primary fw-bold"
                   style="font-size: 0.8rem;">
                    <i class="bi bi-check2-all me-1"></i> Mark all as read
                </a>
            @endif
        </div>
    </div>

    {{-- Live Alert Banner --}}
    <div id="live-alert-banner" class="alert alert-danger d-none border-0 shadow-sm d-flex align-items-center gap-2 mb-3" role="alert">
        <i class="bi bi-lightning-charge-fill fs-5"></i>
        <span id="live-alert-text" class="fw-bold small"></span>
    </div>

    <div class="card mt-0 border-0 shadow-sm">
        <div class="card-body p-0" id="notification-list-container">
            @forelse($notifications as $notification)
                <div id="notif-row-{{ $notification->id }}"
                     class="p-3 border-bottom {{ $notification->unread() ? 'bg-white' : 'bg-light' }}"
                     style="border-left: 4px solid {{ $notification->unread() ? '#dc3545' : 'transparent' }}; transition: 0.3s;">
                    <div class="d-flex align-items-start">

                        {{-- Icon --}}
                        <div class="rounded-circle text-primary p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width: 42px; height: 42px; background: #eef2ff;">
                            <i class="bi {{ $notification->data['icon'] ?? 'bi-bell' }}"></i>
                        </div>

                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="mb-0 fw-bold {{ $notification->unread() ? 'text-dark' : 'text-muted' }}">
                                    {!! $notification->data['title'] !!}
                                </h6>
                                <small class="text-muted ms-2 text-nowrap" style="font-size: 0.72rem;">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>

                            <p class="mb-1 text-muted small mt-1">
                                {!! $notification->data['message'] !!}
                            </p>

                            @if(isset($notification->data['highlight']))
                                <p class="mb-1 small fw-bold text-danger">
                                    {{ $notification->data['highlight'] }}
                                </p>
                            @endif

                            {{-- Winner info for loser notification --}}
                            @if(isset($notification->data['type']) && $notification->data['type'] === 'auction_result' && isset($notification->data['winner']))
                                <p class="mb-1 small text-muted">
                                    <i class="bi bi-person-check-fill text-success me-1"></i>
                                    Winner: <strong class="text-dark">{{ $notification->data['winner'] }}</strong>
                                    &nbsp;|&nbsp;
                                    <strong class="text-warning">{{ $notification->data['job_title'] ?? '' }}</strong>
                                </p>
                            @endif

                            <div class="d-flex gap-2 mt-2 flex-wrap">

                                @if($notification->unread())
                                    <a href="{{ route('notifications.read', $notification->id) }}"
                                       class="btn btn-sm btn-outline-secondary py-0 px-2"
                                       style="font-size: 0.7rem;">
                                        <i class="bi bi-check2 me-1"></i>Mark Read
                                    </a>
                                @endif

                                {{-- Outbid --}}
                                @if(isset($notification->data['type']) && $notification->data['type'] === 'outbid_warning')
                                    <a href="{{ route('vendor.bids') }}"
                                       class="btn btn-sm btn-danger py-0 px-2"
                                       style="font-size: 0.7rem;">
                                        <i class="bi bi-lightning-charge-fill me-1"></i>Re-Bid Now
                                    </a>
                                @endif

                                {{-- Auction Live --}}
                                @if(isset($notification->data['type']) && $notification->data['type'] === 'auction_live')
                                    <a href="{{ $notification->data['action_url'] ?? route('vendor.bids') }}"
                                       class="btn btn-sm btn-success py-0 px-2"
                                       style="font-size: 0.7rem;">
                                        <i class="bi bi-broadcast me-1"></i>View Auction
                                    </a>
                                @endif

                                {{-- Auction Starting Soon --}}
                                @if(isset($notification->data['type']) && $notification->data['type'] === 'auction_starting_soon')
                                    <a href="{{ $notification->data['action_url'] ?? route('vendor.bids') }}"
                                       class="btn btn-sm btn-warning py-0 px-2 text-dark"
                                       style="font-size: 0.7rem;">
                                        <i class="bi bi-alarm me-1"></i>Get Ready
                                    </a>
                                @endif

                                {{-- Auction Ending Soon --}}
                                @if(isset($notification->data['type']) && $notification->data['type'] === 'auction_ending_soon')
                                    <a href="{{ $notification->data['action_url'] ?? route('vendor.bids') }}"
                                       class="btn btn-sm btn-warning py-0 px-2 text-dark"
                                       style="font-size: 0.7rem;">
                                        <i class="bi bi-hourglass-split me-1"></i>Bid Before Time Runs Out
                                    </a>
                                @endif

                                {{-- ✅ Auction Winner --}}
                                @if(isset($notification->data['type']) && $notification->data['type'] === 'auction_winner')
                                    <a href="{{ route('vendor.bids') }}"
                                       class="btn btn-sm btn-warning py-0 px-2 text-dark fw-bold"
                                       style="font-size: 0.7rem;">
                                        <i class="bi bi-trophy-fill me-1"></i>View Winning Job
                                    </a>
                                @endif

                                {{-- ✅ Auction Result (Loser) --}}
                                @if(isset($notification->data['type']) && $notification->data['type'] === 'auction_result')
                                    <span class="badge bg-light text-muted border py-1 px-2"
                                          style="font-size: 0.7rem;">
                                        <i class="bi bi-clock me-1"></i>Refund in 4–5 working days
                                    </span>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5" id="empty-state">
                    <i class="bi bi-bell-slash fs-1 text-muted"></i>
                    <p class="mt-2 text-muted">No notifications yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function () {

    // ── Action button builder ─────────────────────────────────────────────
    function getActionButton(n) {
        if (n.type === 'outbid_warning') {
            return `<a href="/service-provider/bid-status" class="btn btn-sm btn-danger py-0 px-2" style="font-size:0.7rem;">
                        <i class="bi bi-lightning-charge-fill me-1"></i>Re-Bid Now
                    </a>`;
        }
        if (n.type === 'auction_live') {
            return `<a href="${n.action_url ?? '/service-provider/bid-status'}" class="btn btn-sm btn-success py-0 px-2" style="font-size:0.7rem;">
                        <i class="bi bi-broadcast me-1"></i>View Auction
                    </a>`;
        }
        if (n.type === 'auction_starting_soon') {
            return `<a href="${n.action_url ?? '/service-provider/bid-status'}" class="btn btn-sm btn-warning py-0 px-2 text-dark" style="font-size:0.7rem;">
                        <i class="bi bi-alarm me-1"></i>Get Ready
                    </a>`;
        }
        if (n.type === 'auction_ending_soon') {
            return `<a href="${n.action_url ?? '/service-provider/bid-status'}" class="btn btn-sm btn-warning py-0 px-2 text-dark" style="font-size:0.7rem;">
                        <i class="bi bi-hourglass-split me-1"></i>Bid Before Time Runs Out
                    </a>`;
        }
        // ✅ Winner
        if (n.type === 'auction_winner') {
            return `<a href="/service-provider/bid-status" class="btn btn-sm btn-warning py-0 px-2 text-dark fw-bold" style="font-size:0.7rem;">
                        <i class="bi bi-trophy-fill me-1"></i>View Winning Job
                    </a>`;
        }
        // ✅ Loser / Result
        if (n.type === 'auction_result') {
            const winnerInfo = n.winner
                ? `<span class="badge bg-light text-dark border py-1 px-2 ms-1" style="font-size:0.7rem;">
                       <i class="bi bi-person-check-fill text-success me-1"></i>Winner: ${n.winner}
                   </span>`
                : '';
            return `<span class="badge bg-light text-muted border py-1 px-2" style="font-size:0.7rem;">
                        <i class="bi bi-clock me-1"></i>Refund in 4–5 working days
                    </span>${winnerInfo}`;
        }
        return '';
    }

    // ── Banner flash ──────────────────────────────────────────────────────
    function flashBanner(message, color = 'danger') {
        const banner = $('#live-alert-banner');
        banner.removeClass('d-none alert-danger alert-warning alert-success')
              .addClass(`alert-${color}`);
        $('#live-alert-text').text(message);
        setTimeout(() => banner.addClass('d-none'), 8000);
    }

    // ── Beep ──────────────────────────────────────────────────────────────
    function playBeep() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            osc.connect(ctx.destination);
            osc.frequency.value = 880;
            osc.start();
            osc.stop(ctx.currentTime + 0.25);
        } catch(e) {}
    }

    // ── Voice ─────────────────────────────────────────────────────────────
    function speak(text) {
        if ('speechSynthesis' in window) {
            const msg = new SpeechSynthesisUtterance(text);
            msg.lang = 'en-IN';
            window.speechSynthesis.speak(msg);
        }
    }

    // ── Echo Listener ─────────────────────────────────────────────────────
    window.Echo.private('App.Models.User.' + "{{ auth()->id() }}")
        .notification((n) => {

            $('#empty-state').remove();

            const borderColor = {
                outbid_warning       : '#dc3545',
                auction_live         : '#198754',
                auction_starting_soon: '#ffc107',
                auction_ending_soon  : '#fd7e14',
                auction_winner       : '#ffc107',  // ✅ gold
                auction_result       : '#6c757d',  // ✅ gray
            }[n.type] ?? '#0d6efd';

            const highlight = n.highlight
                ? `<p class="mb-1 small fw-bold text-danger">${n.highlight}</p>`
                : '';

            // Winner info line for losers
            const winnerLine = (n.type === 'auction_result' && n.winner)
                ? `<p class="mb-1 small text-muted">
                       <i class="bi bi-person-check-fill text-success me-1"></i>
                       Winner: <strong class="text-dark">${n.winner}</strong>
                       &nbsp;|&nbsp;
                       <strong class="text-warning">${n.job_title ?? ''}</strong>
                   </p>`
                : '';

            const newRow = `
            <div id="notif-row-${n.id ?? Date.now()}"
                 class="p-3 border-bottom bg-white"
                 style="border-left:4px solid ${borderColor};transition:0.3s;animation:fadeSlideIn 0.4s ease;">
                <div class="d-flex align-items-start">
                    <div class="rounded-circle text-primary p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:42px;height:42px;background:#eef2ff;">
                        <i class="bi ${n.icon ?? 'bi-bell'}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <h6 class="mb-0 fw-bold text-dark">${n.title ?? 'New Notification'}</h6>
                            <small class="text-muted ms-2 text-nowrap" style="font-size:0.72rem;">Just now</small>
                        </div>
                        <p class="mb-1 text-muted small mt-1">${n.message ?? ''}</p>
                        ${highlight}
                        ${winnerLine}
                        <div class="d-flex gap-2 mt-2 flex-wrap">
                            <a href="/service-provider/notifications/read/${n.id ?? ''}"
                               class="btn btn-sm btn-outline-secondary py-0 px-2"
                               style="font-size:0.7rem;">
                               <i class="bi bi-check2 me-1"></i>Mark Read
                            </a>
                            ${getActionButton(n)}
                        </div>
                    </div>
                </div>
            </div>`;

            $('#notification-list-container').prepend(newRow);

            // ── Alerts per type ───────────────────────────────────────────
            if (n.type === 'outbid_warning') {
                flashBanner('⚡ You have been outbid! Place a new bid immediately.', 'danger');
                playBeep();
                speak('Alert! You have been outbid on ' + (n.job_title ?? 'a job'));
            }
            if (n.type === 'auction_live') {
                flashBanner('🟢 Auction is now LIVE! Start bidding.', 'success');
                playBeep();
                speak('Auction is now live. You can start bidding.');
            }
            if (n.type === 'auction_starting_soon') {
                flashBanner('⏰ Auction starts in less than 30 minutes. Get ready!', 'warning');
                speak('Heads up! An auction you registered for is starting soon.');
            }
            if (n.type === 'auction_ending_soon') {
                flashBanner('⌛ Auction is ending soon! Submit your final bid.', 'warning');
                playBeep();
                speak('Hurry! The auction is ending soon. Place your final bid now.');
            }
            // ✅ Winner
            if (n.type === 'auction_winner') {
                flashBanner('🏆 Congratulations! You won the auction for ' + (n.job_title ?? 'a job') + '!', 'success');
                playBeep();
                speak('Congratulations! You have been selected as the winner.');
            }
            // ✅ Loser / Result
            if (n.type === 'auction_result') {
                flashBanner('📋 Auction result declared. Winner: ' + (n.winner ?? '') + '. Your EMD refund will be processed in 4–5 working days.', 'warning');
                speak('The auction has been awarded. Your EMD refund will be processed in 4 to 5 working days.');
            }
        });
});
</script>

<style>
@keyframes fadeSlideIn {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>
@endpush