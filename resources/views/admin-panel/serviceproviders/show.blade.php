@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">

        <div class="d-flex align-items-center justify-content-between">
            <div><h5 class="fw-semibold"><a href="{{ route('serviceproviders.index') }}">Service Providers</a><i class="bi bi-chevron-right"></i>{{ $profile ? $profile->company_name : $provider->name }}<i class="bi bi-chevron-right"></i>Overview</h5></div>
        </div>
        @if(auth()->user()->isAdmin())
        <div class="card mt-3 border-0">
            <div class="d-flex">
                @if(canAccessModule('service_providers'))
                    <a href="javascript:void(0)" class="btn btn-lg text-dark border-0"><i class="bi bi-info-circle"></i> Overview</a>
                @endif
                @if(canAccessModule('billing'))
                    <a href="{{ route('serviceproviders.billing',['serviceprovider'=>$provider->id]) }}" class="btn btn-lg text-secondary border-0" style="text-decoration: none"><i class="bi bi-credit-card"></i> Billing</a>
                @endif
            </div>
        </div>
        @endif
        <div class="card mt-3 border-0 pb-2">
            @include('partials.service-provider._profile-show')
        </div>

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
                            img.src = e.target.result; // Set the image source to the result from FileReader
                            preview.appendChild(img); // Add the image to the preview div
                        };

                        reader.readAsDataURL(file); // Read the file as a data URL
                    }
                }
            });
            console.clear();
            ('use strict');
            // Drag and drop - single or multiple image files
            // https://www.smashingmagazine.com/2018/01/drag-drop-file-uploader-vanilla-js/
            // https://codepen.io/joezimjs/pen/yPWQbd?editors=1000
            (function () {

                'use strict';

                // Four objects of interest: drop zones, input elements, gallery elements, and the files.
                // dataRefs = {files: [image files], input: element ref, gallery: element ref}

                const preventDefaults = event => {
                    event.preventDefault();
                    event.stopPropagation();
                };

                const highlight = event =>
                    event.target.classList.add('highlight');

                const unhighlight = event =>
                    event.target.classList.remove('highlight');

                const getInputAndGalleryRefs = element => {
                    const zone = element.closest('.upload_dropZone') || false;
                    const gallery = zone.querySelector('.upload_gallery') || false;
                    const input = zone.querySelector('input[type="file"]') || false;
                    return {input: input, gallery: gallery};
                }

                const handleDrop = event => {
                    const dataRefs = getInputAndGalleryRefs(event.target);
                    dataRefs.files = event.dataTransfer.files;
                    handleFiles(dataRefs);
                }


                const eventHandlers = zone => {

                    const dataRefs = getInputAndGalleryRefs(zone);

                    if (!dataRefs.input) return;

                    // Prevent default drag behaviors
                    ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(event => {
                        zone.addEventListener(event, preventDefaults, false);
                        document.body.addEventListener(event, preventDefaults, false);
                    });

                    // Highlighting drop area when item is dragged over it
                    ;['dragenter', 'dragover'].forEach(event => {
                        zone.addEventListener(event, highlight, false);
                    });
                    ;['dragleave', 'drop'].forEach(event => {
                        zone.addEventListener(event, unhighlight, false);
                    });

                    // Handle dropped files
                    zone.addEventListener('drop', handleDrop, false);

                    // Handle browse selected files
                    dataRefs.input.addEventListener('change', event => {
                        dataRefs.files = event.target.files;
                        handleFiles(dataRefs);
                    }, false);

                }


                // Initialise ALL dropzones
                const dropZones = document.querySelectorAll('.upload_dropZone');
                for (const zone of dropZones) {
                    eventHandlers(zone);
                }


                // No 'image/gif' or PDF or webp allowed here, but it's up to your use case.
                // Double checks the input "accept" attribute
                const isImageFile = file =>
                    ['image/jpeg', 'image/png', 'image/svg+xml'].includes(file.type);


                function previewFiles(dataRefs) {
                    if (!dataRefs.gallery) return;
                    for (const file of dataRefs.files) {
                        let reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onloadend = function() {
                            let img = document.createElement('img');
                            img.className = 'upload_img mt-2';
                            img.setAttribute('alt', file.name);
                            img.src = reader.result;
                            dataRefs.gallery.appendChild(img);
                        }
                    }
                }

                // Based on: https://flaviocopes.com/how-to-upload-files-fetch/
                const imageUpload = dataRefs => {

                    // Multiple source routes, so double check validity
                    if (!dataRefs.files || !dataRefs.input) return;

                    const url = dataRefs.input.getAttribute('data-post-url');
                    if (!url) return;

                    const name = dataRefs.input.getAttribute('data-post-name');
                    if (!name) return;

                    const formData = new FormData();
                    formData.append(name, dataRefs.files);

                    fetch(url, {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log('posted: ', data);
                            if (data.success === true) {
                                previewFiles(dataRefs);
                            } else {
                                console.log('URL: ', url, '  name: ', name)
                            }
                        })
                        .catch(error => {
                            console.error('errored: ', error);
                        });
                }


                // Handle both selected and dropped files
                const handleFiles = dataRefs => {

                    let files = [...dataRefs.files];

                    // Remove unaccepted file types
                    files = files.filter(item => {
                        if (!isImageFile(item)) {
                            console.log('Not an image, ', item.type);
                        }
                        return isImageFile(item) ? item : null;
                    });

                    if (!files.length) return;
                    dataRefs.files = files;

                    previewFiles(dataRefs);
                    imageUpload(dataRefs);
                }

            })();

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

        });
    </script>
@endpush
