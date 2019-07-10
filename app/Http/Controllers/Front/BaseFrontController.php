<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Cookie;


/**
 * Class BaseFrontController
 *
 * @package \App\Http\Controllers\Front
 */
class BaseFrontController extends Controller
{
    public function __construct()
    {
        $this->middleware(['t2g']);
        $this->tracks(['utm_source', 'utm_medium', 'utm_campaign']);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    private function track($name)
    {
        $value = request($name);
        if (!$value) {
            return false;
        }
        $this->setTrackingCookie($name, $value);

        return true;
    }

    /**
     * @param array $names
     */
    private function tracks(array $names)
    {
        $tracked = false;
        foreach ($names as $name) {
            $tracked = $this->track($name);
        }
        if (!$tracked && !empty($_SERVER['HTTP_REFERER'])) {
            $referer = parse_url($_SERVER['HTTP_REFERER']);
            if (!empty($referer['host']) && !in_array($referer['host'], config('site.domains', []))) {
                $this->setTrackingCookie('utm_source', $referer['host']);
                $this->setTrackingCookie('utm_medium', 'Referral');
            }
        }
    }

    private function setTrackingCookie($name, $value)
    {
        $expire = 60 * 24 * 7; // 7 days
        $cookie = Cookie::make($name, $value, $expire);
        Cookie::queue($cookie);
    }

    /**
     * @param $title
     *
     * @return \App\Http\Controllers\Front\BaseFrontController
     */
    protected function setMetaTitle($title)
    {
        view()->share('title', $title . " - " . config('site.seo.title'));
        return $this;
    }

    /**
     * @param $description
     *
     * @return \App\Http\Controllers\Front\BaseFrontController
     */
    protected function setMetaDescription($description)
    {
        view()->share('meta_description', str_limit($description, 255) ?? config('site.seo.meta_description'));

        return $this;
    }

    /**
     * @param $image
     *
     * @return $this
     */
    protected function setMetaImage($image)
    {
        if ($image && strpos(trim($image), 'http') !== 0) {
            $image = url($image);
        }
        view()->share('meta_image', $image ?? asset(config('site.seo.meta_image')));

        return $this;
    }
}
