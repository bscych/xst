<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model {

    
    public function student() {
        return $this->hasOne('App\Model\Student', 'id', 'student_id');
    }
    
     public function classmodel() {
        return $this->hasOne('App\Model\Classmodel', 'id', 'classmodel_id');
    }    
}
