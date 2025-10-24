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
        return $this->belongsToMany(User::class)->withPivot('comment');
    }

    public function nices()
    {
        return $this->belongsToMany(User::class, 'user_nice_items', 'item_id', 'user_id');
    }

    public function buyUsers()
    {
        return $this->belongsToMany(User::class, 'user_buy_items', 'item_id', 'user_id');
    }

    public function exhibitUsers()
    {
        return $this->belongsToMany(User::class, 'user_exhibit_items', 'item_id', 'user_id');
    }

    public function scopeNameSearch($query, $name)
    {
        $query->where('name', 'like', '%' . $name . '%');
    }
}
