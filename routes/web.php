<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
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


Route::post('reviews', 'App\Http\Controllers\ReviewController@store')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
Route::get('product', 'App\Http\Controllers\ProductController@show');
Route::post('reviews/average-stars', 'App\Http\Controllers\ReviewController@getAverageStars')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
Route::post('shop/reviews', 'App\Http\Controllers\ReviewController@shopReviews')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::middleware(['auth.shopify'])->group(function () {
    Route::get('/', function () {
    	return view('reviews');
	})->middleware(['auth.shopify'])->name('home');
    
    Route::resource('products', ProductController::class);
	Route::view('/settings', 'settings');
    Route::delete('/reviews/delete-multiply/{ids}', 'App\Http\Controllers\ReviewController@deleteMultiply');
    Route::post('/reviews/bookmark/{id}', 'App\Http\Controllers\ReviewController@bookmark');
    Route::get('/reviews/stat/{daysAgo}', 'App\Http\Controllers\ReviewController@getStat');
    Route::post('/reviews/toogle-read-status/{id}', 'App\Http\Controllers\ReviewController@toogleReadStatus');
    Route::apiResource('/reviews', 'App\Http\Controllers\ReviewController')->except([
        'store'
    ]);
    Route::resource('settings',SettingController::class)->except(['show']);
    Route::get('/settings/show', 'App\Http\Controllers\SettingController@show');
    
});


