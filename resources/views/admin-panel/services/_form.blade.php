
<div class="modal fade" id="serviceModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modelHeading"></h6>
            </div>
            <form id="serviceForm" class="form-horizontal" enctype="multipart/form-data">
                <div class="modal-body">

                    <input type="hidden" name="id" id="id">
                    <div class="form-group mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <div>
                            <select class="form-control form-select" id="description" name="category_id"
                                    placeholder="Select Category">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Enter Name"
                                   value="">
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>

{{--                    <div class="form-group mb-3">--}}
{{--                        <label for="name" class="form-label">Code</label>--}}
{{--                        <div class="col-sm-12">--}}
{{--                            <input type="text" class="form-control" id="code" name="code"--}}
{{--                                   placeholder="Enter Service Code"--}}
{{--                                   value="">--}}
{{--                            <div class="invalid-feedback">Invalid feedback</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="card border-0 bg-body-tertiary shadow-sm">
                        <div class="card-body previewImg">
                            <div class="mb-3">
                                <label for="formFileMultiple" class="form-label">Upload Images</label>
                                <input class="form-control" type="file" name="images[]" id="formFileMultiple" multiple accept="image/*">
                            </div>
                            <div id="preview" class="preview"></div>
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
