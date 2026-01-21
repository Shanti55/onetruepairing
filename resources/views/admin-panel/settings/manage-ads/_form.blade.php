<form id="manageAdsSettingForm" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ isset($setting) ? $setting->id : null}}">
    <div class="px-3">
        <!--Home Page Section-->
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-header bg-white">
                <h5>Home Page Ads</h5>
            </div>
            <div class="card-body">
                <!--Ad One-->
                <div class="row">
                    <!--Image-->
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <input type="hidden" name="ads_on_home_page_one[image]" value="{{ isset($adOnHomePageOne) && property_exists($adOnHomePageOne,'image') ? $adOnHomePageOne->image : null }}">
                            <label for="formFileMultiple" class="form-label fw-bold">1-Upload Ad Image</label>
                            <input class="form-control" type="file" name="ads_on_home_page_one[image]" id="formFileMultiple" accept="image/*">
                        </div>
                        <div class="d-flex align-items-center previewImg gap-3">
                            <div id="preview" class="preview-cover img-thumbnail mb-3" style="display: {{ $setting && isset($setting->header_banner_img) ? 'block' : 'none' }}">
                                @if( isset($adOnHomePageOne) && property_exists($adOnHomePageOne,'image') && !empty($adOnHomePageOne->image))
                                    <img src="{{ url($adOnHomePageOne->image) }}" alt="Banner Image" class="img-fluid">
                                @else
                                    <h2 class="m-2">No Banner</h2>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!--Url-->
                        <div class="form-group">
                            <label for="ads_on_home_page_one_url" class="form-label fw-bold">URL</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="ads_on_home_page_one_url" name="ads_on_home_page_one[url]"
                                       placeholder="Enter Url Eg : http://www.ctrlf.com"
                                       value="{{ isset($adOnHomePageOne) && property_exists($adOnHomePageOne,'url') ? $adOnHomePageOne->url : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="show_home_ad_one" value="0">
                            <input class="form-check-input" type="checkbox" name="show_home_ad_one" value="1" id="flexCheckHomeAdOne" {{ $setting && $setting->show_home_ad_one ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheckHomeAdOne">
                                Show Ad
                            </label>
                        </div>
                    </div>

                </div>
                <!--Ad Two-->
                <div class="row">
                    <!--Image-->
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <input type="hidden" name="ads_on_home_page_two[image]" value="{{ isset($adOnHomePageTwo) && property_exists($adOnHomePageTwo,'image') ? $adOnHomePageTwo->image : null }}">
                            <label for="formFileMultipleTwo" class="form-label fw-bold">2-Upload Ad Image</label>
                            <input class="form-control" type="file" name="ads_on_home_page_two[image]" id="formFileMultipleTwo" accept="image/*">
                        </div>
                        <div class="d-flex align-items-center previewImg gap-3">
                            <div id="previewTwo" class="preview-cover img-thumbnail mb-3" style="display: {{ $setting && isset($setting->header_banner_img) ? 'block' : 'none' }}">
                                @if( isset($adOnHomePageTwo) && property_exists($adOnHomePageTwo,'image') && !empty($adOnHomePageTwo->image))
                                    <img src="{{ url($adOnHomePageTwo->image) }}" alt="Banner Image" class="img-fluid">
                                @else
                                    <h2 class="m-2">No Banner</h2>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!--Url-->
                        <div class="form-group">
                            <label for="ads_on_home_page_two_url" class="form-label fw-bold">URL</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="ads_on_home_page_two_url" name="ads_on_home_page_two[url]"
                                       placeholder="Enter Url Eg : http://www.ctrlf.com"
                                       value="{{ isset($adOnHomePageTwo) && property_exists($adOnHomePageTwo,'url') ? $adOnHomePageTwo->url : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="show_home_ad_two" value="0">
                            <input class="form-check-input" type="checkbox" name="show_home_ad_two" value="1" id="flexCheckHomeAdTwo" {{ $setting && $setting->show_home_ad_two ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheckHomeAdOne">
                                Show Ad
                            </label>
                        </div>
                    </div>

                </div>
                <!--Ad Three-->
                <div class="row">
                    <!--Image-->
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <input type="hidden" name="ads_on_home_page_three[image]" value="{{ isset($adOnHomePageThree) && property_exists($adOnHomePageThree,'image') ? $adOnHomePageThree->image : null }}">
                            <label for="formFileMultipleThree" class="form-label fw-bold">3-Upload Ad Image</label>
                            <input class="form-control" type="file" name="ads_on_home_page_three[image]" id="formFileMultipleThree" accept="image/*">
                        </div>
                        <div class="d-flex align-items-center previewImg gap-3">
                            <div id="previewThree" class="preview-cover img-thumbnail mb-3" style="display: {{ $setting && isset($setting->header_banner_img) ? 'block' : 'none' }}">
                                @if( isset($adOnHomePageThree) && property_exists($adOnHomePageThree,'image') && !empty($adOnHomePageThree->image))
                                    <img src="{{ url($adOnHomePageThree->image) }}" alt="Banner Image" class="img-fluid">
                                @else
                                    <h2 class="m-2">No Banner</h2>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!--Url-->
                        <div class="form-group">
                            <label for="ads_on_home_page_three_url" class="form-label fw-bold">URL</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="ads_on_home_page_three_url" name="ads_on_home_page_three[url]"
                                       placeholder="Enter Url Eg : http://www.ctrlf.com"
                                       value="{{ isset($adOnHomePageThree) && property_exists($adOnHomePageThree,'url') ? $adOnHomePageThree->url : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="show_home_ad_three" value="0">
                            <input class="form-check-input" type="checkbox" name="show_home_ad_three" value="1" id="flexCheckHomeAdThree" {{ $setting && $setting->show_home_ad_three ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheckHomeAdThree">
                                Show Ad
                            </label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer bg-white text-end">
                <button type="submit" class="btn btn-primary shadow-sm" id="save">Save</button>
            </div>
        </div>
        <!--Browse Page Section-->
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-header bg-white">
                <h5>Browse Page Ads</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!--Image-->
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <input type="hidden" name="ads_on_browse_page_one[image]" value="{{ isset($adOnBrowsePageOne) && property_exists($adOnBrowsePageOne,'image') ? $adOnBrowsePageOne->image : null }}">
                            <label for="formFileMultipleBrowseOne" class="form-label fw-bold">Upload Ad Image</label>
                            <input class="form-control" type="file" name="ads_on_browse_page_one[image]" id="formFileMultipleBrowseOne" accept="image/*">
                        </div>
                        <div class="d-flex align-items-center previewImg gap-3">
                            <div id="previewBrowseOne" class="preview-cover img-thumbnail mb-3" style="display: {{ $setting && isset($setting->header_banner_img) ? 'block' : 'none' }}">
                                @if(isset($adOnBrowsePageOne) && property_exists($adOnBrowsePageOne,'image') && !empty($adOnBrowsePageOne->image))
                                    <img src="{{ url($adOnBrowsePageOne->image) }}" alt="Banner Image" class="img-fluid">
                                @else
                                    <h2 class="m-2">No Banner</h2>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!--Url-->
                        <div class="form-group">
                            <label for="ads_on_browse_page_one_url" class="form-label fw-bold">URL</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="ads_on_browse_page_one_url" name="ads_on_browse_page_one[url]"
                                       placeholder="Enter Url Eg : http://www.ctrlf.com"
                                       value="{{ isset($adOnBrowsePageOne) && property_exists($adOnBrowsePageOne,'url') ? $adOnBrowsePageOne->url : null  }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="show_browse_ad_one" value="0">
                            <input class="form-check-input" type="checkbox" name="show_browse_ad_one" value="1" id="flexCheckBrowseAdOne" {{ $setting && $setting->show_browse_ad_one ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheckBrowseAdOne">
                                Show Ad
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
