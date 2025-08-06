<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Http\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use App\Models\Market\CartItem;
use App\Models\Market\CashPayment;
use App\Models\Market\Copan;
use App\Models\Market\OfflinePayment;
use App\Models\Market\OnlinePayment;
use App\Models\Market\Order;
use App\Models\Market\OrderItem;
use App\Models\Market\Payment;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function payment()
    {
        $user = auth()->user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $order = Order::where('user_id', $user->id)->where('order_status', 0)->first();
        return view('customer.sales-process.payment', compact('cartItems', 'order'));
    }

    // میزان تخفیفی که از کد تخفیف بدست می آید
    public function copanDiscount(Request $request)
    {
        $request->validate(
            ['copan' => 'required']
        );

        $copan = Copan::where([['code', $request->copan], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()]])->first();
        
        if($copan != null)
        {
            // اگر تخفیف خصوصی باشد
            if($copan->user_id != null)
            {
            // حالا باید چک کنیم این تخفیف خصوصی، مال همین کاربر است یا خیر
                $copan = Copan::where([['code', $request->copan], ['status', 1], ['end_date', '>', now()],
                ['start_date', '<', now()], ['user_id', auth()->user()->id]])->first();

                if($copan == null)
                {
                    return redirect()->back()->withErrors(['copan' => 'کد تخفیف اشتباه وارد شده است']);
                }
            }

                
            // حالا باید چک کنیم این کاربر سفارش بررسی نشده ای دارد که در آن از کد تخفیف استفاده نشده
            $order = Order::where('user_id', auth()->user()->id)->where('order_status', 0)->where('copan_id', null)->first();

            if($order)
            {
                // حالا وارد محاسبات کد تخفیف میشویم
                if($copan->amount_type == 0)
                {
                    $copanDiscountAmount = $order->order_final_amount * ($copan->amount / 100);

                    if($copanDiscountAmount > $copan->discount_ceiling)
                    {
                        $copanDiscountAmount = $copan->discount_ceiling; 
                    }
                }
                else{
                    $copanDiscountAmount = $copan->amount;
                }

                $order->order_final_amount = $order->order_final_amount - $copanDiscountAmount;

                $order->order_copan_discount_amount = $copanDiscountAmount;
                $finalDiscount = $order->order_total_products_discount_amount + $copanDiscountAmount;

                $order->update([
                    'copan_id' => $copan->id,
                    'order_copan_discount_amount' => $copanDiscountAmount,
                    'order_total_products_discount_amount' => $finalDiscount,
                ]);

                return redirect()->back()->with(['copan' => 'کد تخفیف با موفقیت اعمال شد']);

            }
            else{
                return redirect()->back()->withErrors(['copan' => 'قبلا از کد تخفیف استفاده کردید یا سفارشی متعلق به شما وجود ندارد']);
            }
                  
        }
            
        else{
            return redirect()->back()->withErrors(['copan' => 'کد تخفیف اشتباه وارد شده است']);
        }
        
        
    }

    public function paymentSubmit(Request $request, PaymentService $paymentService)
    {
        $request->validate([
            'payment_type' => 'required',
        ]);

        $order = Order::where([['user_id', auth()->user()->id], ['order_status', 0]])->first();
        // باید بعد از ثبت سفارش، همه آیتم ها را پاک کنیم
        $cartItems = CartItem::where('user_id', auth()->user()->id)->get();
        $cash_receiver = null;


        switch($request->payment_type)
        {
            case '1':
                $targetModel = OnlinePayment::class;
                $type = 0;
                break;
            case '2':
                $targetModel = OfflinePayment::class;
                $type = 1;
                break;
            case '3':
                $targetModel = CashPayment::class;
                $type = 2;
                $cash_receiver = $request->cash_receiver ? $request->cash_receiver : null;
                break;
            default:
                return redirect()->back()->withErrors(['error' => 'خطا']);
        }

        $paymented = $targetModel::create([
          'amount'  => $order->order_final_amount, 
          'user_id'  => auth()->user()->id,
          'pay_date'  => now(), 
          'cash_receiver' => $cash_receiver, 
          'status'  => 1,     
        ]);
        
        $payment = Payment::create([
            'amount' => $order->order_final_amount, 
            'user_id'  => auth()->user()->id,
            'type' => $type, 
            'paymentable_id' => $paymented->id, 
            'paymentable_type' => $targetModel,
            'status'  => 1, 
        ]);

        // اگر پرداخت آنلاین انتخاب شده باشد، ابتدا باید مطمئن شویم، پرداخت موفق بوده
        if ($request->payment_type == 1) {
            $paymentService->zarinpal($order->order_final_amount, $order, $paymented);
        }

        $order->update([
            'order_status' => 3
        ]);

        // چون کارت آیتم ها سافت دیلیت میشوند، 
        // آنها را پاک میکنیم درغیراینصورت باید استاتوس آنها را تغییر دهیم
        foreach($cartItems as $cartItem)
        {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_object' => $cartItem->product,
                'amazing_sale_id' => $cartItem->product->activeAmazingSales()->id ?? null,
                'amazing_sale_object' => $cartItem->product->activeAmazingSales() ?? null,
                'amazing_sale_discount_amount' => empty($cartItem->product->activeAmazingSales()) ? 0 : $cartItem->cartItemProductDiscount(),
                'number' => $cartItem->number,
                'final_product_price' => $cartItem->cartItemProductPrice() - $cartItem->cartItemProductDiscount(),
                'final_total_price' => $cartItem->cartItemFinalPrice(),
                'color_id' => $cartItem->color_id,
                'guarantee_id' => $cartItem->guarantee_id,
            ]);
            $cartItem->delete();
        }

        return redirect()->route('customer.home')->with('success', 'سفارش شما با موفقیت ثبت شد');
    }

    public function paymentCallback(Order $order, OnlinePayment $onlinePayment, PaymentService $paymentService)
    {
        $amount = $onlinePayment->amount * 10;
        $result = $paymentService->zarinpalVerify($amount, $onlinePayment);

        // چه پرداخت موفقیت آمیز باشد چه نباشد، کارت آیتمها را پاک میکنیم
        $cartItems = CartItem::where('user_id', auth()->user()->id)->get();
        
        DB::transaction(function($result, $cartItems, $order){
            foreach($cartItems as $cartItem)
            {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_object' => $cartItem->product,
                    'amazing_sale_id' => $cartItem->product->activeAmazingSales()->id ?? null,
                    'amazing_sale_object' => $cartItem->product->activeAmazingSales() ?? null,
                    'amazing_sale_discount_amount' => empty($cartItem->product->activeAmazingSales()) ? 0 : $cartItem->cartItemProductDiscount(),
                    'number' => $cartItem->number,
                    'final_product_price' => $cartItem->cartItemProductPrice() - $cartItem->cartItemProductDiscount(),
                    'final_total_price' => $cartItem->cartItemFinalPrice(),
                    'color_id' => $cartItem->color_id,
                    'guarantee_id' => $cartItem->guarantee_id,
                ]);
                $cartItem->delete();
            }
        
            if($result['success'])
            {
                $order->update([
                    'order_status' => 3
                ]);

                return redirect()->route('customer.home')->with('success', 'پرداخت شما با موفقیت انجام شد');
            }
            else{
                $order->update([
                    'order_status' => 3
                ]);
                // باید روی کد خطا سوئیچ کیس بزنیم و متن خطا را دقیقا بنویسیم
                return redirect()->route('customer.home')->with('danger', 'سفارش شما با خطا مواجه شد');
            }
        });
    }
}
