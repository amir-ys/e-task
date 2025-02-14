<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $guarded = [];

    public static function getTableName(): string
    {
        return "posts";
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
