<form id="generalSettingForm" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ isset($setting) ? $setting->id : null}}">
    <div class="px-3">
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-body">
                <!--Logo and Firm name-->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center previewImg gap-3">
                            <div id="preview" class="preview img-thumbnail mb-3 d-flex justify-content-center" style="display: {{ $setting && isset($setting->logo) ? 'block' : 'none' }};width: 150px;">
                                @if($setting && !empty($setting->logo))
                                    <img src="{{ url($setting->logo) }}" alt="Firm Logo" class="img-fluid">
                                @else
                                    <img src="{{ asset('images/show_files/logo-here.png') }}" alt="Placeholder Logo" class="img-fluid">
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="formFileMultiple" class="form-label fw-bold">Upload Logo</label>
                                <input class="form-control" type="file" name="logo" id="formFileMultiple" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="firm_name" class="form-label fw-bold">Firm Name</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-buildings text-secondary"></i></span>
                                <input type="text" class="form-control" id="firm_name" name="firm_name"
                                       placeholder="Enter Firm Name"
                                       value="{{ isset($setting) ? $setting->firm_name : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Contact Details-->
                <div class="row mb-3">
                    <!--Address 1-->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-between border-bottom mb-3">
                                    <h6>Address 1</h6>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="primary_contact_details" value="0" id="flexRadioDefault1" {{ $setting && !$setting->primary_contact_details ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="flexRadioDefault1">
                                            Make Primary
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address_first_heading" class="form-label fw-bold">Header</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-house text-secondary"></i></span>
                                        <input type="text" class="form-control" id="address_first_heading" name="address_first_heading"
                                               placeholder="Enter Title"
                                               value="{{ $setting ? $setting->address_first_heading : null }}">
                                        <div class="invalid-feedback">Invalid feedback</div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address" class="form-label fw-bold">Address</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-geo-alt text-secondary"></i></span>
                                        <input type="text" class="form-control" id="address_first" name="address_first"
                                               placeholder="Enter Address"
                                               value="{{ $setting ? $setting->address_first : null }}">
                                        <div class="invalid-feedback">Invalid feedback</div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="contact_number" class="form-label fw-bold">Contact Number</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-phone text-secondary"></i></span>
                                        <input type="number" class="form-control" id="phone_first" name="phone_first"
                                               placeholder="Enter Contact Number"
                                               value="{{ $setting ? $setting->phone_first : null }}">
                                        <div class="invalid-feedback">Invalid feedback</div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <div class="col-sm-12">
                                        <input type="email" class="form-control" id="email_first" name="email_first"
                                               placeholder="name@example.com"
                                               value="{{ isset($setting) ? $setting->email_first : null }}">
                                        <div class="invalid-feedback">Invalid feedback</div>
                                    </div>
                                </div>
                                <hr>
                                <h6>Set Latitude and Longitude for map view</h6>
                                <div class="form-group mb-3">
                                    <label for="address_first_lat" class="form-label fw-bold">Latitude</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="address_first_lat" name="address_first_lat"
                                               placeholder="Eg : 123238.123"
                                               value="{{ isset($setting) ? $setting->address_first_lat : null }}">
                                        <div class="invalid-feedback">Invalid feedback</div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address_first_lng" class="form-label fw-bold">Longitude</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="address_first_lng" name="address_first_lng"
                                               placeholder="Eg : 223238.675"
                                               value="{{ isset($setting) ? $setting->address_first_lng : null }}">
                                        <div class="invalid-feedback">Invalid feedback</div>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input type="hidden" name="display_address_one_footer" value="0">
                                    <input class="form-check-input" type="checkbox" name="display_address_one_footer" value="1"  id="flexCheckAddFooterOne" {{ $setting && $setting->display_address_one_footer ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="flexCheckAddFooterOne">
                                        Display Footer Address
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Address 2-->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between border-bottom mb-3">
                                    <h6>Address 2</h6>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="primary_contact_details" value="1" id="flexRadioDefault2" {{ $setting && $setting->primary_contact_details ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="flexRadioDefault2">
                                            Make Primary
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address_second_heading" class="form-label fw-bold">Header</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-house  text-secondary"></i></span>
                                        <input type="text" class="form-control" id="address_second_heading" name="address_second_heading"
                                               placeholder="Enter Title"
                                               value="{{ $setting ? $setting->address_second_heading : null }}">
                                        <div class="invalid-feedback">Invalid feedback</div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address" class="form-label fw-bold">Address</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-geo-alt text-secondary"></i></span>
                                        <input type="text" class="form-control" id="address_second" name="address_second"
                                               placeholder="Enter Address"
                                               value="{{ $setting ? $setting->address_second : null }}">
                                        <div class="invalid-feedback">Invalid feedback</div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="contact_number" class="form-label fw-bold">Contact Number</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-phone text-secondary"></i></span>
                                        <input type="number" class="form-control" id="phone_second" name="phone_second"
                                               placeholder="Enter Contact Number"
                                               value="{{ $setting ? $setting->phone_second : null }}">
                                        <div class="invalid-feedback">Invalid feedback</div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <div class="col-sm-12">
                                        <input type="email" class="form-control" id="email_second" name="email_second"
                                               placeholder="name@example.com"
                                               value="{{ isset($setting) ? $setting->email_second : null }}">
                                        <div class="invalid-feedback">Invalid feedback</div>
                                    </div>
                                </div>
                                <hr>
                                <h6>Set Latitude and Longitude for map view</h6>
                                <div class="form-group mb-3">
                                    <label for="address_second_lat" class="form-label fw-bold">Latitude</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="address_second_lat" name="address_second_lat"
                                               placeholder="Eg : 123238.123"
                                               value="{{ isset($setting) ? $setting->address_second_lat : null }}">
                                        <div class="invalid-feedback">Invalid feedback</div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address_second_lng" class="form-label fw-bold">Longitude</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="address_second_lng" name="address_second_lng"
                                               placeholder="Eg : 223238.675"
                                               value="{{ isset($setting) ? $setting->address_second_lng : null }}">
                                        <div class="invalid-feedback">Invalid feedback</div>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input type="hidden" name="display_address_two_footer" value="0">
                                    <input class="form-check-input" type="checkbox" name="display_address_two_footer" value="1"  id="flexCheckAddFooterTwo" {{ $setting && $setting->display_address_two_footer ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="flexCheckAddFooterTwo">
                                        Display Footer Address
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--Social Links-->
                <div class="row mb-3">
                    <h6 class="border-top py-3">Footer</h6>
                    <div class="col-lg-12">
                        <div class="d-flex align-items-center previewImg gap-3">
                            <div id="previewFooterLogo" class="preview img-thumbnail mb-3 d-flex justify-content-center" style="display: {{ $setting && isset($setting->footer_logo) ? 'block' : 'none' }};width: 150px;">
                                @if($setting && !empty($setting->footer_logo))
                                    <img src="{{ url($setting->footer_logo) }}" alt="Footer Logo" class="img-fluid">
                                @else
                                    <img src="{{ asset('images/show_files/logo-here.png') }}" alt="Placeholder Logo" class="img-fluid">
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="formFileFooterLogo" class="form-label fw-bold">Upload Footer Logo</label>
                                <input class="form-control" type="file" name="footer_logo" id="formFileFooterLogo" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="ctrlf_link" class="form-label fw-bold">Learn with CTRLF link</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-youtube text-secondary"></i></span>
                                <input type="text" class="form-control" id="ctrlf_link" name="learn_with_ctrlf_url"
                                       placeholder="https://youtube.com"
                                       value="{{ $setting ? $setting->learn_with_ctrlf_url : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                    <h6 class="py-3">Social Links</h6>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="youtube_link" class="form-label fw-bold">Youtube</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-youtube text-secondary"></i></span>
                                <input type="text" class="form-control" id="youtube_link" name="youtube_link"
                                       placeholder="https://youtube.com"
                                       value="{{ $setting ? $setting->youtube_link : null }}">
                                <span class="input-group-text">
                                    <input type="number" class="form-control" style="width: 70px" id="youtube_link_order" name="youtube_link_order"
                                           value="{{ $setting ? $setting->youtube_link_order : 1 }}">
                                </span>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="facebook_link" class="form-label fw-bold">Facebook</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-facebook text-secondary"></i></span>
                                <input type="text" class="form-control" id="facebook_link" name="facebook_link"
                                       placeholder="https://facebook.com"
                                       value="{{ $setting ? $setting->facebook_link : null }}">
                                <span class="input-group-text">
                                    <input type="number" class="form-control" style="width: 70px" id="facebook_link_order" name="facebook_link_order"
                                           value="{{ $setting ? $setting->facebook_link_order : 1 }}">
                                </span>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="linkedin_link" class="form-label fw-bold">LinkedIn</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-linkedin text-secondary"></i></span>
                                <input type="text" class="form-control" id="linkedin_link" name="linkedin_link"
                                       placeholder="https://linkedin.com"
                                       value="{{ $setting ? $setting->linkedin_link : null }}">
                                <span class="input-group-text">
                                    <input type="number" class="form-control" style="width: 70px" id="linkedin_link_order" name="linkedin_link_order"
                                           value="{{ $setting ? $setting->linkedin_link_order : 1 }}">
                                </span>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="instagram_link" class="form-label fw-bold">Instagram</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-instagram text-secondary"></i></span>
                                <input type="text" class="form-control" id="instagram_link" name="instagram_link"
                                       placeholder="https://instagram.com"
                                       value="{{ $setting ? $setting->instagram_link : null }}">
                                <span class="input-group-text">
                                    <input type="number" class="form-control" style="width: 70px" id="instagram_link_order" name="instagram_link_order"
                                           value="{{ $setting ? $setting->instagram_link_order : 1 }}">
                                </span>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Payment and Qr Code-->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="formFileMultiple2" class="form-label fw-bold">Upload QR Code Image</label>
                            <input class="form-control" type="file" name="qr_code_img" id="formFileMultiple2" accept="image/*">
                        </div>
                        <div class="d-flex align-items-center previewImg gap-3">
                            <div id="preview2" class="preview-cover img-thumbnail mb-3" style="display: {{ $setting && isset($setting->header_banner_img) ? 'block' : 'none' }}">
                                @if($setting && !empty($setting->qr_code_img))
                                    <img src="{{ url($setting->qr_code_img) }}" alt="QR Code Image" class="img-fluid">
                                @else
                                    <h2 class="m-2">No Qr Code Set</h2>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

</div>
{{-- ── Hero Slider Banners ── --}}
<div class="row mt-4">
    <div class="col-12">
        <h6 class="border-top py-3">
            <i class="bi bi-images me-2"></i>Hero Slider Banners
            <small class="text-muted fw-normal ms-2">(Recommended: 1440 × 500px, JPG/PNG/WebP)</small>
        </h6>
    </div>

    @foreach([1,2,3] as $n)
    <div class="col-lg-4 mb-3">
        <div class="card border shadow-sm h-100">
            <div class="card-header bg-light d-flex align-items-center justify-content-between">
                <span class="fw-bold small">
                    <i class="bi bi-image me-1"></i>Banner {{ $n }}
                </span>
                @if($n == 1)<span class="badge bg-success">Slide 1</span>@endif
                @if($n == 2)<span class="badge bg-primary">Slide 2</span>@endif
                @if($n == 3)<span class="badge bg-warning text-dark">Slide 3</span>@endif
            </div>
            <div class="card-body">

                {{-- Preview --}}
                <div id="hero_banner_preview_{{ $n }}" class="mb-3">
                    @if($setting && $setting->{"hero_banner_{$n}"})
                        <img src="{{ url($setting->{"hero_banner_{$n}"}) }}"
                             class="img-fluid rounded w-100"
                             style="height:130px;object-fit:cover;">
                        <p class="text-success small mt-1 mb-0">
                            <i class="bi bi-check-circle me-1"></i>Uploaded
                        </p>
                    @else
                        <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                             style="height:130px;border-style:dashed !important;">
                            <div class="text-center text-muted">
                                <i class="bi bi-image fs-2 d-block mb-1"></i>
                                <small>No image yet</small>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Upload --}}
                <input type="file"
                       name="hero_banner_{{ $n }}"
                       id="hero_banner_input_{{ $n }}"
                       class="form-control form-control-sm"
                       accept="image/jpeg,image/png,image/webp">
                <div class="form-text small">
                    1024× 500px — design in Canva with text, then upload.
                </div>

            </div>
        </div>
    </div>
    @endforeach

</div>
{{-- ── /Hero Slider Banners ── --}}
            <div class="card-footer bg-white text-end">
                <button type="submit" class="btn btn-primary shadow-sm" id="save">Save</button>
            </div>
        </div>

    </div>
</form>
