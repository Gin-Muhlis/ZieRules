<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DataTask;
use Illuminate\Auth\Access\HandlesAuthorization;

class DataTaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dataTask can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list datatasks');
    }

    /**
     * Determine whether the dataTask can view the model.
     */
    public function view(User $user, DataTask $model): bool
    {
        return $user->hasPermissionTo('view datatasks');
    }

    /**
     * Determine whether the dataTask can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create datatasks');
    }

    /**
     * Determine whether the dataTask can update the model.
     */
    public function update(User $user, DataTask $model): bool
    {
        return $user->hasPermissionTo('update datatasks');
    }

    /**
     * Determine whether the dataTask can delete the model.
     */
    public function delete(User $user, DataTask $model): bool
    {
        return $user->hasPermissionTo('delete datatasks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete datatasks');
    }

    /**
     * Determine whether the dataTask can restore the model.
     */
    public function restore(User $user, DataTask $model): bool
    {
        return false;
    }

    /**
     * Determine whether the dataTask can permanently delete the model.
     */
    public function forceDelete(User $user, DataTask $model): bool
    {
        return false;
    }
}
