
<div class="modal fade" id="progressModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modelHeading"></h6>
            </div>
            <form id="progressForm" class="form-horizontal" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="job_post_id" value="{{ $job->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <div class="form-group mb-3">
                        <label for="date" class="form-label">Date</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="date" name="date"
                                   placeholder="Choose Date"
                                   value="">
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="progress_value" class="form-label">Completion Percent(%)</label>
                        <div class="col-sm-12">
                            <input type="number" step="any" class="form-control" id="progress_value" name="progress_value"
                                   placeholder="Enter Completion Percent(%)"
                                   value="">
                            <div class="invalid-feedback">Invalid feedback</div>
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


