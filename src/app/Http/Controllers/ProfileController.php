<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Models\User;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return view('/profile/create');
    }

    public function create(Request $request)
    {
        // store image file to defined place
        $image = $request->file('image');
        if (isset($image)) {
            $path = $image->store('', 'public');
        }

        // DB register oparation 
        $data = $request->only([
            'name',
            'zipcode',
            'address',
            'building',
        ]);
        $id = Auth::id();
        $data = array_merge($data, ['image' => $path, 'user_id' => $id]);
        Profile::create($data);

        return redirect('/');
    }

    public function edit(Request $request)
    {
        $id = Auth::id();
        $user = User::find($id);
        $profiles = $user->profile()->get();
        $profile = $profiles[0];
        return view('/profile/edit', compact('profile'));
    }

    public function update(Request $request)
    {
        // must delete old file 
        $id = Auth::id();
        $user = User::find($id);
        $profiles = $user->profile()->get();
        $profile = $profiles[0];
        $image = $profile->image;
        // delete old file
        if (!empty($image)) {
            Storage::disk('public')->delete($image);
        }
        // store image file to defined place
        $image = $request->file('image');
        if (isset($image)) {
            $path = $image->store('', 'public');
        }
        // DB register oparation 
        $data = $request->only([
            'name',
            'zipcode',
            'address',
            'building',
        ]);

        $data = array_merge($data, ['image' => $path]);
        $profile->update($data);

        return redirect('/mypage');
    }
}
