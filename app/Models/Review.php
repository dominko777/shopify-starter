<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'stars', 'name', 'avatar', 'email', 'is_recommended', 'notify_answer'];

    protected $hidden = ['updated_at'];

    public function getCreatedAtAttribute()
	{
	     return  Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('d-m-Y h:i');
	}
}
