@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">

        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h5 class="fw-semibold"><a href="{{ route('users.index') }}">Users</a>
                    <i class="bi bi-chevron-right"></i>{{ $user->name }}
                </h5>

            </div>
        </div>

        <div class="card mt-3 border-0 pb-2">
            <div class="card border-0 shadow">
                <!--Personal Information-->
                <div class="card-header">
                    <h4>Personal Information</h4>
                </div>
                <div class="card-body px-md-5 px-3">
                    <div class="gy-2 my-3">
                        <!--Avtar-->
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-center align-items-center previewImg gap-3">
                                    <div id="preview" class="preview img-thumbnail mb-3" style="display: {{ $profile && isset($profile->avatar) ? 'block' : 'none' }};width: 150px;height:150px">
                                        @if($profile && !empty($profile->avatar))
                                            <img src="{{ url($profile->avatar) }}" alt="Profile Avatar" class="object-fit-cover w-100" height="80" width="80">
                                        @else
                                            <img src="{{ asset('frontend-images/profile.png') }}" alt="Placeholder Avatar" class="rounded-circle object-fit-cover" height="80" width="80">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <label for="first_name" class="form-label fw-semibold">First Name :</label>
                                </div>
                                <div class="col-lg-9">
                                    <h6 class="fw-normal text-secondary">{{ isset($profile) ? $profile->first_name : null }}</h6>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <label for="last_name" class="form-label fw-semibold">Last Name :</label>
                                </div>
                                <div class="col-lg-9">
                                    <h6 class="fw-normal text-secondary">{{ isset($profile) ? $profile->last_name : null }}</h6>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <label for="gender" class="form-label fw-semibold">Gender :</label>
                                </div>
                                <div class="col-lg-9">
                                    <h6 class="fw-normal text-secondary">{{ isset($profile) ? $profile->gender : null }}</h6>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <label for="email" class="form-label fw-semibold">Email Address :</label>
                                </div>
                                <div class="col-lg-9">
                                    <h6 class="fw-normal text-secondary">{{ $user->email }}</h6>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <label for="mobile" class="form-label fw-semibold">Mobile Number :</label>
                                </div>
                                <div class="col-lg-9">
                                    <h6 class="fw-normal text-secondary">{{ isset($profile) ? $profile->contact_number : null }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header">
                    <h4>Address Information</h4>
                </div>
                <div class="card-body px-md-5 px-3">
                    <div class="gy-2 my-3">
                        <div class="">
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <label for="address" class="form-label fw-semibold">Address :</label>
                                </div>
                                <div class="col-lg-9">
                                    <h6 class="fw-normal text-secondary">{{ $profile ? $profile->address : null }}</h6>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <label for="city" class="form-label fw-semibold">City :</label>
                                </div>
                                <div class="col-lg-9">
                                    <h6 class="fw-normal text-secondary">{{ $profile ? $profile->city : null }}</h6>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <label for="state" class="form-label fw-semibold">State :</label>
                                </div>
                                <div class="col-lg-9">
                                    <h6 class="fw-normal text-secondary">{{ $profile ? $profile->state : null }}</h6>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <label for="region" class="form-label fw-semibold">Region :</label>
                                </div>
                                <div class="col-lg-9">
                                    <h6 class="fw-normal text-secondary">{{ $profile ? $profile->region : null }}</h6>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <label for="pin_code" class="form-label fw-semibold">Pincode :</label>
                                </div>
                                <div class="col-lg-9">
                                    <h6 class="fw-normal text-secondary">{{ $profile ? $profile->pin_code : null }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

