<form id="profileSettingForm" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $provider->id }}">
    <div class="card border-0 pb-2 shadow">

        <div class="row">
            <div class="col-md-4 pe-0">
                <!--Cover Image-->
                <div class="card-header border-0 pt-3" style="border-radius: 0px;">
                    <h4><i class="bi bi-file-image"></i> Cover Image</h4>
                </div>
                <div class="card-body px-5">
                    <div class="row">
                        <div class="col-lg-12">
                            @if($provider && isset($provider->serviceproviderprofile->cover_image))
                            <img src="{{ url($provider->serviceproviderprofile->cover_image) }}" class="img-fluid object-fit-cover" alt="" style="height:250px;">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 ps-0">
                <!--General Details-->
                <div>
                    <div class="card-header border-0 pt-3 px-5 d-flex justify-content-between" style="border-radius: 0px;">
                        <h4><i class="bi bi-house-door"></i> General Details</h4>
                        <!-- Edit button in show page -->
                        <a href="{{ route('serviceproviders.update',['serviceprovider'=>$provider->id]) }}"
                           data-toggle="tooltip"
                           data-original-title="Edit"
                           class="edit btn btn-sm soft-warning editJobPost"
                           title="Edit">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </div>
                    <div class="card-body px-5">
                        <div class="d-flex align-items-center justify-content-center previewImg gap-3">
                            <div id="preview" class="preview img-thumbnail mb-3">
                                @if($profile && !empty($profile->avatar))
                                    <img src="{{ url($profile->avatar) }}" alt="Profile Avatar" class="img-fluid" style="width: 150px;height:150px">
                                @else
                                    <img src="{{ asset('images/show_files/logo-here.png') }}" alt="Placeholder Avatar" class="img-fluid" style="width: 150px;height:150px">
                                @endif
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-3">
                                <label for="company_name" class="form-label fw-semibold">Company Name :</label>
                            </div>
                            <div class="col-lg-9">
                                <h6 class="fw-normal text-secondary">{{ isset($profile) ? $profile->company_name : null }}</h6>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-3">
                                <label for="first_name" class="form-label fw-semibold">First Name :</label>
                            </div>
                            <div class="col-lg-9">
                                <h6 class="fw-normal text-secondary">{{ isset($profile) ? $profile->first_name : null }}</h6>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-3">
                                <label for="last_name" class="form-label fw-semibold ">Last Name :</label>
                            </div>
                            <div class="col-lg-9">
                                <h6 class="fw-normal text-secondary">{{ isset($profile) ? $profile->last_name : null }}</h6>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-3">
                                <label for="designation" class="form-label fw-semibold ">Designation :</label>
                            </div>
                            <div class="col-lg-9">
                                <h6 class="fw-normal text-secondary">{{ isset($profile) ? $profile->company_designation : null }}</h6>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-3">
                                <label for="gst-number" class="form-label fw-semibold ">GST Number :</label>
                            </div>
                            <div class="col-lg-9">
                                <h6 class="fw-normal text-secondary">{{ isset($profile) ? $profile->company_gst_no : null }}</h6>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-3">
                                <label for="referral" class="form-label fw-semibold ">Referral :</label>
                            </div>
                            <div class="col-lg-9">
                                @if(auth()->user()->isAdmin())
                                    <h6 class="fw-normal text-secondary">{{ isset($provider) && isset($provider->referredBy) ? $provider->referredBy->name.' - '.$provider->referredBy->referral_code : null }}</h6>
                                @else
                                    <h6 class="fw-normal text-secondary">{{ isset($provider) && isset($provider->referredBy) ? $provider->referredBy->referral_code : null }}</h6>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--Categories-->
        <div>
            <div class="card-header border-0 pt-3">
                <h4><i class="bi bi-tag"></i> Categories & Services</h4>
            </div>
            <div class="card-body px-5">
                <div class="row mb-2">
                    <div class="col-lg-3">
                        @php
                            $categories = null;
                            $categories = $profile && isset($profile->categories) ? json_decode($profile->categories) :[];
                        @endphp
                        <label for="categories" class="form-label fw-semibold">Categories :</label>
                    </div>
                    <div class="col-lg-9 d-flex flex-wrap gap-2 mb-2">
                      @if($categories)
                           @foreach($categories as $id)
                               @php
                                   $category = \App\Models\Category::find($id);
                                @endphp
                                @if(isset($category))
                                    <span class="btn btn-lg soft-primary" style="font-style: normal">{{ $category->name }}</span>
                                @endif
                           @endforeach
                        @endif
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3">
                        @php
                            $services = null;
                            $services = $profile && isset($profile->services) ? json_decode($profile->services) :[];
                        @endphp
                        <label for="services" class="form-label fw-semibold">Services :</label>
                    </div>
                    <div class="col-lg-9 d-flex flex-wrap gap-2 mb-2">
                        @if($services)
                            @foreach($services as $id)
                                @php
                                    $service = \App\Models\Service::find($id);
                                @endphp
                                @if(isset($service))
                                    <span class="btn btn-lg soft-secondary" style="font-style: normal"> {{ $service->name }}</span>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3">
                        <label for="company_description" class="form-label fw-semibold ">Description :</label>
                    </div>
                    <div class="col-lg-9">
                        <h6 class="fw-normal text-secondary">
                            {{ $profile ? $profile->company_description : null }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!--Contact Details-->
        <div>
            <div class="card-header border-0 pt-3">
                <h4><i class="bi bi-telephone"></i> Contact Details</h4>
            </div>
            <div class="card-body px-5">

                <div class="row mb-2">
                    <div class="col-lg-3">
                        <label for="company_email" class="form-label fw-semibold">Email :</label>
                    </div>
                    <div class="col-lg-9">
                        <h6 class="fw-normal text-secondary">
                            {{ $profile ? $profile->company_email : null }}
                        </h6>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3">
                        <label for="contact_number" class="form-label fw-semibold">Contact Number :</label>
                    </div>
                    <div class="col-lg-9">
                        <h6 class="fw-normal text-secondary">
                            {{ $profile ? $profile->contact_number : null }}
                        </h6>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3">
                        <label for="alternate_contact_number" class="form-label fw-semibold">Whatsapp Number :</label>
                    </div>
                    <div class="col-lg-9">
                        <h6 class="fw-normal text-secondary">
                            {{ $profile ? $profile->alternate_contact_number : null }}
                        </h6>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3">
                        <label for="website" class="form-label fw-semibold">Website :</label>
                    </div>
                    <div class="col-lg-9">
                        <h6 class="fw-normal text-secondary">
                            {{ $profile ? $profile->website : null }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!--Address-->
        <div>
            <div class="card-header border-0 pt-3">
                <h4><i class="bi bi-geo-alt"></i> Address</h4>
            </div>
            <div class="card-body px-5">

                <div class="row mb-2">
                    <div class="col-lg-3">
                        <label for="address" class="form-label fw-semibold">Address :</label>
                    </div>
                    <div class="col-lg-9">
                        <h6 class="fw-normal text-secondary">
                            {{ $profile ? $profile->address : null }}
                        </h6>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3">
                        <label for="city" class="form-label fw-semibold">City :</label>
                    </div>
                    <div class="col-lg-9">
                        <h6 class="fw-normal text-secondary">
                            {{ $profile ? $profile->city : null }}
                        </h6>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3">
                        <label for="pin_code" class="form-label fw-semibold">Pin Code :</label>
                    </div>
                    <div class="col-lg-9">
                        <h6 class="fw-normal text-secondary">
                            {{ $profile ? $profile->pin_code : null }}
                        </h6>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3">
                        <label for="state" class="form-label fw-semibold">State :</label>
                    </div>
                    <div class="col-lg-9">
                        <h6 class="fw-normal text-secondary">
                            {{ $profile ? $profile->state : null }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>


    </div>
</form>
