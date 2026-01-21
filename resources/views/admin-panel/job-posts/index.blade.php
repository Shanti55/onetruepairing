@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Manage Job Posts</h5>

            <div>
                <!-- Filter Button -->
{{--                <button class="btn btn-light shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">--}}
{{--                    <i class="bi bi-funnel"></i>--}}
{{--                </button>--}}

                @if(hasPermissionFor('jobs_create'))
                <a href="#" data-bs-toggle="#jobPostModal" id="add-job-post-btn" class="btn btn-primary shadow-sm">
                    <i class="fas fa-add me-1"></i> Add Job
                </a>
                @endif

            </div>
        </div>
{{--        @include('admin-panel.job-posts._filters')--}}
        <div class="card mt-3 border-0 pb-2 shadow-sm">
            <div class="table-responsive">
                <table id="job-posts-table" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Job Id</th>
                        <th>Title</th>
                        @if(hasPermissionFor('jobs_status'))
                        <th>Status</th>
                        @endif
                        @if(hasPermissionFor('jobs_assigned_to'))
                        <th>Assigned To</th>
                        @endif
                        <th>Progress</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        @include('admin-panel.job-posts._form')

    </div>

@endsection

@push('js')
    <script type="module">
        $(function () {

            var table = $('#job-posts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('job-posts.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'job_id', name: 'job_id'},
                    {data: 'title', name: 'title'},
                    @if(hasPermissionFor('jobs_status'))
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    @endif
                    @if(hasPermissionFor('jobs_status'))
                    {data: 'assigned_to', name: 'assigned_to'},
                    @endif
                    {data: 'progress_bar', name: 'progress_bar', orderable: false, searchable: false},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            $('#add-job-post-btn').click(function () {
                $('#id').val('');
                $('#jobPostForm').trigger("reset");
                $('#modelHeading').html("New Job Post");
                $('#jobPostModal').modal('show');
            });

            $('#jobPostForm').on('submit', function (e) {
                e.preventDefault();

                var data = new FormData($('#jobPostForm')[0]);

                $.easyAjax({
                    url: "{{ route('job-posts.storeOrUpdate') }}",
                    container: '#jobPostForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    onComplete: () => {
                        $('#jobPostModal').modal('hide');
                        $('#modelHeading').html("Post New Job");
                        $('#jobPostForm').trigger("reset");
                        table.draw(false);
                    }
                })

            });

            $('body').on('click', '.editJobPost', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                axios.get(route('job-posts.edit', {job: id})).then((response) => {
                    $('#modelHeading').html("Edit Job Post");
                    $('#jobPostModal').modal('show');

                    var form = $('#jobPostForm'); // Adjust the form ID as needed

                    $.each(response.data.job, function (key, value) {
                        var inputField = form.find('[name="' + key + '"]'); // Scope to form
                        if (inputField.length) {
                            inputField.val(value);
                            $(inputField).trigger('change')
                        }
                    });

                    //set categories
                    $('#categories').val(response.data.categories);
                    $('#categories').trigger('change');

                });
            });

            $('body').on('click', '.deleteJobPost', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('job-posts.delete', {job: id}),
                    confirmationMessage: 'Do you really want to delete this job ?',
                    onComplete: () => {
                        table.draw(false);
                    }
                })
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

            //Set Assignee
            $('body').on('click', '.updateAssignedTo', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var assignedTo = $(this).data('job_assigned_to');

                $.easyAjax({
                    url: "{{ route('job-posts.updateAssignedTo') }}",
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}',
                        assignedTo: assignedTo,
                    },
                    onComplete: () => {
                        table.draw(false);
                    }
                })

            });

        });

    </script>
@endpush
