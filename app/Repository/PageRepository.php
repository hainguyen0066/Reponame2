<?php

namespace App\Repository;

use TCG\Voyager\Models\Page;

/**
 * Class PageRepository
 *
 * @package \App\Repository
 */
class PageRepository extends AbstractEloquentRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return Page::class;
    }

    public function getPageByUri($uri)
    {
        $query = $this->query();
//        $query->where('')
    }
}
