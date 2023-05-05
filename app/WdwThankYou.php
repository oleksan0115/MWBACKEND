<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class WdwThankYou extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'wdw_thanksyou_for_post';
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

		public function user()
    {
		
        return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','user_name','rank','position']);
    }
	
  
}
