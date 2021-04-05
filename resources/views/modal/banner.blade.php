<div class="popup-banner">
    <div class="popup-banner-container">
        <button class="popup-close"></button>
        <a href="{{ $banner->link }}" title="{{ $banner->title }}">
            <img src="{{ Voyager::image($banner->image) }}" alt="{{ $banner->title }}"/>
        </a>
    </div>
</div>
