<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblRankReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_rank_report';
    protected $fillable = [
        'id',
        'totalpoints',
        'points_override',
        'mac_address',
        'user_name',
        'user_id',
        'position',
        'rank',
        'rank_status',
        'is_upd_points',
        'date_inst',
        'date_upd',
        'freezedon',
        'iscreditsfreez',
        'user_credits',
        'credit_updatedon',
        'last_updated_credits',
        'current_points_atcredits',
        'thanks_points',
        'likes_points',
        'quality_rank',
        'quality_position',
        'goateffect_points',
        'wait_time_points',
        'quality_points',
        'lounge_points',
        ];

			public function user()
    {
		 return $this->belongsTo('App\User','user_id','user_id')->select(['*']);
    }
    
	
  
}
