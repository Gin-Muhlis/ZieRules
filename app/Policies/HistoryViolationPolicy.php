<?php

namespace App\Policies;

use App\Models\User;
use App\Models\HistoryViolation;
use Illuminate\Auth\Access\HandlesAuthorization;

class HistoryViolationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the historyViolation can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list historyviolations');
    }

    /**
     * Determine whether the historyViolation can view the model.
     */
    public function view(User $user, HistoryViolation $model): bool
    {
        return $user->hasPermissionTo('view historyviolations');
    }

    /**
     * Determine whether the historyViolation can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create historyviolations');
    }

    /**
     * Determine whether the historyViolation can update the model.
     */
    public function update(User $user, HistoryViolation $model): bool
    {
        return $user->hasPermissionTo('update historyviolations');
    }

    /**
     * Determine whether the historyViolation can delete the model.
     */
    public function delete(User $user, HistoryViolation $model): bool
    {
        return $user->hasPermissionTo('delete historyviolations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete historyviolations');
    }

    /**
     * Determine whether the historyViolation can restore the model.
     */
    public function restore(User $user, HistoryViolation $model): bool
    {
        return false;
    }

    /**
     * Determine whether the historyViolation can permanently delete the model.
     */
    public function forceDelete(User $user, HistoryViolation $model): bool
    {
        return false;
    }
}
