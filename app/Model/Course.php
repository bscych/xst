<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model {

    use SoftDeletes;

    protected $fillable = ['name'];

    public function students() {       
        return $this->belongsToMany('App\Model\Student', 'course_student', 'course_id', 'student_id')->withPivot(['classmodel_id']);
    }
    public function classes() {
        return $this->hasMany('App\Model\Classmodel');
    }
    public function school(){
        return $this->belongsTo('App\Model\School');
    }

}
