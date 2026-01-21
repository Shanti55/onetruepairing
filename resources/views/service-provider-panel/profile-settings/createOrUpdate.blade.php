@extends('service-provider-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Profile Settings</h5>
        </div>
        @include('partials.service-provider._profile-form')
    </div>

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
                            img.style.width = "150px";  // Change to your desired width
                            img.style.height = "150px"; // Change to your desired height
                            img.src = e.target.result; // Set the image source to the result from FileReader
                            preview.appendChild(img); // Add the image to the preview div
                        };

                        reader.readAsDataURL(file); // Read the file as a data URL
                    }
                }
            });
            document.getElementById('formFileCoverImage').addEventListener('change', function (event) {
                const files = event.target.files;
                const preview = document.getElementById('previewCover');
                preview.innerHTML = ''; // Clear previous previews
                preview.style.display = 'block';
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];

                    // Ensure the file is an image
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            const img = document.createElement('img');
                            img.style.width = "250px";  // Change to your desired width
                            img.style.height = "200px"; // Change to your desired height
                            img.src = e.target.result; // Set the image source to the result from FileReader
                            preview.appendChild(img); // Add the image to the preview div
                        };

                        reader.readAsDataURL(file); // Read the file as a data URL
                    }
                }
            });
            //Image Preview
            document.getElementById('formFileMultipleImages').addEventListener('change', function (event) {
                const files = event.target.files;
                const preview = document.getElementById('previewMultiple');
                preview.innerHTML = ''; // Clear previous previews

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];

                    // Ensure the file is an image
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            const img = document.createElement('img');
                            img.style.width = '200px';
                            img.style.height = '150px';
                            img.src = e.target.result; // Set the image source to the result from FileReader
                            preview.appendChild(img); // Add the image to the preview div
                        };
                        reader.readAsDataURL(file); // Read the file as a data URL
                    }
                }
            });
            console.clear();

            //StoreOrUpdate
            $('#profileSettingForm').on('submit', function (e) {
                e.preventDefault();
                var data = new FormData($('#profileSettingForm')[0]);
                $.easyAjax({
                    url: "{{ route('service-providers.profile.update') }}",
                    container: '#profileSettingForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    file: true,
                    onComplete: () => {
                        // $('#profileSettingForm').trigger("reset");
                    }
                })

            });

            $('body').on('click', '.remove-button', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('media.delete', {id: id}),
                    confirmationMessage: 'Do you really want to delete this image ?',
                    onComplete: () => {
                        window.location.reload();
                    }
                })
            });

            $('body').on('click', '.remove-avatar', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('avatar.delete', {id: id}),
                    confirmationMessage: 'Do you really want to delete this image ?',
                    onComplete: () => {
                        window.location.reload();
                    }
                })
            });

            $('body').on('click', '.remove-cover-img', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('cover-image.delete', {id: id}),
                    confirmationMessage: 'Do you really want to delete this image ?',
                    onComplete: () => {
                        window.location.reload();
                    }
                })
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

            //Password Toggle
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
