<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;

trait CanLoadRelationships
{


    protected function shouldHaveRelations(string $relation): bool
    {
        $includes = request()->query('includes');

        if (!$includes) {
            return false;
        }

        $relations = array_map('trim', explode(',', $includes));

        return in_array($relation, $relations);

    }

    public function loadRelationships(Model|EloquentBuilder|QueryBuilder|HasMany $for, ?array $relations = null): Model|EloquentBuilder|QueryBuilder|HasMany
    {
        $relations = $relations ?? $this->relations ?? [];

        foreach ($relations as $relation) {
            $for->when($this->shouldHaveRelations($relation), function ($q) use ($relation, $for) {
                $for instanceof Model ? $for->load($relation) : $for->with($relation);
            });
        }

        return $for;
    }


}