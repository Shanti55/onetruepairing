@extends('frontend.layouts.app')

@section('title', 'Service Provider | CtrlF')

@section('content')

    <section id="hero" class="hero section light-background" style="min-height: 30vh!important;padding: 130px 0 40px 0!important;">
{{--        <img src="{{ asset('frontend-images/bg-img.jpg') }}"  loading="lazy" alt="" class="hero-bg">--}}
        <div class="container">
            <div class="row gy-4 justify-content-between align-items-center">
                <div class="col-lg-6 text-center" data-aos="fade-in">
                    <img src="{{ $profile && isset($profile->avatar) ? url($profile->avatar) : asset('images/show_files/logo-here.png')}}"
                         loading="lazy" class="img img-responsive img-thumbnail mb-3" style="width: 150px;height: 150px;">
                    <h2 class="mb-3"><span class="">{{ isset($profile) ? $profile->company_name : null }}</span>  <i class="bi bi-patch-check-fill text-primary"></i></h2>

{{--                    <h6 class="mb-3">{{ isset($profile) ?  : null }}</h6>--}}
{{--                    <h6 class="mb-3">We are hybrid certified & TDI specialists</h6>--}}
                    <div class="d-flex justify-content-center gap-4">
                        <a href="{{ route('frontend.job-posts.createOrUpdate') }}" class="btn cu-btn rounded-2 border-0"><i class="bi bi-suitcase-lg"></i> Post a Job</a>
                        <a href="javascript:void(0)" class="btn cu-btn rounded-2 border-0"><i class="bi bi-phone"></i> {{ isset($profile) ? $profile->contact_number : null }}</a>
                    </div>
                </div>
                <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="100">
                    <img src="{{ $profile && isset($profile->cover_image) ? url($profile->cover_image) : asset('images/show_files/logo-here.png')}}" class="rounded shadow img-thumbnail object-fit-cover" alt=""  loading="lazy" style="width: 100%!important;max-height:350px!important; ">
                </div>
            </div>
        </div>

    </section><!-- /Hero Section -->

    <div class="container-fluid shadow-sm py-3 bg-white">
            <nav class="container d-flex justify-content-around">
                    <a href="#about" class="active fw-semibold text-secondary">ABOUT</a>
                    <a href="#services" class="text-secondary">SERVICES</a>
                    <a href="#contact" class="text-secondary">CONTACT</a>
                    <a href="#gallery" class="text-secondary">GALLERY</a>
            </nav>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!--About Section-->
                <section id="about" class="about section" style="padding-bottom: 0px!important;">
                    <!-- Section Title -->
                    <div class="container section-title" data-aos="fade-up">
                        <h2>About</h2>
                        <div><span class="description-title">{{ isset($profile) ? $profile->company_name : $provider->name }}</span></div>
                    </div><!-- End Section Title -->

                    <div class="container" data-aos="fade" data-aos-delay="100">

                        <div class="row gy-4">
                            <div class="col-lg-12">
                                <div class="card m-0 shadow-sm border-0">
                                    <div class="card-body d-flex flex-column">
                                        <div>
                                            <h6> Categories</h6>
                                            @php
                                                $providerCategories = isset($provider->serviceproviderprofile->categories) ? json_decode($provider->serviceproviderprofile->categories) : null;
                                            @endphp
                                            @if($providerCategories)
                                                <div class="d-flex flex-wrap gap-2 mb-2 mt-3">
                                                    @foreach($providerCategories as $category)
                                                        @php
                                                            $categoryName = \App\Models\Category::find($category);
                                                        @endphp
                                                        @if(isset($categoryName))
                                                            <span class="btn btn-lg soft-primary" style="font-style: normal">{{ $categoryName->name }}</span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="text-secondary lh-lg">{{ isset($profile) ? $profile->company_description : 'NA' }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </section>

                <!--Services Section-->
                <section id="services" class="services section" style="padding-bottom: 0px!important;">
                    <!-- Section Title -->
                    <div class="container section-title" data-aos="fade-up">
                        <h2>Services</h2>
                        <div><span class="description-title">Services We Provide</span></div>
                    </div><!-- End Section Title -->

                    <div class="container" data-aos="fade" data-aos-delay="100">

                        <div class="row gy-4">
                            <div class="col-lg-12">
                                <div class="card m-0 shadow-sm border-0">
                                    <div class="card-body d-flex flex-column">
                                        <div>
                                            @php
                                                $providerServices = isset($provider->serviceproviderprofile->services) ? json_decode($provider->serviceproviderprofile->services) : null;
                                            @endphp
                                            @if($providerServices)
                                                <div class="d-flex flex-wrap gap-2 mb-2 mt-3">
                                                    @foreach($providerServices as $service)
                                                        @php
                                                            $serviceName = \App\Models\Service::find($service);
                                                        @endphp
                                                        @if(isset($serviceName))
                                                            <span class="btn btn-lg soft-secondary" style="font-style: normal"><i class="bi bi-check-circle-fill text-success"></i> {{ $serviceName->name }}</span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="d-flex justify-content-center">
                                                    <h6>No Services Found</h6>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </section>

                <!-- Contact Section -->
                <section id="contact" class="contact section" style="padding-bottom: 0px!important;">
                    <!-- Section Title -->
                    <div class="container section-title" data-aos="fade-up">
                        <h2>Contact</h2>
                        <div><span>Contact</span> <span class="description-title">Information</span></div>
                    </div><!-- End Section Title -->

                    <div class="container" data-aos="fade" data-aos-delay="100">

                        <div class="row gy-4">

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <div class="card m-0 shadow-sm border-0">
                                            <div class="card-body">
                                                <div class="info-item d-flex flex-wrap" data-aos="fade-up" data-aos-delay="200">
                                                    <i class="bi bi-geo-alt flex-shrink-0"></i>
                                                    <div>
                                                        <h3>Address</h3>
                                                        <h6>{{ $profile ? $profile->address : 'NA' }}</h6>
                                                        <h6 class="small">Pincode : {{ $profile ? $profile->pin_code : 'NA' }} / City : {{ $profile ? $profile->city : 'NA' }} / State : {{ $profile ? $profile->state : 'NA' }}</h6>
                                                    </div>
                                                </div><!-- End Info Item -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <div class="card m-0 shadow-sm border-0">
                                            <div class="card-body">
                                                <div class="info-item d-flex flex-wrap" data-aos="fade-up" data-aos-delay="300">
                                                    <i class="bi bi-telephone flex-shrink-0"></i>
                                                    <div>
                                                        <h3>Call Us</h3>
                                                        <h6>{{ $profile ? $profile->contact_number : 'NA' }}</h6>
                                                        <h6>{{ $profile ? $profile->alternate_contact_number : 'NA' }}</h6>
                                                    </div>
                                                </div><!-- End Info Item -->
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 mb-3">
                                        <div class="card m-0 shadow-sm border-0">
                                            <div class="card-body">
                                                <div class="info-item d-flex flex-wrap" data-aos="fade-up" data-aos-delay="400">
                                                    <i class="bi bi-envelope flex-shrink-0"></i>
                                                    <div>
                                                        <h3>Email Us</h3>
                                                        <h6>{{ $profile ? $profile->company_email : 'NA' }}</h6>
                                                    </div>
                                                </div><!-- End Info Item -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <div class="card m-0 shadow-sm border-0">
                                            <div class="card-body">
                                                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                                                    <i class="bi bi-globe flex-shrink-0"></i>
                                                    <div>
                                                        <h3>Website</h3>
                                                        <h6>{{ $profile ? $profile->website : 'NA' }}</h6>
                                                    </div>
                                                </div><!-- End Info Item -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- /Gallery Section -->
                <section id="gallery" class="gallery section">

                    <!-- Section Title -->
                    <div class="container section-title" data-aos="fade-up">
                        <h2>Gallery</h2>
                        <div><span>Check Our</span> <span class="description-title">Gallery</span></div>
                    </div><!-- End Section Title -->

                    <div class="container" data-aos="fade-up" data-aos-delay="100">
                        @php
                            $images = \App\Models\Media::where('user_id',$provider->id)->get();
                        @endphp
                        <div class="row g-0">
                            @if(count($images))
                                @foreach($images as $image)
                                    <div class="col-lg-3 col-md-4">
                                        <div class="gallery-item" style="height: 200px">
                                            <a href="{{ $image->url }}" target="_blank" class="glightbox" data-gallery="images-gallery">
                                                <img src="{{ $image->url }}" alt="" class="img-fluid" style="width: 100%;height: 100%"  loading="lazy">
                                            </a>
                                        </div>
                                    </div><!-- End Gallery Item -->
                                @endforeach
                            @else
                                <div class="col-lg-12 col-md-12">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="{{ asset('frontend-images/empty-box.png') }}" width="25%"  loading="lazy">
                                        <h1 class="mt-3">Sorry !! No Images Found</h1>
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>

                </section>
            </div>
            <div class="col-lg-4">
                <section id="about" class="about section" style="padding-bottom: 0px!important;">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0 p-md-3">
                        @include('frontend.partials._contact-us-form')
                    </div>
                </div>
                </section>
            </div>
        </div>
    </div>






@endsection


