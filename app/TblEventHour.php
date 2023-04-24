<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblEventHour extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_event_hours';
    protected $fillable = [
        'id',
        'event_date',
        'magic_hours',
        'deluxe',
        'SoCal',
        'SoCal_Select',
        'signature_plus',
        'signature',
        'status',
        'createdon',
        'DL_park_timing',
        'DCA_park_timing',
        'refurbishment',
        'dca_refurbishment',
        ];


    
    
    
  
}
