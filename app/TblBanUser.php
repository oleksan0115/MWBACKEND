<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblBanUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_ban_users';
    protected $fillable = [
        'id',
        'user_id',
        'ban_user_id',
        'status',
        'createdon',
        'reasion_for_ban',
        ];
		

   
}
