<?php

namespace App\Policies;

use App\Model\Classmodel;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassmodelPolicy {

    use HandlesAuthorization;

    /**
     * Determine whether the user can view any classmodels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user) {

        return true;
    }

    /**
     * Determine whether the user can view the classmodel.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Classmodel  $classmodel
     * @return mixed
     */
    public function view(User $user, Classmodel $classmodel) {
        $roles = $user->roles;
        $result = $roles->whereIn('name', ['headmaster', 'supervisor'])->count() > 0;
        return $result;
    }

    /**
     * Determine whether the user can create classmodels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user) {
        $roles = $user->roles;
        $result = $roles->whereIn('name', ['headmaster', 'supervisor'])->count() > 0;
        return $result;
    }

    /**
     * Determine whether the user can update the classmodel.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Classmodel  $classmodel
     * @return mixed
     */
    public function update(User $user, Classmodel $classmodel) {
        $roles = $user->roles;
        $result = $roles->whereIn('name', ['headmaster', 'supervisor'])->count() > 0;
        return $result;
    }

    /**
     * Determine whether the user can delete the classmodel.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Classmodel  $classmodel
     * @return mixed
     */
    public function delete(User $user, Classmodel $classmodel) {
        $roles = $user->roles;
        $result = $roles->whereIn('name', ['headmaster'])->count() > 0;
        return $result;
    }

    /**
     * Determine whether the user can restore the classmodel.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Classmodel  $classmodel
     * @return mixed
     */
    public function restore(User $user, Classmodel $classmodel) {
        //
    }

    /**
     * Determine whether the user can permanently delete the classmodel.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Classmodel  $classmodel
     * @return mixed
     */
    public function forceDelete(User $user, Classmodel $classmodel) {
        //
    }

}
