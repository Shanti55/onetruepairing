
<div class="modal fade" id="stateModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modelHeading"></h6>
            </div>
            <form id="stateForm" class="form-horizontal" enctype="multipart/form-data">
                <div class="modal-body">

                    <input type="hidden" name="id" id="id">
                    <div class="form-group mb-3">
                        <label for="category_id" class="form-label">State</label>
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="Enter Name"
                               value="" required>
                    </div>

                    <div class="form-group previewImg mb-33">
                        <label for="formFileImage" class="form-label">Upload Image</label>
                        <input class="form-control" type="file" name="image" id="formFileImage" accept="image/*">
                        <div id="previewImage" class="preview mt-2"></div>
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
