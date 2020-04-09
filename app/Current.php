<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Current extends Model
{
    /**
     * @return HasMany
     */
    public function waters(): HasMany
    {
        return $this->hasMany(Water::class);
    }
}
