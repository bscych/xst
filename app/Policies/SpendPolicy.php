<?php

namespace App\Policies;

use App\Model\Spend;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpendPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any spends.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
       return true;
    }

    /**
     * Determine whether the user can view the spend.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Spend  $spend
     * @return mixed
     */
    public function view(User $user, Spend $spend)
    {
        //
    }

    /**
     * Determine whether the user can create spends.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
       return true;
    }

    /**
     * Determine whether the user can update the spend.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Spend  $spend
     * @return mixed
     */
    public function update(User $user, Spend $spend)
    {
        //
    }

    /**
     * Determine whether the user can delete the spend.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Spend  $spend
     * @return mixed
     */
    public function delete(User $user, Spend $spend)
    {
        //
    }

    /**
     * Determine whether the user can restore the spend.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Spend  $spend
     * @return mixed
     */
    public function restore(User $user, Spend $spend)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the spend.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Spend  $spend
     * @return mixed
     */
    public function forceDelete(User $user, Spend $spend)
    {
        //
    }
}
