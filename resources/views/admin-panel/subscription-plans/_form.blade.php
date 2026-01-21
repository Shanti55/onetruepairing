
<div class="modal fade" id="subscriptionPlanModal" aria-hidden="true">
    <div class="modal-dialog modal-lg my-5">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modelHeading"></h6>
            </div>
            <form id="subscriptionPlanForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="Enter Name"
                                       value="">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="plan_id" class="form-label">Plan Code</label>
                                <input type="text" class="form-control" id="plan_id" name="plan_id"
                                       placeholder="Enter Subscription Plan Code"
                                       value="">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="price" class="form-label">Monthly Price(Rs.)</label>
                                <input type="number" step="any" min="0" class="form-control" id="price" name="price"
                                       placeholder="Enter Price Eg : 5000"
                                       value="">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="yearly_price" class="form-label">Yearly Price(Rs.)</label>
                                <input type="number" step="any" min="0" class="form-control" id="yearly_price" name="yearly_price"
                                       placeholder="Enter Yearly Price Eg : 14999"
                                       value="">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        {{--                    <div class="col-lg-6">--}}
                        {{--                        <div class="form-group mb-3">--}}
                        {{--                            <label for="billing_cycle" class="form-label">Billing Cycle</label>--}}
                        {{--                            <div>--}}
                        {{--                                <select class="form-control form-select" id="billing_cycle" name="billing_cycle"--}}
                        {{--                                        placeholder="Choose Billing Cycle">--}}
                        {{--                                    <option value="monthly">Monthly</option>--}}
                        {{--                                    <option value="annually">Annually</option>--}}
                        {{--                                </select>--}}
                        {{--                                <div class="invalid-feedback">Invalid feedback</div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}

                        <div class="col-lg-6">
                            <div class="d-flex flex-column">
                                <h6>Features</h6>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="contact_display" name="features[]" value="contact_display">
                                    <label class="form-check-label" for="contact_display">Contact Display</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="whatsapp_display" name="features[]" value="whatsapp_display">
                                    <label class="form-check-label" for="whatsapp_display">Whatsapp Display</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="image_gallery" name="features[]" value="image_gallery">
                                    <label class="form-check-label" for="image_gallery">Image Gallery</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="video" name="features[]" value="video">
                                    <label class="form-check-label" for="video">Video</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="location" name="features[]" value="location">
                                    <label class="form-check-label" for="video">Location</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="map_display" name="features[]" value="map_display">
                                    <label class="form-check-label" for="map_display">Map Display</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <h6>Additional Features</h6>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="city_leads" name="features[]" value="city_leads">
                                    <label class="form-check-label" for="city_leads">Only City based Leads</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="regional_leads" name="features[]" value="regional_leads">
                                    <label class="form-check-label" for="regional_leads">Regional leads</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="pan_india_leads" name="features[]" value="pan_india_leads">
                                    <label class="form-check-label" for="pan_india_leads">PAN India leads</label>
                                </div>


                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="lead_form" name="features[]" value="lead_form">
                                <label class="form-check-label" for="lead_form">Lead Form</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="micro_website" name="features[]" value="micro_website">
                                <label class="form-check-label" for="micro_website">Micro Website</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="website_ad_banners" name="features[]" value="website_ad_banners">
                                <label class="form-check-label" for="website_ad_banners">Website Ad Banner</label>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status</label>
                                <div>
                                    <select class="form-control form-select" id="status" name="status"
                                            placeholder="Choose Status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <div class="invalid-feedback">Invalid feedback</div>
                                </div>
                            </div>
                        </div>

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
