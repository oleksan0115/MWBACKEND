<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TblBestOfPostHour extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_best_of_post_hourly';
    protected $fillable = [
        'id',
        'chat_id',
        'user_id',
        'order_no',
        'status',
        'createdon',
        'isbumped',
        'bumpedon',
        ];

public function chat()
    {
		 return $this->hasMany('App\TblChat','chat_id','chat_id')->select(['chat_id','chat_msg','chat_img','chat_video','chat_time as createdon','chat_reply_update_time','no_of_thanks','chat_room_id','iswatermark',DB::raw('(no_of_likes + no_of_thanks) as totalcounts')]);
    }
	

	public function user()
    {
		 return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','user_name','user_email','image','rank','position','totalpoints','user_status','default_park','isdirect_msg','likes_points','thanks_points','quality_rank as total_likes_points']);
    }
    
    
  
}
