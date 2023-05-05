<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CommentReply extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_chat_reply_reply';
    protected $fillable = [
        'id',
        'chat_reply_id',
        'chat_id',
        'reply_user_id',
        'chat_reply_msg',
        'chat_reply_date',
        'chat_reply_img',
        'chat_room_id',
        'meetup_id',
        'ip_address',
        'chat_reply_status',
        'no_of_likes',
        'no_of_thanks',
        'comment_on_user_id',
       
        
    ];


		public function replyuser()
    {
		 return $this->belongsTo('App\User','reply_user_id','user_id')->select(['user_id','user_name','image','rank','position','totalpoints']);
    }
  
}
