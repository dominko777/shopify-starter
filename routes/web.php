<?php

use App\Http\Controllers\ProductController;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
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

Route::get('/login', function () {
    if (Auth::user()) {
        return redirect()->route('home');
    }
    return view('login');
})->name('login'); 

Route::post('/configure-theme',  );




Route::middleware(['auth.shopify'])->group(function () {
    Route::get('/', function () {
    	return view('reviews');
	})->middleware(['auth.shopify'])->name('home');

    Route::get('product', 'App\Http\Controllers\ProductController@show');
    Route::resource('products', ProductController::class);
	Route::view('/settings', 'settings');
    Route::delete('/reviews/delete-multiply/{ids}', 'App\Http\Controllers\ReviewController@deleteMultiply');
    Route::post('/reviews/bookmark/{id}', 'App\Http\Controllers\ReviewController@bookmark');
    Route::get('/reviews/stat/{daysAgo}', 'App\Http\Controllers\ReviewController@getStat');
    Route::post('/reviews/toogle-read-status/{id}', 'App\Http\Controllers\ReviewController@toogleReadStatus');
    Route::apiResource('/reviews', 'App\Http\Controllers\ReviewController');
    
});


