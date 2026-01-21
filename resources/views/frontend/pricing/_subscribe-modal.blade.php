<div class="modal fade" id="subscribeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="subscribeForm" class="form-horizontal">
                <input type="hidden" name="user_id" value="{{ auth()->check() ? auth()->user()->id : null}}">
                <input type="hidden" name="status" value="on_trial">
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
                                <label for="name" class="form-label">Choose Plan</label>
                                <select class="form-select" name="subscription_plan_id" id="subscription-plan">
                                    <option value="">Choose Plan</option>
                                    @foreach(\App\Models\SubscriptionPlan::all() as $subscriptionPlan)
                                        <option value="{{ $subscriptionPlan->id }}">{{ $subscriptionPlan->name }} [ Rs.{{ $subscriptionPlan->price }} - Monthly | Rs.{{ $subscriptionPlan->yearly_price }} - Yearly ]</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Billing Cycle</label>
                                <select class="form-select" name="billing_cycle" id="billing-subscription">
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
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
                    <button type="submit" class="btn btn-primary shadow-sm" id="save">Start Free Trial
                    </button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
