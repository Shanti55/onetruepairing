<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Notifications\VendorRegistrationConfirmation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;



class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'g-recaptcha-response' => ['required'],
                Rule::unique(User::class),
            ],
            'primary_mobile_number' => 'required|string|unique:users,primary_mobile_number',
            'password' => $this->passwordRules(),
        ])->validate();

        // Verify reCAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $input['g-recaptcha-response'],
        ]);

        if (!$response->json('success')) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Invalid reCAPTCHA. Please try again.',
            ]);
        }

        $referredBy = null;
        if(array_key_exists('referral_code',$input)){
            $referredBy = User::where('referral_code','LIKE',$input['referral_code'])->first();
        }

        $user = User::create([
            'name' => $input['name'],
            'primary_mobile_number' => array_key_exists('primary_mobile_number',$input) ? $input['primary_mobile_number'] : null,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => array_key_exists('role',$input) ? $input['role'] : 'user',
            'referred_by' => $referredBy ? $referredBy->id : null,
        ]);

        try {
            if ($user->role == 'service-provider'){
                $user->notify(new VendorRegistrationConfirmation($user));
            }
        }catch (\Exception $e){

        }

        return $user;
    }
}
