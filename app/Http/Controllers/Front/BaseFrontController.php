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
     * @param      $name
     */
    private function track($name)
    {
        $value = request($name);
        if (!$value) {
            return;
        }
        $expire = 60*24*7; // 7 days
        $cookie = Cookie::make($name, $value, $expire);
        Cookie::queue($cookie);
    }

    /**
     * @param array $names
     */
    private function tracks(array $names)
    {
        foreach ($names as $name) {
            $this->track($name);
        }
    }
}
