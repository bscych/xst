<?php

namespace App\Policies;

use App\Model\Specialdate;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecialdatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any specialdates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the specialdate.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Specialdate  $specialdate
     * @return mixed
     */
    public function view(User $user, Specialdate $specialdate)
    {
        //
    }

    /**
     * Determine whether the user can create specialdates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
       return true;
    }

    /**
     * Determine whether the user can update the specialdate.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Specialdate  $specialdate
     * @return mixed
     */
    public function update(User $user, Specialdate $specialdate)
    {
        //
    }

    /**
     * Determine whether the user can delete the specialdate.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Specialdate  $specialdate
     * @return mixed
     */
    public function delete(User $user, Specialdate $specialdate)
    {
        //
    }

    /**
     * Determine whether the user can restore the specialdate.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Specialdate  $specialdate
     * @return mixed
     */
    public function restore(User $user, Specialdate $specialdate)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the specialdate.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Specialdate  $specialdate
     * @return mixed
     */
    public function forceDelete(User $user, Specialdate $specialdate)
    {
        //
    }
}
