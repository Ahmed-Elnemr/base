<?php

namespace App\Traits;

use App\Relations\CustomMorphMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;

trait HasCustomMorphManyForNotifications
{
    /**
     * Instantiate a new MorphMany relationship.
     *
     * @param  string  $type
     * @param  string  $id
     * @param  string  $localKey
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    protected function newMorphMany(Builder $query, Model $parent, $type, $id, $localKey)
    {
        if ($query->getModel() instanceof DatabaseNotification) {
            return new CustomMorphMany($query, $parent, $type, $id, $localKey);
        }

        return parent::newMorphMany($query, $parent, $type, $id, $localKey);
    }
}
