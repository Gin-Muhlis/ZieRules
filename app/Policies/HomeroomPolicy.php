<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Homeroom;
use Illuminate\Auth\Access\HandlesAuthorization;

class HomeroomPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the homeroom can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list homerooms');
    }

    /**
     * Determine whether the homeroom can view the model.
     */
    public function view(User $user, Homeroom $model): bool
    {
        return $user->hasPermissionTo('view homerooms');
    }

    /**
     * Determine whether the homeroom can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create homerooms');
    }

    /**
     * Determine whether the homeroom can update the model.
     */
    public function update(User $user, Homeroom $model): bool
    {
        return $user->hasPermissionTo('update homerooms');
    }

    /**
     * Determine whether the homeroom can delete the model.
     */
    public function delete(User $user, Homeroom $model): bool
    {
        return $user->hasPermissionTo('delete homerooms');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete homerooms');
    }

    /**
     * Determine whether the homeroom can restore the model.
     */
    public function restore(User $user, Homeroom $model): bool
    {
        return false;
    }

    /**
     * Determine whether the homeroom can permanently delete the model.
     */
    public function forceDelete(User $user, Homeroom $model): bool
    {
        return false;
    }
}
