<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Quote;
use App\Models\Student;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the quote can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list quotes');
    }
    public function studentViewAny(Student $user): bool
    {
        return $user->hasPermissionTo('list quotes');
    }

    /**
     * Determine whether the quote can view the model.
     */
    public function view(User $user, Quote $model): bool
    {
        return $user->hasPermissionTo('view quotes');
    }

    /**
     * Determine whether the quote can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create quotes');
    }

    /**
     * Determine whether the quote can update the model.
     */
    public function update(User $user, Quote $model): bool
    {
        return $user->hasPermissionTo('update quotes');
    }

    /**
     * Determine whether the quote can delete the model.
     */
    public function delete(User $user, Quote $model): bool
    {
        return $user->hasPermissionTo('delete quotes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete quotes');
    }

    /**
     * Determine whether the quote can restore the model.
     */
    public function restore(User $user, Quote $model): bool
    {
        return false;
    }

    /**
     * Determine whether the quote can permanently delete the model.
     */
    public function forceDelete(User $user, Quote $model): bool
    {
        return false;
    }
}
