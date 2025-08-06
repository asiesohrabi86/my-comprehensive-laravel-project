<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Market\Product;
use App\Models\Market\CartItem;

class CartController extends Controller
{
    public function cart(){
        if(Auth::check())
        {
            $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
            if($cartItems->count() > 0)
            {
                $relatedProducts = Product::all();
                return view('customer.sales-process.cart', compact('cartItems', 'relatedProducts'));
            }else{
                return redirect()->back()->with('swal-error', 'هیچ آیتمی در سبد خرید شما وجود ندارد.');
            }
            
        }
        else
        {
            return redirect()->route('auth.customer.login-register-form');
        }

    }

    public function updateCart(Request $request){
        $inputs = $request->all();
        $cartItems = CartItem::where('user_id', auth()->user()->id)->get();
        foreach ($cartItems as $cartItem) {
            if (isset($inputs['number'][$cartItem->id])) {
                $cartItem->update([
                    'number' => $inputs['number'][$cartItem->id]
                ]);
            }
        }

        return redirect()->route('customer.sales-process.address-and-delivery');
    }

    public function addToCart(Product $product, Request $request)
    {
        if(Auth::check())
        {
            $request->validate([
                'color' => 'nullable|exists:product_colors,id',
                'guarantee' => 'nullable|exists:guarantees,id',
                'number' => 'required|min:1|max:5',
            ]);

            $cartItems = CartItem::where('product_id', $product->id)->where('user_id', auth()->user()->id)->get();

            if(!isset($request->color)){
                $request->color = null;
            }

            if(!isset($request->guarantee)){
                $request->guarantee = null;
            }

            // اگر کاربر قبلا این محصول را با رنگ و گارانتی موردنظر در سبد خرید قرار داده بود، باید به تعداد آن اضافه شود
            // و اگر این محصول را با رنگ و کارانتی جدید میخواهد، باید یک آیتم جدید در سبد خرید ایجاد شود.

            foreach($cartItems as $cartItem)
            {
                if($cartItem->color_id == $request->color && $cartItem->guarantee_id == $request->guarantee)
                {
                    if($cartItem->number != $request->number)
                    {
                        $cartItem->update(['number' => $request->number]); 
                        return back()->with('alert-section-success','محصول موردنظر با موفقیت در سبد خرید به روزرسانی  شد');
                    }
                    else
                    {
                        return back();
                    }
                }
            }

            $inputs = [];
            $inputs['color_id'] = $request->color;
            $inputs['guarantee_id'] = $request->guarantee;
            $inputs['user_id'] = auth()->user()->id;
            $inputs['product_id'] = $product->id;
            $inputs['number'] = $request->number;

            CartItem::create($inputs);
            return back()->with('alert-section-success','محصول موردنظر با موفقیت به سبد خرید اضافه شد');
        }
        else
        {
            return redirect()->route('auth.customer.login-register-form');
        }
    }

    public function RemoveFromCart(CartItem $cartItem){
        // باید چک کنیم کسیکه میخواهد آیتم را پاک کند همان کسیست که لاگین کرده
        if ($cartItem->user_id === auth()->user()->id) {
            $cartItem->delete();
        }
        return back();
    }
}
