<?php

namespace App\Http\Controllers\Customer\Market;

use App\Http\Controllers\Controller;
use App\Models\Content\Comment;
use Illuminate\Http\Request;
use App\Models\Market\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function product(Product $product)
    {
        $relatedProducts = Product::all();
        return view('customer.market.product.product', compact('product', 'relatedProducts'));
    }

    public function addComment(Request $request, Product $product)
    {
        $validated = $request->validate([
            'body' => 'required|min:2|max:2000|regex:/^[ا-یa-zA-Z0-9\ء-ي., ]+$/u',
        ]);

        $inputs['body'] = str_replace(PHP_EOL, '<br/>', $request->body);
        $inputs['author_id'] = Auth::user()->id;
        $inputs['commentable_id'] = $product->id;
        $inputs['commentable_type'] = Product::class;
        Comment::create($inputs);
        return back()->with('swal-success', 'نظر شما با موفقیت ثبت شد، بعد از تایید ادمین روی سایت قرار میگیرد');
    }

    public function addToFavorite(Product $product) 
    {
        if (Auth::check()) {
            $product->user()->toggle(auth()->user()->id);
            if ($product->user->contains(auth()->user()->id)) {
                return response()->json(['status' => 1]);
            }else{
                return response()->json(['status' => 2]);
            }
        }else{
            return response()->json(['status' => 3]);
        }
    }
}
