<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\SalesProcess\StoreAddressRequest;
use App\Http\Requests\Customer\SalesProcess\UpdateAddressRequest;
use App\Http\Requests\Customer\SalesProcess\ChooseAddressAndDeliveryRequest;
use App\Models\Address;
use App\Models\City;
use App\Models\Market\CartItem;
use App\Models\Market\CommonDiscount;
use App\Models\Market\Delivery;
use App\Models\Market\Order;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function addressAndDelivery() 
    {
        // check profile
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $deliveryMethods = Delivery::where('status', 1)->get();
        $provinces = Province::all();
        
        // اگر سبد خرید کاربر خالی بود
        if (empty(CartItem::where('user_id', $user->id)->count())) {
            return redirect()->route('customer.sales-process.cart');
        }

        return view('customer.sales-process.address-and-delivery', compact('cartItems', 'provinces', 'deliveryMethods'));
    }

    public function getCities(Province $province)
    {
        $cities = $province->cities;
        if ($cities != null) {
            return response()->json(['status' => true, 'cities' => $cities]);
        }
        else{
            return response()->json(['status' => false, 'cities' => null]);
        }
        
    }

    public function addAddress(StoreAddressRequest $request){
        $inputs = $request->all();
        $inputs['user_id'] = auth()->user()->id;
        $inputs['postal_code'] = convertArabicToEnglish($request->postal_code);
        $inputs['postal_code'] = convertPersianToEnglish($inputs['postal_code']);
        $address = Address::create($inputs);
        return redirect()->back()->with('swal-success', 'آدرس جدید شما با موفقیت ثبت شد');
    }

    public function editAddress(Address $address) 
    {
        $cities = City::where('province_id', $address->province_id)->get();
        return response()->json(['address' => $address, 'cities' => $cities]);
    }

    public function updateAddress(UpdateAddressRequest $request, Address $address){
        $inputs = $request->all();
        $inputs['user_id'] = auth()->user()->id;
        $inputs['postal_code'] = convertArabicToEnglish($request->postal_code);
        $inputs['postal_code'] = convertPersianToEnglish($inputs['postal_code']);
        $address->update($inputs);
        return redirect()->back()->with('swal-success', 'آدرس جدید شما با موفقیت ثبت شد');
    }

    public function chooseAddressAndDelivery(ChooseAddressAndDeliveryRequest $request)
    {
        $user = auth()->user();
        $inputs['address_id'] = $request->address_id; 
        $inputs['delivery_id'] = $request->delivery_id; 

        // calc price
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $totalProductPrice = 0;
        $totalDiscount = 0;
        $totalFinalPrice = 0;
        $totalFinalDiscountPriceWithNumbers = 0;
        foreach($cartItems as $cartItem)
        {
            $totalProductPrice += $cartItem->cartItemProductPrice();
            // تخفیف شگفت انگیز محصول
            $totalDiscount += $cartItem->cartItemProductDiscount();
            $totalFinalPrice += $cartItem->cartItemFinalPrice();
            $totalFinalDiscountPriceWithNumbers += $cartItem->cartItemFinalDiscount();

        }

        // commonDiscount
        $commonDiscount = CommonDiscount::where([['status', 1], ['end_date', '>', now()], ['start_date', '<', now()]])->first(); 
        if($commonDiscount)
        {
            $inputs['common_discount_id'] = $commonDiscount->id;
            // تخفیف عمومی روی کل مبلغ سبد خرید اعمال میشود.
            $commonPercentageDiscountAmount = $totalFinalPrice * ($commonDiscount->percentage / 100);
            if($commonPercentageDiscountAmount > $commonDiscount->discount_ceiling)
            {
                $commonPercentageDiscountAmount = $commonDiscount->discount_ceiling;
            }
            if($commonDiscount != null && $totalFinalPrice >= $commonDiscount->minimal_order_amount){
                $finalPrice = $totalFinalPrice - $commonPercentageDiscountAmount;
            }
            else{
                $finalPrice = $totalFinalPrice;
            }
        }
        else{
            $commonPercentageDiscountAmount = null;
            $finalPrice = $totalFinalPrice;
        }


        $inputs['user_id'] = $user->id;
        $inputs['order_final_amount'] = $finalPrice;
        $inputs['order_discount_amount'] = $totalFinalDiscountPriceWithNumbers;
        $inputs['order_common_discount_amount'] = $commonPercentageDiscountAmount;
        $inputs['order_total_products_discount_amount'] = $inputs['order_discount_amount'] + $inputs['order_common_discount_amount'];
        $order = Order::updateOrCreate(
            ['user_id' => $user->id, 'order_status'  => 0],
            $inputs
        );
        return redirect()->route('customer.sales-process.payment');
    }
}
