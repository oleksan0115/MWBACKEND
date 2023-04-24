<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_chat_reply';
    protected $fillable = [
        'chat_reply_id',
        'chat_id',
        'reply_user_id',
        'chat_reply_msg',
        'chat_reply_date',
        'chat_reply_img',
        'chat_room_id',
        'meetup_id',
        'ip_address',
        'showonmain',
        'chat_reply_status',
        'record_status',
        'commented_on_user_id',
        'comment_chat_reply_id',
        'iscommnt',
        'no_of_likes',
        'no_of_thanks',
        'mac_address',
        'comment_updatedon',
       
        
    ];
	
	
	public function commentuser()
    {
		 return $this->belongsTo('App\User','reply_user_id','user_id')->select(['user_id','user_name','image','rank','position','totalpoints']);
    }

	  public function commentsreply()
    {
        return $this->hasMany('App\CommentReply','chat_reply_id','chat_reply_id')->select(['id','chat_reply_id','chat_id','reply_user_id','chat_reply_date','chat_reply_msg','no_of_likes'])->orderBy('chat_reply_date', 'DESC');
    }
    
    public function chat()
    {
		
        return $this->belongsTo('App\TblChat','chat_id','chat_id');
        
        //	$chatid = TblChat::select('user_id','chat_id')
					//->where('user_id',300579)->get();
					//dd($chatid);
			 //return $chatid;	
    }

  
}
