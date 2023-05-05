<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblUserSuscribeViaEmail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_user_subscribe_via_email';
    protected $fillable = [
        'id',
        'user_id',
        'user_name',
        'subscriber_user_id',
        'subscriber_user_name',
        'createdon',
        'status',
        ];
		

    
   
}
