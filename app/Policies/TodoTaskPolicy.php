<?php

namespace App\Policies;

use App\Models\TodoTask;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoTaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, TodoTask $todoTask): bool
    {
        return $user->id === $todoTask->todo->user_id;
    }

    public function destroy(User $user, TodoTask $todoTask): bool
    {
        return $user->id === $todoTask->todo->user_id;
    }
}
