@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <div><h5 class="fw-semibold"><a href="{{ route('billing.subscriptions.index') }}">Subscriptions</a><i class="bi bi-chevron-right"></i>{{ $profile ? $profile->company_name : $provider->name }}</h5></div>
        </div>
        <div class="card mt-3 border-0 pb-2 bg-light">
            <div class="row">
                <div class="col-lg-3">
                    @include('admin-panel.billings.subscriptions._partials._sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="tab-content">
                        <div id="overviewTab" class="px-3 tab-pane active fade show">
                            @include('partials.service-provider._profile-show')
                        </div>
                        <div id="subscriptionTab" class="tab-pane fade">
                            @include('partials.subscriptions._subscriptions')
                            <hr class="border-0">
                            @include('partials.subscriptions._payments')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

