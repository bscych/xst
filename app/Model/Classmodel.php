<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classmodel extends Model {

    use SoftDeletes;

    public function teacher() {
        return $this->hasOne('App\User', 'id', 'teacher_id');
    }

    public function course() {
        return $this->hasOne('App\Model\Course', 'id', 'course_id');
    }

    public function students() {
        return $this->belongsToMany('App\Model\Student', 'course_student', 'classmodel_id', 'student_id')->withPivot('how_many_left');

    }

}
