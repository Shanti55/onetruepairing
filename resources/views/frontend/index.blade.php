@extends('frontend.layouts.app')

@section('title', 'CtrlF')

@section('content')

    <div class="container-fluid p-0 m-0">
        <main class="main">
        <!-- Hero Section -->

        <section id="hero" class="hero section light-background bg-white pb-0">
{{--            <img src="{{ asset('frontend-images/bg-img.jpg') }}"  loading="lazy" alt="" class="hero-bg">--}}

            <div class="container">
                <div class="row gy-4 justify-content-between">
                    <div class="col-lg-6 order-lg-last hero-img text-end home-hero-img d-none d-lg-block" data-aos="zoom-out" data-aos-delay="100">
                        <img src="{{ $setting->header_banner_img }}" class="img-fluid animated" alt=""  loading="lazy"><!--animated-->
                    </div>

                    <div class="col-lg-6 d-flex flex-column justify-content-center mt-0" data-aos="fade-in">
                        <h1>{{ $setting->header_heading }}<span class="ms-2">{{ $setting->header_highlight }}</span></h1>
                        <p>{{ $setting->search_bar_heading }}<b class="text-dark ms-2">{{ $setting->search_bar_highlight }}</b></p>
                        <x-search-form :uniqueId="1"/>
                        <div class="d-none d-lg-block">
                            <img src="{{ asset('frontend-images/arrow-down.png') }}" class="img-responsive" width="200" alt=""  loading="lazy">
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->



        <!-- Popular Categories -->
            @include('frontend.partials._popular-categories')

            <div class="container section-title mt-5 mobile-category pb-0" style="display: none" data-aos="fade-up">
                <div class="d-flex flex-sm-row justify-content-between">
                    <div><span class="description-title">Categories</span></div>
                    <a href="{{ route('frontend.browse-listings.index') }}" class="btn text-decoration-none border-0">
                        <h5 class="text-common-blue fw-bold"><i class="bi bi-arrow-right-circle"></i> View All</h5>
                    </a>
                </div>
                <section class="features section py-5">
                    <div class="row gy-3 text-center">
                        @php
                            $popularCategories = \App\Models\Category::whereNull('parent_id')->limit(9)->get();
                        @endphp
                        @foreach($popularCategories as $category)
                            @if($category)
                                <div class="col-4 col-sm-3 col-md-2 d-flex justify-content-center mb-3">
                                    <a href="{{ route('frontend.browse-listings.index', ['category' => $category->name]) }}" class="text-decoration-none">
                                        <div class="card shadow-sm border-0" style="width: 100px; height: 100px;">
                                            <div class="card-body d-flex flex-column align-items-center p-2">
                                                <img src="{{ isset($category->icon) ? url($category->icon) : asset('frontend-images/location-img.png') }}"
                                                     loading="lazy" style="width: 60%; height: auto;">
                                                <p style="font-size: 10px;width:80px;" class="text-dark mt-1 text-truncate">{{ $category->name }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </section>
            </div>

        <!--Banner for web view and mobile view-->
           <div class="container mobile-banner d-flex justify-content-center" style="display: none">
               @if($setting->homepage_banner_mobile_show)
                   <a target="_blank" href="{{ $setting->homepage_banner_mobile_link }}">
                       <img src="{{ $setting->homepage_banner_mobile }}" alt="" class="img-fluid img-responsive mb-5"  loading="lazy">
                   </a>
               @endif
           </div>
            <div class="container web-banner d-flex justify-content-center">
                @if($setting->homepage_banner_web_show)
                    <a target="_blank" href="{{ $setting->homepage_banner_web_link }}">
                        <img src="{{ $setting->homepage_banner_web }}" alt="" class="img-fluid img-responsive mb-5"  loading="lazy">
                    </a>
                @endif
            </div>

        <!-- Search By Location -->
        <section id="hero" class="hero section dark-background py-5">
            @php
                // Get the top 4 states with maximum user counts
                $topStates = \App\Models\User::has('serviceproviderprofile')
                ->join('service_provider_profiles', 'users.id', '=', 'service_provider_profiles.profileable_id') // Join with service_provider_profiles
                ->select('service_provider_profiles.state', \Illuminate\Support\Facades\DB::raw('COUNT(users.id) as user_count'))
                ->where('users.role', 'service-provider')
                ->where('users.status', 'verified')
                ->groupBy('service_provider_profiles.state')
                ->orderBy('user_count', 'desc')
                ->take(4)
                ->get();
                $topStates = $topStates->toArray();
            @endphp

            @if(isset($setting->search_by_location_bg_img))
                <img src="{{ $setting->search_by_location_bg_img }}" alt="" class="hero-bg"  loading="lazy">
            @endif
                <div class="container">
                    <div class="row gy-2">
                        <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-in">
                            <h1>SEARCH BY LOCATION</h1>
                            <x-search-form :uniqueId="2"/>
                            <p>{{ $setting->search_by_location_text }}</p>
                        </div>
                        <div class="col-lg-6 d-flex justify-content-center">
                            <div class="box-row-div" style="min-width: 60%">
                                <div class="row box-row-height">
                                    <div class="col-lg-12">
                                        @if(array_key_exists(0,$topStates))
                                            <a href="{{ route('frontend.browse-listings.index',['location'=>$topStates[0]['state']]) }}" title="{{ $topStates[0]['state'] }}">
                                                <div class="box box-first">
                                                    <img src="{{ getStateImage($topStates[0]['state']) }}" alt="{{ $topStates[0]['state'] }}"  loading="lazy">
                                                    <div class="overlay">
                                                        <h3 class="big-font truncate">{{ $topStates[0]['state'] }}</h3>
                                                        <small>{{ $topStates[0]['user_count'] }} Vendors</small>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                        @if(array_key_exists(1,$topStates))
                                            <a href="{{ route('frontend.browse-listings.index',['location'=>$topStates[1]['state']]) }}" title="{{ $topStates[1]['state'] }}">
                                                <div class="box box-second">
                                                    <img src="{{ getStateImage($topStates[1]['state']) }}" alt="{{ $topStates[1]['state'] }}"  loading="lazy">
                                                    <div class="overlay">
                                                        <h3 class="small-font truncate">{{ $topStates[1]['state'] }}</h3>
                                                        <small>{{ $topStates[1]['user_count'] }} Vendors</small>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="row box-row-height">
                                    <div class="col-lg-12">
                                        @if(array_key_exists(2,$topStates))
                                            <a href="{{ route('frontend.browse-listings.index',['location'=>$topStates[2]['state']]) }}" title="{{ $topStates[2]['state'] }}">
                                                <div class="box box-third">
                                                    <img src="{{ getStateImage($topStates[2]['state']) }}" alt="{{ $topStates[2]['state'] }}"  loading="lazy">
                                                    <div class="overlay">
                                                        <h3 class="small-font truncate">{{ $topStates[2]['state'] }}</h3>
                                                        <small>{{ $topStates[2]['user_count'] }} Vendors</small>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                        @if(array_key_exists(3,$topStates))
                                            <a href="{{ route('frontend.browse-listings.index',['location'=>$topStates[3]['state']]) }}" title="{{ $topStates[3]['state'] }}">
                                                <div class="box box-forth">
                                                    <img src="{{ getStateImage($topStates[3]['state']) }}" alt="{{ $topStates[3]['state'] }}"  loading="lazy">
                                                    <div class="overlay">
                                                        <h3 class="big-font truncate">{{ $topStates[3]['state'] }}</h3>
                                                        <small>{{ $topStates[3]['user_count'] }} Vendors</small>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- /Hero Section -->

        <!--Ad Space-->
        @php
            $advertisements = \App\Models\Advertisement::where('display_on_page','Home Page')->where('is_enabled',1)->get();
        @endphp

        @if(count($advertisements))
                <div class="container mt-5">
                    <div class="row">
                        @foreach($advertisements as $advertisement)
                            <div class="col-lg-4 mb-3">
                                <div class="card p-0 rounded-5">
                                        <div class="card-body p-0 rounded-5">
                                            <a href="{{ $advertisement->ad_url }}" target="_blank">
                                                <img src="{{ url($advertisement->ad_url) }}" class="img img-responsive w-100 rounded-5"  loading="lazy">
                                            </a>
                                        </div>
                                    </div>
                            </div>
                        @endforeach
                    </div>
                </div>
        @endif

        <!-- Featured Service Providers Section -->
        <section id="featured-provider" class="team section light-background py-5">

            <!-- Section Title -->
            <div class="container section-title text-center" data-aos="fade-up">
                <h1 class="fw-bold"><span class="description-title">{{ $setting->featured_provider_heading }}</span></h1>
                <p class="text-wrap">{{ $setting->featured_provider_subheading }}</p>
            </div><!-- End Section Title -->

            <div class="container-fluid">
                <!--Carousel 1-->
                <div class="row">
                   @php
                       $serviceProviders = \App\Models\User::has('serviceproviderprofile')
                           ->with(['serviceproviderprofile' => function ($query) {
                               $query->inRandomOrder();
                           }])
                           ->where('role', 'service-provider')
                           ->where('status', 'verified')
                           ->activeSubscription()
                           ->inRandomOrder()
                           ->limit(10)
                           ->get();

                        $manageAD= \App\Models\Advertisement::where('is_enabled',1)->latest()->get();
                        $adIndex = 0;
                         //$serviceProviders = \App\Models\User::has('serviceproviderprofile')->with('serviceproviderprofile')->where('role','service-provider')->where('status','verified')->activeSubscription()->get();
                          // $serviceProviders = \App\Models\User::has('serviceproviderprofile')->with('serviceproviderprofile')->where('role','service-provider')->get();
                   @endphp
                    @if(isset($serviceProviders))
                        <div class="main-content owl-smooth">
                            <div class="owl-carousel owl-theme" id="owl-2">
                                @foreach($serviceProviders as $index => $serviceProvider)
                                    @include('frontend.partials._explore-carousel-1')

                                    @if(($index + 1) % 3 == 0 && isset($manageAD[$adIndex]))
{{--                                        <div class="card-container shadow-sm">--}}
{{--                                            <div class="cardd ad-card bg-light text-center p-3">--}}
{{--                                                <h5 class="mb-2"></h5>--}}
{{--                                                <p class="mb-2">{{ $manageAD[$adIndex]->description }}</p>--}}
{{--                                                @if($manageAD[$adIndex]->ad_url)--}}
{{--                                                    <img src="{{ asset($manageAD[$adIndex]->ad_url) }}" alt="Ad Image" style="max-height: 120px; width: auto;">--}}
{{--                                                @endif--}}
{{--                                                @if($manageAD[$adIndex]->link)--}}
{{--                                                    <a href="{{ $manageAD[$adIndex]->link }}" target="_blank" class="btn btn-primary btn-sm mt-2">Learn More</a>--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <div class="card-container shadow-sm">
                                            <div class="cardd ad-card bg-light text-center p-3 position-relative">
                                                <!-- Ad badge on top-right -->
                                                <span class="badge bg-warning text-dark position-absolute" style="top: 10px; right: 10px; font-weight: bold; font-size: 0.8rem;">
                                                    Ad
                                                </span>

                                                <h5 class="mb-2">{{ $manageAD[$adIndex]->title ?? 'Advertisement' }}</h5>
                                                <p class="mb-2">{{ $manageAD[$adIndex]->description }}</p>
                                                @if($manageAD[$adIndex]->ad_url)
                                                    <img src="{{ asset($manageAD[$adIndex]->ad_url) }}" alt="Ad Image" style="max-height: 120px; width: auto;">
                                                @endif
                                                @if($manageAD[$adIndex]->link)
                                                    <a href="{{ $manageAD[$adIndex]->link }}" target="_blank" class="btn btn-primary btn-sm mt-2">Learn More</a>
                                                @endif
                                            </div>
                                        </div>
                                        @php $adIndex++; @endphp
                                    @endif

                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
                <!--Carousel 2-->
                <div class="row mt-3">
                    @php
                         //$serviceProviders = \App\Models\User::has('serviceproviderprofile')->with('serviceproviderprofile')->where('role','service-provider')->where('status','verified')->activeSubscription()->get();
                         $serviceProviders = \App\Models\User::has('serviceproviderprofile')->with('serviceproviderprofile')->where('role','service-provider')->where('status', 'verified')->inRandomOrder()
                           ->limit(10)->get();

                         $manageAD1 = \App\Models\Advertisement::where('is_enabled',1)->get();
                         $adIndex1 = 0;

                    @endphp
                    @if(isset($serviceProviders))
                        <div class="main-content">
                            <div class="owl-carousel owl-theme" id="owl-3">
                                @foreach($serviceProviders as  $index => $serviceProvider)
                                    @include('frontend.partials._explore-carousel-2')

                                    @if(($index + 1) % 3 == 0 && isset($manageAD1[$adIndex1]))

                                        <div class="card-container shadow-sm">
                                            <div class="cardd ad-card bg-light text-center p-3 position-relative">
                                                <!-- Ad badge on top-right -->
                                                <span class="badge bg-warning text-dark position-absolute" style="top: 10px; right: 10px; font-weight: bold; font-size: 0.8rem;">
                                                    Ad
                                                </span>

                                                <h5 class="mb-2">{{ $manageAD1[$adIndex1]->title ?? 'Advertisement' }}</h5>
                                                <p class="mb-2">{{ $manageAD1[$adIndex1]->description }}</p>
                                                @if($manageAD1[$adIndex1]->ad_url)
                                                    <img src="{{ asset($manageAD1[$adIndex1]->ad_url) }}" alt="Ad Image" style="max-height: 120px; width: auto;">
                                                @endif
                                                @if($manageAD1[$adIndex1]->link)
                                                    <a href="{{ $manageAD1[$adIndex1]->link }}" target="_blank" class="btn btn-primary btn-sm mt-2">Learn More</a>
                                                @endif
                                            </div>
                                        </div>

{{--                                        <div class="card-container shadow-sm">--}}
{{--                                            <div class="cardd ad-card bg-light text-center p-3">--}}
{{--                                                <h5 class="mb-2"></h5>--}}
{{--                                                <p class="mb-2">{{ $manageAD1[$adIndex1]->description }}</p>--}}
{{--                                                @if($manageAD1[$adIndex1]->ad_url)--}}
{{--                                                    <img src="{{ asset($manageAD1[$adIndex1]->ad_url) }}" alt="Ad Image" style="max-height: 120px; width: auto;">--}}
{{--                                                @endif--}}
{{--                                                @if($manageAD1[$adIndex1]->link)--}}
{{--                                                    <a href="{{ $manageAD1[$adIndex1]->link }}" target="_blank" class="btn btn-primary btn-sm mt-2">Learn More</a>--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        @php $adIndex1++; @endphp
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </section>

        <!-- DIGITAL ENGAGEMENT ANALYTICS Section -->
        @if($setting->show_analytics)
        <section id="digital-enagagement" class="team section light-background bg-white">
            <!-- Section Title -->
            <div class="container section-title text-center" data-aos="fade-up">
                <h2>ANALYTICS</h2>
                <h1 class="fw-bold"><span class="description-title">{{ $setting->analytics_heading }}</span></h1>
                <p class="text-wrap">{{ $setting->analytics_subheading }}</p>
            </div><!-- End Section Title -->
            <div class="container">
                <div class="row text-center">
                    <div class="col-lg-3">
                        <h1 class="display-2 fw-bold">{{ $setting->analytics_total_listing }}</h1>
                        <h6>Total Listing</h6>
                    </div>
                    <div class="col-lg-3">
                        <h1 class="display-2 fw-bold">{{ $setting->analytics_search_traffic }}</h1>
                        <h6>Search Traffic</h6>
                    </div>
                    <div class="col-lg-3">
                        <h1 class="display-2 fw-bold">{{ $setting->analytics_online_impression }}</h1>
                        <h6>Oline Impression</h6>
                    </div>
                    <div class="col-lg-3">
                        <h1 class="display-2 fw-bold">{{ $setting->analytics_organic_traffic }}</h1>
                        <h6>Organic Traffic</h6>
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- CONTACT SECTION-->
            <section id="contact" class="contact section bg-white py-5">

                <div class="container aos-init aos-animate" data-aos="fade" data-aos-delay="100">

                    <div class="">
                        <div class="card border-0">
                            <div class="card-body p-0 p-md-3">
                                @include('frontend.partials._contact-us-form')
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @if(!session('bottom_left_promo'))
        <div class="bottom-left-div" id="fixedDiv">
            <button class="close-btn" id="closeBtn">×</button>
            <h4 class="text-white fw-semibold mt-3 text-shadow">Transform your service business with CTRLF</h4>
            <h6 class="text-white mt-3 text-shadow">Grow your Business in 3 easy steps</h6>
            @if(auth()->check() && auth()->user()->isUser())
                <a href="javascript:void(0)" id="switch-user" data-id="{{ auth()->user()->id }}" class="btn btn-outline-light border-2 rounded-4 mt-2 shadow-sm">List your Business Here <i class="bi bi-arrow-up-right-circle"></i></a>
            @else
                <a href="{{ route("frontend.business-listings.createOrUpdate") }}" class="btn btn-outline-light border-2 rounded-4 mt-2 shadow-sm">List your Business Here <i class="bi bi-arrow-up-right-circle"></i></a>
            @endif
        </div>
        @endif
    </div>

@endsection
@push('js')
    <script type="module">
        $(function () {

            const fixedDiv = document.getElementById('fixedDiv');
            const closeBtn = document.getElementById('closeBtn');

            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    fixedDiv.style.display = 'none';

                    $.ajax({
                        url: "{{ route('frontend.modal.close') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            modal: 'bottom_left_promo'
                        },
                    });
                });
            }


            @if(auth()->check() && auth()->user()->isUser())
                document.addEventListener('click', function (e) {
                if (e.target.matches('#switch-user')) {
                    e.preventDefault(); // Prevent default anchor behavior
                    let id = e.target.getAttribute('data-id'); // Get user ID
                    $.easyDelete({
                        url: route('switch.user-profile', {user: id}),
                        type:'POST',
                        confirmationMessage: 'Do you really want to become Service Provider ?',
                        confirmationButtonText: 'Yes, want to switch!',
                        onComplete: () => {
                            window.location.href = route('frontend.business-listings.createOrUpdate');
                        }
                    });
                }
            });
            @endif

        });
    </script>
@endpush
