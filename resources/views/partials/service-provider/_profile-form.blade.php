<form id="profileSettingForm" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $provider->id }}">
    <div class="card border-0  mt-3 pb-2 shadow">
        <!--General Details-->
        <div class="card-header border-0 pt-3">
            <div class="d-flex justify-content-between">
                <h4>General Details</h4>
                <button type="submit" class="btn btn-primary shadow-sm" id="save">Save</button>
            </div>

        </div>

        <div class="card-body px-5">
            <div class="d-flex align-items-center previewImg gap-3">
                <div id="preview" class="preview img-thumbnail mb-3" style="display: {{ $profile && isset($profile->avatar) ? 'block' : 'none' }};width: 150px;height:150px;position: relative">
                    @if($profile && !empty($profile->avatar))
                            <img src="{{ url($profile->avatar) }}" alt="Profile Avatar" class="img-fluid">
                            <button
                                class="btn soft-danger remove-avatar shadow-sm"
                                style="position: absolute; top: 5px; right: 5px;"
                                data-id="{{ $profile->id }}"><i class="bi bi-trash"></i>
                            </button>
                    @else
                        <img src="{{ asset('images/show_files/logo-here.png') }}" alt="Placeholder Avatar" class="img-fluid">
                    @endif
                </div>
                <div class="mb-3">
                    <label for="formFileMultiple" class="form-label fw-bold">Upload Logo <i class="bi bi-info-circle text-warning"></i> <small class="fw-normal"> [Recommended size Width : 500px, Height : 500px]</small></label>
                    <input class="form-control" type="file" name="avatar" id="formFileMultiple" accept="image/*">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="company_name" class="form-label fw-bold">Company Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-buildings text-secondary"></i></span>
                            <input type="text" class="form-control" id="company_name" name="company_name"
                                   placeholder="Enter Company Name"
                                   value="{{ isset($profile) ? $profile->company_name : null }}">
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="first_name" class="form-label fw-bold required">First Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-person text-secondary"></i></span>
                            <input type="text" class="form-control" id="first_name" name="first_name"
                                   placeholder="Enter First Name"
                                   value="{{ isset($profile) ? $profile->first_name : null }}" required>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="last_name" class="form-label fw-bold required">Last Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-person text-secondary"></i></span>
                            <input type="text" class="form-control" id="last_name" name="last_name"
                                   placeholder="Enter Last Name"
                                   value="{{ isset($profile) ? $profile->last_name : null }}" required>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="designation" class="form-label fw-bold">Designation</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-person-bounding-box text-secondary"></i></span>
                            <input type="text" class="form-control" id="designation" name="company_designation"
                                   placeholder="Enter Designation"
                                   value="{{ isset($profile) ? $profile->company_designation : null }}">
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="gst-number" class="form-label fw-bold">GST Number</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-bank text-secondary"></i></span>
                            <input type="text" class="form-control" id="gst-number" name="company_gst_no"
                                   placeholder="Enter GST Number"
                                   value="{{ isset($profile) ? $profile->company_gst_no : null }}">
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!--Categories-->
        <div class="card-header border-0 pt-3">
            <h4>Categories & Services</h4>
        </div>
        <div class="card-body px-5">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        @php
                            $categories = null;
                            $categories = $profile && isset($profile->categories) ? json_decode($profile->categories) :[];
                        @endphp
                        <label for="categories" class="form-label fw-bold required">Categories</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-boxes text-secondary"></i></span>
                            <select class="form-control form-select" id="categories" name="categories[]" multiple
                                    placeholder="Select Category" required>
                                @foreach(\App\Models\Category::all() as $category)
                                    <option {{ isset($categories) && in_array($category->id,$categories) ? 'selected' : null  }} value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        @php
                            $services = null;
                            $services = $profile && isset($profile->services) ? json_decode($profile->services) :[];
                        @endphp
                        <label for="services" class="form-label fw-bold">Services</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-boxes text-secondary"></i></span>
                            <select class="form-control form-select" id="services" name="services[]" multiple
                                    placeholder="Select Services">
                                @foreach(\App\Models\Service::all() as $service)
                                    <option {{ isset($services) && in_array($service->id,$services) ? 'selected' : null  }} value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label for="company_description" class="form-label fw-bold ">Description</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-list text-secondary"></i></span>
                            <textarea type="text" rows="4" class="form-control" id="company_description" name="company_description" value="">{{ $profile ? $profile->company_description : null }}</textarea>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <!--Contact Details-->
        <div class="card-header border-0 pt-3">
            <h4>Contact Details</h4>
        </div>
        <div class="card-body px-5">

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="company_email" class="form-label fw-bold required">Email</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-envelope text-secondary"></i></span>
                            <input type="email" class="form-control" id="email" name="company_email"
                                   placeholder="Enter Email"
                                   value="{{ $profile ? $profile->company_email : null }}" required>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="contact_number" class="form-label fw-bold required">Contact Number</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-phone text-secondary"></i></span>
                            <input type="number" class="form-control" id="contact_number" name="contact_number"
                                   placeholder="Enter Contact Number"
                                   value="{{ $profile ? $profile->contact_number : null }}" required>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="alternate_contact_number" class="form-label fw-bold">Whatsapp Number</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-whatsapp text-secondary text-secondary"></i></span>
                            <input type="number" class="form-control" id="alternate_contact_number" name="alternate_contact_number"
                                   placeholder="Enter Whatsapp Number"
                                   value="{{ $profile ? $profile->alternate_contact_number : null }}">
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="website" class="form-label fw-bold">Website</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-globe-americas text-secondary text-secondary"></i></span>
                            <input type="text" max="10" class="form-control" id="website" name="website"
                                   placeholder="http://www.company.com"
                                   value="{{ $profile ? $profile->website : null }}">
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!--Address-->
        <div class="card-header border-0 pt-3">
            <h4>Address</h4>
        </div>
        <div class="card-body px-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label for="address" class="form-label fw-bold required">Address</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-geo-alt text-secondary"></i></span>
                            <input type="text" class="form-control" id="address" name="address"
                                   placeholder="Enter Address"
                                   value="{{ $profile ? $profile->address : null }}" required>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>

                <x-pincode-lookup :profile="$profile" size="6" weight="bold" icon="1"/>
            </div>
        </div>

        <!--Cover Image-->
        <div class="card-header border-0 pt-3">
            <h4>Cover Image</h4>
        </div>
        <div class="card-body px-5">
            <div class="row">
                <div class="col-lg-6">
                <div class="mb-3">
                    <label for="formFileCoverImage" class="form-label fw-bold">Upload Cover Image <i class="bi bi-info-circle text-warning"></i> <small class="fw-normal"> [Recommended size Width : 500px, Height : 400px]</small></label>
                    <input class="form-control" type="file" name="cover_image" id="formFileCoverImage" accept="image/*">
                </div>
                <div class="d-flex align-items-center previewImg gap-3">
                    <div id="previewCover" class="img-thumbnail mb-3" style="display: {{ $profile && isset($profile->cover_image) ? 'block' : 'none' }};position: relative" >
                        @if($profile && !empty($profile->cover_image))
                            <img src="{{ url($profile->cover_image) }}" alt="Banner Image" class="img-responsive" width="250" height="200">
                            <button
                                class="btn soft-danger remove-cover-img shadow-sm"
                                style="position: absolute; top: 5px; right: 5px;"
                                data-id="{{ $profile->id }}"><i class="bi bi-trash"></i>
                            </button>
                        @else
                            <h2 class="m-2">No Cover Image</h2>
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </div>


        <!--Gallery-->
        <div class="card-header border-0 pt-3">
            <h4>Gallery</h4>
        </div>
        <div class="card-body px-5">
            <div class="row">
                <div class="col-lg-12 previewImg">
                    <div class="mb-3">
                        <label for="formFileMultipleImages" class="form-label fw-bold">Upload Gallery Image <i class="bi bi-info-circle text-warning"></i> <small class="fw-normal"> [Recommended size Width : 500px, Height : 400px]</small></label>
                        <input class="form-control" type="file" name="images[]" id="formFileMultipleImages" multiple accept="image/*">
                    </div>
                    <div id="previewMultiple" class="preview"></div>
                </div>
            </div>
            <div class="row">
                @php
                    $images = \App\Models\Media::where('user_id',$provider->id)->get();
                @endphp
                <div class="col-lg-12 d-flex flex-wrap">
                    @if($images->count())
                        @foreach($images as $image)
                            <div class="image-item" style="width: 250px; height: 200px; margin: 10px; position: relative;">
                                <img
                                    src="{{ $image->url }}"
                                    alt="Image"
                                    class="img-fluid"
                                    style="width: 100%; height: 100%;">
                                <button
                                    class="btn soft-danger remove-button shadow-sm"
                                    style="position: absolute; top: 5px; right: 5px;"
                                    data-id="{{ $image->id }}"><i class="bi bi-trash"></i></button>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!--Ratings-->
        @if(auth()->user()->role == 'admin')
        <div class="card-header border-0 pt-3">
            <h4>Set Rating</h4>
        </div>
        <div class="card-body px-5">
            <div class="row">
                <div class="col-lg-12">
                    <div x-data="{ mode: @js($profile->rating_type ?? 'auto'), rating: @js($profile->manual_rating ?? 0)  }">
                        <!-- Radio Buttons -->
                        <div class="mb-3">
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" x-model="mode" name="rating_type" value="auto" {{ $profile && $profile->rating_type == 'auto' ? 'checked' : '' }}>
                                <span class="form-check-label">Auto</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" x-model="mode" name="rating_type" value="manual" {{ $profile && $profile->rating_type == 'manual' ? 'checked' : '' }}>
                                <span class="form-check-label">Manual</span>
                            </label>
                        </div>

                        <!-- Manual Rating Input -->
                        <template x-if="mode === 'manual'" class="mb-3">
                            <div>
                                <label class="form-label">Set Rating (1-5):</label>
                                <input type="number" x-model="rating" min="1" max="5"
                                       class="form-control w-25" step="any"
                                       name="manual_rating"
                                       placeholder="Enter rating (1-5)">
                            </div>
                        </template>

                        <!-- Display Star Rating -->
                        <template class="" x-if="mode === 'manual'">
                            <template x-for="star in 5" :key="star">
                                <i class="bi star text-warning"
                                   :class="{
                                    'bi-star-fill': star <= Math.floor(rating),
                                    'bi-star-half': star > Math.floor(rating) && star <= Math.ceil(rating) && rating % 1 !== 0,
                                    'bi-star': star > Math.ceil(rating)
                                  }"
                                </i>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!--Address-->
        <div class="card-header border-0 pt-3">
            <h4>Login Credentials</h4>
        </div>

        <div class="card-body px-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label fw-bold required">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Enter Name"
                                   value="{{ $provider->name }}" required>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label for="primary_mobile_number" class="form-label fw-bold required">Mobile Number</label>
                        <div class="col-sm-12">
                            <input type="tel" class="form-control" maxlength="10" pattern="\d{10}" id="primary_mobile_number" name="primary_mobile_number"
                                   placeholder="Enter Mobile Number"
                                   value="{{ $provider->primary_mobile_number }}" required>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label fw-bold required">Email</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="name@example.com"
                                   value="{{ $provider->email }}">
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                </div>



                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control"/>
                            <div class="input-group-append">
                                    <button
                                        type="button"
                                        class="btn btn-lg rounded-0 rounded-end-4 m-0"
                                        style="border-color: #dee2e6;"
                                        id="togglePassword"
                                        tabindex="-1">
                                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                    </button>
                                </div>
                            <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"/>
                            <div class="input-group-append">
                                <button
                                    type="button"
                                    class="btn btn-lg rounded-0 rounded-end-4 m-0"
                                    style="border-color: #dee2e6;"
                                    id="togglePassword2"
                                    tabindex="-1">
                                    <i class="bi bi-eye-slash" id="toggleIcon2"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--Submit Button-->
        <div class="card-footer d-flex justify-content-end py-3 border-0">
            <button type="submit" class="btn btn-primary shadow-sm" id="save">Save
            </button>
        </div>
        <svg style="display:none">
            <defs>
                <symbol id="icon-imageUpload" clip-rule="evenodd" viewBox="0 0 96 96">
                    <path d="M47 6a21 21 0 0 0-12.3 3.8c-2.7 2.1-4.4 5-4.7 7.1-5.8 1.2-10.3 5.6-10.3 10.6 0 6 5.8 11 13 11h12.6V22.7l-7.1 6.8c-.4.3-.9.5-1.4.5-1 0-2-.8-2-1.7 0-.4.3-.9.6-1.2l10.3-8.8c.3-.4.8-.6 1.3-.6.6 0 1 .2 1.4.6l10.2 8.8c.4.3.6.8.6 1.2 0 1-.9 1.7-2 1.7-.5 0-1-.2-1.3-.5l-7.2-6.8v15.6h14.4c6.1 0 11.2-4.1 11.2-9.4 0-5-4-8.8-9.5-9.4C63.8 11.8 56 5.8 47 6Zm-1.7 42.7V38.4h3.4v10.3c0 .8-.7 1.5-1.7 1.5s-1.7-.7-1.7-1.5Z M27 49c-4 0-7 2-7 6v29c0 3 3 6 6 6h42c3 0 6-3 6-6V55c0-4-3-6-7-6H28Zm41 3c1 0 3 1 3 3v19l-13-6a2 2 0 0 0-2 0L44 79l-10-5a2 2 0 0 0-2 0l-9 7V55c0-2 2-3 4-3h41Z M40 62c0 2-2 4-5 4s-5-2-5-4 2-4 5-4 5 2 5 4Z"/>
                </symbol>
            </defs>
        </svg>
    </div>
</form>
