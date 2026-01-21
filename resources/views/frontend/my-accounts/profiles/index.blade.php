@extends('frontend.layouts.app')

@section('title', 'Profile | CtrlF')

@section('content')

    <section id="profile" class="hero section light-background">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-3">
                   @include('frontend.my-accounts._partials._sidebar')
                </div>
                <div class="col-lg-9 justify-content-between align-items-center">
                    <form  method="post" class="php-email-form" id="manageProfileForm" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="card border-0 shadow rounded-0">
                            <!--Personal Information-->
                            <div class="card-header bg-white px-5 mt-2 ">
                                <h4>Personal Information</h4>
                            </div>
                            <div class="card-body px-md-5 px-3">
                                <div class="gy-2 my-3">
                                    <!--Avtar-->
                                    <div class="row mb-3">
                                        <div class="col-lg-12">
                                            <div class="d-flex align-items-center previewImg gap-3">
                                                <div id="preview" class="preview img-thumbnail mb-3" style="display: {{ $profile && isset($profile->avatar) ? 'block' : 'none' }};width: 150px;height:150px">
                                                    @if($profile && !empty($profile->avatar))
                                                        <img  loading="lazy" src="{{ url($profile->avatar) }}" alt="Profile Avatar" class="img-fluid">
                                                    @else
                                                        <img  loading="lazy" src="{{ asset('frontend-images/profile.png') }}" alt="Placeholder Avatar" class="img-fluid">
                                                    @endif
                                                </div>
                                                <div class="mb-3">
                                                    <label for="formFileMultiple" class="form-label fw-bold"><h6 class="mb-0">Avatar <i class="bi bi-info-circle text-warning"></i> <small class="fw-normal">[Recommended size Width : 500px, Height : 500px]</small></h6></label>
                                                    <input class="form-control" type="file" name="avatar" id="formFileMultiple" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--First Name & Last Name-->
                                    <div class="row mb-2">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="first_name" class="form-label fw-bold"><h6 class="mb-0">First Name</h6></label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bi bi-person text-secondary"></i></span>
                                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                                           placeholder="Enter First Name"
                                                           value="{{ isset($profile) ? $profile->first_name : null }}">
                                                    <div class="invalid-feedback">Invalid feedback</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label for="last_name" class="form-label fw-bold"><h6 class="mb-0">Last Name</h6></label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bi bi-person text-secondary"></i></span>
                                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                                           placeholder="Enter Last Name"
                                                           value="{{ isset($profile) ? $profile->last_name : null }}">
                                                    <div class="invalid-feedback">Invalid feedback</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Gender-->
                                    <div class="row mb-2">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label for="gender" class="form-label fw-bold"><h6 class="mb-0">Gender</h6></label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="male" name="gender" id="male" checked>
                                                        <label class="form-check-label" for="male">
                                                            Male
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="female" name="gender" id="female">
                                                        <label class="form-check-label" for="female">
                                                            Female
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Email & Mobile Number-->
                                    <div class="row mb-2">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label fw-bold"><h6 class="mb-0">Email Address</h6></label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bi bi-envelope text-secondary"></i></span>
                                                    <input type="text" class="form-control" id="email" name="email"
                                                           placeholder="Enter Email Address"
                                                           value="{{ $user->email }}">
                                                    <div class="invalid-feedback">Invalid feedback</div>
                                                </div>
                                            </div>
                                            @if(!$user->email_verified_at)
                                                <div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
                                                    <strong>Notice:</strong> Your email is not verified.
                                                    Please <a href="{{ route('verification.notice') }}" class="alert-link">verify your email</a> to unlock full access.
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @else
                                                <span class="badge soft-success"><i class="bi bi-check-circle"></i> Verified</span>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label for="contact_number" class="form-label fw-bold"><h6 class="mb-0">Mobile Number</h6></label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bi bi-phone text-secondary"></i></span>
                                                    <input type="number" maxlength="10" class="form-control" id="contact_number" name="contact_number"
                                                           placeholder="Enter Mobile Number"
                                                           value="{{ isset($profile) ? $profile->contact_number : null }}">
                                                    <div class="invalid-feedback">Invalid feedback</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <!--Personal Information-->
                            <div class="card-header bg-white px-5 mt-2 border-top">
                                <h4>Manage Address</h4>
                            </div>
                            <div class="card-body px-md-5 px-3">
                                <div class="gy-2 my-3">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group mb-2">
                                                <label for="address" class="form-label fw-bold"><h6 class="mb-0">Address</h6></label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bi bi-geo-alt text-secondary"></i></span>
                                                    <input type="text" class="form-control" id="address" name="address"
                                                           placeholder="Enter Address"
                                                           value="{{ $profile ? $profile->address : null }}">
                                                    <div class="invalid-feedback">Invalid feedback</div>
                                                </div>
                                            </div>
                                        </div>

                                        <x-pincode-lookup :profile="$profile" size="6" weight="bold" icon="1"/>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white d-flex justify-content-end py-3 border-0">
                                <button type="submit" class="cu-btn border-0 mb-2" id="save">Save
                                </button>
                            </div>
                        </div><!-- End Contact Form -->
                    </form>
                </div>
            </div>
        </div>
    </section><!-- /Profile Section -->

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
                            img.classList.add('rounded-circle', 'object-fit-cover');
                            img.setAttribute('height', '80');  // Set height (in pixels)
                            img.setAttribute('width', '80');   // Set width (in pixels)
                            img.src = e.target.result; // Set the image source to the result from FileReader
                            preview.appendChild(img); // Add the image to the preview div
                        };

                        reader.readAsDataURL(file); // Read the file as a data URL
                    }
                }
            });
            console.clear();

            //StoreOrUpdate
            $('#manageProfileForm').on('submit', function (e) {
                e.preventDefault();
                var data = new FormData($('#manageProfileForm')[0]);
                $.easyAjax({
                    url: "{{ route('users.profile.storeOrUpdate') }}",
                    container: '#manageProfileForm',
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
