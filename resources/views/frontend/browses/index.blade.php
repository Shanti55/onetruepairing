@extends('frontend.layouts.app')

@section('title', 'Service Provider Listings | CtrlF')

@section('content')
    <div x-data="listings" xmlns="http://www.w3.org/1999/html">
        <div class="container-fluid p-0 m-0">
            <main class="main">
                <!-- Hero Section -->
                <section id="hero" class="hero section bg-white text-center" style="min-height: 30vh!important;padding: 85px 0 10px 0!important;">
                    <div class="container">
                        <div class="row justify-content-center">
                            <p class="mb-2"><span class="text-dark fw-bold">SEARCH ACROSS "500+" </span><span class="fw-bold" style="color: var(--accent-color)">SERVICE PROVIDERS</span></p>
                            <div class="col-lg-6" data-aos="fade-in">
                                <x-search-form :uniqueId="1"/>
                            </div>
                        </div>
                    </div>
                </section><!-- /Hero Section -->
                <!--Slider-->

                <div class="container-fluid bg-white border-top sticky-div py-0">
                    <div class="container mt-4 text-center">
                        <!-- Card 1 -->
                        <div class="row gy-4 justify-content-between gx-2">
                            <div class="col-lg-12 m-0" id="categoryDiv" style="height: 65px;">
                                <div class="main-content px-5 d-none d-md-block">
                                    <div class="owl-carousel owl-theme owl-primary" id="owl-1">
                                        @foreach($categories as $index => $category)
                                            @if($category)
                                                <a href="#" @click.prevent="filterCategory('{{$category->name}}')">
                                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                                        <div class="card border-0">
                                                            <div class="card-body d-flex flex-column justify-content-center align-items-center p-2">
                                                                <img  loading="lazy" src="{{ isset($category->icon) ? url($category->icon) : asset('frontend-images/location-img.png') }}" class="object-fit-cover" height="25" width="25">
                                                            </div>
                                                        </div>
                                                        <small
                                                            class="text-secondary category-name"
                                                            :class="{'active-category': filters.category === '{{ $category->name }}'}">
                                                            {{$category->name}}
                                                        </small>
                                                    </div>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="owl-theme">
                                        <div class="owl-controls">
                                            <div class="custom-nav owl-nav" style="top: -35px!important;left: 0;right: 0;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 m-0 px-3 pt-2" id="searchDivRight" style="display: none">
                                <x-search-form :uniqueId="2"/>
                            </div>
                        </div>
{{--                        <template x-if="subcategories.length > 0 && !showSubCategories">--}}
{{--                            <div class="d-flex flex-column justify-content-center align-items-center">--}}
{{--                                <span class="badge bg-primary mt-1" style="cursor: pointer" @click="showSubCategories=!showSubCategories">Show Subcategories</span>--}}
{{--                                <i class="bi bi-chevron-compact-down text-primary fw-bold"></i>--}}
{{--                            </div>--}}
{{--                        </template>--}}
{{--                        <template x-if="subcategories.length > 0">--}}
{{--                            <div class="row card mt-2 rounded-5 shadow-sm" x-show="showSubCategories" x-transition>--}}
{{--                                <div class="col-lg-12 card-body m-0 d-flex flex-wrap justify-content-center gap-3 p-1">--}}
{{--                                    <template x-for="subcategory in subcategories" :key="subcategory.id">--}}
{{--                                        <a href="#" @click.prevent="filterSubCategory(subcategory.id)" class="subcategory-link">--}}
{{--                                            <div class="d-flex justify-content-center align-items-center">--}}
{{--                                                <div class="card border-0">--}}
{{--                                                    <div class="card-body d-flex flex-column justify-content-center align-items-center p-2">--}}
{{--                                                        <img :src="subcategory.icon" class="object-fit-cover" alt="" height="25" width="25">--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <small--}}
{{--                                                    class="text-secondary category-name"--}}
{{--                                                    :class="{'active-category': filters.subCategory.includes(subcategory.id)}">--}}
{{--                                                    <span x-text="subcategory.name"></span>--}}
{{--                                                </small>--}}
{{--                                            </div>--}}
{{--                                        </a>--}}
{{--                                    </template>--}}
{{--                                </div>--}}
{{--                                <div class="d-flex flex-column justify-content-center align-items-center">--}}
{{--                                    <i class="bi bi-chevron-compact-up text-primary fw-bold"></i>--}}
{{--                                    <span class="badge bg-primary mb-1" style="cursor: pointer" @click="showSubCategories=!showSubCategories">Hide Subcategories</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </template>--}}


                    </div>
                </div>
                <!--End Slider-->

                <section id="details" class="details section bg-white pt-5">

                    <div class="container">

                        <div class="row gy-5">

                            <!--Skeleton-->
                            <template x-if="loading">
                                <template x-for="i in 4">
                                    <div class="col-lg-3 col-md-3" data-aos="fade-up" data-aos-delay="100">
                                    <div class="card shadow is-loading rounded-5 border-0">
                                        <div class="pic rounded-5"></div>
                                        <div class="card-body content">
                                            <h1></h1>
                                            <div class="d-flex justify-content-start gap-2 mt-3">
                                                <h6 class="w-25"></h6>
                                                <h6 class="w-25"></h6>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                </template>
                            </template>
                            @php
                                $advertisements = \App\Models\Advertisement::where('display_on_page','Service Listing')->where('is_enabled',1)->get();
                            @endphp
                            <template x-if="!loading">
                                <template x-for="(listing, index) in listings" :key="listing.id">
                                        <div :class="Object.hasOwnProperty.call(advertisements, index) ? 'col-lg-12 ' : 'col-lg-3 col-md-6'" data-aos="fade-up" data-aos-delay="100"
                                             :id="'listing_'+listing.id" x-intersect="if(index+1 == listings.length) fetchMore()">
                                            <div x-show="Object.hasOwnProperty.call(advertisements, index)">
                                                    <div class="card p-0 rounded-5">
                                                    <div class="card-body p-0 rounded-5">
                                                        <a :href="advertisements[index].link" target="_blank">
                                                            <img  loading="lazy" :src="advertisements[index].ad_url" class="img img-responsive w-100 rounded-5">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div  x-show="!Object.hasOwnProperty.call(advertisements, index)">
                                                <div class="card-wrapper rounded-5 border" style="width: 100%!important;">
                                                    <div class="card-top">
                                                        <img  loading="lazy" :src="listing.serviceproviderprofile.cover_image" class="image" style="filter: none!important;">
                                                    </div>
                                                    <div class="card-bottom">
                                                        <div class="d-flex flex-column">
                                                            <span class="top-text mb-2" x-text="listing.serviceproviderprofile.company_name"></span>
                                                            <span class="mb-2"><i class="bi bi-patch-check-fill text-primary"></i> Verified</span>
                                                            <span class="mb-2"><i class="bi bi-geo-alt pe-2"></i><span x-text="listing.serviceproviderprofile.city"></span>, <span x-text="listing.serviceproviderprofile.state"></span></span>
                                                        </div>

                                                        <div class="d-flex justify-content-start gap-2 mb-2 overflow-hidden">
                                                            <template x-for="(item,i) in JSON.parse(listing.serviceproviderprofile.categories)" :key="item">
                                                                <span class="badge soft-secondary" style="font-style: normal" x-text="findCategory(item)"></span>
                                                            </template>
                                                        </div>
                                                        <br>
                                                        <a :href="route('frontend.service-providers.show',{'provider': listing.id})" class="btn btn-sm w-100 btn-primary">View Details</a>
                                                    </div>
                                                </div>
                                                <div class="mt-2 px-4 d-flex flex-column">
                                                    <h6 class="text-dark fw-bold mb-0" x-text="listing.serviceproviderprofile.company_name"></h6>
                                                    <div>
                                                        <template x-for="star in maxStars" :key="star">
                                                            <i class="bi star"
                                                               :class="{
                                                        'bi-star-fill': star <= Math.floor(listing.rating),
                                                        'bi-star-half': star > Math.floor(listing.rating) && star <= Math.ceil(listing.rating) && listing.rating % 1 !== 0,
                                                        'bi-star': star > Math.ceil(listing.rating)
                                                      }"
                                                            </i>
                                                        </template>
                                                    </div>
                                                    <small x-text="listing.serviceproviderprofile.company_description" style="display: -webkit-box;
                                        -webkit-line-clamp: 2;
                                        -webkit-box-orient: vertical;
                                        overflow: hidden;
                                        text-overflow: ellipsis;
                                        white-space: normal;">
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                </template>
                            </template>
                            <template x-if="!loading && listings.length === 0">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <img  loading="lazy" src="{{ asset('frontend-images/empty-box.png') }}" width="25%">
                                    <h1 class="mt-3">Sorry !! No Listing Found</h1>
                                </div>
                            </template>
                            <template x-if="loading1">
                                <template x-for="i in 4">
                                    <div class="col-lg-3 col-md-3" data-aos="fade-up" data-aos-delay="100">
                                        <div class="card shadow is-loading rounded-5 border-0">
                                            <div class="pic rounded-5"></div>
                                            <div class="card-body content">
                                                <h1></h1>
                                                <div class="d-flex justify-content-start gap-2 mt-3">
                                                    <h6 class="w-25"></h6>
                                                    <h6 class="w-25"></h6>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </template>

                        </div>
                    </div>
                </section>
                <button class="btn btn-dark btn-lg filter-button shadow rounded-4" data-bs-toggle="modal" data-bs-target="#myFilter"><h6 class="text-white mb-0"><i class="bi bi-sliders2"></i> <b>Filter</b></h6></button>
            </main>

        </div>
        @include("frontend.browses._filter")
    </div>
@endsection

@push('js')
    <script>
        listings = () => {
            return {
                skip:0,
                listings : [],
                categories : [],
                subcategories : [],
                indices : [4, 8, 12],
                advertisements : [],
                rating: 0,
                maxStars: 5,
                showSubCategories:false,
                filters: {
                    location : @js(request('location')),
                    category : @js(request('category')),
                    subCategory : [],
                    categories : @js(request('categories')),
                    rating : null,
                    sort_by: null,
                },
                loading:false,
                loading1:false,
                async init() {
                    const arrayKeys = ['categories', 'subCategory'];

                    const params = new URLSearchParams(window.location.search);
                    for (const [key, value] of params.entries()) {
                        if (this.filters.hasOwnProperty(key)) {
                            if (arrayKeys.includes(key)) {
                                // Convert to array of numbers
                                this.filters[key] = value.split(',').map(v => Number(v));
                            } else {
                                this.filters[key] = value;
                            }
                        }
                    }


                    await this.fetchData();
                    await this.fetchAdvertisements();

                    // ✅ Debounce to prevent excessive API calls when filters change
                    let debounceTimeout;
                    this.$watch('filters', async (value) => {
                        console.log('hi');
                        clearTimeout(debounceTimeout);
                        debounceTimeout = setTimeout(async () => {
                            // Update URL with current filters
                            const params = new URLSearchParams(window.location.search);
                            for (const key in value) {
                                if (value[key] !== '' && value[key] != null) {
                                    params.set(key, value[key]);
                                } else {
                                    params.delete(key);
                                }
                            }
                            const newUrl = `${window.location.pathname}?${params.toString()}`;
                            window.history.replaceState({}, '', newUrl);

                            // Fetch data
                            this.listings = [];
                            this.skip = 0;
                            await this.fetchData();
                        }, 300);
                    });


                    // ✅ Correctly detect input value changes using `input` event
                    const filterSearchInput = document.getElementById('filterSearch');
                    if (filterSearchInput) {
                        filterSearchInput.addEventListener('input', () => {
                            this.filters.location = filterSearchInput.value;
                        });

                        filterSearchInput.addEventListener('change', () => {
                            this.filters.location = filterSearchInput.value;
                        });

                        document.addEventListener('locationUpdated', (event) => {
                            this.$nextTick(() => {
                                this.filters.location = event.detail;
                            });
                        });
                    }

                },


                async fetchData() {
                    this.loading = true;
                    let response = await axios.get(route('frontend.browse-listings.get-data', {
                        filters: this.filters,
                        skip: 0,
                    }));
                    this.listings = response.data.listings;
                    this.categories = response.data.categories;
                    this.subcategories = response.data.subcategories;
                    this.loading = false;
                },
                async fetchAdvertisements() {
                    let response = await axios.get(route('frontend.browse-listings.get-ads'));
                    this.advertisements = response.data.advertisements;
                },
                async fetchMore() {
                    this.loading1 = true;
                    this.skip += 8;
                    let response = await axios.get(route('frontend.browse-listings.get-data', {
                        skip: this.skip,
                        filters: this.filters,
                    }));
                    this.listings.push(...response.data.listings);
                    this.loading1 = false;
                },

                findCategory(id) {
                    const category = this.categories.find(cat => cat.id == id);
                    return category ? category.name : 'NA';
                },

                filterCategory(category){
                    this.resetFilters();
                    this.filters.category = category;
                    this.fetchData();
                },
                filterSubCategory(category){
                    if (category && !this.filters.subCategory.includes(category)) {
                        this.filters.subCategory.push(category); // Add category to the array
                        category = ''; // Clear input
                    }else{
                        // If the category exists, remove it by value
                        this.filters.subCategory = this.filters.subCategory.filter(item => item !== category);
                    }
                    this.fetchData();
                },
                filterSortBy(value){
                    this.fetchData();
                },
                resetFilters() {
                    this.filters.location = null;
                    this.filters.category = null;
                    this.filters.subCategory = [];
                    this.filters.categories = null;
                    this.filters.rating = null;

                    const params = new URLSearchParams(window.location.search);
                    ['location', 'category', 'subCategory', 'categories', 'rating'].forEach(param => {
                        params.delete(param);
                    });

                    const newUrl = `${window.location.pathname}?${params.toString()}`;
                    window.history.replaceState({}, '', newUrl);
                }


            }
        }
        <!--End Alpine-->
    </script>
    <script type="module">
        $(function () {
            var owl = $('.main-content #owl-1').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                dots: false,
                navText: [
                    '<div class="d-flex justify-content-center align-items-center owl-nav-arrow" style="border-radius: 50%; height: 30px; width: 30px; border: 1px solid grey;"> <i class="bi bi-chevron-left text-secondary" style="font-size: 18px!important;" aria-hidden="true"></i> </div>',
                    '<div class="d-flex justify-content-center align-items-center owl-nav-arrow" style="border-radius: 50%; height: 30px; width: 30px; border: 1px solid grey;"> <i class="bi bi-chevron-right text-secondary" style="font-size: 18px!important;" aria-hidden="true"></i> </div>'
                ],
                navContainer: '.main-content .custom-nav',
                responsive: {
                    0: {
                        items: 3
                    },
                    600: {
                        items: 4
                    },
                    1000: {
                        items: 8
                    }
                }
            });

            var scrolled = false; // To ensure the change happens only once after scrolling

            $(window).on("scroll", function () {
                if ($(window).scrollTop() > 100 && !scrolled) {
                    scrolled = true;
                    owl.trigger('destroy.owl.carousel'); // Destroy current instance

                    $('.main-content #owl-1').owlCarousel({
                        loop: true,
                        margin: 10,
                        nav: true,
                        dots: false,
                        navText: [
                            '<div class="d-flex justify-content-center align-items-center owl-nav-arrow" style="border-radius: 50%; height: 30px; width: 30px; border: 1px solid grey;"> <i class="bi bi-chevron-left text-secondary" style="font-size: 18px!important;" aria-hidden="true"></i> </div>',
                            '<div class="d-flex justify-content-center align-items-center owl-nav-arrow" style="border-radius: 50%; height: 30px; width: 30px; border: 1px solid grey;"> <i class="bi bi-chevron-right text-secondary" style="font-size: 18px!important;" aria-hidden="true"></i> </div>'
                        ],
                        navContainer: '.main-content .custom-nav',
                        responsive: {
                            0: {
                                items: 3
                            },
                            600: {
                                items: 4
                            },
                            1000: {
                                items: 5 // Updated to 4 items on larger screens after scroll
                            }
                        }
                    });
                }
            });
        });
    </script>

@endpush
