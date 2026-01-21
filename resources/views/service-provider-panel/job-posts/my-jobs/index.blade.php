@extends('service-provider-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Jobs <i class="bi bi-chevron-right"></i> My Jobs</h5>
        </div>

        <div class="card mt-3 border-0 pb-2">
            <div class="table-responsive">
                <table id="my-jobs-table" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Job Id</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script type="module">
        $(function () {
            var table = $('#my-jobs-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('service-providers.my-jobs.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'job_id', name: 'job_id'},
                    {data: 'title', name: 'title'},
                    {data: 'bid_amount', name: 'bid_amount'}, // Naya column
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });


            //Status Update
            $('body').on('click', '.updateStatus', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var status = $(this).data('job_status');

                $.easyAjax({
                    url: "{{ route('job-posts.updateStatus') }}",
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    onComplete: () => {
                        table.draw(false);
                    }
                })

            });

        });

    </script>
@endpush
