<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblMwCreditDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_mw_credits_details';
    protected $fillable = [
        'id',
        'user_id',
        'credits',
        'debit',
        'current_credits',
        'type',
        'points_used',
        'amount',
        'ip_address',
        'status',
        'createdon',
        'paypal_transaction_id',
        'appsstore_receipt_id',
        'paypal_payer_email',
        'paypal_receiver_email',
        'description',
        'current_rank_atthis_point',
        'current_balance_atthis_point',
        'apptype',
        'appname',
        'appversion',
        'os',
        ];
		

		
    
   
}
