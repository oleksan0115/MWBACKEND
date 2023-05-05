<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblTriviaAppStorePurchase extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_trivia_appstore_purchases';
    protected $fillable = [
        'id',
        'quantity',
        'product_id',
        'transaction_id',
        'purchase_date',
        'app_item_id',
        'bid',
        'bvrs',
        'receipt_id',
        'user_id',
        'os',
        ];
		

		
    
   
}
