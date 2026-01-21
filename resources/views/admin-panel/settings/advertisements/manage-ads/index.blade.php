@extends('admin-panel.layouts.setting-app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Manage Advertisement</h5>

            <a href="#" data-bs-toggle="#advertisementModal" id="add-advertisement-btn"
               class="btn btn-primary shadow-sm">
                <i class="fas fa-add me-1"></i> Add Advertisement
            </a>
        </div>

        <div class="card mt-3 border-0 pb-2 shadow-sm">
            <div class="table-responsive">
                <table id="advertisement-table" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Advertisement</th>
                        <th>Url</th>
                        <th>Display On Page</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        @include('admin-panel.settings.advertisements.manage-ads._form')

    </div>

@endsection

@push('js')
    <script type="module">
        $(function () {
            var table = $('#advertisement-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('manage-ads.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'ads', name: 'ads'},
                    {data: 'link', name: 'link'},
                    {data: 'display_on_page', name: 'display_on_page'},
                    {data: 'start_date', name: 'start_date'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'description', name: 'description'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            $('#add-advertisement-btn').click(function () {
                console.log('here');
                $('#id').val('');
                $('#advertisementForm').trigger("reset");
                $('#modelHeading').html("Create New Ads");
                $('#advertisementModal').modal('show');
            });

            $('#advertisementForm').on('submit', function (e) {
                e.preventDefault();
                var data = new FormData($('#advertisementForm')[0]);
                $.easyAjax({
                    url: "{{ route('manage-ads.storeOrUpdate') }}",
                    container: '#advertisementForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    file: true,
                    onComplete: () => {
                        $('#advertisementModal').modal('hide');
                        $('#modelHeading').html("Create New Ads");
                        $('#advertisementForm').trigger("reset");
                        $('#previewAd').html('');
                        table.draw(false);
                    }
                })

            });

            $('body').on('click', '.editAdvertisement', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                axios.get(route('manage-ads.edit', {advertisement: id})).then((response) => {
                    $('#modelHeading').html("Edit Advertisement");
                    $('#advertisementModal').modal('show');
                    var form = $('#advertisementForm'); // Adjust the form ID as needed
                    $.each(response.data, function (key, value) {
                        if(key !== 'ad_url' && key !== 'is_enabled'){
                            console.log(key);
                            var inputField = form.find('[name="' + key + '"]'); // Scope to form
                            if (inputField.length) {
                                inputField.val(value);
                                $(inputField).trigger('change')
                            }
                        }else if(key === 'is_enabled'){
                            var inputField = form.find('[name="' + key + '"]'); // Scope to form
                            if (inputField.length && value == 1) {
                                console.log('checkbox '+inputField);
                                // Set the 'checked' property using jQuery .prop() method
                                inputField.prop('checked', true);
                                // Trigger the 'change' event
                                inputField.trigger('change');
                            }else{
                                inputField.prop('checked', false);
                                // Trigger the 'change' event
                                inputField.trigger('change');
                            }
                        }else{
                            if(key === 'ad_url' && value !== null){
                                const previewIcon = document.getElementById('previewAd');
                                previewIcon.innerHTML = ''; // Clear previous previews
                                const img = document.createElement('img');
                                img.src = value; // Set the image source to the result from FileReader
                                previewIcon.appendChild(img); // Add the image to the preview div
                            }
                        }

                    });

                });
            });

            $('body').on('click', '.deleteAdvertisement', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('manage-ads.delete', {advertisement: id}),
                    confirmationMessage: 'Do you really want to delete this advertisement?',
                    onComplete: () => {
                        table.draw(false);
                    }
                })
            });

            //Icon Preview
            document.getElementById('formUploadAd').addEventListener('change', function (event) {
                const files = event.target.files;
                const previewIcon = document.getElementById('previewAd');
                previewIcon.innerHTML = ''; // Clear previous previews

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];

                    // Ensure the file is an image
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            const img = document.createElement('img');
                            img.src = e.target.result; // Set the image source to the result from FileReader
                            previewIcon.appendChild(img); // Add the image to the preview div
                        };

                        reader.readAsDataURL(file); // Read the file as a data URL
                    }
                }
            });


        });
    </script>
@endpush
