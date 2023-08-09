<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Achievment;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Auth\Access\HandlesAuthorization;

class AchievmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the achievment can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list achievments');
    }

    public function studentViewAny(Student $user): bool
    {
        return $user->hasPermissionTo('list achievments');
    }

    public function teacherViewAny(Teacher $user): bool
    {
        return $user->hasPermissionTo('list achievments');
    }

    /**
     * Determine whether the achievment can view the model.
     */
    public function view(User $user, Achievment $model): bool
    {
        return $user->hasPermissionTo('view achievments');
    }

    /**
     * Determine whether the achievment can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create achievments');
    }

    /**
     * Determine whether the achievment can update the model.
     */
    public function update(User $user, Achievment $model): bool
    {
        return $user->hasPermissionTo('update achievments');
    }

    /**
     * Determine whether the achievment can delete the model.
     */
    public function delete(User $user, Achievment $model): bool
    {
        return $user->hasPermissionTo('delete achievments');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete achievments');
    }

    /**
     * Determine whether the achievment can restore the model.
     */
    public function restore(User $user, Achievment $model): bool
    {
        return false;
    }

    /**
     * Determine whether the achievment can permanently delete the model.
     */
    public function forceDelete(User $user, Achievment $model): bool
    {
        return false;
    }
}
