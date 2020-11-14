<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Setting;
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
Route::post('/configure-theme',  );

Route::get('/', function () {
	$shop = Auth::user();
	$setting = Setting::where('shop_id', $shop->name)->first();
    return view('dashboard', compact('setting'));
})->middleware(['auth.shopify'])->name('home');

Route::view('/customers', 'customers');
Route::view('/settings', 'settings');
Route::get('/products', 'App\Http\Controllers\WhishlistController@index');  
