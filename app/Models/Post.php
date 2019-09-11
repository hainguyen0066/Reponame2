<?php

namespace App\Models;

use App\Event\PostCreatingEvent;
use App\Util\CommonHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property int $author_id
 * @property int|null $category_id
 * @property string $title
 * @property string|null $seo_title
 * @property string|null $excerpt
 * @property string $body
 * @property string|null $image
 * @property string $slug
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int $status
 * @property int $featured
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $publish_date
 * @property-read \TCG\Voyager\Models\User $authorId
 * @property-read \App\Models\Category|null $category
 * @property-read null $translated
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post categorySlug($categorySlug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post orderByPublishDate()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\TCG\Voyager\Models\Post withTranslation($locale = null, $fallback = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\TCG\Voyager\Models\Post withTranslations($locales = null, $fallback = true)
 * @mixin \Eloquent
 */
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

