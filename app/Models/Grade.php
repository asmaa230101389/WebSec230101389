<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model {
    use SoftDeletes;
    protected $fillable = ['course_name', 'credit_hours', 'grade', 'term'];
}