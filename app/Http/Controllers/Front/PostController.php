<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use T2G\Common\Controllers\Front\BaseFrontController;
use T2G\Common\Models\Category;
use T2G\Common\Repository\CategoryRepository;
use T2G\Common\Repository\PostRepository;

/**
 * Class PostController
 *
 * @package \App\Http\Controllers\Front
 */
class PostController extends BaseFrontController
{
    const POSTS_PER_PAGE = 10;
    const CATEGORY_SLUG_ALL = 'tong-hop';

    public function detail($categorySlug, $postSlug, PostRepository $postRepository)
    {
        $post = $postRepository->getPostBySlug($postSlug);
        if (!$post) {
            throw new NotFoundHttpException();
        }
        $otherPosts = $postRepository->getOtherPosts($post);
        $data = [
            'post'   => $post,
            'others' => $otherPosts,
        ];

        $this->setMetaTitle($post->title)
            ->setMetaDescription($post->getDescription())
            ->setMetaImage($post->getImage());

        return view('pages.post_detail', $data);
    }

    public function download(PostRepository $postRepository)
    {
        $post = $postRepository->getPostBySlug('tai-game');
        if (!$post) {
            throw new NotFoundHttpException();
        }
        $otherPosts = $postRepository->getOtherPosts($post);
        $data = [
            'post'   => $post,
            'others' => $otherPosts,
        ];
        $this->setMetaTitle($post->title)
            ->setMetaDescription($post->getDescription())
            ->setMetaImage($post->getImage());

        return view('pages.post_detail', $data);
    }

    public function list($categorySlug, PostRepository $postRepository, CategoryRepository $categoryRepository)
    {
        if ($categorySlug == self::CATEGORY_SLUG_ALL) {
            $category = new Category();
            $category->name = 'Tổng hợp';
            $category->slug = $categorySlug;
            $categorySlug = '';
        } else {
            $category = $categoryRepository->getCategoryBySlug($categorySlug);
            if (!$category) {
                throw new NotFoundHttpException();
            }
        }

        $posts = $postRepository->listPostByCategory($categorySlug, self::POSTS_PER_PAGE);
        $data = [
            'category'   => $category,
            'posts'      => $posts,
            'activeSlug' => $category->slug,
        ];
        $this->setMetaTitle($category->name);

        return view('pages.category', $data);
    }

    public function search(PostRepository $postRepository, Request $request)
    {
        $keyword = $request->get('search');
        $posts = $postRepository->searchPost($keyword, self::POSTS_PER_PAGE);
        $data = [
            'posts'    => $posts,
        ];

        return view('pages.search', $data);
    }
}
