<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'zipcode', 'address', 'building'];

    public function user(){
        $this->belongsTo(User::class);
    }
}
