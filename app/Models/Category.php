<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $guarded = [];

    public static function booted()
    {
        static::creating(function (Category $category) {
            $category->slug = Str::slug($category->title, '-');
        });
    }
}
