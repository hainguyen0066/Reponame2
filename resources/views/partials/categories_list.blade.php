@php
$categories = \App\Util\CommonHelper::getCategories();
$activeSlug = $activeSlug ?? null;
@endphp
<div class="menu">
    <ul>
        @foreach($categories as $slug => $categoryName)
        <li>
            <a href="{{ route('front.category', $slug) }}" title="{{ $categoryName }}"
               class="{{ $slug == $activeSlug ? 'active' : '' }}">{{ $categoryName }}</a>
        </li>
        @endforeach
    </ul>
</div>
