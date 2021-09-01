<meta charset="utf-8">
<meta content="vi-VN" itemprop="inLanguage"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}"/>
<link rel="dns-prefetch" href="//www.google-analytics.com"/>
<link rel="dns-prefetch" href="//www.googletagmanager.com"/>
<link rel="dns-prefetch" href="//www.facebook.com"/>
<link rel="dns-prefetch" href="//connect.facebook.net"/>
<title>{{ $title }}</title>
<link rel="shortcut icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-icon"/>
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/images/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('/images/android-chrome-192x192.png') }}">
<link rel="icon" type="image/png" sizes="512x512"  href="{{ asset('/images/android-chrome-512x512.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/images/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/favicon-16x16.png') }}">
<meta name="theme-color" content="#ffffff">
<meta property="og:title" itemprop="headline" content="{{ $title }}"/>
<meta property="fb:app_id" content="{{ config('site.fb.app_id') }}"/>
<meta property="og:description" content="{{ $meta_description }}"/>
<meta property="og:image" itemprop="thumbnailUrl" content="{{ $meta_image }}"/>
<meta property="og:url" itemprop="url" content="{{ url()->current() }}"/>
<meta property="og:site_name" content="{{ $title }}"/>
<meta property="og:locale" content="vi_VN"/>
<meta property="og:type" content="{{ $og_type ?? 'website' }}"/>
<meta name="keywords" content="{{ $meta_keywords }}"/>
<meta name="description" content="{{ $meta_description }}"/>
<link rel="canonical" href="{{ url()->current() }}"/>
<meta name="csrf-token" content="{{ csrf_token() }}">

@stack('schemas')
