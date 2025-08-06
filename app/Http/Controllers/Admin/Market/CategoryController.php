<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\ProductCategoryRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Market\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productCategories = ProductCategory::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.market.category.index', compact('productCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productCategories = ProductCategory::where('parent_id', null)->get();
        return view('admin.market.category.create', compact('productCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        // $inputs['slug'] = str_replace(' ', '-', $inputs['name']).'-'.Str::random(5);
        // $inputs['image'] = 'image';

        if($request->hasFile('image'))
        {
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'product-category');
            $result = $imageService->createIndexAndSave($request->file('image'));

            if($result === false)
            {
                return redirect(route('admin.market.category.index'))->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
        }

        $inputs['image'] = $result;
        $productCategory = ProductCategory::create($inputs);
        return redirect(route('admin.market.category.index'))->with('swal-success', 'دسته بندی شما با موفقیت ثبت شد');
        
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
    public function edit(ProductCategory $productCategory)
    {
        $parent_categories = ProductCategory::where('parent_id', null)->get()->except($productCategory->id);
        return view('admin.market.category.edit', compact('productCategory', 'parent_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryRequest $request, ProductCategory $productCategory, ImageService $imageService)
    {
        $inputs = $request->all();
        // اگر کاربر در ویرایش، عکسی ارسال کرد، یعنی میخواهد عکس قبلی را پاک کند و عکس جدید را جای آن قرار دهد
        if ($request->hasFile('image')) {

            if(!empty($productCategory->image)){
                // میخواهیم عکس قبلی را پاک کنیم
                $imageService->deleteIndex($productCategory->image);
            }
            
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'product-category');
            $result = $imageService->createIndexAndSave($request->image);
            if($result === false)
            {
                return redirect(route('admin.market.category.edit', compact($productCategory)))->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }

            $inputs['image'] = $result;
        }

        elseif(isset($inputs['current-image']) && !empty($productCategory->image)){
            $image = $productCategory->image;
            $image['currentImage'] = $inputs['current-image'];
            $inputs['image'] = $image;
        }
        
        $productCategory->update($inputs);
        return redirect()->route('admin.market.category.index')->with('swal-success','دسته بندی با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();
        return redirect()->route('admin.market.category.index')->with('swal-success','دسته بندی با موفقیت حذف شد');

    }
}
