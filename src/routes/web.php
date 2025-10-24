<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Mypage\ItemController as MypageItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ItemController::class, 'index']);
Route::get('/{tab?}', [ItemController::class, 'index']);

Route::get('/items/{item_id}', [ItemController::class, 'show']);

Route::middleware('auth')->group(function () {
    Route::get('/profile_create',  [ProfileController::class, 'show']);
    Route::post('/profile_create', [ProfileController::class, 'create']);
    Route::get('/mypage', [MypageItemController::class, 'mypage']);
    Route::get('/mypage/profile',  [ProfileController::class, 'edit']);
    Route::post('/mypage/profile', [ProfileController::class, 'update']);
    Route::post('/mypage/comment', [ProfileController::class, 'create_comment']);
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase']);
    Route::get('/purchase/address/{item_id}', [ItemController::class, 'address']);
    Route::get('/sell', [ItemController::class, 'sell']);
});
