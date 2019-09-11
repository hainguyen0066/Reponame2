<?php

namespace App\Models;

use TCG\Voyager\Traits\Resizable;

/**
 * App\Models\Gallery
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $images
 * @property int|null $order
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel orderByPublishDate()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Gallery extends BaseEloquentModel
{
    use Resizable;
}
