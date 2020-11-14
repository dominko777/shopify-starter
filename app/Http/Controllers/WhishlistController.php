<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; 
use App\Models\Whishlist;
use Illuminate\Http\Request;

class WhishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = Auth::user();
        $products = Whishlist::where('shop_id', $shop->name)->get();
        $list = [];
        foreach ($products as $product) {
            $list[] = "gid://shopify/Product/" . $product->product_id;
        }
        $list = json_encode($list);
        $query = "
            { 
                nodes (ids: $list) {
                ...on Product{
                  id
                  title
                }
              }
            }
        "; 
        $products = $shop->api()->graph($query);
        return view('products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Whishlist::updateOrCreate($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Whishlist  $whishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Whishlist $whishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Whishlist  $whishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Whishlist $whishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Whishlist  $whishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Whishlist $whishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Whishlist  $whishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $item = Whishlist::where([
            'shop_id' => $request['shop_id'],
            'customer_id' => $request['customer_id'],
            'product_id' => $request['product_id']
        ])->first();

        return Whishlist::destroy($item->id); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Whishlist  $whishlist
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        $item = Whishlist::where([
            'shop_id' => $request['shop_id'],
            'customer_id' => $request['customer_id'],
            'product_id' => $request['product_id']
        ])->first();

        if ($item) {
            return 1;
        } else {
            return 0;
        }
    }
}
