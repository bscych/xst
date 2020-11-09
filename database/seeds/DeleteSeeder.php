<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
class DeleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
         Schema::dropIfExists('class_rooms');
         Schema::dropIfExists('holidays');
         Schema::dropIfExists('model_has_permissions');
         Schema::dropIfExists('model_has_roles');
          Schema::dropIfExists('role_has_permissions');
         Schema::dropIfExists('permissions');
         Schema::dropIfExists('roles');
         Schema::dropIfExists('schedule_student');
         Schema::dropIfExists('teacher');
    }
    
    
}
