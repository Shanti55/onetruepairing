@extends('service-provider-panel.layouts.app')

@section('title', 'Ctrl F')

@section('content')
    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Notificatons</h5>
        </div>

        <div class="card mt-3 border-0 pb-2">
            @include('frontend.partials.inbox.index')
        </div>
    </div>

@endsection
