@extends('service-provider-panel.layouts.app')

@section('content')

<div class="px-3">
    <div class="d-flex align-items-center justify-content-between">
        <h5 class="fw-semibold">Jobs <i class="bi bi-chevron-right"></i> New Job Request</h5>
    </div>

    <div class="card mt-3 border-0 pb-2">
        <div class="table-responsive">
            <table id="job-posts-table" class="table">
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

    <!-- PLACE BID MODAL -->
    <div class="modal fade" id="bidModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="placeBidForm" method="POST" action="{{ route('service-provider.job.bid') }}">
                @csrf
             <input type="hidden" id="bid_job_id" name="job_id">


                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Place Bid</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Bid Amount (₹)</label>
                            <input type="number"
                                   name="amount"
                                   class="form-control"
                                   required
                                   min="1"
                                   placeholder="Enter bid amount">
                        </div>

                        <!-- <div class="mb-3">
                            <label class="form-label fw-semibold">Duration</label>
                            <input type="text"
                                   name="duration"
                                   class="form-control"
                                   placeholder="e.g. 7 days">
                        </div> -->

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Message</label>
                            <textarea name="message"
                                      class="form-control"
                                      rows="3"
                                      placeholder="Optional message"></textarea>
                        </div>

                        <div class="form-group mt-2">
    <label>Upload Quotation (PDF)</label>
    <input type="file" name="attachment" class="form-control" accept="application/pdf">
</div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit Bid</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection

@push('js')
<script>
$(function () {
    // 1. Table Setup
    let table = $('#job-posts-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('service-providers.request-job-posts.index') }}",
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'job_id'},
            {data: 'title'},
            {data: 'acceptance', orderable: false, searchable: false},
        ],
    });

    // 2. OPEN BID MODAL
    $('body').off('click', '.placeBidBtn').on('click', '.placeBidBtn', function () {
        let jobId = $(this).attr('data-job-id'); 
        if(jobId) {
            $('#bid_job_id').val(jobId);
            var myModal = new bootstrap.Modal(document.getElementById('bidModal'));
            myModal.show();
        } else {
            alert("Error: Job ID nahi mili!");
        }
    });

    // 3. SUBMIT BID (Using Standard AJAX as backup)
    $('#placeBidForm').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let submitBtn = form.find('button[type="submit"]');
        
        submitBtn.prop('disabled', true).text('Processing...');

        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: form.serialize(),
            success: function (response) {
                // Agar aapka controller 'status' ya 'message' bhej raha hai
                alert("Bid Submitted Successfully!");
                $('#bidModal').modal('hide');
                form[0].reset();
                table.draw(false);
            },
            error: function (error) {
                console.log(error);
                alert("Submission failed. Check console for details.");
            },
            complete: function() {
                submitBtn.prop('disabled', false).text('Submit Bid');
            }
        });
    });
});
</script>
@endpush