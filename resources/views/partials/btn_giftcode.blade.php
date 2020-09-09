<a href="javascript:;" class="btn-giftcode {{ $user ? 'logged' : 'account-register' }}" style="display:none">
    <video poster="{{ staticUrl('images/landing-2020-04/btn-giftcode.png') }}"
           preload="auto" loop muted autoplay playsinline>
        <source src="{{ staticUrl('images/landing-2020-04/btn-giftcode.webm') }}" type="video/webm">
    </video>
    <span>{{ number_format(\App\User::registeredNumber(), 0, ',', '.') }}</span>
</a>
