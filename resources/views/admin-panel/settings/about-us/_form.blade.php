<form id="aboutUsSettingForm" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ isset($setting) ? $setting->id : null}}">
    <div class="px-3">
        <!--Header Section-->
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-header bg-white">
                <h5>About Us</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <!--featured provider heading-->
                        <div class="form-group">
                            <label for="about_us_heading" class="form-label fw-bold">Heading</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="about_us_heading" name="about_us_heading"
                                       placeholder="Enter Heading"
                                       value="{{ isset($setting) ? $setting->about_us_heading : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!--featured provider sub-heading-->
                        <div class="form-group">
                            <label for="about_us_subheading" class="form-label fw-bold">Sub Heading</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="about_us_subheading" name="about_us_subheading"
                                       placeholder="Enter Sub-Heading"
                                       value="{{ isset($setting) ? $setting->about_us_subheading : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!--Heading-->
                        <div class="form-group">
                            <label for="about_us_content" class="form-label fw-bold">Content</label>
                            <!-- Quill Editor -->
                            <div id="editor">{!! $setting->about_us_content !!}</div>
                            <!-- Hidden textarea to store the content -->
                            <textarea id="editor-content" name="about_us_content" style="display: none;"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white text-end">
                <button type="submit" class="btn btn-primary shadow-sm" id="save">Save</button>
            </div>
        </div>

        <!--Video Section-->
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-header bg-white">
                <h5>Video Upload</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group previewImg mb-3">
                            <label for="formFileVideo" class="form-label">Choose Video</label>
                            <input class="form-control" type="file" name="about_us_video" id="formFileVideo" accept="video/mp4,video/mov,video/avi,video/wmv">
                            @if(isset($setting->about_us_video))
                            <div class="mt-3">
                                <video width="500" height="300" controls>
                                    <source src="{{ $setting->about_us_video }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            @endif
                        </div>
                        <!--Enable/Disable Video-->
                        <div class="form-check ">
                            <input type="hidden" name="show_about_us_video" value="0">
                            <input class="form-check-input" type="checkbox" name="show_about_us_video" value="1" id="flexAboutUsVideo" {{ isset($setting) && $setting->show_about_us_video ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="flexAboutUsVideo">
                                Show Video on about us page
                            </label>
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
