<form id="customerAgreementSettingForm" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ isset($setting) ? $setting->id : null}}">
    <div class="px-3">
        <!--Header Section-->
        <div class="card mt-3 border-0 pb-2 p-3">
            <div class="card-header bg-white">
                <h5>Customer Agreement</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <!--featured provider heading-->
                        <div class="form-group">
                            <label for="customer_agreement_heading" class="form-label fw-bold">Heading</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="customer_agreement_heading" name="customer_agreement_heading"
                                       placeholder="Enter Heading"
                                       value="{{ isset($setting) ? $setting->customer_agreement_heading : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!--featured provider sub-heading-->
                        <div class="form-group">
                            <label for="customer_agreement_subheading" class="form-label fw-bold">Sub Heading</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-fonts text-secondary"></i></span>
                                <input type="text" class="form-control" id="customer_agreement_subheading" name="customer_agreement_subheading"
                                       placeholder="Enter Sub-Heading"
                                       value="{{ isset($setting) ? $setting->customer_agreement_subheading : null }}">
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!--Heading-->
                        <div class="form-group">
                            <label for="customer_agreement_content" class="form-label fw-bold">Content</label>
                            <!-- Quill Editor -->
                            <div id="editor">{!! $setting->customer_agreement_content !!}</div>
                            <!-- Hidden textarea to store the content -->
                            <textarea id="editor-content" name="customer_agreement_content" style="display: none;"></textarea>
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
