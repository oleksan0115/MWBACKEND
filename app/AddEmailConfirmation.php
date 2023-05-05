<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AddEmailConfirmation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_email_confirmation';
    protected $fillable = [
        'id',
        'user_id',
        'email_date',
        
    ];



  
}
