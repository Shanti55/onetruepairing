@extends('frontend.layouts.app')

@section('title', 'Notifications | CtrlF')

@section('content')

    <section id="profile" class="hero section light-background">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-3">
                    @include('frontend.my-accounts._partials._sidebar')
                </div>
                <div class="col-lg-9 justify-content-between align-items-center">
                    <div class="card border-0 shadow rounded-0">
                        <div class="card-header bg-white mt-2 ">
                            <div class="d-flex justify-content-between center mb-2">
                                <h4 class="mx-1 mb-0"><i class="bi bi-bell"></i> Notifications</h4>
                            </div>
                        </div>
                        <div class="card-body p-0" style="max-height: 400px!important; overflow-y: scroll">
                            @include('frontend.partials.inbox.index')
                        </div>
                    </div><!-- End Contact Form -->
                </div>
            </div>
        </div>
    </section><!-- /Profile Section -->

@endsection
