@extends('frontend.layouts.app')

@section('title', 'Business Listings | CtrlF')

@section('content')
    <div class="container-fluid p-0 m-0">
        <section id="hero" class="hero section dark-background" style="{{ isset($setting->add_listing_banner_img) ? 'background-color: var(--accent-color)' : '' }}">
            @if(isset($setting->add_listing_banner_img))
                <img src="{{ $setting->add_listing_banner_img }}" alt="" class="hero-bg"  loading="lazy">
            @endif
            <div class="container">
                <div class="row gy-4">
                    <div class="d-flex justify-content-center align-items-center" style="margin-top: 5rem;">
                        <div class="col-lg-4 card shadow-lg rounded-5">
                            <div class="card-header text-center bg-white mt-4 py-0 border-bottom border-light header">
                                <a href="{{ route('frontend.home') }}" class="logo pb-2 d-flex justify-content-center align-items-center">
                                    <!-- Uncomment the line below if you also wish to use an image logo -->
                                    <img class="mx-0" src="{{ $setting->logo }}" alt="ctrlf"  loading="lazy">
                                    {{--            <h1 class="sitename">CtrlF</h1>--}}
                                </a>
                                <h6 class="text-secondary">Welcome To CtrlF</h6>
                                <h4 style="color: var(--surface-color)"><b>LIST YOUR COMPANY HERE</b></h4>
                            </div>
                            <div class="card-body pt-0">
                                <form id="multi-step-form" data-parsley-validate enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="{{ $provider->id }}">
                                    <div class="card-body step active">
                                        <div class="form-group mb-3">
                                            <label for="company_name" class="form-label"><b>Company Name</b></label>
                                            <span class="text-danger">*</span>
                                            <input type="text" name="company_name" required id="company_name" value="{{ isset($profile) ? $profile->company_name : null }}" placeholder="Enter Company" class="rounded-4 form-control @error('company_name') is-invalid @enderror"/>
                                            @error('company_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="company_email" class="form-label"><b>Email</b></label>
                                            <span class="text-danger">*</span>
                                            <input type="text" name="company_email" required id="company_email" value="{{ isset($profile) ? $profile->company_email : null }}" placeholder="Enter Email"
                                                   class="rounded-4 form-control @error('company_email') is-invalid @enderror"/>
                                            @error('company_email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="mobile_no" class="form-label"><b>Mobile Number</b></label>
                                            <span class="text-danger">*</span>
                                            <input type="number" name="contact_number" required id="mobile_no" value="{{ isset($profile) ? $profile->contact_number : null }}" placeholder="Enter Mobile Number"
                                                   class="rounded-4 form-control @error('mobile_no') is-invalid @enderror"/>
                                            @error('mobile_no')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="whatsapp_no" class="form-label"><b>WhatsApp Number</b></label>
                                            <span class="text-danger">*</span>
                                            <input type="number" name="alternate_contact_number" required id="whatsapp_no" value="{{ isset($profile) ? $profile->alternate_contact_number : null }}" placeholder="Enter Whatsapp Number"
                                                   class="rounded-4 form-control @error('whatsapp_no') is-invalid @enderror"/>
                                            @error('whatsapp_no')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="d-flex flex-column text-center">
                                            <button type="button" class="btn-get-started border-0 mb-2 next"><b>NEXT<i class="bi bi-chevron-right mx-1"></i></b></button>
                                        </div>
                                    </div>

                                    <div class="card-body step">
                                        <div class="form-group mb-3">
                                            <label for="Address" class="form-label"><b>Address</b></label>
                                            <span class="text-danger">*</span>
                                            <textarea name="address" id="address" required class="rounded-4 form-control @error('address') is-invalid @enderror">{{ isset($profile) ? $profile->address : null }}</textarea>
                                            @error('address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <x-pincode-lookup :profile="$profile" size="12" weight="bold" icon="0"/>

                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn-get-started border-0 mb-2 prev bg-warning"><b><i class="bi bi-chevron-left mx-1"></i>PREV</b></button>
                                            <button type="button" class="btn-get-started border-0 mb-2 next"><b>NEXT<i class="bi bi-chevron-right mx-1"></i></b></button>
                                        </div>
                                    </div>

                                    <div class="card-body step">
                                        <div class="form-group mb-3">
                                            @php
                                                $categories = null;
                                                $categories = $profile && isset($profile->categories) ? json_decode($profile->categories) :[];
                                            @endphp
                                            <label for="categories" class="form-label"><b>Category</b></label>
                                            <span class="text-danger">*</span>
                                            <select class="rounded-4 form-control form-select" id="categories" placeholder="Category" name="categories[]"
                                                    placeholder="Choose Category" multiple>
                                                <option value="">--Choose Category--</option>
                                                @foreach(\App\Models\Category::all() as $category)
                                                    <option {{ isset($categories) && in_array($category->id,$categories) ? 'selected' : null  }} value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Invalid feedback</div>
                                        </div>

                                        <div class="form-group mb-3">
                                            @php
                                                $services = null;
                                                $services = $profile && isset($profile->services) ? json_decode($profile->services) :[];
                                            @endphp
                                            <label for="services" class="form-label"><b>Service</b></label>
                                            <span class="text-danger">*</span>
                                            <select class="rounded-4 form-control form-select" id="services" placeholder="services" name="services[]"
                                                    placeholder="Choose Service" multiple>
                                                <option value="">--Choose Service--</option>
                                                @foreach(\App\Models\Service::all() as $service)
                                                    <option {{ isset($services) && in_array($service->id,$services) ? 'selected' : null  }} value="{{ $service->id }}">{{ $service->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Invalid feedback</div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="cover_mage" class="form-label"><b>Cover Image</b></label>
                                            <span class="text-danger">*</span>
                                            <input type="file"  name="cover_mage" id="cover_mage"  class="rounded-4 form-control @error('cover_mage') is-invalid @enderror"/>
                                            @error('cover_mage')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="{{ $profile && isset($profile->avatar) ? 'd-flex align-items-center gap-3' : '' }}">
                                            @if($profile && isset($profile->avatar))
                                                <div id="preview" class="preview img-thumbnail mb-3">
                                                    <img  loading="lazy" src="{{ url($profile->avatar) }}" alt="Business Logo" class="" width="80" height="80">
                                                </div>
                                            @endif
                                            <div class="mb-3 flex-grow-1">
                                                <label for="formFileMultiple" class="form-label"><b>Upload Business Logo</b></label>
                                                <span class="text-danger">*</span>
                                                <input class="rounded-4 form-control" type="file" name="avatar" id="formFileMultiple" accept="image/*">
                                            </div>
                                        </div>


                                        <div class="form-group mb-3">
                                            <label for="website" class="form-label"><b>Website Link</b></label>
                                            <span class="text-danger">*</span>
                                            <input type="text"  name="website" id="website" placeholder="Enter Website Link" value="{{ isset($profile) ? $profile->website : null }}" class="rounded-4 form-control @error('website') is-invalid @enderror"/>
                                            @error('website')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn-get-started border-0 mb-2 prev bg-warning"><b><i class="bi bi-chevron-left mx-1"></i>PREV</b></button>
                                            <button type="submit" class="btn-get-started border-0 mb-2"><b>SUBMIT<i class="bi bi-chevron-right mx-1"></i></b></button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

{{--                    <div class="col-lg-6  d-flex flex-column justify-content-center" data-aos="fade-in">--}}
{{--                        <h1>LIST YOUR <span>COMPANY</span></h1>--}}
{{--                        <h1>Find the most trusted,<br>--}}
{{--                            in-demand vendors</h1>--}}
{{--                        <div>--}}

{{--                        </div>--}}
{{--                        <div class="d-flex">--}}
{{--                            <a href="{{ route('frontend.auth.service-providers.register') }}" class="btn-get-started">Become Service Provider ?</a>--}}
{{--                            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                </div>
            </div>
            <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
                <defs>
                    <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
                </defs>
                <g class="wave1">
                    <use xlink:href="#wave-path" x="50" y="3"></use>
                </g>
                <g class="wave2">
                    <use xlink:href="#wave-path" x="50" y="0"></use>
                </g>
                <g class="wave3">
                    <use xlink:href="#wave-path" x="50" y="9"></use>
                </g>
            </svg>

        </section>
    </div>
@endsection

@push('js')
    <script type="module">
        $(function () {

            const steps = document.querySelectorAll('.step');
            console.log(steps);

            steps.forEach((step, index) => {
                step.style.display = index === 0 ? 'block' : 'none'; // Show only the first step
            });

            document.querySelectorAll('.next').forEach(button => {
                button.addEventListener('click', function() {
                    const currentStep = this.closest('.step');
                    currentStep.style.display = 'none';
                    currentStep.nextElementSibling.style.display = 'block';
                });
            });

            document.querySelectorAll('.prev').forEach(button => {
                button.addEventListener('click', function() {
                    const currentStep = this.closest('.step');
                    currentStep.style.display = 'none';
                    currentStep.previousElementSibling.style.display = 'block';
                });
            });

            //StoreOrUpdate
            $('#multi-step-form').on('submit', function (e) {
                e.preventDefault();
                var data = new FormData($('#multi-step-form')[0]);
                $.easyAjax({
                    url: "{{ route('service-providers.profile.update') }}",
                    container: '#multi-step-form',
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

        });

    </script>
@endpush
