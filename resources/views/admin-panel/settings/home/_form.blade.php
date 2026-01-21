<form id="homeSettingForm" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ isset($setting) ? $setting->id : null}}">
    <div class="px-3">
        <!--Header Section-->
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-header bg-white">
                <h5>Header Section</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <!--Heading-->
                        <div class="form-group">
                            <label for="header_heading" class="form-label fw-bold">Heading</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="header_heading" name="header_heading"
                                       placeholder="Enter Heading"
                                       value="{{ isset($setting) ? $setting->header_heading : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <!--Highlight Text-->
                        <div class="form-group">
                            <label for="header_highlight" class="form-label fw-bold">Highlight Text</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="header_highlight" name="header_highlight"
                                       placeholder="Enter Highlight Text"
                                       value="{{ isset($setting) ? $setting->header_highlight : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <!--Search Bar Heading-->
                        <div class="form-group">
                            <label for="search_bar_heading" class="form-label fw-bold">Search Bar Heading</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="search_bar_heading" name="search_bar_heading"
                                       placeholder="Enter Search Bar Text"
                                       value="{{ isset($setting) ? $setting->search_bar_heading : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <!--Search Bar Highlight Text-->
                        <div class="form-group">
                            <label for="search_bar_highlight" class="form-label fw-bold">Search Bar Highlight Text</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="search_bar_highlight" name="search_bar_highlight"
                                       placeholder="Enter Search Bar Highlight Text"
                                       value="{{ isset($setting) ? $setting->search_bar_highlight : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="formFileMultiple" class="form-label fw-bold">Upload Banner</label>
                            <input class="form-control" type="file" name="header_banner_img" id="formFileMultiple" accept="image/*">
                        </div>
                        <div class="d-flex align-items-center previewImg gap-3">
                            <div id="preview" class="preview-cover img-thumbnail mb-3" style="display: {{ $setting && isset($setting->header_banner_img) ? 'block' : 'none' }}">
                                @if($setting && !empty($setting->header_banner_img))
                                    <img src="{{ url($setting->header_banner_img) }}" alt="Banner Image" class="img-fluid">
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

        <!--Home Page Banner-->
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-header bg-white">
                <h5>Home Page Banner</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="formHomePageWebFile" class="form-label fw-bold">Upload Web View Banner</label>
                            <input class="form-control" type="file" name="homepage_banner_web" id="formHomePageWebFile" accept="image/*">
                        </div>
                        <div class="d-flex align-items-center previewImg gap-3">
                            <div id="previewHomePageWeb" class="preview-cover img-thumbnail mb-3" style="display: {{ $setting && isset($setting->homepage_banner_web) ? 'block' : 'none' }}">
                                @if($setting && !empty($setting->homepage_banner_web))
                                    <img src="{{ url($setting->homepage_banner_web) }}" alt="Image" class="img-fluid">
                                @else
                                    <h2 class="m-2">No Image</h2>
                                @endif
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="homepage_banner_web_link" class="form-label fw-bold">URL</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-globe text-secondary"></i></span>
                                <input type="text" class="form-control" id="homepage_banner_web_link" name="homepage_banner_web_link"
                                       placeholder="Enter URL Eg: https://www.controlf.in"
                                       value="{{ isset($setting) ? $setting->homepage_banner_web_link : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="homepage_banner_web_show" value="0">
                            <input class="form-check-input" type="checkbox" name="homepage_banner_web_show" value="1"  id="flexHomeWebBanner" {{ $setting && $setting->homepage_banner_web_show ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="flexHomeWebBanner">
                                Display Web Banner
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="formHomePageMobileFile" class="form-label fw-bold">Upload Mobile View Banner</label>
                            <input class="form-control" type="file" name="homepage_banner_mobile" id="formHomePageMobileFile" accept="image/*">
                        </div>
                        <div class="d-flex align-items-center previewImg gap-3">
                            <div id="previewHomePageMobile" class="preview-cover img-thumbnail mb-3" style="display: {{ $setting && isset($setting->homepage_banner_mobile) ? 'block' : 'none' }}">
                                @if($setting && !empty($setting->homepage_banner_mobile))
                                    <img src="{{ url($setting->homepage_banner_mobile) }}" alt="Image" class="img-fluid">
                                @else
                                    <h2 class="m-2">No Image</h2>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="homepage_banner_mobile_link" class="form-label fw-bold">URL</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-globe text-secondary"></i></span>
                                <input type="text" class="form-control" id="homepage_banner_mobile_link" name="homepage_banner_mobile_link"
                                       placeholder="Enter URL Eg: https://www.controlf.in"
                                       value="{{ isset($setting) ? $setting->homepage_banner_mobile_link : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="homepage_banner_mobile_show" value="0">
                            <input class="form-check-input" type="checkbox" name="homepage_banner_mobile_show" value="1"  id="flexHomeMobileBanner" {{ $setting && $setting->homepage_banner_mobile_show ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="flexHomeMobileBanner">
                                Display Mobile Banner
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Search By Location Section-->
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-header bg-white">
                <h5>Search By Location</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <!--Heading-->
                        <div class="form-group">
                            <label for="search_by_location_text" class="form-label fw-bold">Search Bar Below Text</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <textarea class="form-control" rows="5" name="search_by_location_text" id="search_by_location_text">{{ isset($setting) ? $setting->search_by_location_text : null }}</textarea>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
{{--                    <div class="col-lg-6">--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="formFileMultiple1" class="form-label fw-bold">Upload Image Right Side</label>--}}
{{--                            <input class="form-control" type="file" name="search_by_location_img" id="formFileMultiple1" accept="image/*">--}}
{{--                        </div>--}}
{{--                        <div class="d-flex align-items-center previewImg gap-3">--}}

{{--                            <div id="preview1" class="preview-cover img-thumbnail mb-3" style="display: {{ $setting && isset($setting->header_banner_img) ? 'block' : 'none' }}">--}}
{{--                                @if($setting && !empty($setting->search_by_location_img))--}}
{{--                                    <img src="{{ url($setting->search_by_location_img) }}" alt="Image" class="img-fluid">--}}
{{--                                @else--}}
{{--                                    <h2 class="m-2">No Image</h2>--}}
{{--                                @endif--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="formFileMultiple2" class="form-label fw-bold">Upload Background Image</label>
                            <input class="form-control" type="file" name="search_by_location_bg_img" id="formFileMultiple2" accept="image/*">
                        </div>
                        <div class="d-flex align-items-center previewImg gap-3">

                            <div id="preview2" class="preview-cover img-thumbnail mb-3" style="display: {{ $setting && isset($setting->header_banner_img) ? 'block' : 'none' }}">
                                @if($setting && !empty($setting->search_by_location_bg_img))
                                    <img src="{{ url($setting->search_by_location_bg_img) }}" alt="Image" class="img-fluid">
                                @else
                                    <h2 class="m-2">No Image</h2>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white text-end">
                <button type="submit" class="btn btn-primary shadow-sm">Save</button>
            </div>
        </div>

        <!--Featured Provider Section-->
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-header bg-white">
                <h5>Featured Providers</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <!--featured provider heading-->
                        <div class="form-group">
                            <label for="featured_provider_heading" class="form-label fw-bold">Heading</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="featured_provider_heading" name="featured_provider_heading"
                                       placeholder="Enter Heading"
                                       value="{{ isset($setting) ? $setting->featured_provider_heading : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <!--featured provider sub-heading-->
                        <div class="form-group">
                            <label for="featured_provider_subheading" class="form-label fw-bold">Sub Heading</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <textarea class="form-control" rows="5" name="featured_provider_subheading" id="featured_provider_subheading">{{ isset($setting) ? $setting->featured_provider_subheading : null }}</textarea>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        @php
                            $featuredProviders = json_decode($setting->featured_providers);
                        @endphp
                        <div class="form-group mb-3">
                            <label for="provider-1" class="form-label fw-bold">Provider 1</label>
                            <div>
                                <select class="form-control form-select" id="provider-1" name="featured_providers[]"
                                        placeholder="Select Category">
                                    <option value="">Choose Provider</option>
                                    @foreach($providers as $provider)
                                        <option {{ isset($featuredProviders) && $featuredProviders[0] == $provider->id ? 'selected' : ''  }} value="{{ $provider->id }}">{{ $provider->serviceproviderprofile->company_name }}  {{ $provider->name }} </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="provider-2" class="form-label fw-bold">Provider 2</label>
                            <div>
                                <select class="form-control form-select" id="provider-2" name="featured_providers[]"
                                        placeholder="Select Category">
                                    <option value="">Choose Provider</option>
                                    @foreach($providers as $provider)
                                        <option {{ isset($featuredProviders) && $featuredProviders[1] == $provider->id ? 'selected' : ''  }} value="{{ $provider->id }}">{{ $provider->serviceproviderprofile->company_name }}  {{ $provider->name }} </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="provider-3" class="form-label fw-bold">Provider 3</label>
                            <div>
                                <select class="form-control form-select" id="provider-3" name="featured_providers[]"
                                        placeholder="Select Category">
                                    <option value="">Choose Provider</option>
                                    @foreach($providers as $provider)
                                        <option {{ isset($featuredProviders) && $featuredProviders[2] == $provider->id ? 'selected' : ''  }} value="{{ $provider->id }}">{{ $provider->serviceproviderprofile->company_name }}  {{ $provider->name }} </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="provider-4" class="form-label fw-bold">Provider 4</label>
                            <div>
                                <select class="form-control form-select" id="provider-4" name="featured_providers[]"
                                        placeholder="Select Category">
                                    <option value="">Choose Provider</option>
                                    @foreach($providers as $provider)
                                        <option {{ isset($featuredProviders) && $featuredProviders[3] == $provider->id ? 'selected' : ''  }} value="{{ $provider->id }}">{{ $provider->serviceproviderprofile->company_name }}  {{ $provider->name }} </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white text-end">
                <button type="submit" class="btn btn-primary shadow-sm">Save</button>
            </div>
        </div>

        <!--Analytics Section-->
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-header bg-white">
                <h5>Analytics</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <!--Enable/Disable Analytics-->
                        <div class="form-check">
                            <input type="hidden" name="show_analytics" value="0">
                            <input class="form-check-input" type="checkbox" name="show_analytics" value="1" id="flexCheckDefault" {{ isset($setting) && $setting->show_analytics ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="flexCheckDefault">
                                Show Analytics
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-6">

                        <!--analytics heading-->
                        <div class="form-group">
                            <label for="analytics_heading" class="form-label fw-bold">Heading</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="analytics_heading" name="analytics_heading"
                                       placeholder="Enter Heading"
                                       value="{{ isset($setting) ? $setting->analytics_heading : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <!--featured provider sub-heading-->
                        <div class="form-group">
                            <label for="analytics_subheading" class="form-label fw-bold">Sub Heading</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <textarea class="form-control" rows="5" name="analytics_subheading" id="analytics_subheading">{{ isset($setting) ? $setting->analytics_subheading : null }}</textarea>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!--total listing-->
                        <div class="form-group">
                            <label for="analytics_total_listing" class="form-label fw-bold">Total Listing</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="analytics_total_listing" name="analytics_total_listing"
                                       placeholder="Enter Total Listing"
                                       value="{{ isset($setting) ? $setting->analytics_total_listing : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <!--search traffic-->
                        <div class="form-group">
                            <label for="analytics_search_traffic" class="form-label fw-bold">Search Traffic</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="analytics_search_traffic" name="analytics_search_traffic"
                                       placeholder="Enter Search Traffic"
                                       value="{{ isset($setting) ? $setting->analytics_search_traffic : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <!--online impression-->
                        <div class="form-group">
                            <label for="analytics_online_impression" class="form-label fw-bold">Online Impression</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="analytics_online_impression" name="analytics_online_impression"
                                       placeholder="Enter Online Impression"
                                       value="{{ isset($setting) ? $setting->analytics_online_impression : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <!--organic traffic-->
                        <div class="form-group">
                            <label for="analytics_organic_traffic" class="form-label fw-bold">Organic Traffic</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="analytics_organic_traffic" name="analytics_organic_traffic"
                                       placeholder="Enter Organic Traffic"
                                       value="{{ isset($setting) ? $setting->analytics_organic_traffic : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white text-end">
                <button type="submit" class="btn btn-primary shadow-sm">Save</button>
            </div>
        </div>

    </div>
</form>
