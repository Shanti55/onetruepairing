@extends('frontend.layouts.app')

@section('title', 'Login / Sign Up')

@section('content')
    <div class="container-fluid p-0 m-0">
        <main class="main">
            <section id="hero" class="hero section dark-background" style="{{ isset($setting->login_banner_img) ? 'background-color: var(--accent-color)' : '' }}">
                @if(isset($setting->login_banner_img))
                    <img src="{{ $setting->login_banner_img }}" alt="" class="hero-bg h-100"  loading="lazy">
                @endif
                <div class="container">
                    <h1>Email Verification Required</h1>
                    <p>Thank you for registering! Before accessing your account, please verify your email address by clicking the link we sent to your email.</p>

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button class="btn-get-started bg-warning fw-bold border-0" type="submit">Resend Verification Email</button>
                    </form>

                    <p>If you didn't receive the email, click the button above to resend it.</p>
                </div>
            </section>
        </main>
    </div>
@endsection

