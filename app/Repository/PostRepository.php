<?php

namespace App\Repository;

use App\Models\Post;

/**
 * Class PostRepository
 *
 * @package \App\Repository
 */
class PostRepository extends AbstractEloquentRepository
{

    /**
     * @var Post
     */
    protected $model;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Post::class;
    }

    /**
     * @param     $categorySlug
     * @param int $limit
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]
     */
    public function getHomePostsByCategory($categorySlug = '', $limit = self::DEFAULT_PER_PAGE)
    {
        $query = $this->query();
        $query->published()
            ->orderByPublishDate()
            ->limit($limit)
        ;
        if ($categorySlug) {
            $query->categorySlug($categorySlug);
        }

        return $query->get();
    }

    public function getHomeEvents($eventSlug = 'su-kien', $limit = self::DEFAULT_PER_PAGE)
    {
        $query = $this->query();
        $query->published()
            ->categorySlug($eventSlug)
            ->orderByPublishDate()
            ->limit($limit)
        ;

        return $query->get();
    }

    /**
     * @param string $categorySlug
     * @param int $limit
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listPostByCategory($categorySlug, $limit = self::DEFAULT_PER_PAGE)
    {
        $query = $this->query();
        $query->published()
            ->orderByPublishDate()
        ;
        if ($categorySlug) {
            $query->categorySlug($categorySlug);
        }

        return $query->paginate($limit);
    }

    /**
     * @param \App\Models\Post $post
     * @param int              $limit
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]
     */
    public function getOtherPosts(Post $post, $limit = 6)
    {
        $query = $this->query();
        $query->published()
            ->where("id", '!=', $post->id)
            ->orderByPublishDate()
            ->limit($limit)
            ->with('category')
        ;

        return $query->get();
    }

    /**
     * @param $postSlug
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function getPostBySlug($postSlug)
    {
        $query = $this->query();
        $query->whereSlug($postSlug);

        return $query->first();
    }

    /**
     * @param     $keyword
     * @param int $limit
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchPost($keyword, $limit = 10)
    {
        $query = $this->query();
        $query->published()
            ->whereRaw("title LIKE '%{$keyword}%'")
            ->orderByPublishDate()
        ;

        return $query->paginate($limit);
    }
}
