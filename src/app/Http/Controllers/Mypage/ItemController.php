<?php

namespace App\Http\Controllers\Mypage;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use App\Http\Requests\ExhibitRequest;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $id = Auth::id();
        $user = User::find($id);
        $profiles = $user->profile()->get();
        $profile = $profiles[0];

        $buyItems = $user->buyItems()->get();
        $exhibitItems = $user->exhibitItems()->get();

        $page = $request->query('page', 'sell');
        if ($page == 'sell') {
            $isSellPage = true;
        } elseif ($page == 'buy') {
            $isSellPage = false;
        }

        return view('/mypage/index', compact('profile', 'buyItems', 'exhibitItems', 'isSellPage'));
    }

    public function show()
    {
        $categories = Category::all();

        return view('/mypage/exhibit', compact('categories'));
    }

    public function store(ExhibitRequest $request)
    {
        // store image file to defined place
        $image = $request->file('image');
        if (isset($image)) {
            $path = $image->store('', 'public');
        }
        // DB register oparation 
        $data = $request->only([
            'name',
            'price',
            'brand',
            'description',
            'condition',
        ]);
        $data = array_merge($data, ['image' => $path]);
        $item = Item::create($data);
        // categories
        $categories = $request->categories;
        foreach ($categories as $category_id) {
            $ca[] = $category_id;
        }
        $item->categories()->attach($ca);
        // exhibit
        $id = Auth::id();
        $item->exhibitUsers()->attach($id);

        return view('/items/index');
    }
}
