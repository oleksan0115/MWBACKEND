<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TaggedUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_users_taged';
    protected $fillable = [
        'id',
        'user_id',
        'taged_user_id',
        'chat_id',
        'comment_message',
        'chat_url',
        'status',
        'createdon',
        'comment_id',
        'taged_type',
        ];


		public function user()
    {
		
        return $this->belongsTo('App\User','user_id','user_id');
    }
    
    
   public function chat()
    {
		
        return $this->belongsTo('App\TblChat','chat_id','chat_id');
    }
    
       public function comments()
    {
        return $this->hasMany('App\Comment','chat_id','chat_id')->select(['chat_reply_id','chat_id','reply_user_id','chat_reply_msg','chat_reply_date','chat_reply_img','chat_reply_status','comment_updatedon']);
    }
    
    
    	public function wdwchat()
    {
		
        return $this->hasMany('App\WdwChat','taged_user_id','user_id');
    }
	
	  	public function conversiondata()
    {
		
        return $this->hasMany('App\TextMessage','sender_user_id','taged_user_id');
    }
  
}
