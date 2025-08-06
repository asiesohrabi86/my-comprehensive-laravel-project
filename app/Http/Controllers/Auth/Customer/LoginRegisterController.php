<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\Customer\LoginRegisterRequest;
use Illuminate\Support\Str;
use App\Models\Otp;
use App\Models\User;
use App\Http\Services\Message\SMS\SmsService;
use App\Http\Services\Message\Email\EmailService;
use Illuminate\Support\Facades\Config;
use App\Http\Services\Message\MessageService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoginRegisterController extends Controller
{
    public function loginRegisterForm(){
        return view('customer.auth.login-register');
    }

    public function loginRegister(LoginRegisterRequest $request){
        $inputs = $request->all();

        // check whether id is email or not:
        if(filter_var($inputs['id'], FILTER_VALIDATE_EMAIL)){
            $type = 1; 
            // check if user is already registered:
            $user = User::where('email', $inputs['id'])->first();
            if(empty($user)){
                $newUser['email'] = $inputs['id'];
            }
        }
        //check if id is mobile number or not
        elseif(preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['id'])){
            $type = 0; 

            // all mobile numbers are in one format 9** *** ****
            $inputs['id'] = ltrim($inputs['id'], '0');
            $inputs['id'] = substr($inputs['id'], 0, 2) == '98' ? substr($inputs['id'], 2) : $inputs['id'];
            $inputs['id'] = str_replace('+98', '' , $inputs['id']);

            // check if user is already registered:
            $user = User::where('mobile', $inputs['id'])->first();
            if(empty($user)){
                $newUser['mobile'] = $inputs['id'];
            }
        }

        // neither mobile nor email:
        else{
            $errorText = 'شناسه ورودی شما نه شماره موبایل است نه ایمیل';
            return redirect()->route('auth.customer.login-register-form')->withErrors(['id' => $errorText]);
        }

        // if user is not already registered, we should make it:
        if(empty($user)){
            $newUser['password'] = '98355154';
            $newUser['activation'] = 1;
            $user = User::create($newUser);
        }

        // create OTP code:
        $otpCode = rand(111111, 999999);
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $inputs['id'],
            'type' => $type,
        ];

        Otp::create($otpInputs);

        // send sms or email
        if($type == 0)
        {
            // send sms:
            $smsService = new SmsService();
            $smsService->setFrom(Config::get('sms.otp_from'));
            $smsService->setTo(['0'.$user->mobile]);
            $smsService->setText("مجموعه آمازون \n کد تایید: $otpCode");
            $smsService->setIsFlash(true);

            // activating MessageService:
            $messageService = new MessageService($smsService);
        }elseif($type === 1){
            $emailService = new EmailService();
            $details = [
                'title' => 'ایمیل فعالسازی',
                'body' => "کد فعالسازی: $otpCode"
            ];
            $emailService->setDetails($details);
            $emailService->setFrom('noreply@example.com', 'example');
            $emailService->setSubject('کد احراز هویت');
            $emailService->setTo($inputs['id']);
            
            $messageService = new MessageService($emailService);
        }
        

        $messageService->send();

        return redirect()->route('auth.customer.login-confirm-form', $token);
    }

    public function loginConfirmForm($token){
        $otp = Otp::where('token', $token)->first();
        // اگر کاربر توکن الکی وارد کرد:
        if(empty($otp)){
            return redirect()->route('auth.customer.login-register-form')->withErrors(['id' => 'آدرس وارد شده نامعتبر میباشد']);
        }

        return view('customer.auth.login-confirm-form', compact('token', 'otp'));
    }

    public function loginConfirm($token, LoginRegisterRequest $request){
        $inputs = $request->all();
        $otpCode = $inputs['otp'];
        // dd(Carbon::now());
        $otp = Otp::where('token', $token)->where('used', 0)->where('created_at', ">=", Carbon::now()->subMinutes(5)->toDateTimeString())->first();
        
        if (empty($otp)) {
            return redirect()->route('auth.customer.login-register-form', $token)->withErrors(['id' => 'آدرس واردشده نامعتبر میباشد']);
        }

        // if otp not match
        if ($otp->otp_code !== $inputs['otp']) {
            return redirect()->route('auth.customer.login-confirm-form', $token)->withErrors(['otp' => 'کد واردشده صحیح نمیباشد']);
        }

        // if everything is ok:
        $otp->update(['used' => 1]);
        $user = $otp->user()->first();
        if ($otp->type === 0 && empty($user->mobile_verified_at)) {
            $user->update(['mobile_verified_at' => Carbon::now()]);
        }elseif($otp->type == 1 && empty($user->email_verified_at)){
            $user->update(['email_verified_at' => Carbon::now()]);
        }

        // make user login:
        Auth::login($user);
        return redirect()->route('customer.home');
        
    }

    public function loginResendOtp($token) 
    {
       $otp = Otp::where('token', $token)->where('created_at', "<=", Carbon::now()->subMinutes(5)->toDateTimeString())->first();
        //otpCode has not been expired:
       if(empty($otp)){
            return redirect()->route('auth.customer.login-register-form', $token)->withErrors(['id' => 'آدرس واردشده نامعتبر است']);
       }
       
       $user = $otp->user()->first();
       // create OTP code:
       $otpCode = rand(111111, 999999);
       $token = Str::random(60);
       $otpInputs = [
           'token' => $token,
           'user_id' => $user->id,
           'otp_code' => $otpCode,
           'login_id' => $otp->login_id,
           'type' => $otp->type,
       ];

       $newOtp = Otp::create($otpInputs);

       // send sms or email
       if($otp->type == 0)
       {
           // send sms:
           $smsService = new SmsService();
           $smsService->setFrom(Config::get('sms.otp_from'));
           $smsService->setTo(['0'.$otp->login_id]);
           $smsService->setText("مجموعه آمازون \n کد تایید: $otpCode");
           $smsService->setIsFlash(true);

           // activating MessageService:
           $messageService = new MessageService($smsService);

       }elseif($otp->type === 1){
        
           $emailService = new EmailService();
           $details = [
               'title' => 'ایمیل فعالسازی',
               'body' => "کد فعالسازی: $otpCode"
           ];
           $emailService->setDetails($details);
           $emailService->setFrom('noreply@example.com', 'example');
           $emailService->setSubject('کد احراز هویت');
           $emailService->setTo($otp->login_id);
           
           $messageService = new MessageService($emailService);
       }
       

       $messageService->send();

       return redirect()->route('auth.customer.login-confirm-form', $token);

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('customer.home');
    }
}
