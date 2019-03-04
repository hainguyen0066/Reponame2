<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class GiftCode
 *
 * @package \App\Models
 */
class GiftCode extends BaseEloquentModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return mixed
     */
    public function scopeUnused(Builder $query)
    {
        return $query->whereIsUsed(false);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return mixed
     */
    public function scopeNotOwned(Builder $query)
    {
        return $query->where('user_id', NULL);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return mixed
     */
    public function scopeNotExpires(Builder $query)
    {
        $now = time();
        return $query->whereRaw("(expired_date < {$now} OR expired_date is NULL)");
    }
}
