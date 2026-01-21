@extends('frontend.layouts.app')


@section('content')
    <div class="container-fluid p-0 m-0">
        <main class="main">
            <section id="hero" class="hero section dark-background" style="{{ isset($setting->login_banner_img) ? 'background-color: var(--accent-color)' : '' }}">
                @if(isset($setting->login_banner_img))
                    <img src="{{ $setting->login_banner_img }}" alt="" class="hero-bg">
                @endif
                <div class="container">
                    @session('status')
                    <div class="alert alert-success">{{ session('status') }}</div>
                    @endsession
                    <div class="row gy-4 justify-content-between">
                        <div class="col-lg-4 order-lg-last">
                            <div class="card shadow-lg rounded-5">
                                <div class="card-header text-center bg-white mt-4 py-0 border-bottom border-light header">
                                    <a href="{{ route('frontend.home') }}" class="logo pb-2 d-flex justify-content-center align-items-center">
                                        <!-- Uncomment the line below if you also wish to use an image logo -->
                                        <img class="mx-0" src="{{ $setting->logo }}" alt="ctrlf">
                                        {{--            <h1 class="sitename">CtrlF</h1>--}}
                                    </a>
                                    <h6 class="text-secondary">Welcome To CtrlF</h6>
                                    <h3 class="text-common-blue"><b>FORGOT PASSWORD</b></h3>
                                </div>
                                <div class="card-body pt-0">
                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="email" class="form-label"><b>Email</b></label>
                                                <span class="text-danger">*</span>
                                                <input type="text" name="email" id="email" placeholder="Enter Email"
                                                       class="rounded-4 form-control @error('email') is-invalid @enderror"/>
                                                @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <div class="d-flex flex-column text-center">
                                                <button class="btn-get-started border-0 mb-2"><b>EMAIL PASSWORD RESET LINK</b></button>
                                                <a href="{{ route('frontend.auth.register') }}" class="text-muted ">Don't have an account ? <span class="fw-bold text-dark">Sign up</span> </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6  d-flex flex-column justify-content-center" data-aos="fade-in">
                            <h1><span>FORGOT PASSWORD</span></h1>
                            <p>Forgot your password? No problem. Just let us know your email address and we will email you a
                                password reset link that will allow you to choose a new one.</p>
                            <div class="d-flex">
                                <a href="{{ route('frontend.auth.login') }}" class="btn-get-started bg-warning fw-bold">Goto Login</a>
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

