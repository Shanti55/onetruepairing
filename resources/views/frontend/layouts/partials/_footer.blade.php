<footer id="footer" class="footer bg-black text-white" >

    <div class="container footer-top">
        <div class="row gy-4 justify-content-between">
            <div class="col-lg-2 col-md-6 footer-about">
                <a href="{{ route('frontend.home') }}" class="logo d-flex align-items-center" style="margin-bottom: 0px!important;">
                    <img src="{{ $setting->footer_logo }}" alt="Control F"  loading="lazy">
                </a>
                <div class="footer-contact pt-3">
                    @if($setting->display_address_one_footer)
                        <p class="text-white">{{ $setting->address_first }}</p>
                    @elseif($setting->display_address_two_footer)
                        <p class="text-white">{{ $setting->address_second }}</p>
                    @endif
                    <p class="mt-3 text-white"><strong><i class="bi bi-whatsapp me-1"></i></strong> <span>{{ $setting->phone_first }}</span></p>
                    <p class="text-white"><strong><i class="bi bi-envelope me-1"></i></strong> <span>{{ $setting->email_first }}</span></p>
                </div>
                <div class="social-links d-flex mt-4">
                    @php
                        $socialLinks = [
                            'facebook' => $setting->facebook_link_order,
                            'linkedin' => $setting->linkedin_link_order,
                            'instagram' => $setting->instagram_link_order,
                            'youtube' => $setting->youtube_link_order,
                        ];
                        asort($socialLinks);
                    @endphp
                    @foreach($socialLinks as $key => $link)
                        @if($key == 'facebook')
                            <a class="text-primary bg-white rounded-3" href="{{ $setting->facebook_link }}"><i class="bi bi-facebook"></i></a>
                        @elseif($key == 'linkedin')
                            <a class="text-primary bg-white rounded-3" href="{{ $setting->linkedin_link }}"><i class="bi bi-linkedin"></i></a>
                        @elseif($key == 'instagram')
                            <a class="text-primary bg-white rounded-3" href="{{ $setting->instagram_link }}"><i class="bi bi-instagram"></i></a>
                        @elseif($key == 'youtube')
                            <a class="text-primary bg-white rounded-3" href="{{ $setting->youtube_link }}"><i class="bi bi-youtube"></i></a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4 class="text-white">Quick Links</h4>
                <ul>
                    <li><a class="text-white" href="{{ route('frontend.about-us') }}">About us</a></li>
                    <li><a class="text-white" href="{{ auth()->check() && auth()->user() && auth()->user()->serviceproviderprofile()->first() ? route('profile-settings.index') : route('frontend.business-listings.createOrUpdate') }}">{{ auth()->check() && auth()->user() && auth()->user()->serviceproviderprofile()->first() ? 'Edit Your Listing' : 'Add Listing' }}</a></li>
                    <li><a class="text-white" href="{{ route('frontend.benefits-of-listings') }}">Benefits Of Listing</a></li>
                    <li><a class="text-white" href="{{ route('frontend.pricing.index') }}">Pricing</a></li>
{{--                    <li><a class="text-white" target="_blank" href="{{ $setting->learn_with_ctrlf_url }}">Learn With CtrlF</a></li>--}}
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4 class="text-white">Important Links</h4>
                <ul>
                    <li><a class="text-white" href="{{ route('frontend.terms-and-conditions') }}">Terms & Conditions</a></li>
                    <li><a class="text-white" href="{{ route('frontend.privacy-policy') }}">Privacy Policy</a></li>
                    <li><a class="text-white" href="{{ route('frontend.customer-agreements') }}">Customer Agreement</a></li>
                    <li><a class="text-white" href="{{ route('frontend.refund-policies') }}">Refund Policy</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4 class="text-white">Quick Links</h4>
                <ul>
                    <li><a class="text-white" href="{{ route('frontend.blogs') }}">Blogs</a></li>
                    <li><a class="text-white" href="{{ route('frontend.faqs') }}">FAQ</a></li>
                    <li><a class="text-white" href="{{ route('frontend.contact') }}">Contact Us</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links footer-contact">
                <form  id="enquiryForm" data-aos="fade-up" data-aos-delay="200">
                    <h4 class="text-white mb-0">Contact Us</h4>
                    <ul>
                        <input type="text" name="full_name" class="border-bottom" placeholder="Name" required="">
                        <input type="text" name="email" class="border-bottom" placeholder="Email" required="">
                        <input type="text" name="mobile_no" class="border-bottom" placeholder="Mobile Number" required="">
                        <input type="text" name="message" class="border-bottom" placeholder="Your Message" required="">
                        <button type="submit" class="rounded-2 border-0 bg-white mt-2"><i class="bi bi-arrow-right-circle-fill text-primary"></i> Send Enquiry</button>
                    </ul>
                </form>
            </div>

{{--            <div class="col-lg-2 col-md-3 footer-links">--}}
{{--                <h4>Useful Links</h4>--}}
{{--                <ul>--}}
{{--                    <li><a href="#">Home</a></li>--}}
{{--                    <li><a href="#">About us</a></li>--}}
{{--                    <li><a href="#">Services</a></li>--}}
{{--                    <li><a href="#">Terms of service</a></li>--}}
{{--                    <li><a href="#">Privacy policy</a></li>--}}
{{--                </ul>--}}
{{--            </div>--}}

{{--            <div class="col-lg-2 col-md-3 footer-links">--}}
{{--                <h4>Our Services</h4>--}}
{{--                <ul>--}}
{{--                    <li><a href="#">Web Design</a></li>--}}
{{--                    <li><a href="#">Web Development</a></li>--}}
{{--                    <li><a href="#">Product Management</a></li>--}}
{{--                    <li><a href="#">Marketing</a></li>--}}
{{--                    <li><a href="#">Graphic Design</a></li>--}}
{{--                </ul>--}}
{{--            </div>--}}

{{--            <div class="col-lg-4 col-md-12 footer-newsletter">--}}
{{--                <h4>Our Newsletter</h4>--}}
{{--                <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>--}}
{{--                <form action="forms/newsletter.php" method="post" class="php-email-form">--}}
{{--                    <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>--}}
{{--                    <div class="loading">Loading</div>--}}
{{--                    <div class="error-message"></div>--}}
{{--                    <div class="sent-message">Your subscription request has been sent. Thank you!</div>--}}
{{--                </form>--}}
{{--            </div>--}}

        </div>
    </div>

    <div class="container copyright text-center mt-4 border-top border-1">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">CtrlF</strong> <span>All Rights Reserved</span></p>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you've purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
{{--            Designed by <a href="#">Trumpets Technologies</a>--}}
        </div>
    </div>

</footer>
<!-- Scroll Top -->
{{--<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>--}}

<!-- Preloader -->
<div id="preloader"></div>


@push('js')
    <script type="module">
        $(function () {
            $('#enquiryForm').on('submit', function (e) {
                e.preventDefault();

                var data = new FormData($('#enquiryForm')[0]);

                $.easyAjax({
                    url: "{{ route('frontend.enquiries.store') }}",
                    container: '#enquiryForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    onComplete: () => {
                        $('#enquiryForm').trigger("reset");
                    }
                })

                Swal.fire({
                    title: '<strong style="color: blue;">Thank You</strong>',
                    html: '<div style="font-size: 1.2rem;">Your Request Has Been Submitted</div>',
                    showConfirmButton: false,
                    showCloseButton: true,
                });

            });
        });
    </script>
@endpush
