<?php

namespace App\Livewire;

use Filament\Notifications\Livewire\DatabaseNotifications as BaseDatabaseNotifications;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class CustomDatabaseNotifications extends BaseDatabaseNotifications
{
    public function getNotificationsQuery(): Builder|Relation
    {
        $user = $this->getUser();

        if (! $user) {
            abort(401);
        }

        /** @phpstan-ignore-next-line */
        return $user->notifications()->where('data', 'like', '%"format":"filament"%');
    }
}
