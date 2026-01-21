@extends('admin-panel.layouts.setting-app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h4 class="fw-semibold">Page <i class="bi bi-chevron-right"></i> Manage Ads</h4>
        </div>
    </div>
    @php
        $adOnHomePageOne = json_decode($setting->ads_on_home_page_one);
        $adOnHomePageTwo = json_decode($setting->ads_on_home_page_two);
        $adOnHomePageThree = json_decode($setting->ads_on_home_page_three);
        $adOnBrowsePageOne = json_decode($setting->ads_on_browse_page_one);
    @endphp
   @include('admin-panel.settings.manage-ads._form')

@endsection

@push('js')
    <script type="module">
        $(function () {
            //Image Preview - Ad 1
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

            //Image Preview - Ad 2
            document.getElementById('formFileMultipleTwo').addEventListener('change', function (event) {
                const files = event.target.files;
                const preview = document.getElementById('previewTwo');
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

            //Image Preview - Ad 3
            document.getElementById('formFileMultipleThree').addEventListener('change', function (event) {
                const files = event.target.files;
                const preview = document.getElementById('previewThree');
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


            document.getElementById('formFileMultipleBrowseOne').addEventListener('change', function (event) {
                const files = event.target.files;
                const preview = document.getElementById('previewBrowseOne');
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
            $('#manageAdsSettingForm').on('submit', function (e) {
                e.preventDefault();
                var data = new FormData($('#manageAdsSettingForm')[0]);

                $.easyAjax({
                    url: "{{ route('settings.storeOrUpdate') }}",
                    container: '#manageAdsSettingForm',
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
