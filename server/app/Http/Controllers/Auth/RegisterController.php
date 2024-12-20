<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Compliance;
use App\Models\Country;
use App\Models\Currency;
use App\Models\PaymentGateway;
use App\Models\Settings;
use App\Models\SupportedCountry;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Integer;

class RegisterController extends Controller{

    protected $redirectTo = '/dashboard';

    public function register(Request $request)
    {
        $settings = Settings::first();
        if (!$settings) {
            return response()->json(['error' => 'Settings not found'], 500);
        }
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|numeric|digits_between:8,15|unique:users',
            'business_name' => 'required|string|max:255|unique:users',
            'business_level' => 'required|string|in:startup,small,medium,large',
            'email' => 'required|string|email|max:255|unique:users',
            'country' => 'required|string|exists:supported_countries',
            'password' => 'required|string|min:8',
            'g-recaptcha-response' => $settings->recaptcha == 1 ? 'required|captcha' : '',
        ]);


        if($validator->fails()){
            return $this->errorResponse(['errors' => $validator->errors()], 422);
        }

        $email_verified = $settings->email_verification == 1 ? 0 : 1;
$request->merge(['email_verified' => $email_verified]);
        
        $country = Country::where('name', $request->country)->first();
        if (!$country) {
    return response()->json(['error' => 'Country not found'], 404);
}
        $supported_country = SupportedCountry::where('id', '=', $request->country)->first();
        if (!$supported_country) {
    return response()->json(['error' => 'Country not supported'], 404);
}
        // $payment_gateway = PaymentGateway::where('name', 'stripe')->first();
        // if (!$payment_gateway) {
        //     return response()->json(['error' => 'Payment gateway not found'], 404);
        // }
        $currency = Currency::whereStatus(1)->first();

        // dd($country, $supported_country, $currency);

    


        // if($request->hasFile('image')){
        //     $request->validate([
        //         'image' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        //     ]);
        // }

        // $business_level = $request->business_level;
        // $business_level = implode(',', $business_level);
        // $request->merge(['business_level' => implode(',', $request->business_level)]);


        

      
        try{
            // $image = $request->file('image');

        // if($image){
        //     $imageName = time().'.'.$image->extension();
        //     $image->move(public_path('uploads/images'), $imageName);
        // }

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'business_name' => $request->business_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'country' => $country,
            ]);
            
            $user->public_key = uniqid('PUB-', true);
            $user->secret_key = uniqid('SEC-', true);
            $user->payment_support = $supported_country->id;
            $user->email_verified = $email_verified;
            $user->verification_code = strtoupper(Str::random(2).rand(00, 99).Str::random(2));
            $user->email_verified_at = Carbon::now()->addMinutes(5);
            $user->balance = $settings->balance_reg;
            $user->ip_address = user_ip_address();
            $user->last_login = Carbon::now();
              if($settings->is_stripe_connected == 1){
            $gate = PaymentGateway::where('main_name', '=', 'Stripe')->first();
            if($gate){
                $user->payment_gateways()->attach($gate->id);
            }
        }
            // if($check_business){
            //     $user->business_name = $request->business_name.'-'.rand(00, 99);
            // }
            $user->save();

            $check_business = User::wherebusiness_name($request->business_name)->first();
            $compliance = new Compliance();
            $compliance->user_id = $check_business->id;
            $compliance->save();

            if($settings->email_verification == 1){
                $text = "Welcome to ".$settings->site_name." ".$user->business_name."! <br> <br> Your account has been created successfully. <br> <br> Please verify your email address by clicking the link below. <br> <br> <a href='".url('/')."/verify-email/".$user->verification_code."'>Verify Email</a> <br> <br> If you did not create an account, please ignore this email. <br> <br> Regards, <br> ".$settings->site_name." Team";
                send_email($user->email, $user->business_name, "Welcome ".$request->business_name, $text);
                send_email($user->email, $user->business_name, "Welcome ".$settings->site_name, $settings->welcome_message);
            
            }

            // if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            //     return redirect()->route('user.dashboard');
            // } else {
            //     return redirect()->back()->with('error', 'Invalid login details');
            // }

            return $this->successResponse($user, 'User created successfully', 201);
        }
        catch(Exception $e){
            $this->errorResponse($e->getMessage(), 500);
        }

    }
}