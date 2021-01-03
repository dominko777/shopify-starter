<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Review;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shop = Auth::user();
        $reviews = Review::withCount('photos');
        $reviews->where('user_id', $shop->id);
        if ($request->has('search_query') && !empty($request->search_query)) {
            $searchQuery = $request->search_query;
            $reviews->where(function ($query) use ($shop, $searchQuery) {
                $queryString = ', query: "title:*${' . $searchQuery . '}*"';
                $apiQuery = '
                    {
                        products(first:100' . $queryString . ') {
                                edges {
                                    node {
                                        id
                                        title
                                    }
                                }
                            }
                    }
                ';
                $products = $shop->api()->graph($apiQuery);
                $productIds = [];
                if ($products['body']['data']['products']['edges']) {
                    foreach($products['body']['data']['products']['edges'] as $product){
                        $productIds[] = $product['node']['id'];
                    }
                }
                $query->where('name', 'like', "%$searchQuery%")
                      ->orWhere('description', 'like', "%$searchQuery%")
                      ->orWhere(function ($q) use ($productIds) {
                        $q->whereIn('product_id', $productIds);
                      });
            });
        }
        if ($request->has('productId') && !empty($request->productId)) {
            $reviews->where('product_id', 'like', "%$request->productId%");
        }
        if ($request->has('rating')) {
            $reviews->where('stars', $request->rating);
        }
        if ($request->has('recommended')) {
            $recommended = filter_var($request->recommended, FILTER_VALIDATE_BOOLEAN);
            if ($recommended) {
                $reviews->where('is_recommended', true);
            } 
        }
        if ($request->has('notify_answer')) {
            $notifyAnswer = filter_var($request->input('notify_answer'), FILTER_VALIDATE_BOOLEAN);
            if ($notifyAnswer) {
                $reviews->where('notify_answer', true);
            } 
        }
        if ($request->has('from_date')) {
            if ($request->from_date && !empty($request->from_date)) {
                $fromDate = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
                $reviews->whereDate('created_at', '>=',  $fromDate); 
            }
        }
        if ($request->has('to_date')) {
            if ($request->to_date && !empty($request->to_date)) {
                $toDate = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');
                $reviews->whereDate('created_at', '<=',  $toDate);
            }      
        }
        if ($request->has('bookmarks') && $request->bookmarks) {
            $bookmarks = filter_var($request->bookmarks, FILTER_VALIDATE_BOOLEAN);
            if ($bookmarks) {
              $reviews->has('bookmarks');
            } 
        }
        $reviews = $reviews->with('bookmarks')->orderBy('created_at', 'DESC')->paginate(5);
        $response = [
            'pagination' => [
                'total' => $reviews->total(),
                'per_page' => $reviews->perPage(),
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
                'from' => $reviews->firstItem(),
                'to' => $reviews->lastItem()
            ],
            'data' => $reviews
        ];
        return response()->json($response);
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
    public function show(Review $review)
    {
        //
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
        $photos = Photo::where('review_id', $id)->delete();
        $review = Review::find($id); 
        return $review->delete(); 
    }

    public function deleteMultiply(Request $request) {
      Review::whereIn('id', explode(',', $request->ids))->delete();
      return (['status' => 'success']);
    }

    public function bookmark($id) {
      $shop = Auth::user();
      $hasBookmark = $shop->bookmarks()->where(['user_id' => $shop->id, 'review_id' => $id])->exists();
      if ($hasBookmark) {
        $status = 'detached';
        $shop->bookmarks()->detach($id);
      } else {
        $status = 'attached';
        $shop->bookmarks()->attach($id);
      }
      return ['status' => $status];
    }

    public function getStat($daysAgo) {

        $toDay = Carbon::now();
        $toDayCopy = Carbon::now();
        $days = [];
        $objectDays = [];
        $fromDay = $toDayCopy->subDays($daysAgo);
        $period = CarbonPeriod::create($fromDay, $toDay);
        foreach ($period as $date) {
          $days[]['date'] = $date->format('d-m-Y');
        }
        $reviews = Review::select(DB::Raw('COUNT(*) as `count`'), DB::Raw("DATE_FORMAT(created_at, '%d-%m-%Y') date"))
        ->whereDate('created_at', '>=',  $fromDay->format('Y-m-d'))
        ->whereDate('created_at', '<=',  $toDay->format('Y-m-d'))

        ->groupBy('date')->orderBy('date', 'ASC')
        ->get();  

        $dates = [];
        foreach ($days as $day) {
          $date = [];
          $date['date'] = $day['date']; 

          foreach ($reviews as $review) {
            $date['count'] = 0;
            if ($day['date'] == $review->date) {
              $date['count'] = $review->count;
              break;
            }
          }
          $dates[] = $date;
        }

        return ['dates' => $dates, 'fromDay' => $fromDay->format('d.m'), 'toDay' => $toDay->format('d.m')];
    }

    public function toogleReadStatus($id) {
      $review = Review::find($id);
      if ($review) {
        $review->is_read = 1;
        $review->update();
        return ['status' => 'success'];
      } else {
        return ['status' => 'error'];
      }
    }
}
