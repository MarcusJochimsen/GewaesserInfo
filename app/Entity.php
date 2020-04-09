<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 */
class Entity extends Model
{
    /**
     * @return HasOne
     */
    public function division(): HasOne
    {
        return $this->hasOne(Division::class);
    }

    /**
     * @return HasOne
     */
    public function leader(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
