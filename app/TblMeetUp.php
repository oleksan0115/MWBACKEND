<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblMeetUp extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_meetups';
    protected $fillable = [
        'id',
        'event_name',
        'event_date',
        'event_time',
        'user_id',
        'posted_message',
        'images',
        'video',
        'post_datetime',
        'reply_update_time',
        'status',
        'ip_address',
        'no_of_likes',
        'no_of_thanks',
        'createdon',
        'meetup_room_id',
        ];


    	public function user()
    {
		 return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','user_name','user_email','image','rank','position','totalpoints','user_status','default_park','isdirect_msg','likes_points','thanks_points','quality_rank as total_likes_points','points_override']);
    }
    
    
  
}
