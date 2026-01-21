@extends('frontend.layouts.app')

@section('title', 'Benefits Of Listing | CtrlF')

@section('content')
    <div xmlns="http://www.w3.org/1999/html">
        <div class="container-fluid p-0 m-0">
            <main class="main">

                <!-- About Section-->
                <!-- Featured Service Providers Section -->
                <section id="featured-provider" class="team section light-background pb-0">

                    <!-- Section Title -->
                    <div class="container section-title text-center w-50 pb-0 pb-md-5" data-aos="fade-up">
                        <h1 class="fw-bold"><span class="description-title">{{ $setting->benefits_of_listings_heading }}</span></h1>
                        <p class="text-wrap">{{ $setting->benefits_of_listings_subheading }}</p>
                    </div><!-- End Section Title -->

                </section>

                <section id="about" class="about section benefits pb-md-5 pb-0">

                    <div class="container" data-aos="fade-up" data-aos-delay="100">
                        <div class="row align-items-xl-center gy-5">

                            <div class="col-xl-5 content">
                                <h2>Core Benefits Structure </h2>
                            </div>

                            <div class="col-xl-7">
                                <div class="row gy-4 icon-boxes">

                                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                                        <div class="icon-box listing p-4">
                                            <h3>Business Growth</h3>
                                            <h6>Expand Your Market Reach</h6>
                                            <ul class="px-0">
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1"> Access to 500+ premium clients</span></li>
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1">Multi-city business opportunities</span></li>
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1">Verified project leads</span></li>
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1">Increased brand visibility</span></li>
                                            </ul>
                                        </div>
                                    </div> <!-- End Icon Box -->

                                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                                        <div class="icon-box listing p-4">
                                            <h3>Operational Excellence</h3>
                                            <h6>Streamline Your Operations</h6>
                                            <ul class="px-0">
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1"> Simplified project management</span></li>
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1"> Digital documentation</span></li>
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1"> Automated invoicing</span></li>
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1"> Real-time project tracking</span></li>
                                            </ul>
                                        </div>
                                    </div> <!-- End Icon Box -->

                                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                                        <div class="icon-box listing p-4">
                                            <h3>Financial Benefits</h3>
                                            <h6>Boost Your Revenue</h6>
                                            <ul class="px-0">
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1">Secure payment processing</span></li>
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1">Reduced marketing costs</span></li>
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1">Higher-value projects</span></li>
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1">Transparent pricing</span></li>
                                            </ul>
                                        </div>
                                    </div> <!-- End Icon Box -->

                                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                                        <div class="icon-box listing p-4">
                                            <h3>Professional Development</h3>
                                            <h6>Build Your Reputation</h6>
                                            <ul class="px-0">
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1">Verified vendor status</span></li>
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1">Performance ratings</span></li>
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1">Client testimonials</span></li>
                                                <li class="mb-2 d-flex gap-2 align-items-center"><i class="bi bi-check"></i><span class="mx-1">Portfolio showcase</span></li>
                                            </ul>
                                        </div>
                                    </div> <!-- End Icon Box -->

                                </div>
                            </div>

                        </div>
                    </div>

                </section><!-- /About Section -->

                <section id="features" class="features section about feature-cards pb-0 pt-5">

                    <div class="container">

                        <div class="row gy-4">
                            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon-box listing p-4 pb-5" style="border-left: 3px solid #0454fa">
                                    <i class="bi bi-bank big-icon"></i>
                                    <h3>Market Access</h3>
                                    <ul class="px-0">
                                        <li class="mb-2 d-flex gap-2"><i class="bi bi-check mt-1"></i><span class="mx-1">Direct Client Connections</span></li>
                                        <li class="mb-2 d-flex gap-2"><i class="bi bi-check mt-1"></i><span class="mx-1">Connect directly with retail chains & brands</span></li>
                                        <li class="mb-2 d-flex gap-2"><i class="bi bi-check mt-1"></i><span class="mx-1">Looking for quality service providers</span></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon-box listing p-4" style="border-left: 3px solid #0454fa">
                                    <i class="bi bi-person-check big-icon"></i>
                                    <h3>Digital Presence</h3>
                                    <ul class="px-0">
                                        <li class="mb-2 d-flex gap-2"><i class="bi bi-check mt-1"></i><span class="mx-1">Professional Profile</span></li>
                                        <li class="mb-2 d-flex gap-2"><i class="bi bi-check mt-1"></i><span class="mx-1">Showcase your work, expertise & client</span></li>
                                        <li class="mb-2 d-flex gap-2"><i class="bi bi-check mt-1"></i><span class="mx-1">testimonials on your dedicated business page</span></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon-box listing p-4 pb-5" style="border-left: 3px solid #0454fa">
                                    <i class="bi bi-buildings big-icon"></i>
                                    <h3>Business Tools</h3>
                                    <ul class="px-0">
                                        <li class="mb-2 d-flex gap-2"><i class="bi bi-check mt-1"></i><span class="mx-1">Smart Management Suite</span></li>
                                        <li class="mb-2 d-flex gap-2"><i class="bi bi-check mt-1"></i><span class="mx-1">Access tools for quotes, invoicing, and
                                            project management - all in one place</span></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon-box listing p-4" style="padding-bottom: 4rem !important;border-left: 3px solid #0454fa;">
                                    <i class="bi bi-bar-chart-line big-icon"></i>
                                    <h3>Growth Support</h3>
                                    <ul class="px-0">
                                        <li class="mb-2 d-flex gap-2"><i class="bi bi-check mt-1"></i><span class="mx-1">Business Intelligence</span></li>
                                        <li class="mb-2 d-flex gap-2"><i class="bi bi-check mt-1"></i><span class="mx-1">Get insights on market trends, pricing,
                                            and growth opportunities</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                </section><!-- /Features Section -->

                <section id="stats" class="stats section light-background pb-0 pt-5  ">

                    <div class="container" data-aos="fade-up" data-aos-delay="100">

                        <div class="row gy-4">

                            @foreach(\App\Models\BusinessValue::all() as $value)
                                <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                                    <i class="bi {{$value->icon}}"></i>
                                    <div class="stats-item">
                                        <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter">{{$value->title}}</span>
                                        <p>{{$value->description}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                </section><!-- /Stats Section -->

{{--                <section id="testimonials" class="testimonials section dark-background">--}}

{{--                    <img src="assets/img/testimonials-bg.jpg" class="testimonials-bg" alt="">--}}

{{--                    <div class="container" data-aos="fade-up" data-aos-delay="100">--}}

{{--                        <div class="swiper init-swiper">--}}
{{--                            <script type="application/json" class="swiper-config">--}}
{{--                                {--}}
{{--                                  "loop": true,--}}
{{--                                  "speed": 600,--}}
{{--                                  "autoplay": {--}}
{{--                                    "delay": 5000--}}
{{--                                  },--}}
{{--                                  "slidesPerView": "auto",--}}
{{--                                  "pagination": {--}}
{{--                                    "el": ".swiper-pagination",--}}
{{--                                    "type": "bullets",--}}
{{--                                    "clickable": true--}}
{{--                                  }--}}
{{--                                }--}}
{{--                            </script>--}}
{{--                            <div class="swiper-wrapper">--}}

{{--                                <div class="swiper-slide">--}}
{{--                                    <div class="testimonial-item">--}}
{{--                                        <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">--}}
{{--                                        <h3>Saul Goodman</h3>--}}
{{--                                        <h4>Ceo &amp; Founder</h4>--}}
{{--                                        <div class="stars">--}}
{{--                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>--}}
{{--                                        </div>--}}
{{--                                        <p>--}}
{{--                                            <i class="bi bi-quote quote-icon-left"></i>--}}
{{--                                            <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.</span>--}}
{{--                                            <i class="bi bi-quote quote-icon-right"></i>--}}
{{--                                        </p>--}}
{{--                                    </div>--}}
{{--                                </div><!-- End testimonial item -->--}}

{{--                                <div class="swiper-slide">--}}
{{--                                    <div class="testimonial-item">--}}
{{--                                        <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">--}}
{{--                                        <h3>Sara Wilsson</h3>--}}
{{--                                        <h4>Designer</h4>--}}
{{--                                        <div class="stars">--}}
{{--                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>--}}
{{--                                        </div>--}}
{{--                                        <p>--}}
{{--                                            <i class="bi bi-quote quote-icon-left"></i>--}}
{{--                                            <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.</span>--}}
{{--                                            <i class="bi bi-quote quote-icon-right"></i>--}}
{{--                                        </p>--}}
{{--                                    </div>--}}
{{--                                </div><!-- End testimonial item -->--}}

{{--                                <div class="swiper-slide">--}}
{{--                                    <div class="testimonial-item">--}}
{{--                                        <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">--}}
{{--                                        <h3>Jena Karlis</h3>--}}
{{--                                        <h4>Store Owner</h4>--}}
{{--                                        <div class="stars">--}}
{{--                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>--}}
{{--                                        </div>--}}
{{--                                        <p>--}}
{{--                                            <i class="bi bi-quote quote-icon-left"></i>--}}
{{--                                            <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.</span>--}}
{{--                                            <i class="bi bi-quote quote-icon-right"></i>--}}
{{--                                        </p>--}}
{{--                                    </div>--}}
{{--                                </div><!-- End testimonial item -->--}}

{{--                                <div class="swiper-slide">--}}
{{--                                    <div class="testimonial-item">--}}
{{--                                        <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">--}}
{{--                                        <h3>Matt Brandon</h3>--}}
{{--                                        <h4>Freelancer</h4>--}}
{{--                                        <div class="stars">--}}
{{--                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>--}}
{{--                                        </div>--}}
{{--                                        <p>--}}
{{--                                            <i class="bi bi-quote quote-icon-left"></i>--}}
{{--                                            <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.</span>--}}
{{--                                            <i class="bi bi-quote quote-icon-right"></i>--}}
{{--                                        </p>--}}
{{--                                    </div>--}}
{{--                                </div><!-- End testimonial item -->--}}

{{--                                <div class="swiper-slide">--}}
{{--                                    <div class="testimonial-item">--}}
{{--                                        <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">--}}
{{--                                        <h3>John Larson</h3>--}}
{{--                                        <h4>Entrepreneur</h4>--}}
{{--                                        <div class="stars">--}}
{{--                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>--}}
{{--                                        </div>--}}
{{--                                        <p>--}}
{{--                                            <i class="bi bi-quote quote-icon-left"></i>--}}
{{--                                            <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.</span>--}}
{{--                                            <i class="bi bi-quote quote-icon-right"></i>--}}
{{--                                        </p>--}}
{{--                                    </div>--}}
{{--                                </div><!-- End testimonial item -->--}}

{{--                            </div>--}}
{{--                            <div class="swiper-pagination"></div>--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                </section><!-- /Testimonials Section -->--}}

                <section id="contact" class="contact section py-5">

                    <div class="container" data-aos="fade" data-aos-delay="100">

                        <div class="card p-5 rounded-4 shadow-lg border-0">
                            <!-- Section Title -->
                            <div class="container section-title pb-2" data-aos="fade-up">
                                <h2>Contact</h2>
                                <div><span>Start Growing Your Business</span> <span class="description-title">Today</span></div>
                            </div><!-- End Section Title -->

                            <div class="info-item d-flex align-items-center mt-3" data-aos="fade-up" data-aos-delay="200">
                                <i class="bi bi-check2-circle" style="width: 30px;height: 30px;"></i>
                                <div>
                                    <h3>3-month free trial</h3>
                                </div>
                            </div><!-- End Info Item -->
                            <div class="info-item d-flex align-items-center mt-3" data-aos="fade-up" data-aos-delay="200">
                                <i class="bi bi-check2-circle" style="width: 30px;height: 30px;"></i>
                                <div>
                                    <h3>No hidden charges</h3>
                                </div>
                            </div>
                            <div class="info-item d-flex align-items-center mt-3" data-aos="fade-up" data-aos-delay="200">
                                <i class="bi bi-check2-circle"  style="width: 30px;height: 30px;"></i>
                                <div>
                                    <h3>Dedicated onboarding support</h3>
                                </div>
                            </div>
                            <div class="php-email-form mt-4">
                                <a href="{{route('frontend.business-listings.createOrUpdate')}}" class="btn btn-primary btn-lg rounded-4">Get Started For Free <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </section><!-- /Contact Section -->
            </main>
        </div>
    </div>
@endsection


