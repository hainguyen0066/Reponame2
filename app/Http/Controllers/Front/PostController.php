<?php

namespace App\Http\Controllers\Front;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PostController
 *
 * @package \App\Http\Controllers\Front
 */
class PostController extends BaseFrontController
{
    const POSTS_PER_PAGE = 10;

    public function detail($categorySlug, $postSlug, PostRepository $postRepository)
    {
        $post = $postRepository->getPublishedPostBySlug($postSlug);
        if (!$post) {
            throw new NotFoundHttpException();
        }
        $otherPosts = $postRepository->getOtherPosts($post);
        $data = [
            'post'   => $post,
            'others' => $otherPosts,
        ];

        return view('pages.post_detail', $data);
    }

    public function list(
        $categorySlug,
        PostRepository $postRepository,
        CategoryRepository $categoryRepository
    ) {
        $category = $categoryRepository->getCategoryBySlug($categorySlug);
        if (!$category) {
            throw new NotFoundHttpException();
        }
        $posts = $postRepository->listPostByCategory($categorySlug, self::POSTS_PER_PAGE);
        $data = [
            'category'   => $category,
            'posts'      => $posts,
            'activeSlug' => $category->slug,
        ];

        return view('pages.category', $data);
    }

    public function search(
        PostRepository $postRepository,
        Request $request
    ) {
        $keyword = $request->input('search');
        $posts = $postRepository->searchPost($keyword, self::POSTS_PER_PAGE);
        $data = [
            'posts'    => $posts,
        ];

        return view('pages.search', $data);
    }
}
