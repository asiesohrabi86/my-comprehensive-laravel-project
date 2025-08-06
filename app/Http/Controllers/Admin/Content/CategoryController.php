<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PostCategoryRequest;
use App\Http\Services\Image\ImageCacheService;
use App\Http\Services\Image\ImageService;
use App\Models\Content\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postCategories = PostCategory::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.content.category.index', compact('postCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // کد تمرینی برای کش عکس
        // $imageCache = new ImageCacheService();
        // return $imageCache->cache('admin-assets/images/logo.png');
        return view('admin.content.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCategoryRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        // $inputs['slug'] = str_replace(' ', '-', $inputs['name']).'-'.Str::random(5);
        // $inputs['image'] = 'image';

        if($request->hasFile('image'))
        {
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'post-category');
            // $result = $imageService->save($request->file('image'));
            // $result = $imageService->fitAndSave($request->file('image'), 600, 150);
            // exit;
            $result = $imageService->createIndexAndSave($request->file('image'));

            if($result === false)
            {
                return redirect(route('admin.content.category.index'))->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
        }

        $inputs['image'] = $result;
        $postCategory = PostCategory::create($inputs);
        return redirect(route('admin.content.category.index'))->with('swal-success', 'دسته بندی شما با موفقیت ثبت شد');
        // return redirect(route('admin.content.category.index'))->with('swal-success', 'دسته بندی شما با موفقیت ثبت شد');
        // return redirect(route('admin.content.category.index'))->with('toast-success', 'دسته بندی شما با موفقیت ثبت شد');
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
    public function edit(PostCategory $postCategory)
    {
        return view('admin.content.category.edit', compact('postCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostCategoryRequest $request, PostCategory $postCategory, ImageService $imageService)
    {
        $inputs = $request->all();

        // اگر کاربر در ویرایش، عکسی ارسال کرد، یعنی میخواهد عکس قبلی را پاک کند و عکس جدید را جای آن قرار دهد
        if ($request->hasFile('image')) {

            if(!empty($postCategory->image)){
                // میخواهیم عکس قبلی را پاک کنیم
                $imageService->deleteIndex($postCategory->image);
            }
            
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'post-category');
            $result = $imageService->createIndexAndSave($request->image);
            if($result === false)
            {
                return redirect(route('admin.content.category.edit', compact($postCategory)))->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }

            $inputs['image'] = $result;
        }

        elseif(isset($inputs['current-image']) && !empty($postCategory->image)){
            $image = $postCategory->image;
            $image['currentImage'] = $inputs['current-image'];
            $inputs['image'] = $image;
        }
        
        $postCategory->update($inputs);
        return redirect()->route('admin.content.category.index')->with('swal-success','دسته بندی با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostCategory $postCategory)
    {
        $postCategory->delete();
        return redirect()->route('admin.content.category.index')->with('swal-success', 'دسته بندی شما با موفقیت حذف شد')
        ->with('toast-success', 'دسته بندی شما با موفقیت حذف شد')->with('alert-section-success', 'دسته بندی شما با موفقیت حذف شد');
    }

    public function status(PostCategory $postCategory)
    {
        $postCategory->status = $postCategory->status === 0 ? 1 : 0;
        $result = $postCategory->save();

        if ($result) {
            if ($postCategory->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            }else{
                return response()->json(['status' => true, 'checked' => true]);
            }  
        }else{
            return response()->json(['status' => false]);
        }
    }
}
