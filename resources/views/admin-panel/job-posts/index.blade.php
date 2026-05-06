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

    // ✅ URL FILTER
    const urlParams = new URLSearchParams(window.location.search);
    const filterStatus = urlParams.get('status') || '';

    // ✅ TITLE MAP (FINAL)
    const titleMap = {
        'upcoming'          : '📋 Upcoming Auctions',
        'live'              : '🟢 Live Auctions',
        'closed'            : '⚫ Closed (Hired)',
        'under+verification': '🟣 Under Verification',
    };

    if (filterStatus && titleMap[filterStatus]) {
        $('h5.fw-semibold').text(titleMap[filterStatus]);
    }

    // ✅ DATATABLE
    var table = $('#job-posts-table').DataTable({
        processing: true,
        serverSide: true,
        order: [[7, 'desc']],
        ajax: {
            url: "{{ route('job-posts.index') }}",
            data: function (d) {
                d.filter_status = filterStatus;
            }
        },
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'job_id'},
            {data: 'title'},
            {data: 'auction_timing', orderable:false},
            @if(hasPermissionFor('jobs_status'))
            {data: 'status', orderable:false},
            @endif
            @if(hasPermissionFor('jobs_assigned_to'))
            {data: 'assigned_to'},
            @endif
            {data: 'progress_bar', orderable:false},
            {data: 'created_at'},
            {data: 'action', orderable:false},
        ]
    });

    // ✅ ADD JOB
    $('#add-job-post-btn').click(function(e){
        e.preventDefault();
        $('#jobPostForm')[0].reset();
        $('input[name="id"]').val('');
        new bootstrap.Modal('#jobPostModal').show();
    });

    // ✅ SAVE JOB
    $('#jobPostForm').submit(function(e){
        e.preventDefault();

        let btn = $('#save');
        btn.prop('disabled', true).text('Saving...');

        $.post("{{ route('job-posts.storeOrUpdate') }}", $(this).serialize(),
        function(){
            btn.prop('disabled', false).text('Save');
            bootstrap.Modal.getInstance('#jobPostModal').hide();
            table.draw();
            alert('Saved!');
        }).fail(function(){
            btn.prop('disabled', false).text('Save');
            alert('Error!');
        });
    });

    // ✅ AUCTION SUBMIT
    $('#auctionLiveForm').submit(function(e){
        e.preventDefault();

        let btn = $(this).find('button');
        btn.prop('disabled', true).text('Processing...');

        let isExtend = $('#is_extend').is(':checked');

        $.post("{{ route('job-posts.makeAuctionLive') }}", {
            _token: "{{ csrf_token() }}",
            id: $('#auction_job_id').val(),
            status: $('#target_status').val(),
            is_extend: isExtend,
            auction_start: !isExtend ? $('#auction_start').val().replace('T',' ') : null,
            auction_end: !isExtend ? $('#auction_end').val().replace('T',' ') : null,
            extend_days: isExtend ? $('#extend_days').val() : null
        },
        function(res){
            btn.prop('disabled', false).text('Save Auction');
            bootstrap.Modal.getInstance('#auctionModal').hide();
            table.draw(false);
            alert(res.message);
        }).fail(function(xhr){
            btn.prop('disabled', false).text('Save Auction');
            alert(xhr.responseJSON?.message || 'Error');
        });
    });

    // ✅ EXTEND TOGGLE
    $('#is_extend').change(function(){
        $('#extend_section').toggle(this.checked);
        $('#fresh_live_section').toggle(!this.checked);
    });

    // ✅ GLOBAL OPEN MODAL
    window.openAuctionModal = function(id, start, end, status){
        $('#auction_job_id').val(id);
        $('#auction_start').val(start ? start.replace(' ','T') : '');
        $('#auction_end').val(end ? end.replace(' ','T') : '');
        $('#target_status').val(status || 'pending');

        $('#is_extend').prop('checked', false);
        $('#extend_section').hide();
        $('#fresh_live_section').show();

        new bootstrap.Modal('#auctionModal').show();
    }

});
</script>
@endpush