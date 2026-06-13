<?php

declare(strict_types=1);

namespace Modules\Task\app\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\Task\app\Models\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Task');
    }

    public function view(AuthUser $authUser, Task $task): bool
    {
        return $authUser->can('View:Task');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Task');
    }

    public function update(AuthUser $authUser, Task $task): bool
    {
        return $authUser->can('Update:Task');
    }

    public function delete(AuthUser $authUser, Task $task): bool
    {
        return $authUser->can('Delete:Task');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Task');
    }

}