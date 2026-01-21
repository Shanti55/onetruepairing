<div class="modal fade" id="purchasePlanModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="purchasePlanForm" class="form-horizontal">
                <input type="hidden" name="user_id" value="{{ auth()->check() ? auth()->user()->id : null}}">
                <input type="hidden" name="subscription_plan_id" id="plan-id" value="">
                <div class="modal-body">
                    @if(auth()->check())
                        <div class="row align-items-center border-bottom mb-3 mt-0 pb-2">
                            <div class="col-lg-12">
                                <h4 class="modal-title">Choose Subscription Plan & Subscribe</h4>
                            </div>
                        </div>
                    @else
                        <div class="row align-items-center border-bottom mb-3 mt-0 pb-2">
                            <div class="col-lg-3">
                                <img src="{{ asset('frontend-images/logo.jpg') }}" alt="" width="80"  loading="lazy">
                            </div>
                            <div class="col-lg-9">
                                <h5 class="mb-0 fw-bold">Welcome</h5>
                                <h6>Login for a more personalized experience.</h6>
                            </div>
                        </div>
                    @endif
                    @if(auth()->check())
                        <div>
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Selected Plan</label>
                                <select class="form-select" name="subscription_plan_id" id="purchase-plan" disabled>
                                    <option value="">Choose Plan</option>
                                    @foreach(\App\Models\SubscriptionPlan::all() as $subscriptionPlan)
                                        <option value="{{ $subscriptionPlan->id }}">{{ $subscriptionPlan->name }} [ Rs.{{ $subscriptionPlan->price }} - Monthly | Rs.{{ $subscriptionPlan->yearly_price }} - Yearly ]</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Billing Cycle</label>
                                <select class="form-select" name="billing_cycle" id="billing-purchase">
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                            <hr>
                            <h6><i class="bi bi-1-circle-fill text-common-blue"></i> Scan QR and Proceed to Pay</h6>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <h6>Total Amount(<i class="bi bi-currency-rupee"></i>)</h6>
                                        <div style="display: block" id="div-monthly">
                                            <h1><i class="bi bi-currency-rupee"></i><span id="monthly-amt" class="display-3 fw-semibold">0</span></h1>
                                        </div>
                                        <div style="display: none" id="div-yearly">
                                            <h1><i class="bi bi-currency-rupee"></i><span id="yearly-amt" class="display-3 fw-semibold">0</span></h1>
                                        </div>
                                        <img src="{{ $setting->qr_code_img }}" alt="" class="w-100 mt-2"  loading="lazy">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h6 class="mb-3"><i class="bi bi-2-circle-fill text-success"></i> After Payment is done successfully , Attach Payment Proof in format <span class="text-secondary">[ .jpg,.png,.pdf ]</span></h6>
                            <div class="form-group mb-3">
                                <input type="file"  name="attachment" id="attachment-payment" accept=".jpg, .jpeg, .png, .pdf" class="form-control  @error('attachment') is-invalid @enderror" required/>
                            </div>
                        </div>
                    @else
                        <div class="d-flex flex-column gap-3 align-items-center">
                            <div>
                                <a href="{{ route('service-providers.auth.login') }}" class="btn btn-primary"><i class="bi bi-door-open"></i> | Goto Login Page</a>
                            </div>
                            <div>
                                Join us to elevate your business and connect with more clients!
                            </div>
                        </div>

                    @endif

                </div>
                @if(auth()->check())
                <div class="modal-footer bg-light d-flex justify-content-end py-1">
                    <button type="submit" class="btn btn-primary shadow-sm" id="save">Purchase Plan
                    </button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
