@extends('service-provider-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Manage My Job Posts</h5>

            <a href="#" data-bs-toggle="#jobPostModal" id="add-job-post-btn" class="btn btn-primary shadow-sm">
                <i class="fa fa-plus me-1"></i>Add Job
            </a>
        </div>

        <div class="card mt-3 border-0 pb-2">
            <div class="table-responsive">
                <table id="my-job-posts-table" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Job Id</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Progress</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        @include('service-provider-panel.job-posts.my-job-posts._form')

    </div>

@endsection

@push('js')
    <script type="module">
        $(function () {

            var table = $('#my-job-posts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('service-providers.my-job-posts.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'job_id', name: 'job_id'},
                    {data: 'title', name: 'title'},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    {data: 'assigned_to', name: 'assigned_to'},
                    {data: 'progress_bar', name: 'progress_bar', orderable: false, searchable: false},
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
                    url: "{{ route('service-providers.my-job-posts.storeOrUpdate') }}",
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
                axios.get(route('service-providers.my-job-posts.edit', {job: id})).then((response) => {
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
                    url: route('service-providers.my-job-posts.delete', {job: id}),
                    confirmationMessage: 'Do you really want to delete this job ?',
                    onComplete: () => {
                        table.draw(false);
                    }
                })
            });





        });

    </script>
@endpush
