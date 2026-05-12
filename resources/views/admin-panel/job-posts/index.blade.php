@extends('admin-panel.layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between">
    <h5 class="fw-semibold">Manage Job Posts</h5>

    <div class="d-flex gap-2">
        <a href="{{ route('job-posts.trash') }}" class="btn btn-sm btn-outline-danger">
            <i class="bi bi-trash3 me-1"></i>Trash
        </a>

        @if(hasPermissionFor('jobs_create'))
        <a href="#" id="add-job-post-btn" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Add Job
        </a>
        @endif
    </div>
</div>

<div class="card mt-3 border-0 pb-2 shadow-sm">
    <div class="table-responsive">
        <table id="job-posts-table" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Job Id</th>
                    <th>Title</th>
                    <th>Auction Timing</th>
                    @if(hasPermissionFor('jobs_status')) <th>Status</th> @endif
                    @if(hasPermissionFor('jobs_assigned_to')) <th>Assigned To</th> @endif
                    <th>Progress</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@include('admin-panel.job-posts._form')

{{-- Auction Modal --}}
<div class="modal fade" id="auctionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-broadcast me-2"></i>Auction Control
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <form id="auctionLiveForm">
                    <input type="hidden" id="auction_job_id">

                    <div class="mb-3">
                        <label class="small fw-bold text-uppercase">Auction Status</label>
                        <select id="target_status" class="form-select">
                            <option value="pending">Upcoming</option>
                            <option value="open">Live</option>
                            <option value="closed">Close Auction</option>
                        </select>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_extend">
                        <label class="form-check-label fw-bold">Extend Timing?</label>
                    </div>

                    {{-- Fresh --}}
                    <div id="fresh_live_section">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="small fw-bold">Start</label>
                                <input type="datetime-local" id="auction_start" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold">End</label>
                                <input type="datetime-local" id="auction_end" class="form-control">
                            </div>
                        </div>
                    </div>

                    {{-- Extend --}}
                    <div id="extend_section" style="display:none;">
                        <label class="small fw-bold text-danger">Add Days</label>
                        <select id="extend_days" class="form-select">
                            <option value="1">1 Day</option>
                            <option value="2">2 Days</option>
                            <option value="7">7 Days</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100 mt-4">
                        Save Auction
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(function () {

    // ── URL FILTER ────────────────────────────────────────────────────────
    const urlParams    = new URLSearchParams(window.location.search);
    const filterStatus = urlParams.get('status') || '';

    const titleMap = {
        'upcoming'          : '📋 Upcoming Auctions',
        'live'              : '🟢 Live Auctions',
        'closed'            : '⚫ Closed (Hired)',
        'under_verification': '🟣 Under Verification',
    };

    if (filterStatus && titleMap[filterStatus]) {
        $('h5.fw-semibold').text(titleMap[filterStatus]);
    }

    // ── DATATABLE ─────────────────────────────────────────────────────────
    var table = $('#job-posts-table').DataTable({
        processing: true,
        serverSide: true,
        order: [[7, 'desc']],
        ajax: {
            url: "{{ route('job-posts.index') }}",
            data: function (d) { d.filter_status = filterStatus; }
        },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'job_id' },
            { data: 'title' },
            { data: 'auction_timing', orderable: false },
            @if(hasPermissionFor('jobs_status'))
            { data: 'status', orderable: false },
            @endif
            @if(hasPermissionFor('jobs_assigned_to'))
            { data: 'assigned_to' },
            @endif
            { data: 'progress_bar', orderable: false },
            { data: 'created_at' },
            { data: 'action', orderable: false },
        ]
    });

    // ── ADD JOB ───────────────────────────────────────────────────────────
    $('#add-job-post-btn').click(function (e) {
        e.preventDefault();
        $('#jobPostForm')[0].reset();
        $('input[name="id"]').val('');
        $('#jobPostModal .modal-title').text('Add Job Post'); // optional title reset
        new bootstrap.Modal('#jobPostModal').show();
    });

    // ── EDIT JOB ──────────────────────────────────────────────────────────
    $('body').on('click', '.editJobPost', function () {
        const id = $(this).data('id');

        $.get("{{ url('admin/job-posts') }}/" + id, function (res) {
            const job = res.job;

            $('#jobPostForm')[0].reset();
            $('input[name="id"]').val(job.id);
            $('input[name="title"]').val(job.title);
            $('textarea[name="description"]').val(job.description ?? '');
            $('input[name="location"]').val(job.location ?? '');
            $('input[name="budget"]').val(job.budget ?? '');

            // ── Sync category checkboxes ──
            $('input[name="categories[]"]').prop('checked', false);
            if (res.categories && res.categories.length) {
                res.categories.forEach(function (catId) {
                    $('input[name="categories[]"][value="' + catId + '"]').prop('checked', true);
                });
            }

            $('#jobPostModal .modal-title').text('Edit Job Post');
            new bootstrap.Modal('#jobPostModal').show();

        }).fail(function () {
            alert('Could not load job data. Please try again.');
        });
    });

    // ── DELETE JOB ────────────────────────────────────────────────────────
    $('body').on('click', '.deleteJobPost', function () {
        if (!confirm('Move this job to trash?')) return;

        const id  = $(this).data('id');
        const btn = $(this);
        btn.prop('disabled', true);

        $.ajax({
            url  : "{{ url('admin/job-posts') }}/" + id,
            type : 'DELETE',
            data : { _token: "{{ csrf_token() }}" },
            success: function (res) {
                table.draw(false);
                showToast(res.message, 'success');
            },
            error: function () {
                btn.prop('disabled', false);
                showToast('Delete failed! Please try again.', 'danger');
            }
        });
    });

    // ── SAVE JOB ──────────────────────────────────────────────────────────
    $('#jobPostForm').submit(function (e) {
        e.preventDefault();

        let btn = $('#save');
        btn.prop('disabled', true).text('Saving...');

        $.post("{{ route('job-posts.storeOrUpdate') }}", $(this).serialize(),
        function () {
            btn.prop('disabled', false).text('Save');
            bootstrap.Modal.getInstance('#jobPostModal').hide();
            table.draw();
            showToast('Job saved successfully!', 'success');
        }).fail(function (xhr) {
            btn.prop('disabled', false).text('Save');
            const msg = xhr.responseJSON?.message || 'Something went wrong!';
            showToast(msg, 'danger');
        });
    });

    // ── AUCTION SUBMIT ────────────────────────────────────────────────────
    $('#auctionLiveForm').submit(function (e) {
        e.preventDefault();

        let btn      = $(this).find('button[type="submit"]');
        let isExtend = $('#is_extend').is(':checked');
        btn.prop('disabled', true).text('Processing...');

        $.post("{{ route('job-posts.makeAuctionLive') }}", {
            _token       : "{{ csrf_token() }}",
            id           : $('#auction_job_id').val(),
            status       : $('#target_status').val(),
            is_extend    : isExtend,
            auction_start: !isExtend ? $('#auction_start').val().replace('T', ' ') : null,
            auction_end  : !isExtend ? $('#auction_end').val().replace('T', ' ')   : null,
            extend_days  : isExtend  ? $('#extend_days').val()                      : null,
        },
        function (res) {
            btn.prop('disabled', false).text('Save Auction');
            bootstrap.Modal.getInstance('#auctionModal').hide();
            table.draw(false);
            showToast(res.message, 'success');
        }).fail(function (xhr) {
            btn.prop('disabled', false).text('Save Auction');
            showToast(xhr.responseJSON?.message || 'Error!', 'danger');
        });
    });

    // ── EXTEND TOGGLE ─────────────────────────────────────────────────────
    $('#is_extend').change(function () {
        $('#extend_section').toggle(this.checked);
        $('#fresh_live_section').toggle(!this.checked);
    });

    // ── GLOBAL: Open Auction Modal ────────────────────────────────────────
    window.openAuctionModal = function (id, start, end, status) {
        $('#auction_job_id').val(id);
        $('#auction_start').val(start ? start.replace(' ', 'T') : '');
        $('#auction_end').val(end   ? end.replace(' ', 'T')   : '');
        $('#target_status').val(status || 'pending');
        $('#is_extend').prop('checked', false);
        $('#extend_section').hide();
        $('#fresh_live_section').show();
        new bootstrap.Modal('#auctionModal').show();
    };


    // ── UPDATE STATUS ─────────────────────────────────────────────────────
$('body').on('click', '.updateStatus', function () {
    const jobId    = $(this).attr('id');          // id attribute se job id
    const status   = $(this).data('job_status');  // data-job_status se status
    const btn      = $(this);

    btn.prop('disabled', true);

    $.post("{{ route('job-posts.updateStatus') }}", {
        _token : "{{ csrf_token() }}",
        id     : jobId,
        status : status,
    },
    function (res) {
        btn.prop('disabled', false);
        table.draw(false);               // row refresh karo
        showToast(res.message || 'Status updated!', 'success');
    }).fail(function () {
        btn.prop('disabled', false);
        showToast('Status update failed!', 'danger');
    });
});

    // ── TOAST Helper ──────────────────────────────────────────────────────
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

