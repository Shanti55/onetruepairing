@extends('service-provider-panel.layouts.app')

@section('content')
<div class="px-3">
    <div class="d-flex align-items-center justify-content-between">
        <h5 class="fw-semibold">Manage My Job Posts</h5>
        <a href="#" id="add-job-post-btn" class="btn btn-primary shadow-sm">
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
                <tbody></tbody>
            </table>
        </div>
    </div>

    @include('service-provider-panel.job-posts.my-job-posts._form')
</div>
@endsection

@push('js')
<script type="module">
$(function () {

    // ── DataTable ─────────────────────────────────────────────────────────
    var table = $('#my-job-posts-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('service-providers.my-job-posts.index') }}",
        columns: [
            {data: 'DT_RowIndex',  name: 'DT_RowIndex'},
            {data: 'job_id',       name: 'job_id'},
            {data: 'title',        name: 'title'},
            {data: 'status',       name: 'status',       orderable: false, searchable: false},
            {data: 'assigned_to',  name: 'assigned_to'},
            {data: 'progress_bar', name: 'progress_bar', orderable: false, searchable: false},
            {data: 'action',       name: 'action',       orderable: false, searchable: false},
        ],
    });

    // ── Bootstrap 5 native modal ──────────────────────────────────────────
    const jobPostModal = new bootstrap.Modal(document.getElementById('jobPostModal'));

    // ── Add Job ───────────────────────────────────────────────────────────
    $('#add-job-post-btn').on('click', function (e) {
        e.preventDefault();
        $('#id').val('');
        $('#jobPostForm').trigger("reset");
        $('#modelHeading').html("New Job Post");
        jobPostModal.show();
    });

    // ── Save / Update ─────────────────────────────────────────────────────
    $('#jobPostForm').on('submit', function (e) {
        e.preventDefault();

        const $btn = $('#jobPostForm').find('[type="submit"]');
        $btn.prop('disabled', true).text('Saving...');

        $.ajax({
            url     : "{{ route('service-providers.my-job-posts.storeOrUpdate') }}",
            type    : 'POST',
            data    : new FormData(this),
            processData: false,
            contentType: false,
            success : function (res) {
                $btn.prop('disabled', false).text('Save');
                jobPostModal.hide();
                $('#modelHeading').html("Post New Job");
                $('#jobPostForm').trigger("reset");
                table.draw(false);
                showToast(res.message ?? 'Job saved successfully!', 'success');
            },
            error   : function (xhr) {
                $btn.prop('disabled', false).text('Save');
                const msg = xhr.responseJSON?.message ?? 'Something went wrong.';
                showToast(msg, 'danger');
            }
        });
    });

    // ── Edit ──────────────────────────────────────────────────────────────
    $('body').on('click', '.editJobPost', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        axios.get(route('service-providers.my-job-posts.edit', {job: id})).then((response) => {
            $('#modelHeading').html("Edit Job Post");
            jobPostModal.show();

            var form = $('#jobPostForm').trigger("reset");
            $.each(response.data.job, function (key, value) {
                var inputField = form.find('[name="' + key + '"]');
                if (inputField.length) {
                    inputField.val(value);
                    $(inputField).trigger('change');
                }
            });

            $('#categories').val(response.data.categories);
            $('#categories').trigger('change');
        });
    });

    // ── Delete ────────────────────────────────────────────────────────────
    $('body').on('click', '.deleteJobPost', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        if (!confirm('Do you really want to delete this job?')) return;

        $.ajax({
            url  : route('service-providers.my-job-posts.delete', {job: id}),
            type : 'DELETE',
            data : { _token: "{{ csrf_token() }}" },
            success: function () {
                table.draw(false);
                showToast('Job deleted successfully!', 'success');
            },
            error: function () {
                showToast('Failed to delete job.', 'danger');
            }
        });
    });

    // ── Toast helper ──────────────────────────────────────────────────────
    function showToast(message, type = 'success') {
        const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
        const toast = $(`
            <div class="toast align-items-center text-white ${bgClass} border-0 shadow"
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
        new bootstrap.Toast(toast[0], { delay: 3500 }).show();
        toast[0].addEventListener('hidden.bs.toast', () => toast.remove());
    }

});
</script>
@endpush