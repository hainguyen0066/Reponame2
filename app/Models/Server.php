<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class Server
 *
 * @package \App\Models
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $link
 * @property string $status
 * @property string|null $display_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereDisplayText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereGameServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $game_server_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel orderByPublishDate()
 */
class Server extends BaseEloquentModel
{
    const STATUS_OPEN = 'OPEN';
    const STATUS_CLOSE = 'CLOSE';
    const STATUS_DEV = 'DEV';

    public function scopeActive(Builder $query)
    {
        return $query->where('status', self::STATUS_OPEN);
    }

    /**
     * @param \App\Models\Server $server
     *
     * @return string
     */
    public static function slugPlayGame(Server $server)
    {
        return "S" . $server->game_server_id . "-". $server->slug;
    }
}
