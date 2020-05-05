<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model {

    use SoftDeletes;

    public function classmodels() {
        return $this->belongsToMany('App\Model\Classmodel', 'course_student', 'student_id', 'classmodel_id')->where('start_date', '<', now());
    }

}
