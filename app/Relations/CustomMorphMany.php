<?php

namespace App\Relations;

use Illuminate\Database\Eloquent\Relations\MorphMany;

class CustomMorphMany extends MorphMany
{
    /**
     * Add a basic where clause to the query.
     *
     * @param  array|\Closure|\Illuminate\Database\Query\Expression|string  $column
     * @param  mixed  $operator
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        if (is_string($column) && $column === 'data->format') {
            if (func_num_args() === 2) {
                $value = $operator;
            }

            $this->query->where('data', 'like', '%"format":"'.$value.'"%');

            return $this;
        }

        $this->query->where($column, $operator, $value, $boolean);

        return $this;
    }
}
