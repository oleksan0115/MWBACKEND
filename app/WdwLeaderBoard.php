<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class WdwLeaderBoard extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'wdw_leaderboard';
    protected $fillable = [
        'id',
        'user_id',
        'totalpoints',
        'position',
        'date',
        'status',
        ];

		
	
  
}
