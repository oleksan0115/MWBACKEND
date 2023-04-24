<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class MwProduct extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_mw_products';
    protected $fillable = [
        'id',
        'product_name',
        'product_description',
        'product_quantity',
        'product_price',
        'product_image',
        'status',
        'active_datetime',
        'active_end_datetime',
        'createdon',
        'owner_only',
        'isemojis',
        'emoji_category_id',
        'isauction',
        'start_auction_date',
        'end_auction_date',
        'isauctionclosed',
        'no_of_bids',
        'highest_bid',
        'highest_bid_user_id',
        'highest_bid_user_name',
        'initial_bid',
        'auction_closed_on',
        ];


	
  
}
