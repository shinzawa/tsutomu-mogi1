<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Mypage\ItemController as MypageItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AddressController;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile/create',  [ProfileController::class, 'show']);
    Route::post('/profile/create', [ProfileController::class, 'create']);
    Route::get('/profile/edit',  [ProfileController::class, 'edit']);
    Route::post('/profile/eidt', [ProfileController::class, 'update']);
    Route::get('/exhibit', [MypageItemController::class, 'show']);
    Route::post('/exhibit', [MypageItemController::class, 'sell']);
    Route::get('/mypage', [MypageItemController::class, 'mypage']);
    Route::get('/mypage/profile',  [ProfileController::class, 'edit']);
    Route::post('/mypage/profile', [ProfileController::class, 'update']);
    Route::get('/purchase/address', [AddressController::class, 'show']);
    Route::post('/purchase/address', [AddressController::class, 'update']);
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show']);
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store']);
    Route::post('/mypage/comment/{item_id}', [CommentController::class, 'create']);
});

Route::get('/', [ItemController::class, 'index']);
Route::get('/{tab?}', [ItemController::class, 'index']);
Route::get('/items/{item_id}', [ItemController::class, 'show']);
