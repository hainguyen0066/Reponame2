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
Breadcrumbs::for('changepass', function ($trail) {
    $trail->parent('home');
    $trail->push('Đổi mật khẩu');
});
// Home > [Category]
Breadcrumbs::for('category', function ($trail, \App\Models\Category $category) {
    $trail->parent('home');
    $trail->push($category->name, route('front.category', $category->slug));
});

// Home > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, \App\Models\Post $post) {
    $trail->parent('category', $post->category);
    $trail->push($post->title);
});
