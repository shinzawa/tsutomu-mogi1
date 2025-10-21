<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('index',compact('items'));
    }

    public function show($item_id)
    {
        $item = Item::find($item_id);
        $categories = $item->categories()->get();
        $comments = $item->comments();
        return view('item',compact('item','categories','comments'));
    }
}
