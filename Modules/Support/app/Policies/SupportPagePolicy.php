<?php

declare(strict_types=1);

namespace Modules\Support\app\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\Support\app\Models\SupportPage;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupportPagePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SupportPage');
    }

    public function view(AuthUser $authUser, SupportPage $supportPage): bool
    {
        return $authUser->can('View:SupportPage');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SupportPage');
    }

    public function update(AuthUser $authUser, SupportPage $supportPage): bool
    {
        return $authUser->can('Update:SupportPage');
    }

    public function delete(AuthUser $authUser, SupportPage $supportPage): bool
    {
        return $authUser->can('Delete:SupportPage');
    }

    public function restore(AuthUser $authUser, SupportPage $supportPage): bool
    {
        return $authUser->can('Restore:SupportPage');
    }

    public function forceDelete(AuthUser $authUser, SupportPage $supportPage): bool
    {
        return $authUser->can('ForceDelete:SupportPage');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SupportPage');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SupportPage');
    }

    public function replicate(AuthUser $authUser, SupportPage $supportPage): bool
    {
        return $authUser->can('Replicate:SupportPage');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SupportPage');
    }

}