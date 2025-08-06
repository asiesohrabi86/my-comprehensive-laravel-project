<?php 

namespace App\Http\Services\Image;

use Intervention\Image\Facades\Image;

class ImageCacheService
{
    public function cache($imagePath, $size = '')
    {
        // set image sizes
        $imageSizes = config('image.cache-image-sizes');

        // درصورتیکه سایز ی که کاربر وارد کرده در فایل ترکیب بندی پکیج موجود نباشد، سایز پیش فرض را درنظر میگیریم
        if(! isset($imageSizes[$size])){
            $size = config('image.default-current-cache-image');
        }

        $width = $imageSizes[$size]['width'];
        $height = $imageSizes[$size]['height'];

        // cache image
        // درصورتیکه عکس موجود باشد، آن را کش میکنیم با متد cache()
        if (file_exists($imagePath)) {
            $img = Image::cache(function($image) use($imagePath, $width, $height){
                return $image->make($imagePath)->fit($width, $height);
            }, config('image.image-cache-life-time'), true);

            return $img->response();
        }

        // درصورتیکه عکس موجود نباشد، یک عکس خودمان میسازیم که درون آن نوشته:عکس موجود نیست-404 
        // ساخت عکس با متد canvas() انجام میشود
        else{
            $img = Image::canvas($width, $height, '#cdcdcd')->text('image not found-404', $width/2, $height/2, function($font){
                $font->color('#333333');
                $font->align('center');
                $font->valign('center');
                $font->file(public_path('admin-assets/fonts/IRANSansFaNum.woff'));
                $font->size(24);
            });

            return $img->response();
        }

    }
}