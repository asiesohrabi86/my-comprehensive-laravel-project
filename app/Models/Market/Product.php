<?php

namespace App\Models\Market;

use App\Models\Content\Comment;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\Market\CategoryValue;
use App\Models\User;

class Product extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    public function sluggable(): array {
        return [
            'slug' => [
               'source' => 'name',
            ],
        ];
    }

    protected $casts = ['image' => 'array'];
    
    protected $fillable = ['name', 'introduction', 'slug', 'image', 'weight', 'length', 'width', 'height',
        'price', 'status', 'marketable', 'tags', 'sold_number', 'frozen_number', 'marketable_number',
        'brand_id', 'category_id', 'published_at'];

    public function category(){
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function metas() {
        return $this->hasMany(ProductMeta::class);
    }

    public function colors() {
        return $this->hasMany(ProductColor::class);
    }

    public function images() {
        return $this->hasMany(Gallery::class);
    }

    public function values(){
        return $this->hasMany(CategoryValue::class, 'product_id');
    }

    public function guarantees(){
        return $this->hasMany(Guarantee::class);
    }

    public function amazingSales(){
        return $this->hasMany(AmazingSale::class);
    }

    public function activeAmazingSales(){
        return $this->amazingSales()->where('start_date', '<', Carbon::now())->where('end_date', '>', Carbon::now())->first();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function activeComments(){
        return $this->comments()->where('approved', 1)->whereNull('parent_id')->get();
    }

    // برای تعیین رابطه علاقه مندی ها
    public function user(){
        return $this->belongsToMany(User::class);
    }

}
