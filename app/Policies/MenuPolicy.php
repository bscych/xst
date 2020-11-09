<?php

namespace App\Policies;

use App\Model\Menu;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any menus.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the menu.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Menu  $menu
     * @return mixed
     */
    public function view(User $user, Menu $menu)
    {
        //
    }

    /**
     * Determine whether the user can create menus.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
       return true;
    }

    /**
     * Determine whether the user can update the menu.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Menu  $menu
     * @return mixed
     */
    public function update(User $user, Menu $menu)
    {
        //
    }

    /**
     * Determine whether the user can delete the menu.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Menu  $menu
     * @return mixed
     */
    public function delete(User $user, Menu $menu)
    {
        //
    }

    /**
     * Determine whether the user can restore the menu.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Menu  $menu
     * @return mixed
     */
    public function restore(User $user, Menu $menu)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the menu.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Menu  $menu
     * @return mixed
     */
    public function forceDelete(User $user, Menu $menu)
    {
        //
    }
}
