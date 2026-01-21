@extends('admin-panel.layouts.setting-app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h4 class="fw-semibold">Page <i class="bi bi-chevron-right"></i> Benefits of Listings</h4>
        </div>
    </div>

   @include('admin-panel.settings.benefits-of-listings._form')

@endsection

@push('js')
    <script type="module">
        $(function () {
            //Add Listing Image
            document.getElementById('formFileMultiple').addEventListener('change', function (event) {
                const files = event.target.files;
                const preview = document.getElementById('preview');
                preview.innerHTML = ''; // Clear previous previews
                preview.style.display = 'block';
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

            //Store
            $('#benefitsOfListingsSettingForm').on('submit', function (e) {
                e.preventDefault();
                // Get the Quill editor instance
                var quill = new Quill('#editor', {
                    theme: 'snow' // Ensure Quill is initialized correctly
                });

                // Get the Quill editor content as HTML
                const content = quill.root.innerHTML;

                // Set the Quill content in a hidden input field
                document.getElementById('editor-content').value = content;
                var data = new FormData($('#benefitsOfListingsSettingForm')[0]);

                $.easyAjax({
                    url: "{{ route('settings.storeOrUpdate') }}",
                    container: '#benefitsOfListingsSettingForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    file: true,
                    onComplete: () => {

                    }
                })

            });

        });
    </script>
@endpush
