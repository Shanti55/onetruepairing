@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Manage Services</h5>

            @if(hasPermissionFor('services_create'))
            <a href="#" data-bs-toggle="#serviceModal" id="add-service-btn" class="btn btn-primary shadow-sm">
                <i class="fas fa-add me-1"></i> Add Service
            </a>
            @endif
        </div>

        <div class="card mt-3 border-0 pb-2 shadow-sm">
            <div class="table-responsive">
                <table id="services-table" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Name</th>
{{--                        <th>Code</th>--}}
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        @include('admin-panel.services._form')

    </div>

@endsection

@push('js')
    <script type="module">
        $(function () {

            var table = $('#services-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('services.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'category.name', name: 'category.name'},
                    {data: 'name', name: 'name'},
                    // {data: 'code', name: 'code'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            $('#add-service-btn').click(function () {
                $('#id').val('');
                $('#serviceForm').trigger("reset");
                $('#modelHeading').html("Create New Service");
                $('#serviceModal').modal('show');
            });

            $('#serviceForm').on('submit', function (e) {
                e.preventDefault();
                var data = new FormData($('#serviceForm')[0]);

                $.easyAjax({
                    url: "{{ route('services.storeOrUpdate') }}",
                    container: '#serviceForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    file: true,
                    onComplete: () => {
                        $('#serviceModal').modal('hide');
                        $('#modelHeading').html("Create New Service");
                        $('#serviceForm').trigger("reset");
                        table.draw(false);
                    }
                })

            });

            $('body').on('click', '.editService', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                axios.get(route('services.edit', {service: id})).then((response) => {
                    $('#modelHeading').html("Edit Service");
                    $('#serviceModal').modal('show');

                    var form = $('#serviceForm'); // Adjust the form ID as needed

                    $.each(response.data, function (key, value) {
                        var inputField = form.find('[name="' + key + '"]'); // Scope to form
                        if (inputField.length) {
                            inputField.val(value);
                            $(inputField).trigger('change')
                        }
                    });

                });
            });

            $('body').on('click', '.deleteService', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('services.delete', {service: id}),
                    confirmationMessage: 'Do you really want to delete this service ?',
                    onComplete: () => {
                        table.draw(false);
                    }
                })
            });

            //Image Preview
            document.getElementById('formFileMultiple').addEventListener('change', function (event) {
                const files = event.target.files;
                const preview = document.getElementById('preview');
                preview.innerHTML = ''; // Clear previous previews

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];

                    // Ensure the file is an image
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            const img = document.createElement('img');
                            img.src = e.target.result; // Set the image source to the result from FileReader
                            preview.appendChild(img); // Add the image to the preview div
                        };
                        reader.readAsDataURL(file); // Read the file as a data URL
                    }
                }
            });
        });
    </script>
@endpush
