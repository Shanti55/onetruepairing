@extends('frontend.layouts.app')

@section('title', 'Contact Us | CtrlF')

@section('content')

    <section id="hero" class="hero section dark-background">
        <img src="{{ $setting->contact_us_bg_img }}" alt="" class="hero-bg"  loading="lazy">
        <div class="container">
            <div class="row gy-4 justify-content-between align-items-center">
                <div class="col-lg-8 hero-img" data-aos="zoom-out" data-aos-delay="100">
                    <img src="{{ $setting->contact_us_img }}" class="img-fluid rounded" alt=""  loading="lazy">
                </div>
                <div class="card col-lg-4 rounded-5 p-0 p-md-2">
                    <form  id="enquiryForm" class="php-email-form  p-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="text-center">
                            <h3 class="text-primary"><b>LET'S TALK</b></h3>
                            <span class="text-muted">Have a query or want to meet up for coffee.<br>
                                Contact us directly or fill out the form and<br>
                                we will get back to you.
                            </span>
                        </div>
                        <div class="gy-2 my-3">
                            <div class="mb-3">
                                <lable><b>Full Name</b></lable>
                                <span class="text-danger">*</span>
                                <input type="text" name="full_name" class="form-control rounded-4 mt-2" placeholder="Full Name" required="">
                            </div>

                            <div class="mb-3">
                                <lable><b>Mobile No</b></lable>
                                <span class="text-danger">*</span>
                                <input type="number" name="mobile_no" class="form-control rounded-4 mt-2" placeholder="Mobile No" required="">
                            </div>

                            <div class="mb-3">
                                <lable><b>Email Id</b></lable>
                                <span class="text-danger">*</span>
                                <input type="email" name="email" class="form-control rounded-4 mt-2" placeholder="Email Id" required="">
                            </div>

                            <div class="mb-3">
                                <lable><b>Message</b></lable>
                                <span class="text-danger">*</span>
                                <textarea type="text" name="message" class="form-control rounded-4 mt-2" placeholder="Message" required=""></textarea>
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>

                                <button type="submit" class="cu-btn rounded-4 border-0"><b>Submit</b></button>
                            </div>
                        </div>
                    </form>
                </div><!-- End Contact Form -->
            </div>
            <div class="row mt-5 gy-4 justify-content-between align-items-center">
                @if($setting->contact_us_dfa)
                    <div class="col-md-6">
                    <div class="d-flex flex-column" data-aos="fade-up" data-aos-delay="200">
                        <div>
                            <h2><b>{{ $setting->address_first_heading }}</b></h2>
                            <p class=" mb-0">{{ $setting->address_first }}</p>
                            <p class="mb-0"><i class="bi bi-whatsapp"></i> {{ $setting->phone_first }}</p>
                            <p class="mb-0"><i class="bi bi-envelope"></i>  {{ $setting->email_first }}</p>
                        </div>

                    </div>
                </div>
                @endif
                @if($setting->contact_us_dsa)
                    <div class="col-md-6">
                    <div class=" d-flex" data-aos="fade-up" data-aos-delay="200">
                        <div>
                            <h2><b>{{ $setting->address_second_heading }}</b></h2>
                            <p class=" mb-0">{{ $setting->address_second }}</p>
                            <p class="mb-0"><i class="bi bi-whatsapp"></i> {{ $setting->phone_second }}</p>
                            <p class="mb-0"><i class="bi bi-envelope"></i>  {{ $setting->email_second }}</p>
                        </div>

                    </div>
                </div>
                @endif
            </div>
            <div class="row gy-4 justify-content-between align-items-center">
                @if($setting->contact_us_dfa)
                    <div class="col-md-6">
                    @if($setting->address_first_map)
                        <div class="mt-3">
                            <div class="card border-0 p-2">
                                <div class="card-body map-container">
                                    {!! $setting->address_first_map !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @endif
                @if($setting->contact_us_dsa)
                    <div class="col-md-6">
                    @if($setting->address_second_map)
                        <div class="mt-3">
                            <div class="card border-0 p-2">
                                <div class="card-body map-container">
                                    {!! $setting->address_second_map !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </section><!-- /Hero Section -->


@endsection

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
                    title: '<strong style="color: blue;margin-top: 40px!important;">Thank You!</strong>',
                    html: '<div style="font-size: 1.2rem;margin-bottom: 40px!important;">Your Request Has Been Submitted</div>',
                    showConfirmButton: false,
                    showCloseButton: true,
                });
            });
        });
    </script>
@endpush

