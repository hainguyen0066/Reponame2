<?php

namespace App\Http\Controllers\Front;

use App\Repository\PostRepository;
use App\Repository\SliderRepository;

/**
 * Class HomePageController
 *
 * @package \App\Http\Controllers\Front
 */
class HomePageController extends BaseFrontController
{
    const HOMEPAGE_LIMIT_POSTS = 7;
    const HOMEPAGE_LIMIT_SLIDERS = 5;

    public function index(PostRepository $postRepository, SliderRepository $sliderRepository)
    {
        $postsLimit = self::HOMEPAGE_LIMIT_POSTS;
        $newsByCategory = [
            'tong-hop'  => $postRepository->getHomePostsByCategory('', $postsLimit),
            'thong-bao' => $postRepository->getHomePostsByCategory('thong-bao', $postsLimit),
            'su-kien'   => $postRepository->getHomePostsByCategory('su-kien', $postsLimit),
        ];
        $guides = $postRepository->getHomePostsByCategory('huong-dan', $postsLimit);
        $slides = $sliderRepository->getHomeSlider(self::HOMEPAGE_LIMIT_SLIDERS);

        return view('pages.home', [
            'newsByCategory' => $newsByCategory,
            'slides'         => $slides,
            'guides'         => $guides,
        ]);
    }
}
