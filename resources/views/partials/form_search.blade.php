<div class="search">
    <form action="{{ route('front.search') }}" class="form-search">
        <input type="text" placeholder="Nhập thông tin tìm kiếm.." name="search"
               class="left" value="{{ request('search') }}">
        <button type="submit" class="left">Tìm kiếm</button>
    </form>
    <div class="clearfix"></div>
</div>

