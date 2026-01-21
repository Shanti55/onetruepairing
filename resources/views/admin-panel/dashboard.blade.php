@extends('admin-panel.layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container-fluid">

        <div class="mb-3">
            <h4>Admin Dashboard</h4>
        </div>

        <div class="row mb-5">
            <div class="col-lg-3 col-md-6 d-flex mb-3">
                <div class="card flex-fill shadow-sm soft-primary border-0">
                    <div class="card-body p-0 d-flex flex-fill">
                        <div class="row g-0 w-100">
                            <div class="col">
                                <div class="p-3 m-1">
                                    <h6>Welcome Back, {{ auth()->user()->name }}</h6>
                                </div>
                            </div>
                            <div class="col align-self-end text-end">
                                <img src="{{ asset('images/customer-support.png')  }}" class="img-fluid illustration-img"
                                     alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $adminCounts = \App\Models\User::where('role','admin')->count();
                $serviceProviderCounts = \App\Models\User::where('role','service-provider')->count();
                $userCounts = \App\Models\User::where('role','user')->count();
            @endphp
            <div class="col-lg-3 col-md-6 d-flex mb-3">
                <div class="card flex-fill shadow-sm border-0">
                    <a href="{{ route('admins.index') }}" class="text-dark" wire:navigate>
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h3 class="mb-2">
                                    {{ $adminCounts }}
                                </h3>
                                <h6 class="mb-2">
                                    Total Admins
                                </h6>
{{--                                <div class="mb-0">--}}
{{--                                    <span class="badge soft-success me-2">--}}
{{--                                        +9.0%--}}
{{--                                    </span>--}}
{{--                                    <span class="text-muted">--}}
{{--                                        Since Last Month--}}
{{--                                    </span>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex mb-3">
                <div class="card flex-fill shadow-sm border-0">
                    <a href="{{ route('serviceproviders.index') }}" class="text-dark" wire:navigate>
                        <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h3 class="mb-2">
                                    {{ $serviceProviderCounts }}
                                </h3>
                                <h6 class="mb-2">
                                   Total Service Providers
                                </h6>
{{--                                <div class="mb-0">--}}
{{--                                    <span class="badge soft-success me-2">--}}
{{--                                        +9.0%--}}
{{--                                    </span>--}}
{{--                                    <span class="text-muted">--}}
{{--                                        Since Last Month--}}
{{--                                    </span>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex mb-3">
                <div class="card flex-fill shadow-sm border-0">
                    <a href="{{ route('users.index') }}" class="text-dark" wire:navigate>
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h3 class="mb-2">
                                    {{ $userCounts }}
                                </h3>
                                <h6 class="mb-2">
                                   Total Users
                                </h6>
{{--                                <div class="mb-0">--}}
{{--                                    <span class="badge soft-success me-2">--}}
{{--                                        +9.0%--}}
{{--                                    </span>--}}
{{--                                    <span class="text-muted">--}}
{{--                                        Since Last Month--}}
{{--                                    </span>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>

        <!--Jobs-->
        <div class="mb-3">
            <h4>Jobs Progress</h4>
        </div>

        <div class="row mb-4">
            @php
                $newJobRequestCounts = \App\Models\JobPost::where('status','open')->count();
                $jobUnderVerificationCounts = \App\Models\JobPost::where('status','under verification')->count();
                $jobInProgressCounts = \App\Models\JobPost::where('status','in progress')->count();
                $jobCompletedCounts = \App\Models\JobPost::where('status','completed')->count();
            @endphp
            <div class="col-lg-3 col-md-6 d-flex mb-3">
                <div class="card flex-fill shadow-sm border-0">
                    <a href="{{ route('job-posts.index') }}" class="text-dark" wire:navigate>
                        <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h3 class="mb-2">
                                    {{ $newJobRequestCounts }}
                                </h3>
                                <h6 class="mb-2">
                                    New Requests
                                </h6>
{{--                                <div class="mb-0">--}}
{{--                                    <span class="badge soft-success me-2">--}}
{{--                                        +9.0%--}}
{{--                                    </span>--}}
{{--                                    <span class="text-muted">--}}
{{--                                        Since Last Month--}}
{{--                                    </span>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex mb-3">
                <div class="card flex-fill shadow-sm border-0">
                    <a href="{{ route('job-posts.index') }}" class="text-dark" wire:navigate>
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h3 class="mb-2">
                                    {{ $jobUnderVerificationCounts }}
                                </h3>
                                <h6 class="mb-2">
                                    Under Verification
                                </h6>
{{--                                <div class="mb-0">--}}
{{--                                    <span class="badge soft-success me-2">--}}
{{--                                        +9.0%--}}
{{--                                    </span>--}}
{{--                                    <span class="text-muted">--}}
{{--                                        Since Last Month--}}
{{--                                    </span>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex mb-3">
                <div class="card flex-fill shadow-sm border-0">
                    <a href="{{ route('job-posts.index') }}" class="text-dark" wire:navigate>
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h3 class="mb-2">
                                    {{ $jobInProgressCounts }}
                                </h3>
                                <h6 class="mb-2">
                                    In Progress
                                </h6>
{{--                                <div class="mb-0">--}}
{{--                                    <span class="badge soft-success me-2">--}}
{{--                                        +9.0%--}}
{{--                                    </span>--}}
{{--                                    <span class="text-muted">--}}
{{--                                        Since Last Month--}}
{{--                                    </span>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex mb-3">
                <div class="card flex-fill shadow-sm border-0">
                    <a href="{{ route('job-posts.index') }}" class="text-dark" wire:navigate>
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h3 class="mb-2">
                                    {{ $jobCompletedCounts }}
                                </h3>
                                <h6 class="mb-2">
                                    Completed
                                </h6>
{{--                                <div class="mb-0">--}}
{{--                                    <span class="badge soft-success me-2">--}}
{{--                                        +9.0%--}}
{{--                                    </span>--}}
{{--                                    <span class="text-muted">--}}
{{--                                        Since Last Month--}}
{{--                                    </span>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>


    </div>
@endsection
