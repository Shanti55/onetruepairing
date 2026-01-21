<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                if (auth()->check()) {
                    if (auth()->user()->isAdmin()) {
                        return redirect('/admin/dashboard');
                    } elseif (auth()->user()->isServiceProvider()) {
                        if(!auth()->user()->serviceproviderprofile){
                            return redirect(route('frontend.business-listings.createOrUpdate'));
                        }
                        return redirect('/');
                    } elseif (auth()->user()->isUser()) {
                        return redirect('/');
                    }
                }
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        Fortify::authenticateUsing(function (Request $request) {

            $loginField = $request->input('email'); // Single input field

            // Check if input is an email
            if (filter_var($loginField, FILTER_VALIDATE_EMAIL)) {
                $user = User::where('email', $loginField)->first();
            }
            // Check if input is a mobile number (digits only)
            elseif (preg_match('/^\d{10,15}$/', $loginField)) { // Adjust length as per your need
                $user = User::where('primary_mobile_number', $loginField)->first();
            } else {
                return null; // Invalid input
            }



            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
        });


    }

}
