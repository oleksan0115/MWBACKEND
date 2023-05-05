<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblBanIp extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_banip';
    protected $fillable = [
        'ban_id',
        'ban_ip',
        'ban_add',
        'ban_time',
        'user_id',
        'banby',
        'banby_ip_address',
        'pagefrom',
        ];
		
   
}
