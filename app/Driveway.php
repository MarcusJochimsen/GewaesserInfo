<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed id
 */
class Driveway extends Model
{
    /**
     * @return BelongsTo
     */
    public function water(): BelongsTo
    {
        return $this->belongsTo(Water::class);
    }
}
