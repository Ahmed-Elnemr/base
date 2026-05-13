<?php

declare(strict_types=1);

namespace Modules\Faq\app\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\Faq\app\Models\FaqItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaqItemPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:FaqItem');
    }

    public function view(AuthUser $authUser, FaqItem $faqItem): bool
    {
        return $authUser->can('View:FaqItem');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:FaqItem');
    }

    public function update(AuthUser $authUser, FaqItem $faqItem): bool
    {
        return $authUser->can('Update:FaqItem');
    }

    public function delete(AuthUser $authUser, FaqItem $faqItem): bool
    {
        return $authUser->can('Delete:FaqItem');
    }

    public function restore(AuthUser $authUser, FaqItem $faqItem): bool
    {
        return $authUser->can('Restore:FaqItem');
    }

    public function forceDelete(AuthUser $authUser, FaqItem $faqItem): bool
    {
        return $authUser->can('ForceDelete:FaqItem');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:FaqItem');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:FaqItem');
    }

    public function replicate(AuthUser $authUser, FaqItem $faqItem): bool
    {
        return $authUser->can('Replicate:FaqItem');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:FaqItem');
    }

}