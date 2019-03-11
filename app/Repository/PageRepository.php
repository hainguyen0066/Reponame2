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

    /**
     * @param $uri
     *
     * @return Page|null
     */
    public function getPageByUri($uri)
    {
        $query = $this->query();
        $query->where([
            'uri' => $uri,
            'status' => true
        ]);

        return $query->first();
    }
}
