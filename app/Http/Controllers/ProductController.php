<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shop = Auth::user();
        $queryString = '';
        if ($request->has('q')) {
             $queryString = ', query: "title:*${' . $request->q . '}*"';
        } 
        $query = '
            {
                products(first:10' . $queryString . ') {
                        edges {
                            node {
                                id
                                title
                            }
                        }
                    }
            }
        ';
        $products = $shop->api()->graph($query);
        return $products;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = null;
        if ($request->has('id')) {
            $id = $request->id;
        }
        $shop = Auth::user();
        $query = '
            {
              product(id: "' . $id . '") {
                id
                    handle
                    variants (first:5) {
                        edges {
                            node {
                                title
                            }
                        }
                    }
                }
            }
        ';
        $product = $shop->api()->graph($query);
        return $product;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
