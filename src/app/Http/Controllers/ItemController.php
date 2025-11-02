<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;

class ItemController extends Controller
{
    public function index(Request $request, $tab = 'recommended')
    {
        $id = Auth::id();
        $itemsAll = Item::query()->nameSearch($request->itemname)->get();
        if ($tab == 'mylist') {
            $ismylist = true;
            if (Auth::check()) {
                $items = [];
                foreach ($itemsAll as $item) {
                    $nicesUsers = $item->nices()->get();
                    $ar = [];
                    if (count($nicesUsers) > 0) foreach ($nicesUsers as $nUser) {
                        $ar[] = $nUser->id;
                    }
                    if (in_array($id, $ar))
                        $items[] = $item;
                }
            } else {
                $items = [];
            }
        } else {
            $ismylist = false;
            if (Auth::check()) {
                foreach ($itemsAll as $item) {
                    $id = Auth::id();
                    $exhibitUsers = $item->exhibitUsers()->get();
                    $ar[] = 0;
                    if (count($exhibitUsers) > 0) foreach ($exhibitUsers as $eUser) {
                        $ar[] = $eUser->id;
                    }
                    if (!in_array($id, $ar))
                        $items[] = $item;
                }
            } else {
                $items = $itemsAll;
            }
        }

        return view('items/index', compact('items', 'ismylist'));
    }

    public function show($item_id)
    {
        $item = Item::find($item_id);
        $categories = $item->categories()->get();
        $comments = $item->comments()->get();

        $id = Auth::id();

        $nices = $item->nices()->get();
        if (!empty($nices)) {
            $ids = [];
            foreach ($nices as $nice) {
                $ids[] = $nice->id;
            }
            $isnice = in_array($id, $ids);
        } else {
            $isnice = false;
        }

        return view('item', compact('item', 'categories', 'comments', 'nices', 'isnice'));
    }

    public function change($item_id)
    {
        $item = Item::find($item_id);
        $categories = $item->categories()->get();
        $comments = $item->comments()->get();

        $id = Auth::id();

        $nices = $item->nices()->get();
        if (!empty($nices)) {
            $ids = [];
            foreach ($nices as $nice) {
                $ids[] = $nice->id;
            }
            if (in_array($id, $ids)) {
                $item->nices()->detach($id);
            } else {
                $item->nices()->attach($id);
            }
        } else {
            $item->nices()->attach($id);
        }

        $nices = $item->nices()->get();
        if (!empty($nices)) {
            $ids = [];
            foreach ($nices as $nice) {
                $ids[] = $nice->id;
            }
            $isnice = in_array($id, $ids);
        } else {
            $isnice = false;
        }

        return view('/item', compact('item', 'categories', 'comments', 'nices', 'isnice'));
    }

    public function purchase($item_id)
    {
        return view('mypage/buy/purchase');
    }

    public function address($item_id)
    {
        return view('mypage/buy/address');
    }
}
