<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ColorController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('login', [AdminController::class, 'login'])->name('login');
Route::post('login', [AdminController::class,'auth'])->name('auth');

Route::group(['prefix' => 'admin', 'as' => 'admin.','middleware' => ['admin']],function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('index');
    Route::post('logout', [AdminController::class, 'logout'])->name('logout');

    Route::resource('colors', ColorController::class);
});


