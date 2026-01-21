
<div class="modal fade" id="advertisementModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modelHeading"></h6>
            </div>
            <form id="advertisementForm" class="form-horizontal" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group previewImg mb-3">
                        <label for="formUploadAd" class="form-label">Upload Ads</label>
                        <input class="form-control" type="file" name="ad_url" id="formUploadAd" accept="image/*">
                        <div id="previewAd" class="preview mt-2"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="display_on_page" class="form-label">Choose Page</label>
                        <div>
                            <select class="form-control form-select" id="display-on-page" name="display_on_page"
                                    placeholder="Select Page">
                                <option value="Home Page">Home Page</option>
                                <option value="Service Listing">Service Listing Page</option>
                                <option value="Job Listing">Job Listing Page</option>
                            </select>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="startDate" name="start_date">
                        </div>
                        <div class="col-md-6">
                            <label for="endDate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="endDate" name="end_date">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                    <label for="link" class="form-label">Link [ Set url to redirect any website etc ]</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="link" name="link"
                               placeholder="Enter Link eg: www.controlf.com"
                               value="">
                        <div class="invalid-feedback">Invalid feedback</div>
                    </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                        <div class="invalid-feedback">Invalid feedback</div>
                    </div>

                    <div class="form-check">
                        <input type="hidden" name="is_enabled" value="0">
                        <input class="form-check-input" type="checkbox" name="is_enabled" value="1" id="flexCheckAds">
                        <label class="form-check-label" for="flexCheckAds">
                            Show Ads
                        </label>
                    </div>

                </div>

                <div class="modal-footer bg-light d-flex justify-content-end py-1">
                    <button type="submit" class="btn btn-primary shadow-sm" id="save">Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
