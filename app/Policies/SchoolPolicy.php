<?php

namespace App\Policies;

use App\Model\School;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;

class SchoolPolicy {

    use HandlesAuthorization;

    /**
     * Determine whether the user can view any schools.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user) {
     
        return $user->id===1;
    }

    /**
     * Determine whether the user can view the school.
     *
     * @param  \App\User  $user
     * @param  \App\Model\School  $school
     * @return mixed
     */
    public function view(User $user, School $school) {
        if ($user->name === 'bscych') {
            return true;
        } else {
            //总校的校长的学校可见
            $schools = DB::table('user_has_role_in_school')->where('user_id', $user->id)->where('constant_id',47)->where('school_id',$school->id)->get();
            //总校下的分校，总校校长可见
            
            //分校校长可见自己的学校
            return $schools->isNotEmpty();
           
        }
    }
    
    


    /**
     * Determine whether the user can create schools.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user) { 
       return $user->name === 'bscych';
    }

    /**
     * Determine whether the user can update the school.
     *
     * @param  \App\User  $user
     * @param  \App\Model\School  $school
     * @return mixed
     */
    public function update(User $user, School $school) {

       return session()->get('school_id')===$school->id;
    }

    /**
     * Determine whether the user can delete the school.
     *
     * @param  \App\User  $user
     * @param  \App\Model\School  $school
     * @return mixed
     */
    public function delete(User $user, School $school) {
        //
    }

    /**
     * Determine whether the user can restore the school.
     *
     * @param  \App\User  $user
     * @param  \App\Model\School  $school
     * @return mixed
     */
    public function restore(User $user, School $school) {
        $user_id = $user->id;
        $school_id = $school->id;
        return true;
    }

    /**
     * Determine whether the user can permanently delete the school.
     *
     * @param  \App\User  $user
     * @param  \App\Model\School  $school
     * @return mixed
     */
    public function forceDelete(User $user, School $school) {
        //
    }

}
