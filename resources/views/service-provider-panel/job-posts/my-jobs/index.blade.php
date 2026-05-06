@extends('service-provider-panel.layouts.app')

@section('content')
<div class="px-3">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-semibold">Jobs <i class="bi bi-chevron-right"></i> My Jobs</h5>
    </div>

    <div class="card mt-2 border-0 shadow-sm">
        <div class="table-responsive">
            <table id="my-jobs-table" class="table table-hover align-middle mb-0">
                <thead style="background:#f8f9fc;">
                    <tr>
                        <th class="px-3 py-3">#</th>
                        <th class="py-3">Job ID</th>
                        <th class="py-3">Title & Details</th>
                        <th class="py-3">My Bid</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Progress</th>
                        <th class="py-3">Action</th>
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
    $('#my-jobs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('service-providers.my-jobs.index') }}",
        columns: [
            { data: 'DT_RowIndex',  name: 'DT_RowIndex',  orderable: false },
            { data: 'job_id',       name: 'job_id',        orderable: false },
            { data: 'title',        name: 'title',         orderable: false },
            { data: 'bid_amount',   name: 'bid_amount',    orderable: false },
            { data: 'status',       name: 'status',        orderable: false },
            { data: 'progress_bar', name: 'progress_bar',  orderable: false },
            { data: 'action',       name: 'action',        orderable: false },
        ],
    });
});
</script>
@endpush