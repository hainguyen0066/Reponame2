<!DOCTYPE html>
<html>
<head>
    @component('meta')
        @slot('title')
        {{ config('site.seo.title') }}
        @endslot
    @endcomponent
    <link rel="stylesheet" href="{{ mix('css/landing.css') }}">
    <link rel="stylesheet" href="{{ mix('css/account.css') }}">
    <script type="text/javascript" src="{{ mix('js/landing.js') }}"></script>
    <script>
        window.t2g = window.t2g || {
            authCheck: {{ $user ? "true" : "false" }},
            username: '{{ $user->username ?? '' }}'
        }
    </script>
</head>
<body>
@include('partials.trackers')
@if(!$user)
    @include('modal.account')
@endif
</body>
</html>
