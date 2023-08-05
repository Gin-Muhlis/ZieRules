<?php

namespace App\Policies;

use App\Models\User;
use App\Models\HistoryScan;
use Illuminate\Auth\Access\HandlesAuthorization;

class HistoryScanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the historyScan can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list historyscans');
    }

    /**
     * Determine whether the historyScan can view the model.
     */
    public function view(User $user, HistoryScan $model): bool
    {
        return $user->hasPermissionTo('view historyscans');
    }

    /**
     * Determine whether the historyScan can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create historyscans');
    }

    /**
     * Determine whether the historyScan can update the model.
     */
    public function update(User $user, HistoryScan $model): bool
    {
        return $user->hasPermissionTo('update historyscans');
    }

    /**
     * Determine whether the historyScan can delete the model.
     */
    public function delete(User $user, HistoryScan $model): bool
    {
        return $user->hasPermissionTo('delete historyscans');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete historyscans');
    }

    /**
     * Determine whether the historyScan can restore the model.
     */
    public function restore(User $user, HistoryScan $model): bool
    {
        return false;
    }

    /**
     * Determine whether the historyScan can permanently delete the model.
     */
    public function forceDelete(User $user, HistoryScan $model): bool
    {
        return false;
    }
}
