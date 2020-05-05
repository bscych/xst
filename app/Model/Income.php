<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
     public function constant() {
        return $this->hasOne('App\Model\Constant', 'id', 'name_of_account');
    }

    public function creator() {
        return $this->hasOne('App\user', 'id', 'operator');
    }
}
