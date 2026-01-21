<div class="container section-title mt-5 web-category" data-aos="fade-up">

    <div class="d-flex flex-sm-row flex-column justify-content-sm-between">
        <div><span>Popular</span> <span class="description-title">Categories</span></div>
        <a href="{{ route('frontend.browse-listings.index') }}" class="btn text-decoration-none border-0"><h5 class="text-common-blue fw-bold"><i class="bi bi-arrow-right-circle"></i> View All</h5></a>
    </div>

    <section class="features section py-5">
        <div class="row gy-4 main-content text-center">
            <div class="owl-carousel owl-theme" id="owl-1">
                @php
                    $popularCategories = \App\Models\Category::whereNull('parent_id')->get();
                @endphp
                @foreach($popularCategories as $index => $category)
                    @if($category)
                        <a class="" href="{{ route('frontend.browse-listings.index',['category'=>$category->name]) }}">
                            <div class="card shadow-sm border-0" style="width: 120px!important;height: 120px!important;">
                                <div class="card-body d-flex flex-column align-items-center p-3">
                                    <img  loading="lazy" src="{{ isset($category->icon) ? url($category->icon) : asset('frontend-images/location-img.png') }}" style="width: 60%;height: auto">
                                    <p style="font-size: 10px!important;" class="text-dark mt-1">{{$category->name}}</p>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
            <div class="owl-theme">
                <div class="owl-controls">
                    <div class="custom-nav owl-nav"></div>
                </div>
            </div>
        </div>
    </section>
</div>
@push('js')
    <script type="module">
        $(function () {
            $('.main-content #owl-1').owlCarousel({
                stagePadding: 50,
                loop: true,
                margin: 10,
                nav: true,
                dots: false,
                navText: [
                    '<div class="d-flex justify-content-center align-items-center owl-nav-arrow" style="border-radius: 50%; height: 40px; width: 40px; border: 1px solid grey;"> <i class="bi bi-chevron-left text-secondary" style="font-size: 24px!important;" aria-hidden="true"></i> </div>',
                    '<div class="d-flex justify-content-center align-items-center owl-nav-arrow" style="border-radius: 50%; height: 40px; width: 40px; border: 1px solid grey;"> <i class="bi bi-chevron-right text-secondary" style="font-size: 24px!important;" aria-hidden="true"></i> </div>'
                ],
                navContainer: '.main-content .custom-nav',
                responsive: {
                    0: {
                        stagePadding: 30,
                        margin: 10,
                        items: 2 // 1 item visible for small screens
                    },
                    600: {
                        stagePadding: 30,
                        margin: 10,
                        items: 3 // 3 items visible for medium screens
                    },
                    1000: {
                        items: 8 // 5 items visible for larger screens
                    }
                }
            });
        });
    </script>
@endpush
