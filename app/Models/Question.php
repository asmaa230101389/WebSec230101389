<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model {
    use SoftDeletes;
    protected $fillable = ['question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer'];
}