<div class="modal fade" id="adminModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modelHeading"></h6>
            </div>
            <form id="adminForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Enter Name"
                                   value="">
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="col-sm-12">
                            <input type="pass" class="form-control" id="email" name="email"
                                   placeholder="name@example.com"
                                   value="">
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="primary_mobile_number" class="form-label">Phone No.</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="primary_mobile_number" name="primary_mobile_number"
                                   placeholder="Enter Phone No."
                                   value="">
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control"/>
                                <div class="input-group-append">
                                    <button
                                        type="button"
                                        class="btn btn-lg rounded-0 rounded-end-4 m-0"
                                        style="border-color: #dee2e6;"
                                        id="togglePassword"
                                        tabindex="-1">
                                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"/>
                                <div class="input-group-append">
                                    <button
                                        type="button"
                                        class="btn btn-lg rounded-0 rounded-end-4 m-0"
                                        style="border-color: #dee2e6;"
                                        id="togglePassword2"
                                        tabindex="-1">
                                        <i class="bi bi-eye-slash" id="toggleIcon2"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">Invalid feedback</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="role_id" class="form-label">Roles & Permissions</label>
                        <div class="col-sm-12">
                            <select class="form-control form-select" id="role_id" name="role_id"
                                     placeholder="Select Roles">
                                <option value="">Select Roles</option>
                                @foreach(\App\Models\RolesPermission::all() as $roles)
                                    <option value="{{$roles->id}}"> {{$roles->name }}</option>
                                @endforeach
                            </select>
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
