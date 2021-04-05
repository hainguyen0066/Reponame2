<?php
// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Trang chủ', route('front.home'));
});

Breadcrumbs::for('afterHome', function ($trail, $title) {
    $trail->parent('home');
    $trail->push($title);
});
// Home
Breadcrumbs::for('search', function ($trail) {
    $trail->parent('home');
    $trail->push('Tìm kiếm');
});
// Home > nạp thẻ
Breadcrumbs::for('charge', function ($trail) {
    $trail->parent('home');
    $trail->push('Nạp thẻ');
});

Breadcrumbs::for('charge-detail', function ($trail, $pageTitle) {
    $trail->parent('charge');
    $trail->push($pageTitle);
});

Breadcrumbs::for('changepass', function ($trail) {
    $trail->parent('home');
    $trail->push('Đổi mật khẩu');
});
// Home > [Category]
Breadcrumbs::for('category', function ($trail, \T2G\Common\Models\Category $category) {
    $trail->parent('home');
    $trail->push($category->name, route('front.category', $category->slug));
});

// Home > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, \T2G\Common\Models\Post $post) {
    $trail->parent('category', $post->category);
    $trail->push($post->title);
});

// Home > [Group Name] > [Post]
Breadcrumbs::for('postGroup', function ($trail, \T2G\Common\Models\Post $post) {
    $trail->parent('home');
    $trail->push($post->group_name, route('front.post.group', [$post->group_slug]));
    $trail->push($post->title);
});

Breadcrumbs::for('static', function ($trail, \TCG\Voyager\Models\Page $page) {
    $trail->parent('home');
    $trail->push($page->title);
});

Breadcrumbs::for('manageAccount', function ($trail, $title) {
    $trail->parent('home');
    $trail->push("Quản lý tài khoản", route('front.manage.account.info'));
    $trail->push($title);
});
