<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\ProductRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Market\Brand;
use App\Models\Market\Product;
use App\Models\Market\ProductCategory;
use App\Models\Market\ProductMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.market.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productCategories = ProductCategory::all();
        $brands = Brand::all();
        return view('admin.market.product.create', compact('productCategories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        // $inputs['slug'] = str_replace(' ', '-', $inputs['name']).'-'.Str::random(5);

        $realTimeStamp = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date('Y-m-d H:i:s', (int)$realTimeStamp);
    
        if($request->hasFile('image'))
        {
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'product');
            $result = $imageService->createIndexAndSave($request->file('image'));

            if($result === false)
            {
                return redirect(route('admin.market.product.index'))->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
        }

        $inputs['image'] = $result;

        //میخواهیم اگر یکی از این دو عملیات ساخت پراداکت و ساخت متا به مشگل خوردآ آنیکی هم انجام نشود:
        DB::transaction(function() use($request, $inputs){
            
            $product = Product::create($inputs);
                // باید متاکی ها و متاولیوها را دو به دو متناظر کنیم:
            // برای ورود متاکی و متاولیوها در جدول نیاز به پروداکت آیدی داریم، یعنی حتما باید ابتدا پراداکت ساخته شود و سپس جدوا متاپراداکت پر شود
            $metas = array_combine($request->meta_key, $request->meta_value);
    
            // به ازای تک تک متاها باید یک بار عملیات استور انجام شود به همین دلیل از حلقه استفاده میکنیم
            foreach ($metas as $key => $value) {
                $meta = ProductMeta::create([
                    'meta_key' => $key,
                    'meta_value' => $value,
                    'product_id' => $product->id
                ]);
            }
        });

        return redirect(route('admin.market.product.index'))->with('swal-success', 'محصول شما با موفقیت ثبت شد');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $productCategories = ProductCategory::all();
        $brands = Brand::all();
        return view('admin.market.product.edit', compact('product', 'productCategories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product, ImageService $imageService)
    {
        $inputs = $request->all();
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

         // اگر کاربر در ویرایش، عکسی ارسال کرد، یعنی میخواهد عکس قبلی را پاک کند و عکس جدید را جای آن قرار دهد
        if($request->hasFile('image'))
        {
            if(!empty($product->image)){
                 // میخواهیم عکس قبلی را پاک کنیم
                $imageService->deleteDirectoryAndFiles($product->image['directory']);
            }

            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'product');
            $result = $imageService->createIndexAndSave($request->image);

            if($result === false){
                return redirect()->route('admin.market.product.edit', $product)->with('swal-error', 'آپلود تصویر با خطا مواجه شد');   
            }

            $inputs['image'] = $result;
        }

        elseif(isset($inputs['current-image']) && !empty($product->image)){
            $image = $product->image;
            $image['currentImage'] = $inputs['current-image'];
            $inputs['image'] = $image;
        }
        
        $product->update($inputs);

        // میخواهیم آرایه سه عضوی از متاکی متاولیو و متاآیدی بسازیم:
        if($request->meta_key != null)
        {
            $meta_keys = $request->meta_key;
            $meta_values = $request->meta_value;
            $meta_ids = array_keys($request->meta_key);
            $metas = array_map(function($meta_id, $meta_key, $meta_value){
                return array_combine(['meta_id', 'meta_key', 'meta_value'], [$meta_id, $meta_key, $meta_value]);
            }, $meta_ids, $meta_keys, $meta_values);

            foreach ($metas as $meta) {
                ProductMeta::where('id', $meta['meta_id'])->update([
                    'meta_key' => $meta['meta_key'],
                    'meta_value' => $meta['meta_value'],
                ]);
            }
        }
        
        return redirect()->route('admin.market.product.index')->with('swal-success','محصول با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $metas = $product->metas;
        foreach ($metas as $meta) {
            $meta->delete();
        }
        $product->delete();
        return redirect()->route('admin.market.product.index')->with('swal-success', 'محصول شما با موفقیت حذف شد');
    }
}
