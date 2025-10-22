<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'brand', 'description', 'image', 'condition'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_category', 'item_id', 'category_id');
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class)->withPivot(['comment','user_id']);
    }

    
}
