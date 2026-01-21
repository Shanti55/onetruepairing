
<div class="modal fade" id="jobPostModal" aria-hidden="true">
    <div class="modal-dialog modal-lg my-5">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modelHeading"></h6>
            </div>
            <form id="jobPostForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="form-group mb-3">
                        <label for="posted_by" class="form-label required"> Posted By</label>
                        <div class="col-lg-12">
                            <select class="form-control form-select" id="posted_by" name="posted_by"
                                    placeholder="Choose Posted By" required>
                                <option value="">--Choose Posted By--</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="title" class="form-label required">Job Title</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title"
                                   placeholder="Enter Title"
                                   value="" required>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="location" class="form-label required">Location</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="location" name="location"
                                   placeholder="Enter Location"
                                   value="" required>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>

                    <x-pincode-lookup :profile="$profile=null" size="12" weight="normal" icon="0"/>

                    <div class="form-group mb-3">
                        <label for="categories" class="form-label required"> Job Category</label>
                        <div class="col-lg-12">
                            <select class="form-control form-select" id="categories" name="categories[]"
                                    placeholder="Choose Category" multiple required>
                                <option value="">--Choose Category--</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="cost" class="form-label">Approx Budget(Rs.)</label>
                        <div class="col-sm-12">
                            <input type="number" step="any" min="0" class="form-control" id="cost" name="cost"
                                   placeholder="Enter Cost Eg : 50000"
                                   value="0">
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>

                   <div class="row">
                       <div class="form-group col-sm-6 mb-3">
                           <label for="duration_type" class="form-label"> Duration Type</label>
                           <div class="">
                               <select class="form-control form-select" id="duration_type" name="duration_type"
                                       placeholder="Choose Duration Type">
                                   <option value="hours">Hours</option>
                                   <option value="days">Days</option>
                                   <option value="months">Months</option>
                               </select>
                               <div class="invalid-feedback">Invalid feedback</div>
                           </div>
                       </div>

                       <div class="form-group col-sm-6 mb-3">
                           <label for="duration_value" class="form-label">Duration Value</label>
                           <div class="">
                               <input type="number" step="any" class="form-control" id="duration_value" name="duration_value"
                                      placeholder="Enter Duration Eg : 5"
                                      value="">
                               <div class="invalid-feedback">Invalid feedback</div>
                           </div>
                       </div>
                   </div>

                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Description</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <div>
                                <select class="form-control form-select" id="status" name="status"
                                        placeholder="Choose Status">
                                    @foreach(\App\Enums\JobStatus::cases() as $status)
                                        <option value="{{ $status->value }}">{{ $status->name }}</option>
                                    @endforeach

                                </select>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                        <div class="form-group col-sm-4 mb-3">
                            <label for="assigned_to" class="form-label">Assigned To</label>
                            <div>
                                <select class="form-control form-select" id="assigned_to" name="assigned_to"
                                        placeholder="Choose Assigned TO">
                                    <option value="">None</option>
                                    @foreach($serviceProviders as $provider)
                                        <option value="{{ $provider->id }}">{{ $provider->serviceproviderprofile->company_name ?? $provider->name }}</option>
                                    @endforeach

                                </select>
                                <div class="invalid-feedback">Invalid feedback</div>
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
