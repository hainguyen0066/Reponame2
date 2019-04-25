<div class="popup-banner">
    @foreach($banners as $banner)
    <div>
        <a href="{{ $banner->link }}" title="{{ $banner->title }}">
            <img src="{{ Voyager::image($banner->image) }}" alt="{{ $banner->title }}"/>
        </a>
    </div>
@endforeach  
</div>
