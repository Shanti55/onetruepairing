@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <h5 class="fw-semibold">Manage Users</h5>

            <div>
                <!-- Filter Button -->
                <button class="btn btn-light shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
                    <i class="bi bi-funnel"></i>
                </button>
                <a href="{{ route('users.export') }}" class="btn btn-light shadow-sm">
                    <i class="bi bi-box-arrow-up"></i> Export
                </a>
                @if(hasPermissionFor('users_delete'))
                <button id="delete-selected" class="btn btn-danger shadow-sm px-2"><i class="fas fa-trash me-1"></i> Delete Selected</button>
                @endif
                @if(hasPermissionFor('users_create'))
                <a href="#" data-bs-toggle="#userModal" id="add-user-btn" class="btn btn-primary shadow-sm">
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
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        @include('admin-panel.users._form')

    </div>

@endsection

@push('js')
    <script type="module">
        $(function () {
            var table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('users.index') }}', // Backend script to fetch data
                    type: 'GET',
                    data: function (d) {
                        d.name = $('#nameFilter').val();
                        d.contact_number = $('#contactNumberFilter').val();
                        d.location = $('#locationFilter').val();
                    }
                },
                columns: [
                    @if(hasPermissionFor('users_delete'))
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                    @endif
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'userprofile.contact_number', name: 'userprofile.contact_number',defaultContent:'--'},
                    {data: 'userprofile.city', name: 'userprofile.city',defaultContent:'--'},
                    {data: 'userprofile.state', name: 'userprofile.state',defaultContent:'--'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            // Select all checkboxes
            $('#select-all').on('click', function() {
                $('.user-checkbox').prop('checked', this.checked);
            });

            $('#add-user-btn').click(function () {
                $('#id').val('');
                $('#userForm').trigger("reset");
                $('#modelHeading').html("Create New User");
                $('#userModal').modal('show');
            });

            $('#userForm').on('submit', function (e) {
                e.preventDefault();

                // Show the loader
                const submitButton = document.getElementById('save');
                submitButton.style.display = 'none';
                const loader = document.getElementById('loader');
                loader.style.display = 'block';

                var data = new FormData($('#userForm')[0]);

                $.easyAjax({
                    url: "{{ route('users.storeOrUpdate') }}",
                    container: '#userForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    onComplete: () => {
                        $('#userModal').modal('hide');
                        $('#modelHeading').html("Create New User");
                        $('#userForm').trigger("reset");
                        loader.style.display = 'none';
                        submitButton.style.display = 'block';
                        table.draw(false);
                    }
                })

            });

            $('body').on('click', '.editUser', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                axios.get(route('users.edit', {user: id})).then((response) => {
                    $('#modelHeading').html("Edit User");
                    $('#userModal').modal('show');

                    var form = $('#userForm'); // Adjust the form ID as needed

                    $.each(response.data.userprofile, function (key, value) {
                        var inputField = form.find('[name="' + key + '"]');

                        if (inputField.length) {
                            inputField.val(value);
                            $(inputField).trigger('change')
                        }
                    });

                    $.each(response.data, function (key, value) {
                        var inputField = form.find('[name="' + key + '"]');

                        if (inputField.length) {
                            inputField.val(value);
                            $(inputField).trigger('change')
                        }
                    });



                });
            });

            $('body').on('click', '.deleteUser', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('users.delete', {user: id}),
                    confirmationMessage: 'Do you really want to delete this user?',
                    onComplete: () => {
                        table.draw(false);
                    }
                })
            });

            // Bulk Delete Action
            $('#delete-selected').on('click', function() {
                let selected = [];
                $('.user-checkbox:checked').each(function() {
                    selected.push($(this).val());
                });

                if (selected.length === 0) {
                    alert('No users selected');
                    return;
                }

                if (!confirm('Are you sure you want to delete selected users?')) return;

                $.ajax({
                    url: "{{ route('users.bulk-delete') }}",
                    type: 'DELETE',
                    data: {
                        ids: selected,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        alert(response.message);
                        table.ajax.reload();
                    }
                });
            });

            // Apply Filters
            $('#applyFilters').on('click', function () {
                table.ajax.reload(); // Reload table data with new filters
            });

            // Reset Filters
            $('#resetFilters').on('click', function () {
                $('#filterForm')[0].reset(); // Reset the form inputs
                $('#nameFilter').val('').trigger('change');
                $('#contactNumberFilter').val('').trigger('change');
                table.ajax.reload(); // Reload table data without filters
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
