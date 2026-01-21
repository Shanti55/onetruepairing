@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">

        <div class="d-flex align-items-center justify-content-between">
            <div><h5 class="fw-semibold"><a href="{{ route('serviceproviders.index') }}">Service Providers</a><i class="bi bi-chevron-right"></i>{{ $profile ? $profile->company_name : $provider->name }}<i class="bi bi-chevron-right"></i>Billing</h5></div>
        </div>
        @if(auth()->user()->isAdmin())
        <div class="card mt-3 border-0">
            <div class="d-flex">
                @if(canAccessModule('service_providers'))
                    <a href="{{ route('serviceproviders.show',['serviceprovider'=>$provider->id]) }}" class="btn btn-lg text-secondary border-0"><i class="bi bi-info-circle"></i> Overview</a>
                @endif
                @if(canAccessModule('billing'))
                    <a href="javascript:void(0)" class="btn btn-lg text-dark border-0"><i class="bi bi-credit-card"></i> Billing</a>
                @endif
            </div>
        </div>
        @endif
        @include('partials.subscriptions._subscriptions')
        <hr class="border-0">
        @include('partials.subscriptions._payments')

    </div>

@endsection

