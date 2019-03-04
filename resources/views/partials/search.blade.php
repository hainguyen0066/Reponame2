<div class="c-search">
    <form action="{{ route('front.search') }}">
        <input type="text" placeholder="Nhập thông tin tìm kiếm.." name="search"
               class="left" value="{{ request('search') }}">
        <button type="submit" class="left"></button>
    </form>
</div>
