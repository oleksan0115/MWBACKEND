<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class LoginUserTracking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_user_login_tracking';
    protected $fillable = [
        'id',
        'user_name',
        'user_id',
        'login_datetime',
        'ip_address',
        'mac_address',
        'login_from',
        'no_of_login_from_ip',
        'status',
        'createdon',
        'user_email',
        'os',
        ];

public function user()
    {
		 return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','user_name','user_email','image','rank','position','totalpoints','user_status','default_park','isdirect_msg','likes_points','thanks_points','quality_rank as total_likes_points','ip_address']);
    }
	
  
}
