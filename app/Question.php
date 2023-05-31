<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $timestamps = false;
    protected $table = 'initial_questions';
    protected $fillable = [
      'question',
      'question_category_id',
    ];
}
