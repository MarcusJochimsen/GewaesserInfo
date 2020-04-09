<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    /**
     * @return HasMany
     */
    public function entitys(): HasMany
    {
        return $this->hasMany(Entity::class);
    }
}
