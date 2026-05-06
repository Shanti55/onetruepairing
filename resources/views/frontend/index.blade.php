@extends('frontend.layouts.app')

@section('title', 'CtrlF')

@section('content')

<div class="container-fluid p-0 m-0">
    <main class="main">

    {{-- ── Hero Section ── --}}
   {{-- Hero Section replace karo pura --}}
<section id="hero" class="hero section pb-0" style="padding:0;margin:0;">

    {{-- Full Width Slider --}}
    <div id="heroBannerSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000"
         style="width:100%;overflow:hidden;">

        <div class="carousel-inner">

            {{-- ── Slide 1 ── --}}
            <div class="carousel-item active">
                <div style="background:linear-gradient(105deg,#0d1b4b 0%,#1e3a8a 45%,#2563eb 75%,#3b82f6 100%);min-height:500px;position:relative;overflow:hidden;display:flex;align-items:center;">

                    {{-- Diagonal shape right --}}
                    <div style="position:absolute;right:0;top:0;bottom:0;width:45%;background:linear-gradient(120deg,transparent 20%,rgba(37,99,235,0.4) 40%,#1d4ed8 70%,#2563eb 100%);clip-path:polygon(20% 0%,100% 0%,100% 100%,0% 100%);"></div>

                    {{-- Dots pattern --}}
                    <div style="position:absolute;right:0;top:0;width:80px;height:100%;background:repeating-linear-gradient(0deg,rgba(255,255,255,0.08) 0,rgba(255,255,255,0.08) 2px,transparent 2px,transparent 16px);"></div>

                    <div class="container position-relative" style="z-index:2;padding:3rem 1.5rem;">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-7">
                                <p style="color:#93c5fd;font-size:13px;letter-spacing:2px;text-transform:uppercase;margin-bottom:10px; padding-top:50px;">
                                    India's #1 Reverse Auction Platform
                                </p>
                                <h1 style="color:#fff;font-size:clamp(1.8rem,4vw,2.8rem);font-weight:800;line-height:1.15;margin-bottom:10px;">
                                    {{ $setting->header_heading }}
                                    <span style="color:#fbbf24;"> {{ $setting->header_highlight }}</span>
                                </h1>
                                <p style="color:#bfdbfe;font-size:15px;margin-bottom:2rem;max-width:480px;line-height:1.65;">
                                    {{ $setting->search_bar_heading }}
                                    <b style="color:#fff;">{{ $setting->search_bar_highlight }}</b>
                                </p>

                                {{-- Steps --}}
                                <div style="display:flex;gap:1rem;flex-wrap:wrap;margin-bottom:2rem;">
                                    <div style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);border-radius:12px;padding:14px 18px;flex:1;min-width:130px;">
                                        <div style="width:32px;height:32px;background:#fbbf24;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;color:#1e3a8a;font-size:14px;margin-bottom:8px;">1</div>
                                        <div style="color:#fff;font-weight:700;font-size:13px;margin-bottom:4px;">Register</div>
                                        <div style="color:#93c5fd;font-size:11px;line-height:1.5;">Sign up and verify your account to get started.</div>
                                    </div>
                                    <div style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);border-radius:12px;padding:14px 18px;flex:1;min-width:130px;">
                                        <div style="width:32px;height:32px;background:#fbbf24;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;color:#1e3a8a;font-size:14px;margin-bottom:8px;">2</div>
                                        <div style="color:#fff;font-weight:700;font-size:13px;margin-bottom:4px;">Auction</div>
                                        <div style="color:#93c5fd;font-size:11px;line-height:1.5;">Browse live auctions and place your lowest bid.</div>
                                    </div>
                                    <div style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);border-radius:12px;padding:14px 18px;flex:1;min-width:130px;">
                                        <div style="width:32px;height:32px;background:#fbbf24;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;color:#1e3a8a;font-size:14px;margin-bottom:8px;">3</div>
                                        <div style="color:#fff;font-weight:700;font-size:13px;margin-bottom:4px;">Hire</div>
                                        <div style="color:#93c5fd;font-size:11px;line-height:1.5;">Win the auction and get hired for the job.</div>
                                    </div>
                                </div>

                                {{-- Search + CTA --}}
                                <x-search-form :uniqueId="1"/>
                                <div style="margin-top:1rem;">
                                    <a href="{{ route('frontend.jobs.index') }}"
                                       style="display:inline-block;background:#fbbf24;color:#1e3a8a;padding:14px 36px;border-radius:50px;font-weight:800;font-size:14px;letter-spacing:0.5px;text-decoration:none;transition:transform 0.2s;">
                                        Register to Start Bidding ›
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ── Slide 2 ── --}}
            <div class="carousel-item">
                <div style="background:linear-gradient(105deg,#1a0533 0%,#3b0f8c 45%,#6d28d9 75%,#7c3aed 100%);min-height:500px;position:relative;overflow:hidden;display:flex;align-items:center;">

                    <div style="position:absolute;right:0;top:0;bottom:0;width:45%;background:linear-gradient(120deg,transparent 20%,rgba(109,40,217,0.4) 40%,#5b21b6 70%,#6d28d9 100%);clip-path:polygon(20% 0%,100% 0%,100% 100%,0% 100%);"></div>
                    <div style="position:absolute;right:0;top:0;width:80px;height:100%;background:repeating-linear-gradient(0deg,rgba(255,255,255,0.06) 0,rgba(255,255,255,0.06) 2px,transparent 2px,transparent 16px);"></div>

                    {{-- Sound wave --}}
                    <div style="position:absolute;top:0;left:0;right:0;height:60px;display:flex;align-items:flex-end;gap:2px;padding:0;overflow:hidden;opacity:0.5;">
                        @for($i=0;$i<80;$i++)
                            <div style="flex:1;background:linear-gradient(to top,#ec4899,transparent);height:{{ rand(10,55) }}px;border-radius:1px;"></div>
                        @endfor
                    </div>

                    <div class="container position-relative" style="z-index:2;padding:3rem 1.5rem;">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-7">
                               
                                <h1 style="color:#fff;font-size:clamp(1.8rem,4vw,2.8rem);font-weight:800;line-height:1.15;margin-bottom:10px;font-family:'Impact',sans-serif;letter-spacing:1px;text-shadow:2px 2px 0 #4c1d95; padding-top:50px;">
                                    INDIA'S SMARTEST<br>
                                    <span style="color:#a78bfa;">REVERSE AUCTION</span><br>
                                    MARKETPLACE
                                </h1>
                                <p style="color:#ddd6fe;font-size:14px;margin-bottom:2rem;line-height:1.65;max-width:440px;">
                                    Post your requirements and let verified vendors compete to give you the lowest price.
                                </p>

                                <div style="display:flex;gap:1rem;flex-wrap:wrap;margin-bottom:2rem;">
                                    <div style="background:rgba(109,40,217,0.7);border:1px solid #2b49f1;border-radius:10px;padding:14px 18px;flex:1;min-width:130px;">
                                        <div style="width:32px;height:32px;background:#a78bfa;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;color:#1e0050;font-size:14px;margin-bottom:8px;">1</div>
                                        <div style="color:#fff;font-weight:700;font-size:13px;margin-bottom:4px;">Register</div>
                                        <div style="color:#c4b5fd;font-size:11px;line-height:1.5;">Create your vendor account in minutes.</div>
                                    </div>
                                    <div style="background:rgba(109,40,217,0.5);border:1px solid #2222f3;border-radius:10px;padding:14px 18px;flex:1;min-width:130px;">
                                        <div style="width:32px;height:32px;background:#a78bfa;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;color:#1e0050;font-size:14px;margin-bottom:8px;">2</div>
                                        <div style="color:#fff;font-weight:700;font-size:13px;margin-bottom:4px;">Bid</div>
                                        <div style="color:#c4b5fd;font-size:11px;line-height:1.5;">Place the lowest bid and stand out from competition.</div>
                                    </div>
                                    <div style="background:rgba(64, 29, 237, 0.3);border:1px solid #4828fb;border-radius:10px;padding:14px 18px;flex:1;min-width:130px;">
                                        <div style="width:32px;height:32px;background:#a78bfa;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;color:#1e0050;font-size:14px;margin-bottom:8px;">3</div>
                                        <div style="color:#fff;font-weight:700;font-size:13px;margin-bottom:4px;">Win</div>
                                        <div style="color:#c4b5fd;font-size:11px;line-height:1.5;">Win the auction and grow your business.</div>
                                    </div>
                                </div>

                                <a href="{{ route('frontend.jobs.index') }}"
                                   style="display:inline-block;background:linear-gradient(135deg,#7c3aed,#db2777);color:#fff;padding:14px 36px;border-radius:50px;font-weight:800;font-size:14px;text-decoration:none;letter-spacing:0.5px;">
                                    View Live Auctions →
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ── Slide 3 ── --}}
            <div class="carousel-item">
                <div style="background:linear-gradient(105deg,#0f172a 0%,#1e293b 45%,#334155 75%,#475569 100%);min-height:500px;position:relative;overflow:hidden;display:flex;align-items:center;">

                    <div style="position:absolute;right:0;top:0;bottom:0;width:45%;background:linear-gradient(120deg,transparent 20%,rgba(51,65,85,0.4) 40%,#1e293b 70%,#334155 100%);clip-path:polygon(20% 0%,100% 0%,100% 100%,0% 100%);"></div>
                    <div style="position:absolute;right:0;top:0;width:80px;height:100%;background:repeating-linear-gradient(0deg,rgba(255,255,255,0.05) 0,rgba(255,255,255,0.05) 2px,transparent 2px,transparent 16px);"></div>

                    <div class="container position-relative" style="z-index:2;padding:3rem 1.5rem;">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-7">
                                <p style="color:#94a3b8;font-size:13px;letter-spacing:2px;text-transform:uppercase;margin-bottom:10px; padding-top:50px;">
                                    Trusted by 500+ Vendors Across India
                                </p>
                                <h1 style="color:#fff;font-size:clamp(1.8rem,4vw,2.6rem);font-weight:800;line-height:1.2;margin-bottom:12px;">
                                    Find The Best Vendor<br>
                                    <span style="color:#38bdf8;">At The Lowest Price</span>
                                </h1>
                                <p style="color:#cbd5e1;font-size:14px;margin-bottom:2rem;line-height:1.65;max-width:440px;">
                                    India's most trusted reverse auction marketplace. Post a job, get bids, hire the best.
                                </p>

                                {{-- Stats row --}}
                                <div style="display:flex;gap:1.5rem;flex-wrap:wrap;margin-bottom:2rem;padding:1.2rem;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:14px;">
                                    <div style="text-align:center;flex:1;">
                                        <div style="color:#fff;font-size:1.8rem;font-weight:800;line-height:1;">500+</div>
                                        <div style="color:#94a3b8;font-size:11px;letter-spacing:1px;text-transform:uppercase;margin-top:2px;">Vendors</div>
                                    </div>
                                    <div style="width:1px;background:rgba(255,255,255,0.15);"></div>
                                    <div style="text-align:center;flex:1;">
                                        <div style="color:#fff;font-size:1.8rem;font-weight:800;line-height:1;">1000+</div>
                                        <div style="color:#94a3b8;font-size:11px;letter-spacing:1px;text-transform:uppercase;margin-top:2px;">Auctions</div>
                                    </div>
                                    <div style="width:1px;background:rgba(255,255,255,0.15);"></div>
                                    <div style="text-align:center;flex:1;">
                                        <div style="color:#fff;font-size:1.8rem;font-weight:800;line-height:1;">24/7</div>
                                        <div style="color:#94a3b8;font-size:11px;letter-spacing:1px;text-transform:uppercase;margin-top:2px;">Support</div>
                                    </div>
                                    <div style="width:1px;background:rgba(255,255,255,0.15);"></div>
                                    <div style="text-align:center;flex:1;">
                                        <div style="color:#38bdf8;font-size:1.8rem;font-weight:800;line-height:1;">₹0</div>
                                        <div style="color:#94a3b8;font-size:11px;letter-spacing:1px;text-transform:uppercase;margin-top:2px;">Listing Fee</div>
                                    </div>
                                </div>

                                <x-search-form :uniqueId="3"/>
                                <div style="margin-top:1rem;">
                                    <a href="{{ route('service-providers.dashboard') }}"
                                       style="display:inline-block;background:#38bdf8;color:#0f172a;padding:14px 36px;border-radius:50px;font-weight:800;font-size:14px;text-decoration:none;">
                                        Start Winning Jobs Today ›
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        {{-- Prev/Next --}}
        <button class="carousel-control-prev" type="button"
                data-bs-target="#heroBannerSlider" data-bs-slide="prev"
                style="width:44px;height:44px;background:rgba(0,0,0,0.4);border-radius:50%;top:50%;transform:translateY(-50%);left:16px;border:none;">
            <span class="carousel-control-prev-icon" style="width:14px;height:14px;"></span>
        </button>
        <button class="carousel-control-next" type="button"
                data-bs-target="#heroBannerSlider" data-bs-slide="next"
                style="width:44px;height:44px;background:rgba(0,0,0,0.4);border-radius:50%;top:50%;transform:translateY(-50%);right:16px;border:none;">
            <span class="carousel-control-next-icon" style="width:14px;height:14px;"></span>
        </button>

        {{-- Dot Indicators --}}
        <div class="carousel-indicators" style="bottom:14px;margin:0;">
            <button type="button" data-bs-target="#heroBannerSlider" data-bs-slide-to="0"
                    class="active" style="width:10px;height:10px;border-radius:50%;background:#fbbf24;border:none;"></button>
            <button type="button" data-bs-target="#heroBannerSlider" data-bs-slide-to="1"
                    style="width:10px;height:10px;border-radius:50%;background:rgba(255,255,255,0.5);border:none;"></button>
            <button type="button" data-bs-target="#heroBannerSlider" data-bs-slide-to="2"
                    style="width:10px;height:10px;border-radius:50%;background:rgba(255,255,255,0.5);border:none;"></button>
        </div>

    </div>

</section>
    {{-- /Hero Section --}}

    {{-- ── Popular Categories ── --}}
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
                @php $popularCategories = \App\Models\Category::whereNull('parent_id')->limit(9)->get(); @endphp
                @foreach($popularCategories as $category)
                    @if($category)
                        <div class="col-4 col-sm-3 col-md-2 d-flex justify-content-center mb-3">
                            <a href="{{ route('frontend.browse-listings.index', ['category' => $category->name]) }}" class="text-decoration-none">
                                <div class="card shadow-sm border-0" style="width:100px;height:100px;">
                                    <div class="card-body d-flex flex-column align-items-center p-2">
                                        <img src="{{ isset($category->icon) ? url($category->icon) : asset('frontend-images/location-img.png') }}"
                                             loading="lazy" style="width:60%;height:auto;">
                                        <p style="font-size:10px;width:80px;" class="text-dark mt-1 text-truncate">{{ $category->name }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
    </div>

    {{-- ── Banners ── --}}
    <div class="container mobile-banner d-flex justify-content-center" style="display:none">
        @if($setting->homepage_banner_mobile_show)
            <a target="_blank" href="{{ $setting->homepage_banner_mobile_link }}">
                <img src="{{ $setting->homepage_banner_mobile }}" alt="" class="img-fluid img-responsive mb-5" loading="lazy">
            </a>
        @endif
    </div>
    <div class="container web-banner d-flex justify-content-center">
        @if($setting->homepage_banner_web_show)
            <a target="_blank" href="{{ $setting->homepage_banner_web_link }}">
                <img src="{{ $setting->homepage_banner_web }}" alt="" class="img-fluid img-responsive mb-5" loading="lazy">
            </a>
        @endif
    </div>

    {{-- ── Search By Location ── --}}
    <section id="hero" class="hero section dark-background py-5">
        @php
            $topStates = \App\Models\User::has('serviceproviderprofile')
                ->join('service_provider_profiles','users.id','=','service_provider_profiles.profileable_id')
                ->select('service_provider_profiles.state', \Illuminate\Support\Facades\DB::raw('COUNT(users.id) as user_count'))
                ->where('users.role','service-provider')
                ->where('users.status','verified')
                ->groupBy('service_provider_profiles.state')
                ->orderBy('user_count','desc')
                ->take(4)
                ->get()
                ->toArray();
        @endphp

        @if(isset($setting->search_by_location_bg_img))
            <img src="{{ $setting->search_by_location_bg_img }}" alt="" class="hero-bg" loading="lazy">
        @endif
        <div class="container">
            <div class="row gy-2">
                <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-in">
                    <h1>SEARCH BY LOCATION</h1>
                    <x-search-form :uniqueId="2"/>
                    <p>{{ $setting->search_by_location_text }}</p>
                </div>
                <div class="col-lg-6 d-flex justify-content-center">
                    <div class="box-row-div" style="min-width:60%">
                        <div class="row box-row-height">
                            <div class="col-lg-12">
                                @if(array_key_exists(0,$topStates))
                                    <a href="{{ route('frontend.browse-listings.index',['location'=>$topStates[0]['state']]) }}" title="{{ $topStates[0]['state'] }}">
                                        <div class="box box-first">
                                            <img src="{{ getStateImage($topStates[0]['state']) }}" alt="{{ $topStates[0]['state'] }}" loading="lazy">
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
                                            <img src="{{ getStateImage($topStates[1]['state']) }}" alt="{{ $topStates[1]['state'] }}" loading="lazy">
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
                                            <img src="{{ getStateImage($topStates[2]['state']) }}" alt="{{ $topStates[2]['state'] }}" loading="lazy">
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
                                            <img src="{{ getStateImage($topStates[3]['state']) }}" alt="{{ $topStates[3]['state'] }}" loading="lazy">
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

    {{-- ── Ad Space ── --}}
    @php $advertisements = \App\Models\Advertisement::where('display_on_page','Home Page')->where('is_enabled',1)->get(); @endphp
    @if(count($advertisements))
        <div class="container mt-5">
            <div class="row">
                @foreach($advertisements as $advertisement)
                    <div class="col-lg-4 mb-3">
                        <div class="card p-0 rounded-5">
                            <div class="card-body p-0 rounded-5">
                                <a href="{{ $advertisement->ad_url }}" target="_blank">
                                    <img src="{{ url($advertisement->ad_url) }}" class="img img-responsive w-100 rounded-5" loading="lazy">
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ── Featured Service Providers ── --}}
    <section id="featured-provider" class="team section light-background py-5">
        <div class="container section-title text-center" data-aos="fade-up">
            <h1 class="fw-bold"><span class="description-title">{{ $setting->featured_provider_heading }}</span></h1>
            <p class="text-wrap">{{ $setting->featured_provider_subheading }}</p>
        </div>

        <div class="container-fluid">

            {{-- Carousel 1 --}}
            <div class="row">
                @php
                    $serviceProviders = \App\Models\User::has('serviceproviderprofile')
                        ->with(['serviceproviderprofile' => function($q){ $q->inRandomOrder(); }])
                        ->where('role','service-provider')
                        ->where('status','verified')
                        ->activeSubscription()
                        ->inRandomOrder()
                        ->limit(10)
                        ->get();
                    $manageAD  = \App\Models\Advertisement::where('is_enabled',1)->latest()->get();
                    $adIndex   = 0;
                @endphp
                @if(isset($serviceProviders))
                    <div class="main-content owl-smooth">
                        <div class="owl-carousel owl-theme" id="owl-2">
                            @foreach($serviceProviders as $index => $serviceProvider)
                                @include('frontend.partials._explore-carousel-1')
                                @if(($index + 1) % 3 == 0 && isset($manageAD[$adIndex]))
                                    <div class="card-container shadow-sm">
                                        <div class="cardd ad-card bg-light text-center p-3 position-relative">
                                            <span class="badge bg-warning text-dark position-absolute" style="top:10px;right:10px;font-weight:bold;font-size:0.8rem;">Ad</span>
                                            <h5 class="mb-2">{{ $manageAD[$adIndex]->title ?? 'Advertisement' }}</h5>
                                            <p class="mb-2">{{ $manageAD[$adIndex]->description }}</p>
                                            @if($manageAD[$adIndex]->ad_url)
                                                <img src="{{ asset($manageAD[$adIndex]->ad_url) }}" alt="Ad Image" style="max-height:120px;width:auto;">
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

            {{-- Carousel 2 --}}
            <div class="row mt-3">
                @php
                    $serviceProviders = \App\Models\User::has('serviceproviderprofile')
                        ->with('serviceproviderprofile')
                        ->where('role','service-provider')
                        ->where('status','verified')
                        ->inRandomOrder()
                        ->limit(10)
                        ->get();
                    $manageAD1 = \App\Models\Advertisement::where('is_enabled',1)->get();
                    $adIndex1  = 0;
                @endphp
                @if(isset($serviceProviders))
                    <div class="main-content">
                        <div class="owl-carousel owl-theme" id="owl-3">
                            @foreach($serviceProviders as $index => $serviceProvider)
                                @include('frontend.partials._explore-carousel-2')
                                @if(($index + 1) % 3 == 0 && isset($manageAD1[$adIndex1]))
                                    <div class="card-container shadow-sm">
                                        <div class="cardd ad-card bg-light text-center p-3 position-relative">
                                            <span class="badge bg-warning text-dark position-absolute" style="top:10px;right:10px;font-weight:bold;font-size:0.8rem;">Ad</span>
                                            <h5 class="mb-2">{{ $manageAD1[$adIndex1]->title ?? 'Advertisement' }}</h5>
                                            <p class="mb-2">{{ $manageAD1[$adIndex1]->description }}</p>
                                            @if($manageAD1[$adIndex1]->ad_url)
                                                <img src="{{ asset($manageAD1[$adIndex1]->ad_url) }}" alt="Ad Image" style="max-height:120px;width:auto;">
                                            @endif
                                            @if($manageAD1[$adIndex1]->link)
                                                <a href="{{ $manageAD1[$adIndex1]->link }}" target="_blank" class="btn btn-primary btn-sm mt-2">Learn More</a>
                                            @endif
                                        </div>
                                    </div>
                                    @php $adIndex1++; @endphp
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </section>

    {{-- ── Analytics ── --}}
    @if($setting->show_analytics)
    <section id="digital-enagagement" class="team section light-background bg-white">
        <div class="container section-title text-center" data-aos="fade-up">
            <h2>ANALYTICS</h2>
            <h1 class="fw-bold"><span class="description-title">{{ $setting->analytics_heading }}</span></h1>
            <p class="text-wrap">{{ $setting->analytics_subheading }}</p>
        </div>
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
                    <h6>Online Impression</h6>
                </div>
                <div class="col-lg-3">
                    <h1 class="display-2 fw-bold">{{ $setting->analytics_organic_traffic }}</h1>
                    <h6>Organic Traffic</h6>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ── Contact ── --}}
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

    {{-- ── Bottom Left Promo ── --}}
    @if(!session('bottom_left_promo'))
    <div class="bottom-left-div" id="fixedDiv">
        <button class="close-btn" id="closeBtn">×</button>
        <h4 class="text-white fw-semibold mt-3 text-shadow">Transform your service business with CTRLF</h4>
        <h6 class="text-white mt-3 text-shadow">Grow your Business in 3 easy steps</h6>
        @if(auth()->check() && auth()->user()->isUser())
            <a href="javascript:void(0)" id="switch-user" data-id="{{ auth()->user()->id }}"
               class="btn btn-outline-light border-2 rounded-4 mt-2 shadow-sm">
               List your Business Here <i class="bi bi-arrow-up-right-circle"></i>
            </a>
        @else
            <a href="{{ route('frontend.business-listings.createOrUpdate') }}"
               class="btn btn-outline-light border-2 rounded-4 mt-2 shadow-sm">
               List your Business Here <i class="bi bi-arrow-up-right-circle"></i>
            </a>
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
                    data: { _token: "{{ csrf_token() }}", modal: 'bottom_left_promo' },
                });
            });
        }

        @if(auth()->check() && auth()->user()->isUser())
            document.addEventListener('click', function (e) {
                if (e.target.matches('#switch-user')) {
                    e.preventDefault();
                    let id = e.target.getAttribute('data-id');
                    $.easyDelete({
                        url: route('switch.user-profile', { user: id }),
                        type: 'POST',
                        confirmationMessage: 'Do you really want to become Service Provider?',
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