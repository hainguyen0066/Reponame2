<?php

namespace App\Http\Controllers\Front;

use T2G\Common\Controllers\Front\BaseFrontController;
use T2G\Common\Repository\BannerRepository;
use T2G\Common\Repository\PostRepository;
use T2G\Common\Repository\SliderRepository;

/**
 * Class HomePageController
 *
 * @package \App\Http\Controllers\Front
 */
class HomePageController extends BaseFrontController
{
    const HOMEPAGE_LIMIT_POSTS = 7;
    const HOMEPAGE_LIMIT_SLIDERS = 5;
    const WELCOME_PAGE_LIMIT_NEW_POSTS = 5;

    public function index(PostRepository $postRepository, SliderRepository $sliderRepository, BannerRepository $bannerRepository)
    {
        $postsLimit = self::HOMEPAGE_LIMIT_POSTS;
        $newsByCategory = [
            'tong-hop'  => $postRepository->getHomePostsByCategory('', $postsLimit),
            'thong-bao' => $postRepository->getHomePostsByCategory('thong-bao', $postsLimit),
            'su-kien'   => $postRepository->getHomePostsByCategory('su-kien', $postsLimit),
        ];
        $guides = $postRepository->getHomePostsByCategory('huong-dan', $postsLimit);
        $slides = $sliderRepository->getHomeSlider(self::HOMEPAGE_LIMIT_SLIDERS);
        $banners = $bannerRepository ->getActiveBanner();

        $this->setMetaTitle('Trang chủ');

        return view('pages.home', [
            'newsByCategory' => $newsByCategory,
            'slides'         => $slides,
            'guides'         => $guides,
            'banner'         => $banners
        ]);
    }

    public function welcome(PostRepository $postRepository)
    {
        $welcomePostSlugs = [
            'ho-tro-tan-thu',
            'thong-tin-sever-vo-lam-trung-nguyen',
            'trung-gian-giao-dich-admin',
        ];

        $data= [
            'welcomePosts' => $postRepository->getPostsBySlugs($welcomePostSlugs, count($welcomePostSlugs)),
            'newPosts'     => $postRepository->listPostByCategory('', self::WELCOME_PAGE_LIMIT_NEW_POSTS),
        ];

        return view('pages.registered', $data);
    }
}
