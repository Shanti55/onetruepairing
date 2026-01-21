@extends('admin-panel.layouts.setting-app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h4 class="fw-semibold">Page <i class="bi bi-chevron-right"></i> Home</h4>
        </div>
    </div>

   @include('admin-panel.settings.home._form')

@endsection

@push('js')
    <script type="module">
        $(function () {
            //Image Preview
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
            //Search by location image-Right Side
            // document.getElementById('formFileMultiple1').addEventListener('change', function (event) {
            //     const files = event.target.files;
            //     const preview = document.getElementById('preview1');
            //     preview.innerHTML = ''; // Clear previous previews
            //     preview.style.display = 'block';
            //     for (let i = 0; i < files.length; i++) {
            //         const file = files[i];
            //
            //         // Ensure the file is an image
            //         if (file.type.startsWith('image/')) {
            //             const reader = new FileReader();
            //
            //             reader.onload = function (e) {
            //                 const img = document.createElement('img');
            //                 img.src = e.target.result; // Set the image source to the result from FileReader
            //                 preview.appendChild(img); // Add the image to the preview div
            //             };
            //
            //             reader.readAsDataURL(file); // Read the file as a data URL
            //         }
            //     }
            // });

            //Web Banner - Homepage
            document.getElementById('formHomePageWebFile').addEventListener('change', function (event) {
                const files = event.target.files;
                const preview = document.getElementById('previewHomePageWeb');
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

            //Mobile Banner - Homepage
            document.getElementById('formHomePageMobileFile').addEventListener('change', function (event) {
                const files = event.target.files;
                const preview = document.getElementById('previewHomePageMobile');
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

            //Search by location image-Bg
            document.getElementById('formFileMultiple2').addEventListener('change', function (event) {
                const files = event.target.files;
                const preview = document.getElementById('preview2');
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
            console.clear();

            //Store
            $('#homeSettingForm').on('submit', function (e) {
                e.preventDefault();
                var data = new FormData($('#homeSettingForm')[0]);

                $.easyAjax({
                    url: "{{ route('settings.storeOrUpdate') }}",
                    container: '#homeSettingForm',
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
