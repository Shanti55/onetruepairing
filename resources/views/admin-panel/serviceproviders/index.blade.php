@extends('admin-panel.layouts.app')

@section('content')
<div class="px-3">
    <div class="d-flex flex-wrap align-items-center justify-content-between">
        <h5 class="fw-semibold">Manage Service Providers</h5>
        <div>
            <button class="btn btn-light shadow-sm" type="button" data-bs-toggle="collapse"
                    data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
                <i class="bi bi-funnel"></i>
            </button>
            @if(hasPermissionFor('service_providers_export'))
            <a href="{{ route('serviceproviders.export') }}" class="btn btn-light shadow-sm">
                <i class="bi bi-box-arrow-up"></i> Export
            </a>
            @endif
            @if(hasPermissionFor('service_providers_import'))
            <a href="#" data-bs-toggle="modal" data-bs-target="#serviceProviderImportModal" class="btn btn-light shadow-sm">
                <i class="bi bi-box-arrow-down"></i> Import
            </a>
            @endif
            @if(hasPermissionFor('service_providers_delete'))
            <button id="delete-selected" class="btn btn-danger shadow-sm">
                <i class="fas fa-trash me-1"></i> Delete Selected
            </button>
            @endif
            @if(hasPermissionFor('service_providers_create'))
            {{-- ✅ data-bs-toggle hata diya --}}
            <a href="#" id="add-serviceprovider-btn" class="btn btn-primary shadow-sm mt-2 mt-md-0">
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
                <tbody></tbody>
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

    // ── DataTable ─────────────────────────────────────────────────────────
    var table = $('#serviceproviders-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        ajax: {
            url : '{{ route('serviceproviders.index') }}',
            type: 'GET',
            data: function (d) {
                d.company_name    = $('#companyFilter').val();
                d.name            = $('#nameFilter').val();
                d.contact_number  = $('#contactNumberFilter').val();
                d.location        = $('#locationFilter').val();
            }
        },
        columns: [
            @if(hasPermissionFor('service_providers_delete'))
            { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
            @endif
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'serviceproviderprofile.company_name', name: 'serviceproviderprofile.company_name' },
            { data: 'name',  name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'serviceproviderprofile.contact_number', name: 'serviceproviderprofile.contact_number' },
            @if(hasPermissionFor('service_providers_offline_verification'))
            { data: 'offline_verification', name: 'offline_verification', orderable: false, searchable: false },
            @endif
            @if(hasPermissionFor('service_providers_status'))
            { data: 'status', name: 'status', orderable: false, searchable: false },
            @endif
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
    });

    // ── Bootstrap 5 native modals ─────────────────────────────────────────
    const serviceProviderModal = new bootstrap.Modal(
        document.getElementById('serviceProviderModal')
    );

    // ── Select All ────────────────────────────────────────────────────────
    $('#select-all').on('click', function () {
        $('.user-checkbox').prop('checked', this.checked);
    });

    // ── Add Service Provider ──────────────────────────────────────────────
    $('#add-serviceprovider-btn').on('click', function (e) {
        e.preventDefault();
        $('#id').val('');
        $('#serviceProviderForm').trigger("reset");
        $('#modelHeading').html("Create New Service Provider");
        serviceProviderModal.show();
    });

    // ── Save / Update ─────────────────────────────────────────────────────
    $('#serviceProviderForm').on('submit', function (e) {
        e.preventDefault();
        const $btn = $(this).find('[type="submit"]');
        $btn.prop('disabled', true).text('Saving...');

        $.ajax({
            url        : "{{ route('serviceproviders.storeOrUpdate') }}",
            type       : 'POST',
            data       : new FormData(this),
            processData: false,
            contentType: false,
            success: function (res) {
                $btn.prop('disabled', false).text('Save');
                serviceProviderModal.hide();
                $('#modelHeading').html("Create New Service Provider");
                $('#serviceProviderForm').trigger("reset");
                table.draw(false);
                showToast(res.message ?? 'Saved successfully!', 'success');
            },
            error: function (xhr) {
                $btn.prop('disabled', false).text('Save');
                showToast(xhr.responseJSON?.message ?? 'Something went wrong.', 'danger');
            }
        });
    });

    // ── Edit ──────────────────────────────────────────────────────────────
    $('body').on('click', '.editServiceProvider', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        axios.get(route('serviceproviders.edit', { serviceprovider: id })).then((response) => {
            $('#modelHeading').html("Edit Service Provider");
            serviceProviderModal.show();
            var form = $('#serviceProviderForm');
            $.each(response.data, function (key, value) {
                var inputField = form.find('[name="' + key + '"]');
                if (inputField.length) {
                    inputField.val(value);
                    $(inputField).trigger('change');
                }
            });
        });
    });

    // ── Delete ────────────────────────────────────────────────────────────
    $('body').on('click', '.deleteServiceProvider', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (!confirm('Do you really want to delete this service provider?')) return;
        $.ajax({
            url  : route('serviceproviders.delete', { serviceprovider: id }),
            type : 'DELETE',
            data : { _token: "{{ csrf_token() }}" },
            success: function () {
                table.draw(false);
                showToast('Deleted successfully!', 'success');
            },
            error: function () {
                showToast('Failed to delete.', 'danger');
            }
        });
    });

    // ── Status Update ─────────────────────────────────────────────────────
    $('body').on('click', '.updateStatus', function (e) {
        e.preventDefault();
        var id     = $(this).attr('id');
        var status = $(this).data('status');
        $.ajax({
            url  : "{{ route('users.updateStatus') }}",
            type : 'POST',
            data : { id: id, _token: '{{ csrf_token() }}', status: status },
            success: function () {
                table.draw(false);
                showToast('Status updated!', 'success');
            },
            error: function () {
                showToast('Status update failed.', 'danger');
            }
        });
    });

    // ── Offline Verification ──────────────────────────────────────────────
    $('body').on('click', '.offlineVerificaton', function (e) {
        e.preventDefault();
        var id     = $(this).attr('id');
        var status = $(this).data('status');
        $.ajax({
            url  : "{{ route('users.offlineVerification') }}",
            type : 'POST',
            data : { id: id, _token: '{{ csrf_token() }}', status: status },
            success: function () {
                table.draw(false);
                showToast('Verification updated!', 'success');
            },
            error: function () {
                showToast('Verification update failed.', 'danger');
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
            showToast('No service providers selected.', 'danger');
            return;
        }
        if (!confirm('Are you sure you want to delete selected service providers?')) return;
        $.ajax({
            url  : "{{ route('serviceproviders.bulk-delete') }}",
            type : 'DELETE',
            data : { ids: selected, _token: "{{ csrf_token() }}" },
            success: function (res) {
                showToast(res.message ?? 'Deleted successfully!', 'success');
                table.ajax.reload();
            },
            error: function () {
                showToast('Bulk delete failed.', 'danger');
            }
        });
    });

    // ── Filters ───────────────────────────────────────────────────────────
    $('#applyFilters').on('click', function () {
        table.ajax.reload();
    });
    $('#resetFilters').on('click', function () {
        $('#filterForm')[0].reset();
        $('#companyFilter, #nameFilter, #contactNumberFilter').val('').trigger('change');
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

    // ── Toast Helper ──────────────────────────────────────────────────────
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