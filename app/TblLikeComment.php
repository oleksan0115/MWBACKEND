<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblLikeComment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_like_comments';
    protected $fillable = [
        'id',
        'chat_id',
		'comment_id',
        'user_id',
        'user_name',
        'status',
        'createdon',
        'ip_address',
        ];
		

	public function user()
    {
		 return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','user_name','image']);
    }
    
   
}
