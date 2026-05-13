<?php

declare(strict_types=1);

namespace Modules\Faq\app\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\Faq\app\Models\FaqSection;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaqSectionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:FaqSection');
    }

    public function view(AuthUser $authUser, FaqSection $faqSection): bool
    {
        return $authUser->can('View:FaqSection');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:FaqSection');
    }

    public function update(AuthUser $authUser, FaqSection $faqSection): bool
    {
        return $authUser->can('Update:FaqSection');
    }

    public function delete(AuthUser $authUser, FaqSection $faqSection): bool
    {
        return $authUser->can('Delete:FaqSection');
    }

    public function restore(AuthUser $authUser, FaqSection $faqSection): bool
    {
        return $authUser->can('Restore:FaqSection');
    }

    public function forceDelete(AuthUser $authUser, FaqSection $faqSection): bool
    {
        return $authUser->can('ForceDelete:FaqSection');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:FaqSection');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:FaqSection');
    }

    public function replicate(AuthUser $authUser, FaqSection $faqSection): bool
    {
        return $authUser->can('Replicate:FaqSection');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:FaqSection');
    }

}