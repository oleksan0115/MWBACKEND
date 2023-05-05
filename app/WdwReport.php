<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class WdwReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'wdw_report';
    protected $fillable = [
        'id',
        'chat_id',
        'user_id',
        'user_name',
        'status',
        'createdon',
        'type',
        'reasion_for_report',
        ];
		
		
	
    /* 
    	public function chat()
    {
		 return $this->belongsTo('App\TblChat','chat_id','chat_id')->select(['chat_id','user_id','chat_msg','chat_img','chat_status']);
    }
    
    	public function user()
    {
		 return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','user_name as postedusername']);
    }
    
      public function comments()
    {
        return $this->hasMany('App\Comment','chat_reply_id','chat_id')->select(['chat_reply_id','chat_id','reply_user_id','chat_reply_msg as chat_msg']);
    }
     */
    

   
}
