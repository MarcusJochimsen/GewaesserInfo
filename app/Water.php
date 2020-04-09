<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 */
class Water extends Model
{
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function tide(): BelongsTo
    {
        return $this->belongsTo(Tide::class);
    }

    /**
     * @return BelongsTo
     */
    public function current(): BelongsTo
    {
        return $this->belongsTo(Current::class);
    }

    /**
     * @return HasMany
     */
    public function driveways(): HasMany
    {
        return $this->hasMany(Driveway::class);
    }

    /**
     * @return HasMany
     */
    public function dangers(): HasMany
    {
        return $this->hasMany(Danger::class);
    }
}
