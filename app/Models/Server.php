<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

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
