<?php

namespace App\Http\Controllers\Mypage;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;

class ItemController extends Controller
{
    public function mypage()
    {
        $id = Auth::id();
        $user = User::find($id);
        $profiles = $user->profile()->get();
        $profile = $profiles[0];

        $buyItems = $user->buyItems()->get();
        $exhibitItems = $user->exhibitItems()->get();

        return view('/mypage/index', compact('profile', 'buyItems', 'exhibitItems'));
    }
}
