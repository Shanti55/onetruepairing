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
                                    <h6 class="text-secondary">Welcome To CtrlF - Service Provider</h6>
                                    <h3 class="text-common-blue"><b>LOGIN</b></h3>
                                </div>
                                <div class="card-body pt-0 p-0 p-md-3">
                                    <form method="POST" action="{{ route('frontend.auth.login') }}">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="email" class="form-label"><b>Email or Mobile Number</b></label>
                                                <span class="text-danger">*</span>
                                                <input type="text" name="email" id="email" placeholder="Enter Email or Mobile Number"
                                                       class="rounded-4 form-control @error('email') is-invalid @enderror"/>
                                                @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="password" class="form-label"><b>Password</b></label>
                                                <span class="text-danger">*</span>
                                                <div class="input-group">
                                                    <input
                                                        type="password"
                                                        name="password"
                                                        id="password"
                                                        placeholder="Enter Password"
                                                        class="rounded-start-4 form-control @error('password') is-invalid @enderror"
                                                    />
                                                    <div class="input-group-append">
                                                        <button
                                                            type="button"
                                                            class="btn btn-lg rounded-0 rounded-end-4 m-0"
                                                            style="border-color: #dee2e6;"
                                                            id="togglePassword"
                                                            tabindex="-1">
                                                            <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                                @error('password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="d-flex flex-column text-center">
                                                <button class="btn-get-started border-0 mb-2"><b>LOG IN</b></button>
                                                <a href="{{ route('password.request') }}" class="text-muted mb-2">Forgot your password ?</a>
                                                <a href="{{ route('frontend.auth.service-providers.register') }}" class="text-muted ">Don't have an account ? <span class="fw-bold text-dark">Sign up</span> </a>

                                            </div>
{{--                                            <div class="form-check">--}}
{{--                                                <input class="form-check-input" type="checkbox" name="remember_me" id="remember_me">--}}
{{--                                                <label class="form-check-label" for="remember_me">--}}
{{--                                                    Remember Me--}}
{{--                                                </label>--}}
{{--                                            </div>--}}


                                        </div>
                                    </form>
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

    <script type="module">
        $(function () {

            document.getElementById('togglePassword').addEventListener('click', function () {
                const passwordInput = document.getElementById('password');
                const toggleIcon = document.getElementById('toggleIcon');

                // Toggle the type attribute
                const isPasswordVisible = passwordInput.type === 'password';
                passwordInput.type = isPasswordVisible ? 'text' : 'password';

                // Toggle the eye icon
                toggleIcon.classList.toggle('bi-eye');
                toggleIcon.classList.toggle('bi-eye-slash');
            });

        });
    </script>
@endpush
