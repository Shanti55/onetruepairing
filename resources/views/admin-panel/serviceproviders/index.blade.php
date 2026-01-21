@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <h5 class="fw-semibold">Manage Service Providers</h5>

            <div>
                <!-- Filter Button -->
                <button class="btn btn-light shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
                    <i class="bi bi-funnel"></i>
                </button>
                @if(hasPermissionFor('service_providers_export'))
                <a href="{{ route('serviceproviders.export') }}" class="btn btn-light shadow-sm">
                    <i class="bi bi-box-arrow-up"></i> Export
                </a>
                @endif
                @if(hasPermissionFor('service_providers_import'))
                <a  href="#" data-bs-toggle="modal" data-bs-target="#serviceProviderImportModal" class="btn btn-light shadow-sm">
                    <i class="bi  bi-box-arrow-down"></i> Import
                </a>
                @endif
                @if(hasPermissionFor('service_providers_delete'))
                    <button id="delete-selected" class="btn btn-danger shadow-sm"><i class="fas fa-trash me-1"></i> Delete Selected</button>
                @endif
                @if(hasPermissionFor('service_providers_create'))
                <a href="#" data-bs-toggle="#serviceProviderModal" id="add-serviceprovider-btn" class="btn btn-primary shadow-sm mt-2 mt-md-0">
                    <i class="fas fa-add me-1"></i> Add Service Provider
                </a>
                @endif
            </div>

        </div>
        @include('admin-panel.serviceproviders._filters')
        <div class="card mt-3 border-0 pb-2 shadow-sm">
            <div class="table-responsive">
                <table id="serviceproviders-table" class="table">
                    <thead>
                    <tr>
                        @if(hasPermissionFor('service_providers_delete'))
                        <th><input type="checkbox" id="select-all"></th>
                        @endif
                        <th>#</th>
                        <th>Company Name</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone No.</th>
                        @if(hasPermissionFor('service_providers_offline_verification'))
                        <th>Offline Verification</th>
                        @endif
                        @if(hasPermissionFor('service_providers_status'))
                        <th>Status</th>
                        @endif
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        @include('admin-panel.serviceproviders._form')
        @include('admin-panel.serviceproviders._import')

    </div>

@endsection

@push('js')
    <script type="module">
        $(function () {

            var table = $('#serviceproviders-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                ajax: {
                    url: '{{ route('serviceproviders.index') }}', // Backend script to fetch data
                    type: 'GET',
                    data: function (d) {
                        d.company_name = $('#companyFilter').val();
                        d.name = $('#nameFilter').val();
                        d.contact_number = $('#contactNumberFilter').val();
                        d.location = $('#locationFilter').val();
                    }
                },
                columns: [
                    @if(hasPermissionFor('service_providers_delete'))
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                    @endif
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'serviceproviderprofile.company_name',name: 'serviceproviderprofile.company_name'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'serviceproviderprofile.contact_number',name: 'serviceproviderprofile.contact_number'},
                    @if(hasPermissionFor('service_providers_offline_verification'))
                    {data: 'offline_verification', name: 'offline_verification', orderable: false, searchable: false},
                    @endif
                    @if(hasPermissionFor('service_providers_status'))
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    @endif
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            // Select all checkboxes
            $('#select-all').on('click', function() {
                $('.user-checkbox').prop('checked', this.checked);
            });

            $('#add-serviceprovider-btn').click(function () {
                $('#id').val('');
                $('#serviceProviderForm').trigger("reset");
                $('#modelHeading').html("Create New Service Provider");
                $('#serviceProviderModal').modal('show');
            });

            $('#serviceProviderForm').on('submit', function (e) {
                e.preventDefault();

                var data = new FormData($('#serviceProviderForm')[0]);

                $.easyAjax({
                    url: "{{ route('serviceproviders.storeOrUpdate') }}",
                    container: '#serviceProviderForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    onComplete: () => {
                        $('#serviceProviderModal').modal('hide');
                        $('#modelHeading').html("Create New Service Provider");
                        $('#serviceProviderForm').trigger("reset");
                        table.draw(false);
                    }
                })

            });

            $('body').on('click', '.editServiceProvider', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                axios.get(route('serviceproviders.edit', {serviceprovider: id})).then((response) => {
                    $('#modelHeading').html("Edit Service Provider");
                    $('#serviceProviderModal').modal('show');

                    var form = $('#serviceProviderForm'); // Adjust the form ID as needed

                    $.each(response.data, function (key, value) {
                        var inputField = form.find('[name="' + key + '"]'); // Scope to form

                        if (inputField.length) {
                            inputField.val(value);
                            $(inputField).trigger('change')
                        }
                    });

                });
            });

            $('body').on('click', '.deleteServiceProvider', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('serviceproviders.delete', {serviceprovider: id}),
                    confirmationMessage: 'Do you really want to delete this service provider ?',
                    onComplete: () => {
                        table.draw(false);
                    }
                })
            });

            //Status Update
            $('body').on('click', '.updateStatus', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var status = $(this).data('status');
                $.easyAjax({
                    url: "{{ route('users.updateStatus') }}",
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

            //Offline Verification
            $('body').on('click', '.offlineVerificaton', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var status = $(this).data('status');
                $.easyAjax({
                    url: "{{ route('users.offlineVerification') }}",
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
                    url: "{{ route('serviceproviders.bulk-delete') }}",
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
                $('#companyFilter').val('').trigger('change');
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
