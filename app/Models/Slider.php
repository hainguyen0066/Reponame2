<?php

namespace App\Models;

use TCG\Voyager\Traits\Resizable;

/**
 * Class Slider
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel orderByPublishDate()
 */
class Slider extends BaseEloquentModel
{
    use Resizable;

    public function displayLink()
    {
        $domains = config('site.domains');
        $siteDomain = $_SERVER['HTTP_HOST'];
        $urlParsed = parse_url($this->link);
        if (!empty($urlParsed['host']) && in_array($urlParsed['host'], $domains) && $urlParsed['host'] != $siteDomain) {
            return str_replace($urlParsed['host'], $siteDomain, $this->link);
        }

        return $this->link;
    }
}
