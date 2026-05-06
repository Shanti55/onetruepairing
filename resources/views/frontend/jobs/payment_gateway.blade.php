@extends('frontend.layouts.app')

@section('content')
<div class="container my-5 text-center" style="min-height: 450px;">
    <div class="card shadow-lg p-5 border-0 d-inline-block mt-5" style="max-width: 500px;">
        <div id="payment-loader">
            <div class="spinner-border text-primary mb-4" role="status" style="width: 3rem; height: 3rem;"></div>
            <h4 class="fw-bold">Processing Your Registration</h4>
            <p class="text-muted">Please do not refresh or close this window. We are connecting you to Razorpay...</p>
        </div>
        
        <div class="bg-light p-3 rounded-3 mt-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-secondary">Job Title:</span>
                <span class="fw-bold text-end ms-2">{{ $job->title }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-secondary">Registration Fee (1%):</span>
                <span class="fw-bold text-danger">₹{{ number_format($amount, 2) }}</span>
            </div>
        </div>

        <div class="mt-4">
            <button id="retry-button" class="btn btn-primary d-none" onclick="location.reload()">Retry Payment</button>
            <a href="{{ route('frontend.jobs.index') }}" class="btn btn-link text-muted">Cancel and Go Back</a>
        </div>

        <p class="small text-muted mt-4">
            <i class="bi bi-shield-check text-success"></i> 100% Secure Transaction via Razorpay
        </p>
    </div>
</div>

{{-- Scripts --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        var options = {
            "key": "{{ config('services.razorpay.key') ?? env('RAZORPAY_KEY') }}", 
            "amount": "{{ round($amount * 100) }}", // Rounding to avoid decimal issues in paise
            "currency": "INR",
            "name": "CtrlF Auction",
            "description": "Registration Fee for Job #{{ $job->id }}",
            "handler": function (response){
                // Show loader again while saving to DB
                $('#payment-loader h4').text('Verifying Payment...');
                
                $.ajax({
                    url: "{{ route('jobs.payment.success') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        razorpay_payment_id: response.razorpay_payment_id,
                        job_id: "{{ $job->id }}",
                        amount: "{{ $amount }}"
                    },
                    success: function(res) {
                        if(res.status === 'success') {
                            alert('Registration Successful! Ab aap bid kar sakte hain.');
                            window.location.href = "{{ route('frontend.jobs.index') }}";
                        } else {
                            alert('Something went wrong: ' + res.message);
                        }
                    },
                    error: function(err) {
                        alert('Database entry failed. Agar paise kat gaye hain toh Support se contact karein.');
                        $('#retry-button').removeClass('d-none');
                    }
                });
            },
            "prefill": {
                "name": "{{ auth()->user()->name }}",
                "email": "{{ auth()->user()->email }}"
            },
            "theme": {
                "color": "#0d6efd"
            },
            "modal": {
                "ondismiss": function(){
                    // Redirect back if user closes popup
                    window.location.href = "{{ route('frontend.jobs.index') }}";
                }
            }
        };

        try {
            var rzp1 = new Razorpay(options);
            rzp1.on('payment.failed', function (response){
                alert("Payment Failed: " + response.error.description);
                $('#retry-button').removeClass('d-none');
            });
            rzp1.open();
        } catch (e) {
            console.error("Razorpay failed to load", e);
            alert("Payment Gateway load nahi ho paya. Please refresh karein.");
            $('#retry-button').removeClass('d-none');
        }
    });
</script>
@endsection