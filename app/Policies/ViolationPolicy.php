<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Violation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ViolationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the violation can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list violations');
    }

    /**
     * Determine whether the violation can view the model.
     */
    public function view(User $user, Violation $model): bool
    {
        return $user->hasPermissionTo('view violations');
    }

    /**
     * Determine whether the violation can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create violations');
    }

    /**
     * Determine whether the violation can update the model.
     */
    public function update(User $user, Violation $model): bool
    {
        return $user->hasPermissionTo('update violations');
    }

    /**
     * Determine whether the violation can delete the model.
     */
    public function delete(User $user, Violation $model): bool
    {
        return $user->hasPermissionTo('delete violations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete violations');
    }

    /**
     * Determine whether the violation can restore the model.
     */
    public function restore(User $user, Violation $model): bool
    {
        return false;
    }

    /**
     * Determine whether the violation can permanently delete the model.
     */
    public function forceDelete(User $user, Violation $model): bool
    {
        return false;
    }
}
