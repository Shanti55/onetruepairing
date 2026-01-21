@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Manage Blogs</h5>
            @if(hasPermissionFor('blogs_create'))
            <a href="{{ route('blogs.create') }}" id="add-category-btn" class="btn btn-primary shadow-sm">
                <i class="fas fa-add me-1"></i> Add Blog
            </a>
            @endif
        </div>

        <div class="card mt-3 border-0 pb-2 shadow-sm">
            <div class="table-responsive">
                <table id="blogs-table" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Status</th>
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

            var table = $('#blogs-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('blogs.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'content', name: 'content'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            $('body').on('click', '.deleteBlog', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('blogs.delete', {blog: id}),
                    confirmationMessage: 'Do you really want to delete this blog?',
                    onComplete: () => {
                        table.draw(false);
                    }
                })
            });

            $('body').on('click', '.updateStatus', function (e) {
                e.preventDefault();
                var status = $(this).data('status');
                var id = $(this).data('id');
                $.easyAjax({
                    url: route('blogs.status', {blog: id}),
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    disableButton: false,
                    blockUI: false,
                    onComplete: async () => {
                        table.draw(false);
                    }
                });
            });

        });
    </script>
@endpush
