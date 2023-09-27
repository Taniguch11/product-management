<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'items', 'as' => 'items.'], function () {
    // 商品一覧画面
    Route::get('index', [App\Http\Controllers\ItemController::class, 'index'])->name('index');
    // 検索
    Route::get('search', [App\Http\Controllers\ItemController::class, 'search'])->name('search');

    // 商品登録画面
    Route::get('create', [App\Http\Controllers\ItemController::class, 'create'])->name('create');
    // 登録機能
    Route::post('create', [App\Http\Controllers\ItemController::class, 'create'])->name('create');

    // 商品編集画面
    Route::get('edit/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('edit');
    // 編集機能
    Route::post('update/{id}', [App\Http\Controllers\ItemController::class, 'update'])->name('update');
    // 削除機能
    Route::post('destroy/{id}', [App\Http\Controllers\ItemController::class, 'destroy'])->name('destroy');
});
