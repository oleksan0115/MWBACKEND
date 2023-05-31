<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionCategory extends Model
{
    public $timestamps = false;
    protected $table = 'initial_question_categories';
    protected $fillable = [
      'category_name',
    ];
}
