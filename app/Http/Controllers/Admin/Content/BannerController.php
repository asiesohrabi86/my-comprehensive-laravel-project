<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\BannerRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Content\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index() 
    {
        $banners = Banner::orderBy('created_at', 'desc')->simplePaginate(15);
        $positions = Banner::$positions;
        return view('admin.content.banner.index', compact('banners', 'positions'));
    }

    public function create() 
    {
        $positions = Banner::$positions;
        return view('admin.content.banner.create', compact('positions'));
    }

    public function store(BannerRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();

        if($request->hasFile('image'))
        {
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'banner');
            $result = $imageService->save($request->file('image'));

            if($result === false)
            {
                return redirect(route('admin.content.banner.index'))->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }

        $banner = Banner::create($inputs);
        return redirect(route('admin.content.banner.index'))->with('swal-success', 'بنر شما با موفقیت ثبت شد');
    
    }

    public function edit(Banner $banner) {
        $positions = Banner::$positions;
        return view('admin.content.banner.edit', compact('banner', 'positions'));
    }

    public function update(Banner $banner, BannerRequest $request, ImageService $imageService) 
    {
        $inputs = $request->all();

        // اگر کاربر در ویرایش، عکسی ارسال کرد، یعنی میخواهد عکس قبلی را پاک کند و عکس جدید را جای آن قرار دهد
        if ($request->hasFile('image')) {

            if(!empty($banner->image)){
                // میخواهیم عکس قبلی را پاک کنیم
                $imageService->deleteImage($banner->image);
            }
            
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'banner');
            $result = $imageService->save($request->image);
            if($result === false)
            {
                return redirect(route('admin.content.banner.edit', compact('banner')))->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }

            $inputs['image'] = $result;
        }

        elseif(isset($inputs['current-image']) && !empty($banner->image)){
            $image = $banner->image;
            $image['currentImage'] = $inputs['current-image'];
            $inputs['image'] = $image;
        }
        
        $banner->update($inputs);
        return redirect()->route('admin.content.banner.index')->with('swal-success','بنر با موفقیت ویرایش شد');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('admin.content.banner.index')->with('swal-success','بنر با موفقیت حذف شد');
    }

    public function status(Banner $banner)
    {
        $banner->status = $banner->status === 0 ? 1 : 0;
        $result = $banner->save();

        if ($result) {
            if ($banner->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            }else{
                return response()->json(['status' => true, 'checked' => true]);
            }  
        }else{
            return response()->json(['status' => false]);
        }
    }
}
