<?php

namespace App\Policies;

use App\Model\Menuitem;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuitemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any menuitems.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the menuitem.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Menuitem  $menuitem
     * @return mixed
     */
    public function view(User $user, Menuitem $menuitem)
    {
        //
    }

    /**
     * Determine whether the user can create menuitems.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
       return true;
    }

    /**
     * Determine whether the user can update the menuitem.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Menuitem  $menuitem
     * @return mixed
     */
    public function update(User $user, Menuitem $menuitem)
    {
        //
    }

    /**
     * Determine whether the user can delete the menuitem.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Menuitem  $menuitem
     * @return mixed
     */
    public function delete(User $user, Menuitem $menuitem)
    {
        //
    }

    /**
     * Determine whether the user can restore the menuitem.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Menuitem  $menuitem
     * @return mixed
     */
    public function restore(User $user, Menuitem $menuitem)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the menuitem.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Menuitem  $menuitem
     * @return mixed
     */
    public function forceDelete(User $user, Menuitem $menuitem)
    {
        //
    }
}
