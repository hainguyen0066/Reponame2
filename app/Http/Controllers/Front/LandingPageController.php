<?php

namespace App\Http\Controllers\Front;

use T2G\Common\Controllers\Front\BaseFrontController;
/**
 * Class LandingPageController
 *
 * @package \App\Http\Controllers\Front
 */
class LandingPageController extends BaseFrontController
{
    public function index()
    {
        if (setting('site.landing_page_enabled')) {
            return view('pages.landing_2019_11');
            return view('pages.landing');
        }

        return redirect(route('front.home'));
    }
}
