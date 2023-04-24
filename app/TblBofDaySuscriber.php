<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblBofDaySuscriber extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_bof_day_subscriber';
    protected $fillable = [
        'id',
        'chat_id',
        'user_id',
        'user_name',
        'status',
        'createdon',
        'type',
        'istodaysent',
        'sentdatetime',
        ];


	public function user()
    {
		 return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','user_name','user_email']);
    }
	
  
}
