<div class="list-content">
    @foreach($posts as $post)
        <?php
        $url = route('front.details.post', [$post->getCategorySlug(), $post->slug]);
        ?>
        <div class="item">
            <a href="{{ $url }}" class="img f-left">
                <img src="{{ Voyager::image($post->getImage()) }}" onerror="if (this.src != '/images/hot-img.png') this.src = '/images/hot-img.png';" alt="{{ $post->title }}" />
            </a>
            <a class="content f-left" href="{{ $url }}" title="{{ $post->title }}">
                <div class="title">{{ str_limit($post->title, 100) }}</div>
                <div class="description">
                    {{ str_limit($post->excerpt, 200) }}
                </div>
                <a href="{{ $url }}" class="time f-right">{{ $post->displayPublishedDate() }}</a>
            </a>
        </div>
    @endforeach

    <div class="center">
        {{ $posts->links() }}
    </div>
</div>
