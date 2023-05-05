<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblRide extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_rides';
    protected $fillable = [
        'rides_id',
        'avg_time',
        'avg_upd_time',
        'park_id',
        'rides_name',
        'rides_location',
        'rides_waittime',
        'lat',
        'lon',
        'rides_update_time',
        'opening_time',
        'closing_time',
        'fastpass',
        'is_fastpass',
        'rides_status',
        'ride_mw_rank',
        'islock',
        'isfood',
        'crowd_index',
        'is_crowdindex',
        'youtube',
        'yelp',
        'wikipedia',
        'default_waittime',
        'no_of_time_added',
        'last_updated_wt_user_id',
        'last_updated_wt_user_name',
        'wt_postedon',
        'last_updated_fp_user_id',
        'last_updated_fp_user_name',
        'fp_postedon',
        'is_show_username_wt',
        'is_show_username_fp',
        ];
		
	 public function park()
    {
        return $this->hasMany('App\TblPark','park_id','park_id');
    }
    
   
}
