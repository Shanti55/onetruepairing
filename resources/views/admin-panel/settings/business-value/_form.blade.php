
<div class="modal fade" id="businessValuesModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modelHeading"></h6>
            </div>
            <form id="businessValuesForm" class="form-horizontal" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="form-group mb-3">
                        <label for="icons" class="form-label">Choose Icon</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="icon" name="icon"
                                   placeholder="Enter icons"
                                   value="bi-emoji-smile">
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                        <div class="mt-2 text-muted">
                            🔍 To select an icon, visit
                            <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a>,<br>
                            click on any icon , and copy <b>only the class name</b> <br>
                            after the space — like <b><code>bi-9-circle</code></b>.
                        </div>
                    </div>

                    <div class="form-group mb-3">
                            <label for="title" class="form-label">Title</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="title" name="title"
                                           placeholder="Enter Title"
                                           value="">
                                    <div class="invalid-feedback">Invalid feedback</div>
                                </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                        <div class="invalid-feedback">Invalid feedback</div>
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
