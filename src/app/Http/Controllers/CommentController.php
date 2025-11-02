<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $item_id)
    {
        $item = Item::find($item_id);
        $id = Auth::id();
        $comment = $request->comment;
        $item->comments()->attach($id, ['comment' => $comment]);

        return redirect()->back();
    }
}
