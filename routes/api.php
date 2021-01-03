<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/add-to-whishlist', 'App\Http\Controllers\WhishlistController@store');
Route::post('/delete-to-whishlist', 'App\Http\Controllers\WhishlistController@destroy');
Route::post('/check-whishlist', 'App\Http\Controllers\WhishlistController@check');


