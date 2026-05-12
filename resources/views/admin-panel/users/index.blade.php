@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <h5 class="fw-semibold">Manage Users</h5>

            <div>
                <button class="btn btn-light shadow-sm" type="button" data-bs-toggle="collapse"
                        data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
                    <i class="bi bi-funnel"></i>
                </button>
                <a href="{{ route('users.export') }}" class="btn btn-light shadow-sm">
                    <i class="bi bi-box-arrow-up"></i> Export
                </a>
                @if(hasPermissionFor('users_delete'))
                <button id="delete-selected" class="btn btn-danger shadow-sm px-2">
                    <i class="fas fa-trash me-1"></i> Delete Selected
                </button>
                @endif
                @if(hasPermissionFor('users_create'))
                <a href="#" id="add-user-btn" class="btn btn-primary shadow-sm">
                    <i class="fas fa-add me-1"></i> Add User
                </a>
                @endif
            </div>
        </div>

        @include('admin-panel.users._filters')

        <div class="card mt-3 border-0 pb-2 shadow-sm">
            <div class="table-responsive">
                <table id="users-table" class="table">
                    <thead>
                        <tr>
                            @if(hasPermissionFor('users_delete'))
                            <th><input type="checkbox" id="select-all"></th>
                            @endif
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        @include('admin-panel.users._form')
    </div>

@endsection

@push('js')
<script>
$(function () {

    // ── DataTable ─────────────────────────────────────────────────────────
    var table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url : '{{ route('users.index') }}',
            type: 'GET',
            data: function (d) {
                d.name           = $('#nameFilter').val();
                d.contact_number = $('#contactNumberFilter').val();
                d.location       = $('#locationFilter').val();
            }
        },
        columns: [
            @if(hasPermissionFor('users_delete'))
            { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
            @endif
            { data: 'DT_RowIndex',               name: 'DT_RowIndex' },
            { data: 'name',                       name: 'name' },
            { data: 'email',                      name: 'email' },
            { data: 'userprofile.contact_number', name: 'userprofile.contact_number', defaultContent: '--' },
            { data: 'userprofile.city',           name: 'userprofile.city',           defaultContent: '--' },
            { data: 'userprofile.state',          name: 'userprofile.state',          defaultContent: '--' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
    });

    // ── Select All ────────────────────────────────────────────────────────
    $('#select-all').on('click', function () {
        $('.user-checkbox').prop('checked', this.checked);
    });

    // ── Add User ──────────────────────────────────────────────────────────
    $('#add-user-btn').on('click', function (e) {
        e.preventDefault();
        $('#id').val('');
        $('#userForm').trigger('reset');
        $('#modelHeading').html('Create New User');
        $('#userModal').modal('show');
    });

    // ── Edit User ─────────────────────────────────────────────────────────
    $('body').on('click', '.editUser', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        $.get("{{ url('admin/users') }}/" + id, function (response) {
            $('#modelHeading').html('Edit User');
            $('#userForm').trigger('reset');
            $('#userModal').modal('show');

            var form = $('#userForm');

            // Fill userprofile fields
            if (response.userprofile) {
                $.each(response.userprofile, function (key, value) {
                    var field = form.find('[name="' + key + '"]');
                    if (field.length) field.val(value).trigger('change');
                });
            }

            // Fill user fields (objects skip karo)
            $.each(response, function (key, value) {
                var field = form.find('[name="' + key + '"]');
                if (field.length && typeof value !== 'object') {
                    field.val(value).trigger('change');
                }
            });

        }).fail(function () {
            alert('Could not load user data. Please try again.');
        });
    });

    // ── Delete User ───────────────────────────────────────────────────────
    $('body').on('click', '.deleteUser', function (e) {
        e.preventDefault();
        if (!confirm('Do you really want to delete this user?')) return;

        var id  = $(this).data('id');
        var btn = $(this);
        btn.prop('disabled', true);

        $.ajax({
            url  : "{{ url('admin/users') }}/" + id,
            type : 'DELETE',
            data : { _token: "{{ csrf_token() }}" },
            success: function (res) {
                table.draw(false);
                alert(res.message || 'User deleted successfully!');
            },
            error: function () {
                btn.prop('disabled', false);
                alert('Delete failed! Please try again.');
            }
        });
    });

    // ── Save User (Form Submit) ───────────────────────────────────────────
    $('#userForm').on('submit', function (e) {
        e.preventDefault();

        const submitButton = document.getElementById('save');
        const loader       = document.getElementById('loader');
        submitButton.style.display = 'none';
        loader.style.display       = 'block';

        $.easyAjax({
            url          : "{{ route('users.storeOrUpdate') }}",
            container    : '#userForm',
            type         : 'POST',
            disableButton: true,
            blockUI      : true,
            data         : new FormData($('#userForm')[0]),
            onComplete   : () => {
                $('#userModal').modal('hide');
                $('#modelHeading').html('Create New User');
                $('#userForm').trigger('reset');
                loader.style.display       = 'none';
                submitButton.style.display = 'block';
                table.draw(false);
            }
        });
    });

    // ── Bulk Delete ───────────────────────────────────────────────────────
    $('#delete-selected').on('click', function () {
        let selected = [];
        $('.user-checkbox:checked').each(function () {
            selected.push($(this).val());
        });

        if (selected.length === 0) {
            alert('No users selected.');
            return;
        }

        if (!confirm('Are you sure you want to delete selected users?')) return;

        $.ajax({
            url  : "{{ route('users.bulk-delete') }}",
            type : 'DELETE',
            data : { ids: selected, _token: "{{ csrf_token() }}" },
            success: function (response) {
                alert(response.message);
                table.ajax.reload();
            },
            error: function () {
                alert('Bulk delete failed! Please try again.');
            }
        });
    });

    // ── Apply Filters ─────────────────────────────────────────────────────
    $('#applyFilters').on('click', function () {
        table.ajax.reload();
    });

    // ── Reset Filters ─────────────────────────────────────────────────────
    $('#resetFilters').on('click', function () {
        $('#filterForm')[0].reset();
        $('#nameFilter').val('').trigger('change');
        $('#contactNumberFilter').val('').trigger('change');
        table.ajax.reload();
    });

    // ── Password Toggle ───────────────────────────────────────────────────
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon  = document.getElementById('toggleIcon');
        input.type  = input.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });

    document.getElementById('togglePassword2').addEventListener('click', function () {
        const input = document.getElementById('password_confirmation');
        const icon  = document.getElementById('toggleIcon2');
        input.type  = input.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });

});
</script>
@endpush