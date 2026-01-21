<div class="modal fade" id="rolesPermissionsModal" aria-hidden="true">
    <div class="modal-dialog modal-lg my-5">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modelHeading"></h6>
            </div>
            <form id="rolesPermissionsForm" class="form-horizontal">
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

                        <div class="col-lg-12">
                        <div class="mt-3 w-auto overflow-auto">
                            <div class="tab-content pt-2" id="tab-content">
                                <div class="tab-pane active" id="fill-tabpanel-0" role="tabpanel" aria-labelledby="fill-tab-0">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <td>Resource</td>
                                            <td>Create</td>
                                            <td>Edit</td>
                                            <td>Delete</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {{--  Enquiry  --}}
                                        <tr>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="enquiry" id="enquiry" name="module_access[]">
                                                    <label class="form-check-label" for="enquiry">Enquiry</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="enquiry_create" id="enquiry_create" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="enquiry_edit" id="enquiry_edit" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="enquiry_delete" id="enquiry_delete" name="permissions[]">
                                                </div>
                                            </td>
                                        </tr>
                                        {{--  Enquiry  --}}
                                        {{-- Jobs --}}
                                        <tr>
                                            <td class="border-bottom-0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="jobs" id="jobs" name="module_access[]">
                                                    <label class="form-check-label" for="jobs">Jobs</label>
                                                </div>
                                            </td>
                                            <td class="border-bottom-0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="jobs_create" id="jobs_create" name="permissions[]">
                                                </div>
                                            </td>
                                            <td class="border-bottom-0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="jobs_edit" id="jobs_edit" name="permissions[]">
                                                </div>
                                            </td>
                                            <td class="border-bottom-0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="jobs_delete" id="jobs_delete" name="permissions[]">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="100%" class="text-center">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr>
                                                        <td class="border-bottom-0">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" value="jobs_status" id="jobs_status" name="permissions[]">
                                                                <label class="form-check-label" for="jobs_status">Can Update Status</label>
                                                            </div>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" value="jobs_assigned_to" id="jobs_assigned_to" name="permissions[]">
                                                                <label class="form-check-label" for="jobs_assigned_to">Can Update Assigned To</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        {{--  Jobs  --}}
                                        {{-- Admins --}}
                                        <tr>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="admins" id="admins" name="module_access[]">
                                                    <label class="form-check-label" for="admins">Admins</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="admins_create" id="admins_create" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="admins_edit" id="admins_edit" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="admins_delete" id="admins_delete" name="permissions[]">
                                                </div>
                                            </td>
                                        </tr>
                                        {{--  Admins  --}}
                                        {{-- Users --}}
                                        <tr>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="users" id="users" name="module_access[]">
                                                    <label class="form-check-label" for="users">Users</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="users_create" id="users_create" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="users_edit" id="users_edit" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="users_delete" id="users_delete" name="permissions[]">
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- Users  --}}
                                        {{-- Service Providers --}}
                                        <tr>
                                            <td class="border-bottom-0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" value="service_providers" id="service_providers" name="module_access[]">
                                                        <label class="form-check-label" for="service_providers">Service Providers</label>
                                                    </div>
                                            </td>
                                            <td class="border-bottom-0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="service_providers_create" id="service_providers_create" name="permissions[]">
                                                </div>
                                            </td>
                                            <td class="border-bottom-0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="service_providers_edit" id="service_providers_edit" name="permissions[]">
                                                </div>
                                            </td>
                                            <td class="border-bottom-0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="service_providers_delete" id="service_providers_delete" name="permissions[]">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="100%" class="text-center">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr>
                                                        <td class="border-bottom-0">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" value="service_providers_import" id="service_providers_import" name="permissions[]">
                                                                <label class="form-check-label" for="service_providers_import">Can Import</label>
                                                            </div>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" value="service_providers_export" id="service_providers_export" name="permissions[]">
                                                                <label class="form-check-label" for="service_providers_export">Can Export</label>
                                                            </div>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" value="service_providers_offline_verification" id="service_providers_offline_verification" name="permissions[]">
                                                                <label class="form-check-label" for="service_providers_offline_verification">Can Update Offline Verification</label>
                                                            </div>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" value="service_providers_status" id="service_providers_status" name="permissions[]">
                                                                <label class="form-check-label" for="service_providers_status">Can Update Status</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        {{--  Service Providers  --}}
                                        {{-- Categories --}}
                                        <tr>
                                            <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" value="categories" id="categories" name="module_access[]">
                                                        <label class="form-check-label" for="categories">Categories</label>
                                                    </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="categories_create" id="categories_create" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="categories_edit" id="categories_edit" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="categories_delete" id="categories_delete" name="permissions[]">
                                                </div>
                                            </td>
                                        </tr>
                                        {{--  Categories  --}}
                                        {{-- Services --}}
                                        <tr>
                                            <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" value="services" id="services" name="module_access[]">
                                                        <label class="form-check-label" for="services">Services</label>
                                                    </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="services_create" id="services_create" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="services_edit" id="services_edit" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="services_delete" id="services_delete" name="permissions[]">
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- services --}}
                                        {{-- Blogs --}}
                                        <tr>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="blogs" id="blogs" name="module_access[]">
                                                    <label class="form-check-label" for="blogs">Blogs</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="blogs_create" id="blogs_create" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="blogs_edit" id="blogs_edit" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="blogs_delete" id="blogs_delete" name="permissions[]">
                                                </div>
                                            </td>
                                        </tr>
                                        {{--  Blogs  --}}
                                        {{-- Subscription Plan --}}
                                        <tr>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="subscription_plan" id="subscription_plan" name="module_access[]">
                                                    <label class="form-check-label" for="subscription_plan">Subscription Plan</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="subscription_plan_create" id="subscription_plan_create" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="subscription_plan_edit" id="subscription_plan_edit" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="subscription_plan_delete" id="subscription_plan_delete" name="permissions[]">
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- Subscription Plan --}}

                                        {{-- Roles Permissions--}}
                                        <tr>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="roles_permissions" id="roles_permissions" name="module_access[]">
                                                    <label class="form-check-label" for="roles_permissions">Roles & Permissions</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="roles_permissions_create" id="roles_permissions_create" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="roles_permissions_edit" id="roles_permissions_edit" name="permissions[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="roles_permissions_delete" id="roles_permissions_delete" name="permissions[]">
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- Roles Permissions --}}

                                        {{-- Reports --}}
                                        <tr>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="reports" id="reports" name="module_access[]">
                                                    <label class="form-check-label" for="reports">Reports</label>
                                                </div>
                                            </td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>-- </td>
                                        </tr>
                                        {{-- Reports --}}

                                        {{-- Billing--}}
                                        <tr>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="billing" id="billing" name="module_access[]">
                                                    <label class="form-check-label" for="billing">Billing</label>
                                                </div>
                                            </td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        </tr>
                                        {{-- Billing --}}

                                        {{-- Settings--}}
                                        <tr>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" value="settings" id="settings" name="module_access[]">
                                                    <label class="form-check-label" for="billing">Settings</label>
                                                </div>
                                            </td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        </tr>
                                        {{-- Billing --}}

                                        </tbody>
                                    </table>
                                </div>
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
