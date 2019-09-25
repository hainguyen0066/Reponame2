<?php

namespace App\Http\Controllers\Front;

use T2G\Common\Controllers\Front\BaseFrontController;
use T2G\Common\Repository\PostRepository;
use T2G\Common\Repository\SliderRepository;

/**
 * Class WebLauncherController
 *
 * @package \App\Http\Controllers\Front
 */
class WebLauncherController extends BaseFrontController
{
    const WEBLAUNCHER_LIMIT_POSTS = 6;
    const WEBLAUNCHER_LIMIT_SLIDERS = 1;

    public function index(PostRepository $postRepository, SliderRepository $sliderRepository)
    {
        $postsLimit = self::WEBLAUNCHER_LIMIT_POSTS;
        $newsByCategory = [
            'tong-hop'  => $postRepository->getHomePostsByCategory('', $postsLimit)
        ];
        $slides = $sliderRepository->getHomeSlider(self::WEBLAUNCHER_LIMIT_SLIDERS);

        return view('pages.web_launcher', [
            'newsByCategory' => $newsByCategory,
            'slides'         => $slides
        ]);
    }
}
