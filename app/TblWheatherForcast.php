<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblWheatherForcast extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_weather_forecast';
    protected $fillable = [
        'id',
        'datetime',
        'current_condition',
        'status',
        'createdon',
        'current_temp',
        'current_image',
        'current_text',
        'forecast1',
        'forecast_text',
        'forecast2',
        'forecast3',
        'forecast4',
        'forecast5',
        
        ];


    
    
    
  
}
