<div class="modal fade" id="serviceProviderImportModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Import Service Provider</h6>
            </div>
            <form  action="{{ route('serviceproviders.import') }}" method="POST" enctype="multipart/form-data" id="import_service_provider_form" class="form-horizontal">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="import" class="form-label">Select File</label>
                            <div class="input-group">
                                <input type="file" name="file"
                                       class="form-control">
                                <span class="error invalid-feedback"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label><a download="service-providers-sample.xlsx" href="{{ asset('import-samples/service-provider-sample-format.xlsx') }}"><i class="fas fa-download mr-1"></i> Download Sample File</a></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light d-flex justify-content-end py-1">
                    <button type="submit" class="btn btn-primary shadow-sm" id="import">Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
