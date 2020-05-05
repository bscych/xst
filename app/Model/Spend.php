<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spend extends Model {

    use SoftDeletes;

    public function constant() {
        return $this->hasOne('App\Model\Constant', 'id', 'name_of_account');
    }

    public function creator() {
        return $this->hasOne('App\user', 'id', 'operator');
    }

    public function school() {
        return $this->hasOne('App\Model\School', 'id', 'school_id');
    }

}
