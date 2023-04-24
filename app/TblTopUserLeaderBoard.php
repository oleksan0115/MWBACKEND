<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblTopUserLeaderBoard extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_top_user_leaderboard';
    protected $fillable = [
        'counter',
        'createdon',
        'user_id',
        'user_name',
        'lbtotalpoints',
        'image',
        'rnktotalpoints',
        'rmkposition',
        'rnkrank',
        'default_park',
        'weekly_rank',
        ];
		
  	public function user()
    {
		 return $this->belongsTo('App\User','user_id','user_id')->select('*');
    }
    
	
   
}
