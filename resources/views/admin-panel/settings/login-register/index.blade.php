@extends('admin-panel.layouts.setting-app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h4 class="fw-semibold">Page <i class="bi bi-chevron-right"></i> Login/Signup</h4>
        </div>
    </div>

   @include('admin-panel.settings.login-register._form')

@endsection

@push('js')
    <script type="module">
        $(function () {
            //Login
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
            //Signup
            document.getElementById('formFileMultiple1').addEventListener('change', function (event) {
                const files = event.target.files;
                const preview = document.getElementById('preview1');
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
            $('#loginSignupSettingForm').on('submit', function (e) {
                e.preventDefault();
                var data = new FormData($('#loginSignupSettingForm')[0]);

                $.easyAjax({
                    url: "{{ route('settings.storeOrUpdate') }}",
                    container: '#loginSignupSettingForm',
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
