<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;


class   AddressController extends Controller
{
    public function show(Request $request, $item_id)
    {
        $purchaseMethod = $request->only(['purchaseMethod']);
                
        return view('/purchase/address', compact('item_id', 'purchaseMethod'));
    }

    public function update(Request $request, $item_id)
    {
        $newaddress = $request->only([
            'zipcode',
            'address',
            'building',
        ]);

        $purchase = Item::find($item_id);

        $id = Auth::id();
        $user = User::find($id);
        $profiles = $user->profile()->get();
        $profile = $profiles[0];

        $purchaseMethod = $request->only(['purchaseMethod']);

        return view('/purchase/create', compact('purchase', 'profile', 'newaddress', 'item_id', 'purchaseMethod'));
    }
}
