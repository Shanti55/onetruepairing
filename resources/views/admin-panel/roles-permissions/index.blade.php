@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Manage Roles & Permission</h5>

            @if(hasPermissionFor('roles_permissions_create'))
            <a href="#" data-bs-toggle="#rolesPermissionsModal" id="add-roles_permissions-btn" class="btn btn-primary shadow-sm">
                <i class="fas fa-add me-1"></i> Add Roles
            </a>
            @endif
        </div>

    <div class="card mt-3 border-0 pb-2 shadow-sm">
        <div class="table-responsive">
            <table id="roles-permissions-table" class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

        @include('admin-panel.roles-permissions._create')
    </div>
@endsection

@push('js')
    <script type="module">
        $(function () {

            var table = $('#roles-permissions-table').DataTable({
                processing: true,
                serverSide: true,
               // columnDefs: [{ width: '30%', targets: 5 }],
                ajax: "{{ route('roles-permissions.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            $('#add-roles_permissions-btn').click(function () {
                $('#id').val('');
                $('#rolesPermissionsForm').trigger("reset");
                $('#modelHeading').html("Create New Roles & Permission");
                $('#rolesPermissionsModal').modal('show');
            });

            $('#rolesPermissionsForm').on('submit', function (e) {
                e.preventDefault();

                var data = new FormData($('#rolesPermissionsForm')[0]);

                $.easyAjax({
                    url: "{{ route('roles-permissions.storeOrUpdate') }}",
                    container: '#rolesPermissionsForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    onComplete: () => {
                        $('#rolesPermissionsModal').modal('hide');
                        $('#modelHeading').html("Create New Roles & Permissions");
                        $('#rolesPermissionsForm').trigger("reset");
                        table.draw(false);
                    }
                })
            });

            $('body').on('click', '.editRolesPermissions', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                axios.get(route('roles-permissions.edit', {roles: id})).then((response) => {
                    $('#modelHeading').html("Edit Roles & Permissions");
                    $('#rolesPermissionsModal').modal('show');

                    var form = $('#rolesPermissionsForm').trigger("reset");

                    // $.each(response.data, function (key, value) {
                    //     var inputField = form.find('[name="' + key + '"]');
                    //
                    //     if (inputField.length) {
                    //         inputField.val(value);
                    //         $(inputField).trigger('change')
                    //     }
                    // });

                    $.each(response.data, function (key, value) {
                        if (key === "module_access" && Array.isArray(value)) {
                            form.find('[name="module_access[]"]').each(function () {
                                var checkboxValue = $(this).val();
                                if (value.includes(checkboxValue)) {
                                    $(this).prop('checked', true);
                                } else {
                                    $(this).prop('checked', false);
                                }
                            });
                        }else if (key === "permissions" && Array.isArray(value)) {
                            form.find('[name="permissions[]"]').each(function () {
                                var checkboxValue = $(this).val();
                                if (value.includes(checkboxValue)) {
                                    $(this).prop('checked', true);
                                } else {
                                    $(this).prop('checked', false);
                                }
                            });
                        } else {
                            var inputField = form.find('[name="' + key + '"]');
                            if (inputField.length) {
                                inputField.val(value);
                                $(inputField).trigger('change');
                            }
                        }
                    });

                });
            });

            $('body').on('click', '.deleteRolesPermissions', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('roles-permissions.delete', {roles: id}),
                    confirmationMessage: 'Do you really want to delete this roles ?',
                    onComplete: () => {
                        table.draw(false);
                    }
                })
            });

        });
    </script>
@endpush
