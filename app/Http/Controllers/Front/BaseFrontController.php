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
            if (!empty($referer['host'])) {
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
}
