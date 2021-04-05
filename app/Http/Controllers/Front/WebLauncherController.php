<?php

namespace App\Http\Controllers\Front;

use T2G\Common\Controllers\Front\BaseFrontController;
use T2G\Common\Repository\PostRepository;

/**
 * Class WebLauncherController
 *
 * @package \App\Http\Controllers\Front
 */
class WebLauncherController extends BaseFrontController
{
    const WEBLAUNCHER_LIMIT_POSTS   = 7;
    const WEBLAUNCHER_LIMIT_SLIDERS = 4;

    public function index(PostRepository $postRepository)
    {
        $postsLimit = self::WEBLAUNCHER_LIMIT_POSTS;
        $posts      = $postRepository->getHomePostsByCategory('', $postsLimit);

        return view('pages.web_launcher_2021', [
            'posts' => $posts,
        ]);
    }

    public function showSlider(PostRepository $postRepository)
    {
        $slidersLimit = self::WEBLAUNCHER_LIMIT_SLIDERS;
        $slides       = $postRepository->getHomePostsByCategory('', $slidersLimit);
        $dots         = count($slides);

        return view('pages.web_launcher_slider_2021', [
            'slides' => $slides,
            'dots'   => $dots
        ]);
    }
}
