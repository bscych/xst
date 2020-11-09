<?php

namespace App\Policies;

use App\Model\Serviceitem;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceitemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any serviceitems.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the serviceitem.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Serviceitem  $serviceitem
     * @return mixed
     */
    public function view(User $user, Serviceitem $serviceitem)
    {
        //
    }

    /**
     * Determine whether the user can create serviceitems.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the serviceitem.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Serviceitem  $serviceitem
     * @return mixed
     */
    public function update(User $user, Serviceitem $serviceitem)
    {
        //
    }

    /**
     * Determine whether the user can delete the serviceitem.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Serviceitem  $serviceitem
     * @return mixed
     */
    public function delete(User $user, Serviceitem $serviceitem)
    {
        //
    }

    /**
     * Determine whether the user can restore the serviceitem.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Serviceitem  $serviceitem
     * @return mixed
     */
    public function restore(User $user, Serviceitem $serviceitem)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the serviceitem.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Serviceitem  $serviceitem
     * @return mixed
     */
    public function forceDelete(User $user, Serviceitem $serviceitem)
    {
        //
    }
}
