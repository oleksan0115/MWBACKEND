<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class WdwLike extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'wdw_like';
    protected $fillable = [
        'id',
        'chat_id',
        'user_id',
        'user_name',
        'status',
        'createdon',
        'ip_address',
        ];
		

	public function user()
    {
		return $this->belongsTo('App\User','user_id','user_id');
    }
    
    
    // public function chat()
    // {
		
        // return $this->belongsTo('App\TblChat','chat_id','chat_id')->select('chat_id','user_id','chat_msg','chat_video','chat_img','chat_time','chat_room_id','isbestofthedaypost','date_of_bod','type_of_bod','isadvertisepost','islock','mapping_url','no_of_likes as likecount','chat_status')->withCount('comments as commentcount');
    // }
    
   
}
