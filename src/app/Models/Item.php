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
        return $this->belongsToMany(Category::class, 'item_category', 'item_id', 'category_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->belongsToMany(User::class, 'comments', 'item_id', 'user_id')->withPivot('comment')->withTimestamps();
    }

    public function nices()
    {
        return $this->belongsToMany(User::class, 'user_nice_items', 'item_id', 'user_id')->withTimestamps();
    }

    public function buyUsers()
    {
        return $this->belongsToMany(User::class, 'user_buy_items', 'item_id', 'user_id')->withPivot(['zipcode','address','building'])->withTimestamps();
    }

    public function exhibitUsers()
    {
        return $this->belongsToMany(User::class, 'user_exhibit_items', 'item_id', 'user_id')->withTimestamps();
    }

    public function scopeNameSearch($query, $name)
    {
        $query->where('name', 'like', '%' . $name . '%');
    }
}
