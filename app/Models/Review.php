<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; 

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'stars', 'name', 'avatar', 'email', 'is_recommended', 'notify_answer', 'user_id', 'is_read', 'comment', 'pagination_count', 'product_title', 'product_id']; 

    protected $appends = [
        'created_at_date',
        /* 'product', */
    ];

    protected $hidden = ['updated_at'];

    public function getCreatedAtAttribute()
	{
	     return  Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('d-m-Y h:i');
	}

	public function getCreatedAtDateAttribute()
	{
        if (isset($this->attributes['created_at'])) {
	     return  Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('d-m-Y');  
        } else return '';
	}

	public function photos()
    {
        return $this->hasMany('App\Models\Photo');
    } 

    /* public function getProductAttribute() {
        $id = null;
        if ($this->product_id) {
            $id = $this->product_id;
        }
        $shop = Auth::user(); 
        $query = '
            {
              product(id: "' . $id . '") {
                title
                description
                onlineStoreUrl
              }
            }
        ';
        $product = $shop->api()->graph($query);
        if(isset($product['body']['data']['product'])) {
            $product = $product['body']['data']['product'];
        }  
        return $product;
    } */

    public function bookmarks()
    {   
      return $this->belongsToMany('App\Models\User', 'bookmarks');
    }

}
