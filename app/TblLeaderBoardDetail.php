<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblLeaderBoardDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_leaderboard_details';
    protected $fillable = [
        'id',
        'user_id',
        'availpoints',
        'Type',
        'status',
        'createdon',
        'Park_name',
        'who_is_user_id',
        'ip_address',
        ];

		
	public function user()
    {
		 return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','user_name','image','rank','position','totalpoints']);
    }
	
	
  
}
