<form id="contactUsSettingForm" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ isset($setting) ? $setting->id : null}}">
    <div class="px-3">
        <!--Header Section-->
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-header bg-white">
                <h5>Contact Us</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="formFileMultiple" class="form-label fw-bold">Upload Image</label>
                            <input class="form-control" type="file" name="contact_us_img" id="formFileMultiple" accept="image/*">
                        </div>
                        <div class="d-flex align-items-center previewImg gap-3">

                            <div id="preview" class="preview-cover img-thumbnail mb-3" style="display: {{ $setting && isset($setting->header_banner_img) ? 'block' : 'none' }}">
                                @if($setting && !empty($setting->contact_us_img))
                                    <img src="{{ url($setting->contact_us_img) }}" alt="Banner Image" class="img-fluid">
                                @else
                                    <h2 class="m-2">No Image</h2>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="formFileMultiple1" class="form-label fw-bold">Upload Background Image</label>
                            <input class="form-control" type="file" name="contact_us_bg_img" id="formFileMultiple1" accept="image/*">
                        </div>
                        <div class="d-flex align-items-center previewImg gap-3">

                            <div id="preview1" class="preview-cover img-thumbnail mb-3" style="display: {{ $setting && isset($setting->header_banner_img) ? 'block' : 'none' }}">
                                @if($setting && !empty($setting->contact_us_bg_img))
                                    <img src="{{ url($setting->contact_us_bg_img) }}" alt="Background Image" class="img-fluid">
                                @else
                                    <h2 class="m-2">No Backgroud Image</h2>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-check">
                            <input type="hidden" name="contact_us_dfa" value="0">
                            <input class="form-check-input" type="checkbox" name="contact_us_dfa" value="1" id="flexCheckFirstAdd" {{ $setting && $setting->contact_us_dfa ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheckFirstAdd">
                                Display {{ $setting && $setting->address_first_heading ? $setting->address_first_heading : $setting->address_first }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="contact_us_dfm" value="0">
                            <input class="form-check-input" type="checkbox" name="contact_us_dfm" value="1"  id="flexCheckFirstMap" {{ $setting && $setting->contact_us_dfm ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheckFirstMap">
                                Display Map Address 1
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-check">
                            <input type="hidden" name="contact_us_dsa" value="0">
                            <input class="form-check-input" type="checkbox" name="contact_us_dsa" value="1" id="flexCheckSecondAdd" {{ $setting && $setting->contact_us_dsa ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheckSecondAdd">
                                Display {{ $setting && $setting->address_second_heading ? $setting->address_second_heading : $setting->second }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="contact_us_dsm" value="0">
                            <input class="form-check-input" type="checkbox" name="contact_us_dsm" value="1"  id="flexCheckSecondMap" {{ $setting && $setting->contact_us_dsm ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheckSecondMap">
                                Display Map Address 2
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <textarea class="form-control" rows="5" name="address_first_map" id="address_first_map">{{ isset($setting) ? $setting->address_first_map : null }}</textarea>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <textarea class="form-control" rows="5" name="address_second_map" id="address_second_map">{{ isset($setting) ? $setting->address_second_map : null }}</textarea>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white text-end">
                <button type="submit" class="btn btn-primary shadow-sm" id="save">Save</button>
            </div>
        </div>


    </div>
</form>
