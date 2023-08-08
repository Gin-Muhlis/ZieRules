<?php

namespace App\Policies;

use App\Models\User;
use App\Models\HistoryTask;
use Illuminate\Auth\Access\HandlesAuthorization;

class HistoryTaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the historyTask can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list historytasks');
    }

    /**
     * Determine whether the historyTask can view the model.
     */
    public function view(User $user, HistoryTask $model): bool
    {
        return $user->hasPermissionTo('view historytasks');
    }

    /**
     * Determine whether the historyTask can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create historytasks');
    }

    /**
     * Determine whether the historyTask can update the model.
     */
    public function update(User $user, HistoryTask $model): bool
    {
        return $user->hasPermissionTo('update historytasks');
    }

    /**
     * Determine whether the historyTask can delete the model.
     */
    public function delete(User $user, HistoryTask $model): bool
    {
        return $user->hasPermissionTo('delete historytasks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete historytasks');
    }

    /**
     * Determine whether the historyTask can restore the model.
     */
    public function restore(User $user, HistoryTask $model): bool
    {
        return false;
    }

    /**
     * Determine whether the historyTask can permanently delete the model.
     */
    public function forceDelete(User $user, HistoryTask $model): bool
    {
        return false;
    }
}
