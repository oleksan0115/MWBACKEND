<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblUserRight extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_user_rights';
    protected $fillable = [
        'id',
        'user_id',
        'rights_id',
        'status',
        'createdon',
        ];
		
   public function menuname()
    {
		 return $this->hasOne('App\TblRight','id','rights_id');
    }
	
   
}
