<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblThankYouEmail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_thanksyou_for_post_email';
    protected $fillable = [
        'id',
        'chat_id',
        'chat_user_id',
        'user_id',
        'user_name',
        'status',
        'createdon',
        'ip_address',
        ];

		
	
  
}
