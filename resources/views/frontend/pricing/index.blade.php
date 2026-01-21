@extends('frontend.layouts.app')

@section('title', 'Pricing | CtrlF')

@section('content')



<section id="pricing" class="pricing section">

        <!-- Section Title -->
        <div class="container section-title aos-init aos-animate" data-aos="fade-up">
            <h2>Pricing</h2>
            <div><span>Check Our</span> <span class="description-title">Pricing</span></div>
        </div><!-- End Section Title -->

        <div class="container">
            @php
                $plans = \App\Models\SubscriptionPlan::where('status','active')->get();
            @endphp
            <div class="row gy-4">

                @if(isset($plans))
                    @foreach($plans as $plan)

                        <div class="col-lg-4 aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">
                            <div class="pricing-item bg-white shadow-sm {{ isset(auth()->user()->subscriptionPlan) && auth()->user()->subscriptionPlan->subscription_plan_id == $plan->id ? 'featured' : '' }} ">
                                @if(isset(auth()->user()->subscriptionPlan) && auth()->user()->subscriptionPlan->subscription_plan_id == $plan->id)
                                <p class="popular {{ auth()->user()->subscriptionPlan->active_status_formatted == 'expired' ? 'bg-danger' : 'bg-warning' }}">{{  ucwords(str_replace('_',' ',auth()->user()->subscriptionPlan->status->value)) }} {{ ucfirst(auth()->user()->subscriptionPlan->active_status_formatted) }}</p>

                                @endif
                                <div class="d-flex flex-column align-items-center">
                                    <h1>{{ $plan->name }}</h1>
                                    <h5 class="description">{{ $plan->plan_id }}</h5>
                                </div>

                                <div class="d-flex flex-column align-items-center gap-3">
                                    <h4><sup><i class="bi bi-currency-rupee"></i></sup>{{ floor($plan->price) }}<span> / monthly</span></h4>
                                    <h6 class="fw-bold"><sup><i class="bi bi-currency-rupee"></i></sup>{{ floor($plan->yearly_price) }}<span> / yearly</span></h6>
                                </div>
                                @if(isset(auth()->user()->subscriptionPlan) && auth()->user()->subscriptionPlan->subscription_plan_id == $plan->id)
                                    <a href="javascript:void(0)" class="cta-btn purchasePlanModal" data-id="{{ $plan->id }}" data-monthly="{{ round($plan->price) }}" data-yearly="{{ round($plan->yearly_price) }}">Purchase Plan</a>
                                    <p class="text-center small fw-bold">{{ auth()->user()->subscriptionPlan->active_status_formatted == 'active' ? 'Will Expire' : 'Expired' }} on {{ auth()->user()->subscriptionPlan->end_date }}</p>
                                @elseif(isset(auth()->user()->subscriptionPlan) && auth()->user()->subscriptionPlan->subscription_plan_id !== $plan->id)
                                    <a href="javascript:void(0)" class="cta-btn purchasePlanModal" data-id="{{ $plan->id }}" data-monthly="{{ $plan->price }}" data-yearly="{{ $plan->yearly_price }}">Purchase Plan</a>
                                    <p class="text-center small fw-bold">Free for 3 month</p>
                                @else
                                    <a href="javascript:void(0)" class="cta-btn subscribeModal" data-id="{{ $plan->id }}">Start a free trial</a>
                                    <p class="text-center small fw-bold">Free for 3 month</p>
                                @endif

                                @php
                                    $features = [];
                                    $features = json_decode($plan->features);
                                @endphp
                                @if(isset($features))
                                <h6 class="fw-bold">Key Features</h6>
                                <ul>
                                    <x-included-features :features="$features"/>
                                    <x-excluded-features :features="$features"/>
                                </ul>
                                @else
                                    <h6 class="fw-bold"><i class="bi bi-x text-danger"></i> No Key Features</h6>
                                @endif
                            </div>
                        </div><!-- End Pricing Item -->
                    @endforeach
                @endif

{{--                <div class="col-lg-4 aos-init aos-animate" data-aos="zoom-in" data-aos-delay="200">--}}
{{--                    <div class="pricing-item featured">--}}
{{--                        <p class="popular">Popular</p>--}}
{{--                        <h3>Business Plan</h3>--}}
{{--                        <p class="description">Ullam mollitia quasi nobis soluta in voluptatum et sint palora dex strater</p>--}}
{{--                        <h4><sup>$</sup>29<span> / month</span></h4>--}}
{{--                        <a href="#" class="cta-btn">Start a free trial</a>--}}
{{--                        <p class="text-center small">No credit card required</p>--}}
{{--                        <ul>--}}
{{--                            <li><i class="bi bi-check"></i> <span>Quam adipiscing vitae proin</span></li>--}}
{{--                            <li><i class="bi bi-check"></i> <span>Nec feugiat nisl pretium</span></li>--}}
{{--                            <li><i class="bi bi-check"></i> <span>Nulla at volutpat diam uteera</span></li>--}}
{{--                            <li><i class="bi bi-check"></i> <span>Pharetra massa massa ultricies</span></li>--}}
{{--                            <li><i class="bi bi-check"></i> <span>Massa ultricies mi quis hendrerit</span></li>--}}
{{--                            <li><i class="bi bi-check"></i> <span>Voluptate id voluptas qui sed aperiam rerum</span></li>--}}
{{--                            <li class="na"><i class="bi bi-x"></i> <span>Iure nihil dolores recusandae odit voluptatibus</span></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div><!-- End Pricing Item -->--}}


            </div>

        </div>

    </section>
    @include('frontend.pricing._subscribe-modal')
    @include('frontend.pricing._purchase-plan-modal')


@endsection

@push('js')
    <script type="module">
        $(function () {
            //Subscribe Trail Plan
            $('body').on('click', '.subscribeModal', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#subscription-plan').val(id).trigger('change');
                $('#subscribeModal').modal('show');
            });
            $('#subscribeForm').on('submit', function (e) {
                e.preventDefault();

                var data = new FormData($('#subscribeForm')[0]);

                $.easyAjax({
                    url: "{{ route('subscriptions.purchase') }}",
                    container: '#subscribeForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    onComplete: () => {
                        $('#subscribeModal').modal('hide');
                        $('#subscribeForm').trigger("reset");
                    }
                })

            });

            //Purchase Plan
            $('body').on('click', '.purchasePlanModal', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                var monthlyAmount =  $(this).data('monthly')
                var yearlyAmount =  $(this).data('yearly')
                $('#purchase-plan').val(id).trigger('change');
                $('#monthly-amt').text(monthlyAmount);
                $('#yearly-amt').text(yearlyAmount);
                $('#plan-id').val(id);
                $('#purchasePlanModal').modal('show');
            });

            $('#purchasePlanForm').on('submit', function (e) {
                e.preventDefault();
                var data = new FormData($('#purchasePlanForm')[0]);
                $.easyAjax({
                    url: "{{ route('payment.requests') }}",
                    container: '#purchasePlanForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    file: true,
                    onComplete: () => {
                        $('#purchasePlanModal').modal('hide');
                        $('#purchasePlanForm').trigger("reset");
                    }
                })
            });

            $('#billing-purchase').on('change',function (e){
               e.preventDefault();
               var billingCycle = $('#billing-purchase').val();

               if(billingCycle == 'yearly'){
                   $('#div-monthly').hide();
                   $('#div-yearly').show();
               }else{
                   $('#div-yearly').hide();
                   $('#div-monthly').show();
               }

            });


        });
    </script>
@endpush
