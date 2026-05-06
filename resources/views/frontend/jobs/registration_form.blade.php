@extends('frontend.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white py-3 text-center">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Auction Registration</h5>
                </div>

                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold text-dark">{{ $job->title }}</h4>
                        <p class="text-muted small">Job ID: EL#{{ str_pad($job->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>

                    {{-- Fee Calculation Table --}}
                    <div class="registration-details mb-4">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="text-secondary">Project Cost:</td>
                                        <td class="text-end fw-bold">₹{{ number_format($job->cost, 2) }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="text-secondary pt-2">EMD Charge — 10% of Project Cost (Refundable*):</td>
                                        <td class="text-end fw-bold text-info pt-2">₹{{ number_format($emd, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-secondary">Platform Fee — 1% of EMD (Non-Refundable):</td>
                                        <td class="text-end fw-bold text-danger">₹{{ number_format($platform_fee, 2) }}</td>
                                    </tr>
                                    <tr class="border-top bg-light">
                                        <td class="h5 fw-bold py-2">Total Payable Amount:</td>
                                        <td class="h5 fw-bold text-primary text-end py-2">₹{{ number_format($total, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center mt-2">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#policyModal"
                               class="text-decoration-none small fw-bold">
                                <i class="bi bi-info-circle-fill me-1"></i> View Refund Policy & Fee Details
                            </a>
                        </div>
                    </div>

                    {{-- Vendor Details Form --}}
                    <div class="card border-0 bg-light rounded-3 p-3 mb-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="bi bi-person-lines-fill me-2 text-primary"></i>Vendor Details
                        </h6>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" id="vendor_name" class="form-control border-2"
                                   placeholder="Enter your full name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" id="vendor_email" class="form-control border-2"
                                   placeholder="Enter your email address" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Phone Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">+91</span>
                                <input type="tel" id="vendor_phone" class="form-control border-2"
                                       placeholder="10-digit mobile number" maxlength="10" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">
                                Business Name <span class="text-muted fw-normal">(Optional)</span>
                            </label>
                            <input type="text" id="vendor_business" class="form-control border-2"
                                   placeholder="Your company / business name">
                        </div>

                        <div class="mb-0">
                            <label class="form-label small fw-bold">
                                Additional Details <span class="text-muted fw-normal">(Optional)</span>
                            </label>
                            <textarea id="vendor_details" class="form-control border-2" rows="3"
                                      placeholder="Any additional information"></textarea>
                        </div>
                    </div>

                    {{-- QR Code Section --}}
                    <div class="text-center my-4 p-3 border rounded bg-light shadow-sm">
                        <h6 class="fw-bold mb-3 text-uppercase small text-muted">Scan & Pay via UPI</h6>

                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=upi://pay?pa=YOUR_UPI_ID@okaxis%26am={{ $total }}%26tn=Registration_EL-{{ str_pad($job->id, 5, '0', STR_PAD_LEFT) }}"
                             alt="UPI QR Code"
                             class="img-fluid mb-3 shadow-sm"
                             style="max-width: 180px; border: 4px solid #fff; border-radius: 10px;">

                        <div class="mt-2">
                            <p class="mb-0 small text-muted">Please pay exactly:</p>
                            <h4 class="text-success fw-bold">₹{{ number_format($total, 2) }}</h4>
                        </div>
                    </div>

                    {{-- Transaction Input --}}
                    <div class="mb-4">
                        <label for="transaction_id" class="form-label small fw-bold text-dark">
                            Transaction ID / UTR Number <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="transaction_id"
                               name="transaction_id"
                               class="form-control form-control-lg border-2"
                               placeholder="Enter 12-digit UTR number"
                               required>
                        <div class="form-text text-danger small mt-2">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            Warning: Submitting an incorrect Transaction ID will result in rejection of your registration.
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="button" id="submit-registration-btn"
                                class="btn btn-success btn-lg shadow-sm py-3 fw-bold">
                            <span id="btn-text" class="text-uppercase">Submit Registration</span>
                            <span id="btn-loader" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </div>

                <div class="card-footer bg-light text-center py-3">
                    <a href="{{ route('frontend.jobs.index') }}" class="text-decoration-none text-muted small">
                        <i class="bi bi-chevron-left me-1"></i> Back to Jobs List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Refund Policy & Fee Details Modal --}}
<div class="modal fade" id="policyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title text-light">Refund Policy & Fee Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">

                {{-- EMD & Platform Fee Info --}}
                <h6 class="fw-bold text-primary mb-3">
                    <i class=""></i> EMD & Platform Fee Structure
                </h6>
                <div class="table-responsive mb-2">
                    <table class="table table-bordered table-sm small">
                        <thead class="table-light">
                            <tr>
                                <th>Project Value</th>
                                <th class="text-end">EMD (10%)</th>
                                <th class="text-end">Platform Fee (1% of EMD)</th>
                                <th class="text-end">Total Payable</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>₹10,000</td>      <td class="text-end text-info fw-bold">₹1,000</td>     <td class="text-end text-danger">₹10</td>     <td class="text-end fw-bold text-primary">₹1,010</td></tr>
                            <tr><td>₹25,000</td>      <td class="text-end text-info fw-bold">₹2,500</td>     <td class="text-end text-danger">₹25</td>     <td class="text-end fw-bold text-primary">₹2,525</td></tr>
                            <tr><td>₹50,000</td>      <td class="text-end text-info fw-bold">₹5,000</td>     <td class="text-end text-danger">₹50</td>     <td class="text-end fw-bold text-primary">₹5,050</td></tr>
                            <tr><td>₹75,000</td>      <td class="text-end text-info fw-bold">₹7,500</td>     <td class="text-end text-danger">₹75</td>     <td class="text-end fw-bold text-primary">₹7,575</td></tr>
                            <tr><td>₹1,00,000</td>    <td class="text-end text-info fw-bold">₹10,000</td>    <td class="text-end text-danger">₹100</td>    <td class="text-end fw-bold text-primary">₹10,100</td></tr>
                            <tr><td>₹2,00,000</td>    <td class="text-end text-info fw-bold">₹20,000</td>    <td class="text-end text-danger">₹200</td>    <td class="text-end fw-bold text-primary">₹20,200</td></tr>
                            <tr><td>₹3,00,000</td>    <td class="text-end text-info fw-bold">₹30,000</td>    <td class="text-end text-danger">₹300</td>    <td class="text-end fw-bold text-primary">₹30,300</td></tr>
                            <tr><td>₹5,00,000</td>    <td class="text-end text-info fw-bold">₹50,000</td>    <td class="text-end text-danger">₹500</td>    <td class="text-end fw-bold text-primary">₹50,500</td></tr>
                            <tr><td>₹7,50,000</td>    <td class="text-end text-info fw-bold">₹75,000</td>    <td class="text-end text-danger">₹750</td>    <td class="text-end fw-bold text-primary">₹75,750</td></tr>
                            <tr><td>₹10,00,000</td>   <td class="text-end text-info fw-bold">₹1,00,000</td>  <td class="text-end text-danger">₹1,000</td>  <td class="text-end fw-bold text-primary">₹1,01,000</td></tr>
                            <tr><td>₹25,00,000</td>   <td class="text-end text-info fw-bold">₹2,50,000</td>  <td class="text-end text-danger">₹2,500</td>  <td class="text-end fw-bold text-primary">₹2,52,500</td></tr>
                            <tr><td>₹50,00,000</td>   <td class="text-end text-info fw-bold">₹5,00,000</td>  <td class="text-end text-danger">₹5,000</td>  <td class="text-end fw-bold text-primary">₹5,05,000</td></tr>
                            <tr><td>₹1,00,00,000</td> <td class="text-end text-info fw-bold">₹10,00,000</td> <td class="text-end text-danger">₹10,000</td> <td class="text-end fw-bold text-primary">₹10,10,000</td></tr>
                        </tbody>
                    </table>
                </div>
                <p class="text-muted small mb-4">
                    <i class="bi bi-info-circle me-1"></i>
                    EMD = <strong>10% of project value</strong> (refundable in most cases).
                    Platform Fee = <strong>1% of EMD</strong> (strictly non-refundable).
                </p>

                {{-- Refund Policy --}}
                <h6 class="fw-bold text-danger mb-3">
                    <i class="bi bi-shield-check me-1"></i> Refund Policy
                </h6>

                
                    <div class="fs-5"></div>
                    <div>
                        <p class="mb-1 fw-bold small text-success">Full Refund — Bid Unsuccessful</p>
                        <p class="mb-0 small text-muted">If you participate in the auction but do not win the job, your entire EMD will be refunded within 7 working days of auction closure. No deductions.</p>
                    </div>
              

               
                    <div class="fs-5"></div>
                    <div>
                        <p class="mb-1 fw-bold small text-warning">EMD Adjusted — Winner, Job Completed</p>
                        <p class="mb-0 small text-muted">If you win the auction and successfully complete the job, the EMD will be adjusted against your final payment settlement. Only the platform fee is non-refundable.</p>
                    </div>
             

               
                    <div class="fs-5"></div>
                    <div>
                        <p class="mb-1 fw-bold small text-danger">No Refund — Winner but Job Abandoned</p>
                        <p class="mb-0 small text-muted">If you win the auction but fail to commence or complete the job without a valid reason, your EMD will be forfeited. This protects clients from last-minute dropouts.</p>
                    </div>
            

       
                    <div class="fs-5"></div>
                    <div>
                        <p class="mb-1 fw-bold small text-danger">No Refund — Registration Withdrawn After Auction Goes Live</p>
                        <p class="mb-0 small text-muted">Once the auction is live, withdrawing your registration will result in forfeiture of the EMD. Please register only if you genuinely intend to bid.</p>
                    </div>
             

                <p class="text-muted small mt-3 mb-0">
                    <i class="bi bi-clock me-1"></i>
                    Refunds are processed to the original payment source within 5–7 working days after verification.
                    For disputes, contact support within 48 hours of auction closure.
                </p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-sm px-4" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#submit-registration-btn').on('click', function (e) {
        e.preventDefault();

        let name     = $('#vendor_name').val().trim();
        let email    = $('#vendor_email').val().trim();
        let phone    = $('#vendor_phone').val().trim();
        let business = $('#vendor_business').val().trim();
        let details  = $('#vendor_details').val().trim();
        let txnId    = $('#transaction_id').val().trim();

        if (name === '') {
            alert('Please enter your full name.');
            $('#vendor_name').focus(); return;
        }
        if (email === '' || !email.includes('@')) {
            alert('Please enter a valid email address.');
            $('#vendor_email').focus(); return;
        }
        if (phone === '' || phone.length !== 10 || isNaN(phone)) {
            alert('Please enter a valid 10-digit phone number.');
            $('#vendor_phone').focus(); return;
        }
        if (txnId === '' || txnId.length < 6) {
            alert('Please enter a valid Transaction ID / UTR Number.');
            $('#transaction_id').focus(); return;
        }

        if (confirm('Have you completed the payment of ₹{{ number_format($total, 0) }}? Your registration will be verified by the admin after submission.')) {
            let btn     = $(this);
            let btnText = $('#btn-text');
            let loader  = $('#btn-loader');

            btn.prop('disabled', true);
            btnText.text('Processing...');
            loader.removeClass('d-none');

            $.ajax({
                url: "{{ route('job.registration.submit', $job->id) }}",
                method: "POST",
                data: {
                    transaction_id  : txnId,
                    vendor_name     : name,
                    vendor_email    : email,
                    vendor_phone    : phone,
                    vendor_business : business,
                    vendor_details  : details,
                },
                success: function (response) {
                    btn.removeClass('btn-success').addClass('btn-secondary');
                    btnText.text('Submitted Successfully!');
                    loader.addClass('d-none');
                    alert(response.message);
                    window.location.href = "{{ route('frontend.jobs.index') }}";
                },
                error: function (xhr) {
                    btn.prop('disabled', false);
                    btnText.text('Submit Registration');
                    loader.addClass('d-none');
                    let errorMsg = xhr.responseJSON?.message ?? "Something went wrong. Please try again.";
                    alert("Error: " + errorMsg);
                }
            });
        }
    });
});
</script>
@endpush