@extends('service-provider-panel.layouts.app')

@section('content')
<div class="px-3">
    <div class="d-flex align-items-center justify-content-between">
        <h5 class="fw-semibold">Jobs <i class="bi bi-chevron-right"></i> New Job Request</h5>
    </div>

    <div class="card mt-3 border-0 pb-2 shadow-sm">
        <div class="table-responsive">
            <table id="job-posts-table" class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Job Id</th>
                        <th>Title</th>
                        <th>Acceptance</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="bidModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form id="placeBidForm" method="POST" action="{{ route('service-provider.job.bid') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="bid_job_id" name="job_id">

                    <div class="modal-header bg-light border-0">
                        <div class="w-100 text-center position-relative">
                            <h5 class="modal-title fw-bold text-dark mb-1">Live Bidding: <span id="display_job_id" class="text-primary"></span></h5>
                            <div id="auction-timer-container" class="d-none">
                                <span class="badge bg-warning text-dark px-3 py-2 fw-bold" id="modal-timer-box">
                                    <span id="modal-timer">00h : 00m : 00s</span>
                                </span>
                                <small class="text-muted d-block mt-1 small fw-bold" id="timer-label">Remaining Time</small>
                            </div>
                            <button type="button" class="btn-close position-absolute end-0 top-0" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>

                    <div class="modal-body p-0">
                        <div class="row g-0">
                            <div class="col-md-5 bg-light border-end p-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-muted small mb-0">LIVE BID HISTORY</h6>
                                    <span class="badge bg-danger pulse-red">● LIVE</span>
                                </div>
                                <div id="live-bid-list" class="pe-2" style="height: 380px; overflow-y: auto;">
                                    <p class="text-center text-muted small mt-5">Waiting for live updates...</p>
                                </div>
                                <hr>
                                <div class="mt-2 text-center">
                                    <span class="badge bg-dark px-3 py-2 w-100 small">Super-Fast Real-time Bidding</span>
                                </div>
                            </div>

                            <div class="col-md-7 p-4 bg-white">
                                <div class="text-center mb-4 p-3 bg-light rounded shadow-sm border border-success border-opacity-25">
                                    <label class="text-muted small d-block mb-1 text-uppercase fw-bold">Current Lowest Bid</label>
                                    <h2 class="fw-bold text-success mb-0" id="modal-current-lowest">₹---</h2>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-secondary">Quick Drop Buttons</label>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <button type="button" class="btn btn-outline-primary btn-sm flex-fill fw-bold" onclick="applyDrop(500)">-₹500</button>
                                        <button type="button" class="btn btn-outline-info btn-sm flex-fill fw-bold" onclick="applyDrop(2000)">-₹2k</button>
                                        <button type="button" class="btn btn-danger btn-sm flex-fill fw-bold shadow-sm" onclick="applyDrop(5000)">
                                            <i class="bi bi-fire"></i> Monster
                                        </button>
                                    </div>

                                    <label class="form-label fw-bold small text-secondary">Manual Bid (₹)</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0">₹</span>
                                        <input type="number" id="bid_amount_input" name="amount" class="form-control border-start-0 ps-0" required placeholder="Enter amount">
                                    </div>
                                    <div id="bid-error" class="text-danger small mt-2 d-none" style="font-weight: 600;"></div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-secondary">Proposal (PDF)</label>
                                    <input type="file" name="attachment" class="form-control form-control-sm" accept="application/pdf">
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm fw-bold" id="submitBtn">
                                    <i class="bi bi-hammer me-2"></i> Submit Live Bid
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.pulse-red { animation: pulse-red 2s infinite; }
@keyframes pulse-red { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }
.new-bid-highlight { animation: highlight 2s ease-out; }
@keyframes highlight { from { background-color: #fff9c4; } to { background-color: transparent; } }
.shake { animation: shake 0.5s; }
@keyframes shake { 0%, 100% {transform: translateX(0);} 25% {transform: translateX(-5px);} 75% {transform: translateX(5px);} }
.blink-danger { animation: blink-bg 0.8s infinite !important; background-color: #dc3545 !important; color: white !important; }
@keyframes blink-bg { 0% { opacity: 1; } 50% { opacity: 0.7; } 100% { opacity: 1; } }
#live-bid-list::-webkit-scrollbar { width: 4px; }
#live-bid-list::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
</style>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>

<script>
$(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const filterJobId = urlParams.get('job_id');

    let table = $('#job-posts-table').DataTable({
        processing: true, 
        serverSide: true,
        ajax: { 
            url: "{{ route('service-providers.request-job-posts.index') }}",
            data: function (d) {
                if(filterJobId) {
                    d.job_id = filterJobId;
                }
            }
        },
        columns: [
            {data: 'DT_RowIndex'}, 
            {data: 'job_id'}, 
            {data: 'title'},
            {data: 'acceptance', orderable: false, searchable: false},
        ],
        initComplete: function() {
            if(filterJobId) {
                setTimeout(() => {
                    let firstRowFormattedId = $('#job-posts-table tbody tr:first td:nth-child(2)').text();
                    fetchAndShowBidModal(filterJobId, firstRowFormattedId);
                }, 800);
            }
        }
    });

    function speak(text) {
        if ('speechSynthesis' in window) {
            window.speechSynthesis.cancel();
            let msg = new SpeechSynthesisUtterance(text);
            msg.rate = 1.1;
            window.speechSynthesis.speak(msg);
        }
    }

    if (typeof window.Echo !== 'undefined') {
        window.Echo.private('App.Models.User.' + "{{ auth()->id() }}")
            .notification((notif) => {
                if(notif.type === 'outbid_warning') {
                    speak("Attention! You have been outbid on " + notif.job_id);
                    toastr.error(notif.message, "OUTBID ALERT!");
                }
            });
    }

    window.applyDrop = function(dropAmount) {
        let currentText = $('#modal-current-lowest').text().replace(/[^0-9.]/g, '');
        let currentLowest = parseFloat(currentText);
        if (isNaN(currentLowest)) return;
        
        let newBid = currentLowest - dropAmount;
        if (newBid > 0) {
            $('#bid_amount_input').val(Math.floor(newBid));
            $('#placeBidForm').submit(); 
        }
    }

    function updateLiveUI(data, isHistory = false) {
        let formattedAmount = parseInt(data.amount).toLocaleString('en-IN');
        if(!isHistory) $('#modal-current-lowest').text('₹' + formattedAmount);

        let myId = String("{{ auth()->id() }}");
        let bidVendorId = String(data.vendor_id);
        let isMyBid = (bidVendorId === myId);

        let displayTime = isHistory ? (data.time || 'Just now') : 'Just now';

        let bgColor = isMyBid ? '#e3f2fd' : '#ffffff'; 
        let borderColor = isMyBid ? '#0dcaf0' : '#198754';
        let textColor = isMyBid ? '#007bff' : '#198754';

        let bidItem = `
            <div class="bid-item p-2 mb-2 shadow-sm rounded ${!isHistory ? 'new-bid-highlight' : ''}" 
                  style="background-color: ${bgColor} !important; border-left: 5px solid ${borderColor} !important; border-top: 1px solid #eee; border-right: 1px solid #eee; border-bottom: 1px solid #eee;">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold" style="color: ${textColor}">₹${formattedAmount}</span>
                    <small class="text-muted" style="font-size: 10px;">${displayTime}</small>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <div class="small text-secondary" style="font-size: 11px;">${data.vendor_name || 'Vendor'}</div>
                    ${isMyBid ? '<span class="badge bg-info text-dark" style="font-size: 9px; padding: 2px 5px; font-weight: bold;">YOU</span>' : ''}
                </div>
            </div>`;
        
        if($('#live-bid-list .bid-item').length === 0) $('#live-bid-list').empty();
        isHistory ? $('#live-bid-list').append(bidItem) : $('#live-bid-list').prepend(bidItem);
    }

    function subscribeToAuction(jobId) {
        if (typeof window.Echo !== 'undefined') {
            window.Echo.leave('auction.' + jobId);
            window.Echo.channel('auction.' + jobId)
                .listen('.bid.placed', (data) => {
                    let myId = String("{{ auth()->id() }}").trim();
                    let incomingVendorId = String(data.vendor_id).trim();

                    if (incomingVendorId !== myId) {
                        let sound = new Audio('https://assets.mixkit.co/active_storage/sfx/2358/2358-preview.mp3');
                        sound.play().catch(e => {});
                        toastr.error("Warning! You have been outbid. New lowest: ₹" + data.amount);
                        speak("Attention! Someone placed a lower bid.");
                    }
                    updateLiveUI(data, false);
                });
        }
    }

    let timerInterval;
    let hasAlerted15Min = false;

    // 🛠 UPDATED: Timer logic with Auto-Disable
    function runTimer(endTime) {
        clearInterval(timerInterval);
        hasAlerted15Min = false; 
        if(!endTime) {
            $('#auction-timer-container').addClass('d-none');
            return;
        }
        $('#auction-timer-container').removeClass('d-none');
        
        function update() {
            let now = new Date().getTime();
            let distance = new Date(endTime).getTime() - now;
            
            if (distance < 0) {
                clearInterval(timerInterval);
                $('#modal-timer').text("EXPIRED");
                $('#modal-timer-box').removeClass('bg-warning bg-danger blink-danger').addClass('bg-secondary text-white');
                
                // Disable inputs and buttons
                $('#bid_amount_input').prop('disabled', true);
                $('.btn-outline-primary, .btn-outline-info, .btn-danger').prop('disabled', true);
                $('input[name="attachment"]').prop('disabled', true);
                
                $('#submitBtn').prop('disabled', true)
                             .removeClass('btn-primary')
                             .addClass('btn-secondary')
                             .html('<i class="bi bi-lock-fill me-2"></i> Bidding Ended');

                $('#bid-error').removeClass('d-none').addClass('text-muted').text("This auction has ended.");
                return;
            }

            let h = Math.floor(distance / (1000 * 60 * 60));
            let m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let s = Math.floor((distance % (1000 * 60)) / 1000);
            $('#modal-timer').text(`${h}h : ${m}m : ${s}s`);

            if (distance <= 900000) { 
                $('#modal-timer-box').removeClass('bg-warning text-dark').addClass('blink-danger');
                $('#timer-label').text("HURRY UP! CLOSING SOON").addClass('text-danger fw-bold');
                if (!hasAlerted15Min) {
                    speak("Attention! Only 15 minutes remaining for this auction.");
                    hasAlerted15Min = true;
                }
            } else {
                $('#modal-timer-box').addClass('bg-warning text-dark').removeClass('blink-danger');
                $('#timer-label').text("Remaining Time").removeClass('text-danger fw-bold');
            }
        }
        update();
        timerInterval = setInterval(update, 1000);
    }

    // 🛠 UPDATED: Reset status on every modal open
    window.fetchAndShowBidModal = function(jobId, formattedId = null) {
        if(!jobId) return;
        
        $('#bid_job_id').val(jobId);
        if(formattedId) { $('#display_job_id').text(formattedId); }

        $('#placeBidForm')[0].reset();
        $('#bid-error').addClass('d-none');

        // Reset to enabled state
        $('#bid_amount_input').prop('disabled', false);
        $('.btn-outline-primary, .btn-outline-info, .btn-danger').prop('disabled', false);
        $('input[name="attachment"]').prop('disabled', false);
        $('#submitBtn').prop('disabled', false)
                     .addClass('btn-primary')
                     .removeClass('btn-secondary')
                     .html('<i class="bi bi-hammer me-2"></i> Submit Live Bid');

        $('#live-bid-list').html('<p class="text-center text-muted small mt-5">Loading history...</p>');

        $.get("{{ url('/service-provider/get-bid-status') }}/" + jobId)
        .done(function(res) {
            $('#modal-current-lowest').text('₹' + res.lowest.toLocaleString('en-IN'));
            $('#live-bid-list').empty();
            if(res.history && res.history.length > 0) {
                res.history.forEach(bid => updateLiveUI(bid, true));
            } else {
                $('#live-bid-list').html('<p class="text-center text-muted small mt-5">No bids yet.</p>');
            }
            runTimer(res.auction_end); // Timer will auto-disable if expired
            subscribeToAuction(jobId);
            let myModal = new bootstrap.Modal(document.getElementById('bidModal'));
            myModal.show();
        })
        .fail(function() {
            toastr.error("Could not fetch bid status.");
        });
    }

    $('body').on('click', '.placeBidBtn', function () {
        let jobId = $(this).attr('data-job-id');
        let formattedId = $(this).closest('tr').find('td:nth-child(2)').text(); 
        fetchAndShowBidModal(jobId, formattedId);
    });

    $('#placeBidForm').on('submit', function (e) {
        e.preventDefault();
        let submitBtn = $('#submitBtn');
        let originalContent = submitBtn.html();
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Submitting...');

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: new FormData(this),
            processData: false, contentType: false,
            success: function (response) {
                new Audio('https://assets.mixkit.co/active_storage/sfx/2013/2013-preview.mp3').play().catch(e => {});
                confetti({ particleCount: 150, spread: 70, origin: { y: 0.6 }, zIndex: 2000 });
                toastr.success(response.message);
                $('#bidModal').modal('hide');
                table.draw(false);
            },
            error: function (xhr) {
                submitBtn.prop('disabled', false).html(originalContent);
                let msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : "Invalid Bid!";
                $('#bid-error').removeClass('d-none').text(msg);
                $('.modal-content').addClass('shake');
                setTimeout(() => $('.modal-content').removeClass('shake'), 500);
            }
        });
    });

    $('#bidModal').on('hidden.bs.modal', function () {
        let jobId = $('#bid_job_id').val();
        if(jobId && typeof window.Echo !== 'undefined') {
            window.Echo.leave('auction.' + jobId);
        }
        clearInterval(timerInterval);
    });
});
</script>
@endpush