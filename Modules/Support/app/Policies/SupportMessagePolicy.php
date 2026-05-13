<?php

declare(strict_types=1);

namespace Modules\Support\app\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\Support\app\Models\SupportMessage;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupportMessagePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SupportMessage');
    }

    public function view(AuthUser $authUser, SupportMessage $supportMessage): bool
    {
        return $authUser->can('View:SupportMessage');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SupportMessage');
    }

    public function update(AuthUser $authUser, SupportMessage $supportMessage): bool
    {
        return $authUser->can('Update:SupportMessage');
    }

    public function delete(AuthUser $authUser, SupportMessage $supportMessage): bool
    {
        return $authUser->can('Delete:SupportMessage');
    }

    public function restore(AuthUser $authUser, SupportMessage $supportMessage): bool
    {
        return $authUser->can('Restore:SupportMessage');
    }

    public function forceDelete(AuthUser $authUser, SupportMessage $supportMessage): bool
    {
        return $authUser->can('ForceDelete:SupportMessage');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SupportMessage');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SupportMessage');
    }

    public function replicate(AuthUser $authUser, SupportMessage $supportMessage): bool
    {
        return $authUser->can('Replicate:SupportMessage');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SupportMessage');
    }

}