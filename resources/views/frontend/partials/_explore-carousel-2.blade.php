@include('frontend.partials._new_card')
@push('js')
    <script type="module">
        $(function () {
            var owl = $('.main-content #owl-3');
            owl.owlCarousel({
                lazyLoad: true,
                loop: true,
                dots: false,
                rtl: true,
                margin: 10,
                stagePadding: 0,
                smartSpeed : 4000,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        stagePadding: 50,
                        items: 1 // 1 item visible for small screens
                    },
                    600: {
                        stagePadding: 50,
                        items: 2 // 3 items visible for medium screens
                    },
                    1000: {
                        items: 5 // 5 items visible for larger screens
                    }
                }
            });
            $('.main-content #owl-3 .cardd').on('click', function () {
                owl.trigger('stop.owl.autoplay');
            });
        });
    </script>
@endpush
