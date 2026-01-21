@extends('service-provider-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Subscriptions and Payments</h5>
        </div>

        @include('partials.subscriptions._subscriptions')
        <hr class="border-0">
        @include('partials.subscriptions._payments')

    </div>

@endsection
