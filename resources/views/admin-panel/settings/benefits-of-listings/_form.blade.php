<form id="benefitsOfListingsSettingForm" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ isset($setting) ? $setting->id : null}}">
    <div class="px-3">
        <!-- Background Img for Add Listing-->
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-header bg-white">
                <h5>Add/Edit Listing Section</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="formFileMultiple" class="form-label fw-bold">Upload Background Image</label>
                            <input class="form-control" type="file" name="add_listing_banner_img" id="formFileMultiple" accept="image/*">
                        </div>
                        <div class="d-flex align-items-center previewImg gap-3">
                            <div id="preview" class="preview-cover img-thumbnail mb-3" style="display: {{ $setting && isset($setting->header_banner_img) ? 'block' : 'none' }}">
                                @if($setting && !empty($setting->add_listing_banner_img))
                                    <img src="{{ url($setting->add_listing_banner_img) }}" alt="Banner Image" class="img-fluid">
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
        <!--Benefits of Listing Section-->
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-header bg-white">
                <h5>Benefits of Listings</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <!--featured provider heading-->
                        <div class="form-group">
                            <label for="benefits_of_listings_heading" class="form-label fw-bold">Heading</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="benefits_of_listings_heading" name="benefits_of_listings_heading"
                                       placeholder="Enter Heading"
                                       value="{{ isset($setting) ? $setting->benefits_of_listings_heading : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!--featured provider sub-heading-->
                        <div class="form-group">
                            <label for="benefits_of_listings_subheading" class="form-label fw-bold">Sub Heading</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="benefits_of_listings_subheading" name="benefits_of_listings_subheading"
                                       placeholder="Enter Sub-Heading"
                                       value="{{ isset($setting) ? $setting->benefits_of_listings_subheading : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!--Heading-->
                        <div class="form-group">
                            <label for="benefits_of_listings_content" class="form-label fw-bold">Content</label>
                            <!-- Quill Editor -->
                            <div id="editor">{!! $setting->benefits_of_listings_content !!}</div>
                            <!-- Hidden textarea to store the content -->
                            <textarea id="editor-content" name="benefits_of_listings_content" style="display: none;"></textarea>
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
