<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'stars', 'name', 'avatar', 'email', 'is_recommended', 'notify_answer'];

    protected $hidden = ['created_at', 'updated_at'];
}
