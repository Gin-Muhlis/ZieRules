<?php

namespace App\Policies;

use App\Models\User;
use App\Models\HistoryAchievment;
use Illuminate\Auth\Access\HandlesAuthorization;

class HistoryAchievmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the historyAchievment can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list historyachievments');
    }

    /**
     * Determine whether the historyAchievment can view the model.
     */
    public function view(User $user, HistoryAchievment $model): bool
    {
        return $user->hasPermissionTo('view historyachievments');
    }

    /**
     * Determine whether the historyAchievment can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create historyachievments');
    }

    /**
     * Determine whether the historyAchievment can update the model.
     */
    public function update(User $user, HistoryAchievment $model): bool
    {
        return $user->hasPermissionTo('update historyachievments');
    }

    /**
     * Determine whether the historyAchievment can delete the model.
     */
    public function delete(User $user, HistoryAchievment $model): bool
    {
        return $user->hasPermissionTo('delete historyachievments');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete historyachievments');
    }

    /**
     * Determine whether the historyAchievment can restore the model.
     */
    public function restore(User $user, HistoryAchievment $model): bool
    {
        return false;
    }

    /**
     * Determine whether the historyAchievment can permanently delete the model.
     */
    public function forceDelete(User $user, HistoryAchievment $model): bool
    {
        return false;
    }
}
