@extends('frontend.layouts.app')

@section('title', 'Login / Sign Up')

@section('content')
    <div class="container-fluid p-0 m-0">
        <main class="main">
            <section id="hero" class="hero section dark-background" style="{{ isset($setting->login_banner_img) ? 'background-color: var(--accent-color)' : '' }}">
                @if(isset($setting->login_banner_img))
                    <img src="{{ $setting->login_banner_img }}" alt="" class="hero-bg"  loading="lazy">
                @endif
                <div class="container">
                    <div class="row gy-4 justify-content-between">
                        <div class="col-lg-4 order-lg-last">
                            <div class="card shadow-lg rounded-5">
                                <div class="card-header text-center bg-white mt-4 py-0 border-bottom border-light header">
                                    <a href="{{ route('frontend.home') }}" class="logo pb-2 d-flex justify-content-center align-items-center">
                                        <!-- Uncomment the line below if you also wish to use an image logo -->
                                        <img class="mx-0" src="{{ $setting->logo }}" alt="ctrlf"  loading="lazy">
                                        {{--            <h1 class="sitename">CtrlF</h1>--}}
                                    </a>
                                    <h6 class="text-secondary">Welcome To CtrlF</h6>
                                    <h3 class="text-common-blue"><b>Login</b></h3>
                                    @if ($errors->any())
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="card-body pt-0 p-0 p-md-3">
                                    @if(!session('status'))
                                        <form method="POST" action="{{ route('send-otp') }}">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="email" class="form-label"><b>Email</b></label>
                                                <span class="text-danger">*</span>
                                                <input type="text" name="email" id="email" placeholder="Enter Email" required
                                                       class="rounded-4 form-control @error('email') is-invalid @enderror"/>
                                                @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="d-flex flex-column text-center">
                                                <button class="btn-get-started border-0 mb-2"><b>Send OTP</b></button>
                                                <a href="{{ route('frontend.auth.register') }}" class="text-muted ">Don't have an account ? <span class="fw-bold text-dark">Sign up</span> </a>
                                                <hr>
                                                <a href="{{ route('frontend.auth.login') }}" class="mb-2 fw-semibold text-dark">Login using Email/Password</a>
                                            </div>
                                        </div>
                                    </form>
                                    @endif
                                    @if(session('status'))
                                        @php
                                            $subEmail = substr(session('email'),0,6);
                                        @endphp
                                        <form id="otpForm" action="{{ route('login-otp') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="email" value="{{ session('email') }}">
                                            <div class="container otp-container d-flex justify-content-center align-items-center">
                                        <div class="position-relative">
                                            <div class="text-center">
                                                <h6 class="text-dark">Please enter the one time password <br> to verify your account</h6>
                                                <div> <span class="text-secondary">A code has been sent to</span> <small class="text-secondary" id="maskedNumber">{{ $subEmail }}*******</small> </div>
                                                <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                                                    <input class="m-2 text-center form-control rounded" type="text" id="first" maxlength="1" />
                                                    <input class="m-2 text-center form-control rounded" type="text" id="second" maxlength="1" />
                                                    <input class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1" />
                                                    <input class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1" />
                                                    <input class="m-2 text-center form-control rounded" type="text" id="fifth" maxlength="1" />
                                                    <input class="m-2 text-center form-control rounded" type="text" id="sixth" maxlength="1" />
                                                </div>
                                                <div class="mt-4">
                                                    <button id="validateBtn" class="btn-get-started border-0 mb-2">Validate</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6  d-flex flex-column justify-content-center" data-aos="fade-in">
                            <h1><span>{{ $setting->login_heading  }}</span></h1>
                            <h1>{{ $setting->login_text  }}</h1>
                            <div class="d-flex">
                                <a href="{{ route('frontend.auth.service-providers.register') }}" class="btn-get-started bg-white text-primary fw-bold">Become Service Provider ?</a>
                            </div>
                        </div>

                    </div>
                </div>
                <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
                    <defs>
                        <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
                    </defs>
                    <g class="wave1">
                        <use xlink:href="#wave-path" x="50" y="3"></use>
                    </g>
                    <g class="wave2">
                        <use xlink:href="#wave-path" x="50" y="0"></use>
                    </g>
                    <g class="wave3">
                        <use xlink:href="#wave-path" x="50" y="9"></use>
                    </g>
                </svg>

            </section>
        </main>
    </div>
@endsection
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function OTPInput() {
                const inputs = document.querySelectorAll('#otp > input');
                for (let i = 0; i < inputs.length; i++) {
                    inputs[i].addEventListener('input', function() {
                        if (this.value.length > 1) {
                            this.value = this.value[0]; //
                        }
                        if (this.value !== '' && i < inputs.length - 1) {
                            inputs[i + 1].focus(); //
                        }
                    });

                    inputs[i].addEventListener('keydown', function(event) {
                        if (event.key === 'Backspace') {
                            this.value = '';
                            if (i > 0) {
                                inputs[i - 1].focus();
                            }
                        }
                    });
                }
            }

            OTPInput();

            const validateBtn = document.getElementById('validateBtn');
            validateBtn.addEventListener('click', function() {
                let otp = '';
                document.querySelectorAll('#otp > input').forEach(input => otp += input.value);
                if (otp.length === 6) { // Ensure OTP is fully entered
                    const otpForm = document.getElementById('otpForm');
                    const otpInput = document.createElement('input');
                    otpInput.type = 'hidden';
                    otpInput.name = 'otp';
                    otpInput.value = otp;
                    otpForm.appendChild(otpInput);
                    otpForm.submit(); // Submit the form
                } else {
                    alert('Please enter a complete 6-digit OTP.');
                }
            });
        });
    </script>
@endpush

