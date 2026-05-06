@extends('admin-panel.layouts.app')

@section('content')
<div class="px-3">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-semibold">Manage Bids</h5>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table id="manage-bids-table" class="table table-hover align-middle mb-0">
                <thead style="background:#f8f9fc;">
                    <tr>
                        <th class="px-3 py-3">#</th>
                        <th class="py-3">Job Title</th>
                        <th class="py-3">Total Bids</th>
                        <th class="py-3">Lowest Bid</th>
                        <th class="py-3">Status</th>
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
    $('#manage-bids-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.manage-bids.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false },
            { data: 'title',       name: 'title' },
            { data: 'total_bids',  name: 'total_bids', orderable: false },
            { data: 'lowest_bid',  name: 'lowest_bid', orderable: false },
            { data: 'status',      name: 'status', orderable: false },
            { data: 'action',      name: 'action', orderable: false },
        ],
    });
});
</script>
@endpush