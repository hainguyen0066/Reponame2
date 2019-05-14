<div class="slider">
    <div class="my-slider">
        @foreach($slides as $slide)
            <div>
                <a href="{{ $slide->displayLink() }}" title="{{ $slide->title }}">
                    <img src="{{ Voyager::image($slide->image) }}" alt="{{ $slide->title }}"/>
                </a>
            </div>
        @endforeach
    </div>
    <div class="slider-nav">
        <div class="pre-arrow f-left"></div>
        <div class="slider-nav-thumbnails f-left">
            @foreach($slides as $slide)
                <div class="slider-item">{{ $slide->title }}</div>
            @endforeach
        </div>
        <div class="next-arrow f-right"></div>
    </div>
</div>
