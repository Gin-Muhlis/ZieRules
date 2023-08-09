<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\Task;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the task can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list tasks');
    }

    public function studentViewAny(Student $user): bool
    {
        return $user->hasPermissionTo('list tasks');
    }

    public function teacherViewAny(Teacher $user): bool
    {
        return $user->hasPermissionTo('list tasks');
    }

    /**
     * Determine whether the task can view the model.
     */
    public function view(User $user, Task $model): bool
    {
        return $user->hasPermissionTo('view tasks');
    }

    /**
     * Determine whether the task can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create tasks');
    }

    /**
     * Determine whether the task can update the model.
     */
    public function update(User $user, Task $model): bool
    {
        return $user->hasPermissionTo('update tasks');
    }

    /**
     * Determine whether the task can delete the model.
     */
    public function delete(User $user, Task $model): bool
    {
        return $user->hasPermissionTo('delete tasks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete tasks');
    }

    /**
     * Determine whether the task can restore the model.
     */
    public function restore(User $user, Task $model): bool
    {
        return false;
    }

    /**
     * Determine whether the task can permanently delete the model.
     */
    public function forceDelete(User $user, Task $model): bool
    {
        return false;
    }
}
