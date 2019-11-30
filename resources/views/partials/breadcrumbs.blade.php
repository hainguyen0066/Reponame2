@if (count($breadcrumbs))
    <ol class="breadcrumb">
        @php
        $position = 1;
        @endphp
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
                @php
                    $breadcrumbItems[] = [
                        "@type" => "ListItem",
                        "position" => $position++,
                        "item" => [
                            '@id' => $breadcrumb->url,
                            'name' => $breadcrumb->title,
                            'type' => 'WebPage',
                        ]
                    ];
                @endphp
                <li class="breadcrumb-item">
                    <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                </li>
            @else
                <li class="breadcrumb-item active">{{ str_limit($breadcrumb->title, 40) }}</li>
            @endif
        @endforeach
    </ol>
@endif

@push('schemas')
    @include('t2g_common::schemas.breadcrumb', $breadcrumbItems)
@endpush
