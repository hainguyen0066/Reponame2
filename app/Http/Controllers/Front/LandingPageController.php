<?php

namespace App\Http\Controllers\Front;

/**
 * Class LandingPageController
 *
 * @package \App\Http\Controllers\Front
 */
class LandingPageController extends BaseFrontController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index()
    {
        if (setting('site.landing_page_enabled')) {
            return view('pages.landing');
        }

        return redirect(route('front.home'));
    }
}
