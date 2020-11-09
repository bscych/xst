<?php

namespace App\Policies;

use App\Model\Course;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy {

    use HandlesAuthorization;

    /**
     * Determine whether the user can view any courses.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user) {
        return true;
    }

    /**
     * Determine whether the user can view the course.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Course  $course
     * @return mixed
     */
    public function view(User $user, Course $course) {
//       同一所学校下的课程对supervisor以上的人可见
//        不同学校的课程对不同的学校的老师不可见
        return true;
    }

    /**
     * Determine whether the user can create courses.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user) {
        return true;
    }

     public function edit(User $user) {
        $roles = $user->roles;
        $result = $roles->whereIn('name', ['admin', 'headmaster', 'supervisor'])->count() > 0;
        return $result;
    }
    
    /**
     * Determine whether the user can update the course.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Course  $course
     * @return mixed
     */
    public function update(User $user, Course $course) {
        $roles = $user->roles;
        $result = $roles->whereIn('name', ['admin', 'headmaster', 'supervisor'])->count()> 0;
        return $result;
    }
    
//     public function update(User $user,$id) {
//        $roles = $user->roles;
//        $result = $roles->whereIn('name', ['admin', 'headmaster', 'supervisor'])->count()> 0;
//        return $result;
//    }

    /**
     * Determine whether the user can delete the course.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Course  $course
     * @return mixed
     */
    public function delete(User $user, Course $course) {
       return true;
    }

    /**
     * Determine whether the user can restore the course.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Course  $course
     * @return mixed
     */
    public function restore(User $user, Course $course) {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the course.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Course  $course
     * @return mixed
     */
    public function forceDelete(User $user, Course $course) {
       return true;
    }

    /*
     * determine whether the user can view student list of the course
     */

    public function studentList(User $user) {
        return true;
    }

}
