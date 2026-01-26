<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugObserver
{
    /**
     * Handle the Model "creating" event.
     */
    public function creating(Model $model): void
    {
        if (! isset($model->name) || ! empty($model->slug)) { 
            return; 
        }

        $baseSlug = Str::slug($model->name);

        $slug = $baseSlug;
        $counter = 1;

        while (
            $model->newQuery()
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $model->slug = $slug;
    }
}
