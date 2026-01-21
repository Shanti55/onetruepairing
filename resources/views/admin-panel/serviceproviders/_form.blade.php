<div class="modal fade" id="serviceProviderModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modelHeading"></h6>
            </div>
            <form id="serviceProviderForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    @if(auth()->user()->is_master)
                    <div class="form-group mb-3">
                        <label for="referred_by" class="form-label">Referred By</label>
                        <div>
                            <select class="form-control form-select" id="referred_by" name="referred_by"
                                    placeholder="Select Referred By">
                                <option value="">None</option>
                                @foreach(\App\Models\User::where('role','admin')->whereNotIn('is_master',[1])->get() as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Invalid feedback</div>
                        </div>
                    </div>
                    <hr>
                    @else
                        <input type="hidden" name="referred_by" value="{{ auth()->user()->id }}" id="referred_by">
                    @endif

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

                </div>

                <div class="modal-footer bg-light d-flex justify-content-end py-1">
                    <button type="submit" class="btn btn-primary shadow-sm" id="save">Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
