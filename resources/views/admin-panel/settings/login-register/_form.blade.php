<form id="loginSignupSettingForm" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ isset($setting) ? $setting->id : null}}">
    <div class="px-3">
        <!--Login Section-->
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-header bg-white">
                <h5>Login Section</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <!--Heading-->
                        <div class="form-group">
                            <label for="login_heading" class="form-label fw-bold">Heading</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="login_heading" name="login_heading"
                                       placeholder="Enter Heading"
                                       value="{{ isset($setting) ? $setting->login_heading : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <!--Login Text-->
                        <div class="form-group">
                            <label for="login_text" class="form-label fw-bold">Login Text</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <textarea class="form-control" rows="5" name="login_text" id="login_text">{{ isset($setting) ? $setting->login_text : null }}</textarea>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="formFileMultiple" class="form-label fw-bold">Upload Background Image</label>
                            <input class="form-control" type="file" name="login_banner_img" id="formFileMultiple" accept="image/*">
                        </div>
                        <div class="d-flex align-items-center previewImg gap-3">
                            <div id="preview" class="preview-cover img-thumbnail mb-3" style="display: {{ $setting && isset($setting->header_banner_img) ? 'block' : 'none' }}">
                                @if($setting && !empty($setting->login_banner_img))
                                    <img src="{{ url($setting->login_banner_img) }}" alt="Banner Image" class="img-fluid">
                                @else
                                    <h2 class="m-2">No Banner</h2>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white text-end">
                <button type="submit" class="btn btn-primary shadow-sm" id="save">Save</button>
            </div>
        </div>

        <!--Signup Section-->
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-header bg-white">
                <h5>Signup Section</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <!--Heading-->
                        <div class="form-group">
                            <label for="signup_heading" class="form-label fw-bold">Heading</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="signup_heading" name="signup_heading"
                                       placeholder="Enter Heading"
                                       value="{{ isset($setting) ? $setting->signup_heading : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <!--Login Text-->
                        <div class="form-group">
                            <label for="signup_text" class="form-label fw-bold">Signup Text</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <textarea class="form-control" rows="5" name="signup_text" id="signup_text">{{ isset($setting) ? $setting->signup_text : null }}</textarea>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="formFileMultiple1" class="form-label fw-bold">Upload Background Image</label>
                            <input class="form-control" type="file" name="signup_banner_img" id="formFileMultiple1" accept="image/*">
                        </div>
                        <div class="d-flex align-items-center previewImg gap-3">
                            <div id="preview1" class="preview-cover img-thumbnail mb-3" style="display: {{ $setting && isset($setting->header_banner_img) ? 'block' : 'none' }}">
                                @if($setting && !empty($setting->signup_banner_img))
                                    <img src="{{ url($setting->signup_banner_img) }}" alt="Banner Image" class="img-fluid">
                                @else
                                    <h2 class="m-2">No Banner</h2>
                                @endif
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
