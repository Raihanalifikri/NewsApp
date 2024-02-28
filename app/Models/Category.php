<?php

namespace App\Models;

use App\Models\News;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;


    // Apa aja yang bisa di edit
    protected $fillable = [
        'name',
        'slug',
        'image'
    ];

    // Relation With News
    public function news(){
        return $this->hasMany(News::class);
    }

    // Accesor Image Category
    public function image() : Attribute{
        return Attribute::make(
            get: fn($value) => asset('/storage/category/' . $value)
        );
    }
}
