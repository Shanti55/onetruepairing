@push('js')
    <script type="module">
        $(function () {
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
                        items: 3 // 1 item visible for small screens
                    },
                    600: {
                        items: 4 // 3 items visible for medium screens
                    },
                    1000: {
                        items: 8 // 5 items visible for larger screens
                    }
                }
            });

        });
    </script>
@endpush
