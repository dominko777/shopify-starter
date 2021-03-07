<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['rating', 'rating_color', 'images', 'review_reminder', 'reminder_email', 'reminder_email_subject', 'reminder_email_message', 'shop_id', 'activated', 'pagination_count',
    	'admin_pagination_count', 'modal_background_color', 'reviews_block_background'
	]; 
}
