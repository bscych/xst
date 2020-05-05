<?php

namespace App\Policies;

use App\Model\Constant;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConstantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any constants.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->name ==='bscych';
    }

    /**
     * Determine whether the user can view the constant.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Constant  $constant
     * @return mixed
     */
    public function view(User $user, Constant $constant)
    {
        return $user->name =='bscych';
    }

    /**
     * Determine whether the user can create constants.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->name =='bscych';
    }

    /**
     * Determine whether the user can update the constant.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Constant  $constant
     * @return mixed
     */
    public function update(User $user, Constant $constant)
    {
        return $user->name =='bscych';
    }

    /**
     * Determine whether the user can delete the constant.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Constant  $constant
     * @return mixed
     */
    public function delete(User $user, Constant $constant)
    {
        return $user->name =='bscych';
    }

    /**
     * Determine whether the user can restore the constant.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Constant  $constant
     * @return mixed
     */
    public function restore(User $user, Constant $constant)
    {
        return $user->name ==='bscych';
    }

    /**
     * Determine whether the user can permanently delete the constant.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Constant  $constant
     * @return mixed
     */
    public function forceDelete(User $user, Constant $constant)
    {
       return $user->name =='bscych';
    }
}
