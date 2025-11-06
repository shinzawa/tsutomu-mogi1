<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;
use App\Http\Requests\PurchaseRequest;


class PurchaseController extends Controller
{
    public $purchaseMethod;

    public function show(Request $request, $item_id)
    {
        $purchase = Item::find($item_id);

        $id = Auth::id();
        $user = User::find($id);
        $profiles = $user->profile()->get();
        $profile = $profiles[0];

        $purchaseMethod = ['purchaseMethod' => null];
        return view('/purchase/create', compact('purchase', 'profile', 'item_id', 'purchaseMethod'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
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
