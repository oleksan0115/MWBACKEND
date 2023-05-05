<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblEmailTemplate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_email_templates';
    protected $fillable = [
        'id',
        'template_for',
        'subject',
        'template',
        'description',
        'status',
        'createdon',
        
    ];



  
}
