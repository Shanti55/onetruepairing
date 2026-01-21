@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Manage Admins</h5>

            @if(hasPermissionFor('admins_create'))
            <a href="javascript:void(0)" data-bs-toggle="#adminModal" id="add-admin-btn" class="btn btn-primary shadow-sm">
                <i class="fas fa-add me-1"></i> Add Admin
            </a>
            @endif

        </div>

        <div class="card mt-3 border-0 pb-2 shadow-sm">
            <div class="table-responsive">
                <table id="admins-table" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone No.</th>
                        <th>Referral Code</th>
                        <th>Roles & Permissions</th>
                        <th>Service Provider(*)</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        @include('admin-panel.admins._form')

    </div>

@endsection

@push('js')
    <script type="module">
        $(function () {

            var table = $('#admins-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admins.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'primary_mobile_number', name: 'primary_mobile_number'},
                    {data: 'referral_code', name: 'referral_code'},
                    {data: 'role_permission.name', name: 'role_permission.name'},
                    {data: 'provider_counts', name: 'provider_counts'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            $('#add-admin-btn').click(function () {
                $('#id').val('');
                $('#adminForm').trigger("reset");
                $('#modelHeading').html("Create New Admin");
                $('#adminModal').modal('show');
            });

            $('#adminForm').on('submit', function (e) {
                e.preventDefault();

                var data = new FormData($('#adminForm')[0]);

                $.easyAjax({
                    url: "{{ route('admins.storeOrUpdate') }}",
                    container: '#adminForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    onComplete: () => {
                        $('#adminModal').modal('hide');
                        $('#modelHeading').html("Create New Admin");
                        $('#adminForm').trigger("reset");
                        table.draw(false);
                    }
                })

            });

            $('body').on('click', '.editAdmin', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                axios.get(route('admins.edit', {admin: id})).then((response) => {
                    $('#modelHeading').html("Edit Admin");
                    $('#adminModal').modal('show');

                    var form = $('#adminForm'); // Adjust the form ID as needed

                    $.each(response.data, function (key, value) {
                        var inputField = form.find('[name="' + key + '"]'); // Scope to form

                        if (inputField.length) {
                            inputField.val(value);
                            $(inputField).trigger('change')
                        }
                    });

                });
            });

            $('body').on('click', '.deleteAdmin', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('admins.delete', {admin: id}),
                    confirmationMessage: 'Do you really want to delete this admin?',
                    onComplete: () => {
                        table.draw(false);
                    }
                })
            });

            //Password Toggle
            document.getElementById('togglePassword').addEventListener('click', function () {
                const passwordInput = document.getElementById('password');
                const toggleIcon = document.getElementById('toggleIcon');

                // Toggle the type attribute
                const isPasswordVisible = passwordInput.type === 'password';
                passwordInput.type = isPasswordVisible ? 'text' : 'password';

                // Toggle the eye icon
                toggleIcon.classList.toggle('bi-eye');
                toggleIcon.classList.toggle('bi-eye-slash');
            });

            //Password Toggle2
            document.getElementById('togglePassword2').addEventListener('click', function () {
                const passwordInput = document.getElementById('password_confirmation');
                const toggleIcon = document.getElementById('toggleIcon2');

                // Toggle the type attribute
                const isPasswordVisible = passwordInput.type === 'password';
                passwordInput.type = isPasswordVisible ? 'text' : 'password';

                // Toggle the eye icon
                toggleIcon.classList.toggle('bi-eye');
                toggleIcon.classList.toggle('bi-eye-slash');
            });


        });
    </script>
@endpush
