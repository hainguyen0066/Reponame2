<?php

namespace App\Repository;

use App\Models\Category;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PostRepository
 *
 * @package \App\Repository
 */
class CategoryRepository extends AbstractEloquentRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Category::class;
    }

    /**
     * @param $slug
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function getCategoryBySlug($slug)
    {
        $query = $this->query();
        $query->whereSlug($slug)
            ->whereStatus(true)
        ;

        return $query->first();
    }

}
