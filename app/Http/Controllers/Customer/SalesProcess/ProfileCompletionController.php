<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Models\Market\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Customer\SalesProcess\ProfileCompletionRequest;

class ProfileCompletionController extends Controller
{
    public function profileCompletion() 
    {
       $user = Auth::user(); 
        //جچون در این صفحه سبد خرید را نمایش میدهد نیاز به آیتم های سبد خرید داریم
       $cartItems = CartItem::where('user_id', $user->id)->get();
        return view('customer.sales-process.profile-completion', compact('user', 'cartItems'));
    }

    public function update(ProfileCompletionRequest $request) 
    {
        $user = Auth::user();
        // با اینکه در ریکویست تبدیل کردیم باز هم برای اطمینان ازینکه عدد انگلیسی در دیتابیس ذخیره میشود، تبدیل میکنیم
        $national_code = convertArabicToEnglish($request->national_code);
        $national_code = convertPersianToEnglish($national_code);
        $inputs = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
        ];
        if (isset($request->mobile) && empty($user->mobile)) {
            $mobile = convertArabicToEnglish($request->mobile);
            $mobile = convertPersianToEnglish($mobile);

            if (preg_match('/^(\+98|98|0)9\d{9}$/', $mobile)) {
                // یعنی کاربر موبایل وارد کرده
                // مستوانیم اس ام اس فعالسازی به این شماره بفرستیم
                // $type = 0;
                // all mobile numbers in one format(9*********)
                $mobile = ltrim($mobile, '0');
                $mobile = substr($mobile, 0, 2) == '98' ? substr($mobile, 2) : $mobile;
                $mobile = str_replace('+98', '' ,$mobile);

                $inputs['mobile'] = $mobile;
            }else{
                $errorText = 'فرمت شماره موبایل معتبر نیست';
                return redirect()->back()->withErrors(['mobile' => $errorText]);
            }
        }

        if (isset($request->email) && empty($user->email)) {
            // کاربر ایمیل وارد کرده
            // مستوانیم ایمیل فعالسازی به این ایمیل بفرستیم
            // $type = 1;
            $email = convertArabicToEnglish($request->email);
            $email = convertPersianToEnglish($email);

            // if (filter_var(FILTER_VALIDATE_EMAIL, $request->email)) {
                $inputs['email'] = $email;
            // }
        }

        // خانه های خالی آرایه را پاک میکنیم
        $inputs = array_filter($inputs);

        if (!empty($inputs)) {
            $user->update($inputs);
        }
        
        return redirect()->route('customer.sales-process.address-and-delivery');
    }
}
