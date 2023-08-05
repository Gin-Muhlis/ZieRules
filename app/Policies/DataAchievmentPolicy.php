<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DataAchievment;
use Illuminate\Auth\Access\HandlesAuthorization;

class DataAchievmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dataAchievment can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list dataachievments');
    }

    /**
     * Determine whether the dataAchievment can view the model.
     */
    public function view(User $user, DataAchievment $model): bool
    {
        return $user->hasPermissionTo('view dataachievments');
    }

    /**
     * Determine whether the dataAchievment can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create dataachievments');
    }

    /**
     * Determine whether the dataAchievment can update the model.
     */
    public function update(User $user, DataAchievment $model): bool
    {
        return $user->hasPermissionTo('update dataachievments');
    }

    /**
     * Determine whether the dataAchievment can delete the model.
     */
    public function delete(User $user, DataAchievment $model): bool
    {
        return $user->hasPermissionTo('delete dataachievments');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete dataachievments');
    }

    /**
     * Determine whether the dataAchievment can restore the model.
     */
    public function restore(User $user, DataAchievment $model): bool
    {
        return false;
    }

    /**
     * Determine whether the dataAchievment can permanently delete the model.
     */
    public function forceDelete(User $user, DataAchievment $model): bool
    {
        return false;
    }
}
