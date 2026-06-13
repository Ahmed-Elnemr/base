<?php

declare(strict_types=1);

namespace Modules\Setting\app\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\Setting\app\Models\GeneralSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class GeneralSettingPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:GeneralSetting');
    }

    public function view(AuthUser $authUser, GeneralSetting $generalSetting): bool
    {
        return $authUser->can('View:GeneralSetting');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:GeneralSetting');
    }

    public function update(AuthUser $authUser, GeneralSetting $generalSetting): bool
    {
        return $authUser->can('Update:GeneralSetting');
    }

    public function delete(AuthUser $authUser, GeneralSetting $generalSetting): bool
    {
        return $authUser->can('Delete:GeneralSetting');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:GeneralSetting');
    }

}