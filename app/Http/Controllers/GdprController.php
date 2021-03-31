<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class GdprController extends Controller
{
    public function customersRedact (Request $request) {
    	return [];
    }

    public function shopRedact (Request $request) {
    	if ($request->has('shop_domain')) {
    		$shop = User::where('name', $request->shop_domain)->first();
    		if ($shop) {  
    			$settings = Setting::where('shop_id', $shop->id)->first();
    			if ($settings) {
	    			$settings->delete();
	    		}
    			$reviews = Review::where('user_id', $shop->id)->with('photos')->get();
    			foreach ($reviews as $review) {
    				foreach ($review->photos as $photo) {
    					$photo->delete();
    				}
    				$review->delete();
    			}  
    			$shop->delete();
    		}
    	}
    	return ['success' => true];  
    }

    public function customersDataRequest (Request $request) {
    	return [];
    }
}
