<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    protected $fillable = ['name', 'brand_id', 'category_id', 'image', 'price'];


    public function brand()
    {

        return $this->belongsTo(Brand::class);
    }

    public function category()
    {

        return $this->belongsTo(Category::class);
    }
}
