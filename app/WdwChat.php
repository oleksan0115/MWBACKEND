<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class WdwChat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'wdw_chat';
    protected $fillable = [
        'chat_id',
        'dl_chat_id',
        'user_id',
        'chat_msg',
        'chat_img',
        'chat_video',
        'chat_time',
        'mapping_url',
        'chat_reply_update_time',
        'chat_status',
        'posted_from',
        'chat_room_id',
        'chat_room_name',
        'ip_address',
        'showonmain',
        'last_taged_on',
        'no_of_likes',
        'no_of_thanks',
        'isbump',
        'mac_address',
        'iswatermark',
        'meetup_id',
        'comments',
        'isbestofthedaypost',
        'date_of_bod',
        'type_of_bod',
        'islock',
        'isadvertisepost',
        ];

	public function user()
    {
		
    return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','user_name','user_email','image','rank','position','totalpoints']);
    }
	
	public function topimages() 
	{
        
    return $this->hasMany('App\TblMwMycollection','user_id','user_id')->select(['id', 'product_id','product_name','user_id','product_image'])->where
								 ([
								 ['is_featured', '=', '1'],
								 ['status', '>', '0'],
								 ]);
   }
   
	public function thanks()
    {
        return $this->hasMany('App\WdwThankYou','chat_id','chat_id')->select(['chat_id','user_id','user_name'])->where
								 ([
								 ['status', '=', '1'],
								 ]);
    }
	
	public function checksticky()
    {
		
        return $this->belongsTo('App\TblChatSticky','chat_id','chat_id')->select('*');
    }
    
   
	public function chatroom()
    {
		
        return $this->belongsTo('App\WdwChatRoom','chat_room_id','id')->select(['id','chat_room']);
    }
	
	public function comments()
    {
        return $this->hasMany('App\WdwChatReply','chat_id','chat_id')->select(['chat_reply_id','chat_id','reply_user_id','chat_reply_msg','chat_reply_date','chat_reply_img','no_of_likes'])->orderBy('chat_reply_date', 'ASC');
    }
	
	public function tagcomposit()
    {
        return $this->hasMany('App\WdwTagChatComposit','chat_id','chat_id')->select(['tags_id','chat_id']);
    }
   
	public function isbookmark()
    { 
        
		$user = auth()->user();
		if($user != null ){
		$user_id = $user->user_id;
		return $this->belongsTo('App\WdwLike','chat_id','chat_id')->select(['chat_id','status'])->where
								 ([
								 ['user_id', '=', $user_id],
								 ['status', '=', '1'],
								 ]);
		}
		else
		{
			 	return $this->belongsTo('App\WdwLike','chat_id','chat_id')->select(['user_id','chat_id','status']);
		}
	

    }
    
	public function isthankyou()
    { 
		$user = auth()->user();
		if($user != null ){
		$user_id = $user->user_id;
		return $this->belongsTo('App\WdwThankYou','chat_id','chat_id')->select(['chat_id','status','user_id'])->where
								 ([
								 ['user_id', '=', $user_id],
								 ['status', '=', '1'],
								 ]);
		}
		else
		{
		return $this->belongsTo('App\WdwThankYou','chat_id','chat_id')->select(['user_id','chat_id','status']);
		
		}
	

    }
	
    public function wdwchat()
    {
		
        return $this->hasMany('App\WdwChatReply','chat_id','chat_id')->select(['chat_reply_id','chat_id','reply_user_id','chat_reply_msg']);
    }
  
	
  
}
