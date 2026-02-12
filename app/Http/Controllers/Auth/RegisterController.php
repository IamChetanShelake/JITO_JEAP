<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserRegisteredSuccessfullyMail;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Traits\LogsUserActivity;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, LogsUserActivity;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(\Illuminate\Http\Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Perform PAN verification
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJmcmVzaCI6ZmFsc2UsImlhdCI6MTc2Nzc3MjYwNCwianRpIjoiMTBjODNjNTktZTY3ZC00ZGNhLTgyZDktZTc1ZWQ4YmVmOGZiIiwidHlwZSI6ImFjY2VzcyIsImlkZW50aXR5IjoiZGV2LnNsdW5hd2F0ZmluQHN1cmVwYXNzLmlvIiwibmJmIjoxNzY3NzcyNjA0LCJleHAiOjIzOTg0OTI2MDQsImVtYWlsIjoic2x1bmF3YXRmaW5Ac3VyZXBhc3MuaW8iLCJ0ZW5hbnRfaWQiOiJtYWluIiwidXNlcl9jbGFpbXMiOnsic2NvcGVzIjpbInVzZXIiXX19.4PUIOM6lMXFUKqUxsNi1ZYIW5BLJ3A63LxZqiYB9a3c'
            ])->post('https://kyc-api.surepass.io/api/v1/pan/pan-comprehensive', [
                'id_number' => $request->pan_card
            ]);

            if (!$response->successful()) {
                return redirect()->back()->withErrors(['pan_card' => 'PAN verification failed. Please try again.'])->withInput();
            }

            $apiData = $response->json();

            if (!isset($apiData['data']['dob'])) {
                return redirect()->back()->withErrors(['pan_card' => 'Unable to retrieve date of birth from PAN.'])->withInput();
            }

            $dob = Carbon::parse($apiData['data']['dob']);
            $age = $dob->age;

            if ($age < 18 || $age > 30) {
                return redirect()->back()->withErrors(['pan_card' => 'Age criteria not satisfied. You must be between 18 and 30 years old.'])->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['pan_card' => 'API error occurred. Please try again later.'])->withInput();
        }

        // Extract additional data from API
        $additionalData = [];
        if (isset($apiData['data']['full_name'])) {
            $additionalData['name'] = $apiData['data']['full_name'];
        }
        if (isset($apiData['data']['dob'])) {
            $additionalData['d_o_b'] = $apiData['data']['dob'];
        }
        $additionalData['age'] = $age;
        if (isset($apiData['data']['gender'])) {
            $additionalData['gender'] = strtolower($apiData['data']['gender']) === 'm' ? 'male' : (strtolower($apiData['data']['gender']) === 'f' ? 'female' : null);
        }
        if (isset($apiData['data']['masked_aadhaar'])) {
            $additionalData['aadhar_card_number'] = $apiData['data']['masked_aadhaar'];
        }

        $userData = array_merge($request->all(), $additionalData);
        $user = $this->create($userData);

        try {
            Mail::to($user->email)->send(new UserRegisteredSuccessfullyMail($user));
        } catch (\Throwable $e) {
            report($e);
        }

        $this->guard()->login($user);

        // Log user registration
        $this->logUserActivity(
            'user_registration',
            'created',
            'User registered for JEAP application',
            'user',
            null,
            null,
            [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'pan_card' => $user->pan_card,
                'age' => $user->age,
                'gender' => $user->gender,
                'aadhar_card_number' => $user->aadhar_card_number,
                'registration_method' => 'online'
            ],
            $user->id,
            'User',
            'applicant'
        );

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //  dd($data);
        return Validator::make($data, [
            'pan_card' => ['required', 'string', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'] ?? null,
            'd_o_b' => $data['d_o_b'] ?? null,
            'age' => $data['age'] ?? null,
            'gender' => $data['gender'] ?? null,
            'aadhar_card_number' => $data['aadhar_card_number'] ?? null,
            'pan_card' => $data['pan_card'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
