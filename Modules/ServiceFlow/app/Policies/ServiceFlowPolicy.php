<?php

declare(strict_types=1);

namespace Modules\ServiceFlow\app\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\ServiceFlow\app\Models\ServiceFlow;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceFlowPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ServiceFlow');
    }

    public function view(AuthUser $authUser, ServiceFlow $serviceFlow): bool
    {
        return $authUser->can('View:ServiceFlow');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ServiceFlow');
    }

    public function update(AuthUser $authUser, ServiceFlow $serviceFlow): bool
    {
        return $authUser->can('Update:ServiceFlow');
    }

    public function delete(AuthUser $authUser, ServiceFlow $serviceFlow): bool
    {
        return $authUser->can('Delete:ServiceFlow');
    }

    public function restore(AuthUser $authUser, ServiceFlow $serviceFlow): bool
    {
        return $authUser->can('Restore:ServiceFlow');
    }

    public function forceDelete(AuthUser $authUser, ServiceFlow $serviceFlow): bool
    {
        return $authUser->can('ForceDelete:ServiceFlow');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ServiceFlow');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ServiceFlow');
    }

    public function replicate(AuthUser $authUser, ServiceFlow $serviceFlow): bool
    {
        return $authUser->can('Replicate:ServiceFlow');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ServiceFlow');
    }

}