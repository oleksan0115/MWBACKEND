<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class BestOfTheDay extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_best_of_chats';
    protected $fillable = [
        'id',
        'chat_id',
        'user_id',
        'status',
        'createdon',
        'isbumped',
        'bumpedon',
        ];
		

		public function user()
    {
		
        return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','user_name','user_email','image','rank','position','totalpoints','user_status']);
    }
    
    
    
    public function chat()
    {
		
        return $this->belongsTo('App\TblChat','chat_id','chat_id');
    }
    
   
}
