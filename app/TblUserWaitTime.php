<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblUserWaitTime extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_user_waittime';
    protected $fillable = [
        'user_wt_id',
        'rides_id',
        'wt_time',
        'wt_cur_time',
        'user_ip',
        'mac_address',
        'status',
        'user_id',
        'user_name',
        'ext_point',
        'upd_time',
        'rank_status',
        'is_show_username',
        ];
		

   
}
