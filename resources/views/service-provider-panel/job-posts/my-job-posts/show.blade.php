@extends('admin-panel.layouts.app')

@section('content')

    {{--Overview Section--}}
    <div id="overview" class="px-3 tab-pane active">
        <br>
        <div class="row">

            <div class="col-lg-12">

                <div class="card border-0 shadow">
                    <div class="card-header border-0">
                        <h5 class="fw-semibold"><i class="bi bi-briefcase-fill"></i> Job Information</h5>
                    </div>
                    <div class="card-body">
                        @include('partials.job-posts._job-info')
                    </div>
                </div>

                <div class="card mt-3 border-0 shadow">
                    <div class="card-header border-0">
                        <h5 class="text-dark"><i class="bi bi-tag-fill"></i> Service provider Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-lg-4 mt-2">
                                <p class="card-title text-muted mb-0"><small>Company Name</small></p>
                                <h6 class="card-text">{{ $profile->company_name }}</h6>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <p class="card-title text-muted mb-0"><small>Email</small></p>
                                <h6 class="card-text">{{  $profile->company_email }}</h6>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <p class="card-title text-muted mb-0"><small>Website</small></p>
                                <h6 class="card-text">{{ $profile->website ?? '--' }}</h6>
                            </div>
                            <div class="col-lg-4 mt-2">
                                @php
                                    $categories = null;
                                    $categories = $profile && isset($profile->categories) ? json_decode($profile->categories) :[];
                                @endphp
                                <p class="card-title text-muted mb-0"><small>Categories</small></p>
                                <h6 class="card-text d-flex flex-wrap ">
                                    @if($categories)
                                        @foreach($categories as $id)
                                            @php
                                                $category = \App\Models\Category::find($id);
                                            @endphp
                                        <div class="d-flex flex-wrap ">
                                            <h6>
                                                {{ $category->name }} <span>,</span>
                                            </h6>
                                        </div>
                                        @endforeach
                                    @endif
                                </h6>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <p class="card-title text-muted mb-0"><small>First Name</small></p>
                                <h6 class="card-text">{{ $profile->first_name }}</h6>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <p class="card-title text-muted mb-0"><small>Last Name</small></p>
                                <h6 class="card-text">{{  $profile->last_name }}</h6>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <p class="card-title text-muted mb-0"><small>Email</small></p>
                                <h6 class="card-text">{{ $profile->company_email }}</h6>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <p class="card-title text-muted mb-0"><small>Contact No</small></p>
                                <h6 class="card-text">{{ $profile->contact_number }}</h6>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <p class="card-title text-muted mb-0"><small>Address</small></p>
                                <h6 class="card-text">{{ $profile->address }}</h6>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <p class="card-title text-muted mb-0"><small>City</small></p>
                                <h6 class="card-text">{{ $profile->city }}</h6>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <p class="card-title text-muted mb-0"><small>State</small></p>
                                <h6 class="card-text">{{ $profile->state }}</h6>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <p class="card-title text-muted mb-0"><small>Pincode</small></p>
                                <h6 class="card-text">{{ $profile->pin_code }}</h6>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

@endsection

