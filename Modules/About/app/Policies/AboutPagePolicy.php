<?php

namespace Modules\About\app\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class AboutPagePolicy
{
    use HandlesAuthorization;

    public function viewAny($user): bool
    {
        return true;
    }

    public function view($user): bool
    {
        return true;
    }

    public function create($user): bool
    {
        return false;
    }

    public function update($user): bool
    {
        return true;
    }

    public function delete($user): bool
    {
        return false;
    }
}
