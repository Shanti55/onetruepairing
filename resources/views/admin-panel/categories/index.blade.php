@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Manage Categories</h5>

            @if(hasPermissionFor('categories_create'))
            <a href="#" data-bs-toggle="#categoryModal" id="add-category-btn" class="btn btn-primary shadow-sm">
                <i class="fas fa-add me-1"></i> Add Category
            </a>
            @endif
        </div>

        <div class="card mt-3 border-0 pb-2 shadow-sm">
            <div class="table-responsive">
                <table id="categories-table" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Icon</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        @include('admin-panel.categories._form')

    </div>

@endsection

@push('js')
    <script type="module">
        $(function () {

            var table = $('#categories-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('categories.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'parentcategory.name', name: 'parentcategory.name'},
                    {data: 'icon', name: 'icon'},
                    {data: 'image', name: 'image'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            $('#add-category-btn').click(function () {
                $('#id').val('');
                $('#categoryForm').trigger("reset");
                $('#modelHeading').html("Create New Category");
                $('#categoryModal').modal('show');
            });

            $('#categoryForm').on('submit', function (e) {
                e.preventDefault();

                var data = new FormData($('#categoryForm')[0]);


                $.easyAjax({
                    url: "{{ route('categories.storeOrUpdate') }}",
                    container: '#categoryForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    file: true,
                    onComplete: () => {
                        $('#categoryModal').modal('hide');
                        $('#modelHeading').html("Create New Category");
                        $('#categoryForm').trigger("reset");
                        $('#previewIcon').html('');
                        $('#previewImage').html('');
                        table.draw(false);
                    }
                })

            });

            $('body').on('click', '.editCategory', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                axios.get(route('categories.edit', {category: id})).then((response) => {
                    $('#modelHeading').html("Edit Category");
                    $('#categoryModal').modal('show');

                    var form = $('#categoryForm'); // Adjust the form ID as needed

                    $.each(response.data, function (key, value) {
                        if(key !== 'icon' && key !== 'image'){
                            console.log(key);
                            var inputField = form.find('[name="' + key + '"]'); // Scope to form
                            if (inputField.length) {
                                inputField.val(value);
                                $(inputField).trigger('change')
                            }
                        }else{
                            if(key === 'icon' && value !== null){
                                const previewIcon = document.getElementById('previewIcon');
                                previewIcon.innerHTML = ''; // Clear previous previews
                                const img = document.createElement('img');
                                img.src = value; // Set the image source to the result from FileReader
                                previewIcon.appendChild(img); // Add the image to the preview div
                            }
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

            $('body').on('click', '.deleteCategory', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('categories.delete', {category: id}),
                    confirmationMessage: 'Do you really want to delete this category?',
                    onComplete: () => {
                        table.draw(false);
                    }
                })
            });

            //Icon Preview
            document.getElementById('formFileIcon').addEventListener('change', function (event) {
                const files = event.target.files;
                const previewIcon = document.getElementById('previewIcon');
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
