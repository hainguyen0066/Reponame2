<?php

namespace App\Http\Controllers\Front;

use Symfony\Component\HttpFoundation\Cookie;
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
    const HOMEPAGE_LIMIT_POSTS = 10;
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
        $featuredPosts = [
            'Tính năng đặc sắc' => $postRepository->getGroupPostsWithoutSubs('tinh-nang-dac-sac', $postsLimit),
            'Nhiệm vụ tân thủ' => $postRepository->getGroupPostsWithoutSubs('nhiem-vu-tan-thu', $postsLimit),
            'Môn phái & Trang bị' => $postRepository->getGroupPostsWithoutSubs('mon-phai%', $postsLimit),
        ];
        $slides = $sliderRepository->getHomeSlider(self::HOMEPAGE_LIMIT_SLIDERS);
        $banner = $bannerRepository ->getActiveBanner();
        $this->setMetaTitle('Trang chủ');

        $response = response(view('pages.home', [
            'newsByCategory' => $newsByCategory,
            'featuredPosts'  => $featuredPosts,
            'slides'         => $slides,
            'banner'         => $banner,
        ]));
        if ($banner && !request()->cookie('HomeBanner' . $banner->getKey())) {
            $response = $response->withCookie(new Cookie('HomeBanner' . $banner->getKey(), true, time() + 24 * 3600 * 3));
        }

        return $response;
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
