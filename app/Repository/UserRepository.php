<?php

namespace App\Repository;

use App\User;

/**
 * Class UserRepository
 *
 * @package \App\Repository
 */
class UserRepository extends AbstractEloquentRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * @return int
     */
    public function getTodayRegistered()
    {
        $startOfToday = strtotime(date('Y-m-d 00:00:00'));
        $query = $this->query()->where('created_at', '>', $startOfToday);

        return $query->count();
    }
}
