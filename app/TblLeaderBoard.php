<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblLeaderBoard extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_leaderboard';
    protected $fillable = [
        'id',
        'user_id',
        'totalpoints',
        'rank',
        'position',
        'date',
        'status',
        ];

	public function user()
    {
		 return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','user_name','image','rank','position','totalpoints']);
    }
	
  
}
