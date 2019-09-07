<?php

namespace App\Models;

use App\Event\PostCreatingEvent;
use App\Util\CommonHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Post extends \TCG\Voyager\Models\Post
{
    use BaseEloquentModelTrait;

    const PUBLISHED = 1;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'creating' => PostCreatingEvent::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImage()
    {
        if (!empty($this->image)) {
            return $this->image;
        }
        if ($this->body) {
            return $this->getFirstImageFromBody();
        }

        return null;
    }

    /**
     * @return null
     */
    private function getFirstImageFromBody() {
        preg_match('/<img.*src="([^"]*)"/i', $this->body, $matches);

        return $matches[1] ?? null;
    }

    /**
     * @return bool
     */
    public function hasImage()
    {
        return !!$this->getImage();
    }

    /**
     * Scope a query to only published scopes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(Builder $query)
    {
        $now = time();

        return $query->whereStatus(self::PUBLISHED)
            ->where(
                function ($query) use ($now) {
                    $query->where('publish_date', '<=', Carbon::now())
                        ->orWhere('publish_date', '=', null);
                }
            )->where("category_id", ">", 0 )
        ;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param                                       $categorySlug
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCategorySlug(Builder $query, $categorySlug)
    {
        return $query->whereHas('category', function (Builder $query) use ($categorySlug) {
            $query->whereSlug($categorySlug);
        });
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function displayPublishedDate($format = 'd.m.Y')
    {
        $date = $this->publish_date ?? $this->created_at;

        return CommonHelper::formatDate($date, $format);
    }

    /**
     *
     * @return string
     */
    public function getCategorySlug()
    {
        return $this->category ? $this->category->slug : "";
    }

    /**
     * @return string
     */
    public function getCategoryName()
    {
        return $this->category ? $this->category->name : "";
    }
}

