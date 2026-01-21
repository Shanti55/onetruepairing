@extends('admin-panel.layouts.auth')

@section('content')
    <div class="card shadow-sm border-0">
        <form method="POST" action="{{ route('admin.auth.login') }}">
            @csrf
            <div class="card-header text-center bg-white mt-4 border-bottom border-light">
                <h6 class="text-secondary">Welcome To CtrlF</h6>
                <h3 class="text-dark"><b>ADMIN LOGIN</b></h3>
            </div>
            <div class="card-body px-4">
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email or Mobile Number</label>
                    <input type="text" name="email" id="email"
                           class="form-control @error('email') is-invalid @enderror"/>
                    @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password"
                           class="form-control @error('password') is-invalid @enderror"/>
                    @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember_me" id="remember_me">
                    <label class="form-check-label" for="remember_me">
                        Remember Me
                    </label>
                </div>

                <div class="d-flex align-items-center justify-content-end gap-3">
                    <a href="{{ route('password.request') }}" class="text-decoration-underline text-muted">Forgot your password?</a>
                    <button class="btn btn-dark">LOG IN</button>
                </div>
            </div>
        </form>
    </div>
@endsection
