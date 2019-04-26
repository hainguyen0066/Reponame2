<?php

namespace App\Repository;

use App\Models\Banner;

/**
 * Class BannerRepository
 *
 * @package \App\Repository
 */
class BannerRepository extends AbstractEloquentRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model():string
    {
        return Banner::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getActiveBanner()
    {
        $query = $this->query();
        $query->active()
            ->orderBy('id', 'desc')
        ;

        return $query->first();
    }
}
