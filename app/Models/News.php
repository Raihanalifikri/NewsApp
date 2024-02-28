<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;

    // fillable
    protected $fillable = [
        'category_id',
        'title',
        'image',
        'slug',
        'content'
    ];

    // Relation with Category
    public function category(){
        return $this->beLongsTo(Category::class);
    }

    // Accessor Image News
    public function image() : Attribute{
        return Attribute::make(
            get: fn($value) => asset('/storage/news/' . $value)
        );
    }
}
