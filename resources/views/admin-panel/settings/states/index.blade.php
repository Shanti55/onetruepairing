@extends('admin-panel.layouts.setting-app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Manage States</h5>
            <a href="#" data-bs-toggle="#stateModal" id="add-state-btn" class="btn btn-primary shadow-sm">
                <i class="fas fa-add me-1"></i> Add State
            </a>
        </div>

        <div class="card mt-3 border-0 pb-2 shadow-sm">
            <div class="table-responsive">
                <table id="states-table" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>State</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        @include('admin-panel.settings.states._form')

    </div>

@endsection

@push('js')
    <script type="module">
        $(function () {

            var table = $('#states-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('states.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'image', name: 'image'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            $('#add-state-btn').click(function () {
                $('#id').val('');
                $('#stateForm').trigger("reset");
                $('#modelHeading').html("Create New State");
                $('#stateModal').modal('show');
            });

            $('#stateForm').on('submit', function (e) {
                e.preventDefault();
                var data = new FormData($('#stateForm')[0]);

                $.easyAjax({
                    url: "{{ route('states.storeOrUpdate') }}",
                    container: '#stateForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    file: true,
                    onComplete: () => {
                        $('#stateModal').modal('hide');
                        $('#modelHeading').html("Create New State");
                        $('#stateForm').trigger("reset");
                        table.draw(false);
                    }
                })

            });

            $('body').on('click', '.editState', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                axios.get(route('states.edit', {state: id})).then((response) => {
                    $('#modelHeading').html("Edit State");
                    $('#stateModal').modal('show');

                    var form = $('#stateForm'); // Adjust the form ID as needed

                    $.each(response.data, function (key, value) {
                        if(key !== 'image'){
                            var inputField = form.find('[name="' + key + '"]'); // Scope to form
                            if (inputField.length) {
                                inputField.val(value);
                                $(inputField).trigger('change')
                            }
                        }else{
                            if(key === 'image' && value !== null){
                                const previewImage = document.getElementById('previewImage');
                                previewImage.innerHTML = ''; // Clear previous previews
                                const img = document.createElement('img');
                                img.src = value; // Set the image source to the result from FileReader
                                previewImage.appendChild(img); // Add the image to the preview div
                            }
                        }

                    });

                });
            });

            $('body').on('click', '.deleteState', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('state.delete', {state: id}),
                    confirmationMessage: 'Do you really want to delete this state ?',
                    onComplete: () => {
                        table.draw(false);
                    }
                })
            });

            //Image Preview
            document.getElementById('formFileImage').addEventListener('change', function (event) {
                const files = event.target.files;
                const previewImage = document.getElementById('previewImage');
                previewImage.innerHTML = ''; // Clear previous previews

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];

                    // Ensure the file is an image
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            const img = document.createElement('img');
                            img.src = e.target.result; // Set the image source to the result from FileReader
                            previewImage.appendChild(img); // Add the image to the preview div
                        };

                        reader.readAsDataURL(file); // Read the file as a data URL
                    }
                }
            });
        });
    </script>
@endpush
