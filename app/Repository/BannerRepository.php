<?php

namespace App\Repository;

use App\Models\Banner;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BannerRepository
 *
 * @package \App\Repository
 */
class BannerRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Banner::class;
    }
}
