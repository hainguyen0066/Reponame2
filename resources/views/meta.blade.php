<meta charset="utf-8">
<title>{{ $title }}</title>
<meta property="og:title" content="{{ $title ?? config('site.seo.title') }}"/>
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
<meta property="fb:app_id" content="{{ config('site.fb.app_id') }}" />
<meta property="og:description" content="{{ $meta_description ?? config('site.seo.meta_description') }}"/>
<meta property="og:image" content="{{ $shareImage ?? asset('images/share.1.1.jpg') }}"/>
<meta property="og:url" content="{{ url()->current() }}"/>
<meta property="og:site_name" content="{{ $title ?? config('site.seo.title') }}"/>
<meta property="og:locale" content="vi_VN"/>
<meta property="og:type" content="website"/>
<meta name="keywords" content="{{ $meta_keywords ?? config('site.seo.meta_keyword') }}"/>
<meta name="description" content="{{ $meta_description ?? config('site.seo.meta_description') }}"/>
<link rel="canonical" href="{{ url()->current() }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">

