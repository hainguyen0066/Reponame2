<?php

namespace App\Models;

use TCG\Voyager\Traits\Resizable;

/**
 * Class Banner
 *
 * @package \App\Models
 * @property int $id
 * @property string $title
 * @property string $link
 * @property string|null $image
 * @property int $status
 * @property string|null $start_date
 * @property string|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel orderByPublishDate()
 */
class Banner extends BaseEloquentModel
{
    use Resizable;
}
