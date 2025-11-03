<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $purchase = Item::find($item_id);

        $id = Auth::id();
        $user = User::find($id);
        $profiles = $user->profile()->get();
        $profile = $profiles[0];

        return view('/purchase/create', compact('purchase', 'profile', 'item_id'));
    }

    public function store(Request $request, $item_id)
    {
        dd($request);
        $id = Auth::id();
        $zipcode = $request->input('zipcode');
        $address = $request->input('address');
        $building = $request->input('building');
        $item = Item::find($item_id);
        $item->buyUsers()->attach($id, ['zipcode' => $zipcode, 'address' => $address, 'building' => $building]);

        $itemsAll = Item::query()->nameSearch($request->itemname)->get();

        $ismylist = false;
        foreach ($itemsAll as $item) {
            $id = Auth::id();
            $exhibitUsers = $item->exhibitUsers()->get();
            $ar = [];
            if (count($exhibitUsers) > 0) foreach ($exhibitUsers as $eUser) {
                $ar[] = $eUser->id;
            }
            if (!in_array($id, $ar)) {
                $items[] = $item;
            }
        }
        // TODO: strip call

        return view('items/index', compact('items', 'ismylist'));
    }
}
