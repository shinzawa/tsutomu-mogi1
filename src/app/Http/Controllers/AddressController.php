<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class   AddressController extends Controller
{
    public function show() 
    {
        return view('/purchase/address');
    }

    public function update(Request $request)
    {
        $newaddress = $request->only([
            'zipcode',
            'address',
            'building',
        ]);

        return redirect()->route('/purchase/create')->with($newaddress);
    }
}
