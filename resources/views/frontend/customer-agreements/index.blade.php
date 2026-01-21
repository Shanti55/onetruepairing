@extends('frontend.layouts.app')

@section('title', 'Customer Agreement | CtrlF')

@section('content')
    <div xmlns="http://www.w3.org/1999/html">
        <div class="container-fluid p-0 m-0">
            <main class="main">
                <section id="featured-provider" class="team section light-background">

                    <!-- Section Title -->
                    <div class="container section-title text-center w-50" data-aos="fade-up">
                        <h1 class="fw-bold"><span class="description-title">{{ $setting->customer_agreement_heading }}</span></h1>
                        <p class="text-wrap">{{ $setting->customer_agreement_subheading }}</p>
                    </div><!-- End Section Title -->

                    <div class="container">
                        <div class="row gy-5">
                            <div class="col-lg-12 mt-0">
                                <div class="card border-0 border-sm">
                                    <div class="card-body  p-md-5 p-3">
                                        <p>{!! $setting->customer_agreement_content !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>

            </main>
        </div>
    </div>
@endsection


