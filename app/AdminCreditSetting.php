<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AdminCreditSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'admin_credits_setting';
    protected $fillable = [
        'id',
        'createdon',
        'no_of_times',
        'start_date',
        'end_date',
        'status',
        'type',
        
    ];
	
	

  
}
