<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DataViolation;
use Illuminate\Auth\Access\HandlesAuthorization;

class DataViolationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dataViolation can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list dataviolations');
    }

    /**
     * Determine whether the dataViolation can view the model.
     */
    public function view(User $user, DataViolation $model): bool
    {
        return $user->hasPermissionTo('view dataviolations');
    }

    /**
     * Determine whether the dataViolation can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create dataviolations');
    }

    /**
     * Determine whether the dataViolation can update the model.
     */
    public function update(User $user, DataViolation $model): bool
    {
        return $user->hasPermissionTo('update dataviolations');
    }

    /**
     * Determine whether the dataViolation can delete the model.
     */
    public function delete(User $user, DataViolation $model): bool
    {
        return $user->hasPermissionTo('delete dataviolations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete dataviolations');
    }

    /**
     * Determine whether the dataViolation can restore the model.
     */
    public function restore(User $user, DataViolation $model): bool
    {
        return false;
    }

    /**
     * Determine whether the dataViolation can permanently delete the model.
     */
    public function forceDelete(User $user, DataViolation $model): bool
    {
        return false;
    }
}
