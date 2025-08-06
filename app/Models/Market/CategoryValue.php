<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Market\CategoryAttribute;
use App\Models\Market\Product;

class CategoryValue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_id', 'category_attribute_id', 'value', 'type',];


    public function attribute(){
        return $this->belongsTo(CategoryAttribute::class, 'category_attribute_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
