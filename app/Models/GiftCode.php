<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class GiftCode
 *
 * @package \App\Models
 * @property int $id
 * @property string $code
 * @property int|null $is_used
 * @property string|null $expired_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode notExpires()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode notOwned()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel orderByPublishDate()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode unused()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode whereExpiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode whereIsUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode whereUserId($value)
 * @mixin \Eloquent
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
