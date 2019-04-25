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
    
    public function getBanner($limit = 1)
    {
        $query = $this->query();
        $query->active()
            ->orderBy('id', 'desc')
            ->limit($limit)
        ;
        return $query->get();
    }
}
