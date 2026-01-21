@extends('frontend.layouts.app')

@section('title', 'About Us | CtrlF')

@section('content')
    <div xmlns="http://www.w3.org/1999/html">
        <div class="container-fluid p-0 m-0">
            <main class="main">

                <!-- About Section-->
                <!-- Featured Service Providers Section -->
                <section id="featured-provider" class="team section light-background">

                    <!-- Section Title -->
                    <div class="container section-title text-center w-50" data-aos="fade-up">
                        <h1 class="fw-bold"><span class="description-title">{{ $setting->about_us_heading }}</span></h1>
                        <p class="text-wrap">{{ $setting->about_us_subheading }}</p>
                    </div><!-- End Section Title -->

                    <div class="container">
                        <div class="row gy-5">
                            <div class="col-lg-12 mt-0">
                                <div class="card border-0 border-sm">
                                    <div class="card-body p-md-5 p-3">
                                        <p>{!! $setting->about_us_content !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
                <!--Video-->
                @if($setting->show_about_us_video)
                <section id="hero" class="hero section dark-background">
                    @if(isset($setting->search_by_location_bg_img))
                        <img src="{{ $setting->search_by_location_bg_img }}" alt="" class="hero-bg"  loading="lazy">
                    @endif
                    <div class="container">
                        <div class="row gy-5">
                            <div class="col-lg-12 d-flex justify-content-center">
                                <video width="800" height="400" controls>
                                    <source src="{{ $setting->about_us_video }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </div>
                    <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
                        <defs>
                            <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
                        </defs>
                        <g class="wave1">
                            <use xlink:href="#wave-path" x="50" y="3"></use>
                        </g>
                        <g class="wave2">
                            <use xlink:href="#wave-path" x="50" y="0"></use>
                        </g>
                        <g class="wave3">
                            <use xlink:href="#wave-path" x="50" y="9"></use>
                        </g>
                    </svg>
                </section>
                @endif

            </main>
        </div>
    </div>
@endsection


