<div class="table-responsive">
    <table id="dataTable" class="table table-hover">
        <thead>
        <tr>
            @can('delete',app($dataType->model_name))
                <th>
                    <input type="checkbox" class="select_all">
                </th>
            @endcan
            @foreach($dataType->browseRows as $row)
                <th>
                    @if ($isServerSide)
                        <a href="{{ $row->sortByUrl() }}">
                            @endif
                            {{ $row->display_name }}
                            @if ($isServerSide)
                                @if ($row->isCurrentSortField())
                                    @if (!isset($_GET['sort_order']) || $_GET['sort_order'] == 'asc')
                                        <i class="voyager-angle-up pull-right"></i>
                                    @else
                                        <i class="voyager-angle-down pull-right"></i>
                                    @endif
                                @endif
                        </a>
                    @endif
                </th>
            @endforeach
            <th class="actions text-right">{{ __('voyager::generic.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($dataTypeContent as $data)
            <tr>
                @can('delete',app($dataType->model_name))
                    <td>
                        <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                    </td>
                @endcan
                @foreach($dataType->browseRows as $row)
                    <td>
                        <?php $options = json_decode($row->details); ?>
                        @if(!empty($options->displayFunction))
                            {!! $data->{$options->displayFunction}() !!}
                        @elseif($row->type == 'image')
                            <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                        @elseif($row->type == 'relationship')
                            @include('voyager::formfields.relationship', ['view' => 'browse'])
                        @elseif($row->type == 'select_multiple')
                            @if(property_exists($options, 'relationship'))

                                @foreach($data->{$row->field} as $item)
                                    @if($item->{$row->field . '_page_slug'})
                                        <a href="{{ $item->{$row->field . '_page_slug'} }}">{{ $item->{$row->field} }}</a>@if(!$loop->last), @endif
                                    @else
                                        {{ $item->{$row->field} }}
                                    @endif
                                @endforeach

                            @elseif(property_exists($options, 'options'))
                                @if (count(json_decode($data->{$row->field})) > 0)
                                    @foreach(json_decode($data->{$row->field}) as $item)
                                        @if (@$options->options->{$item})
                                            {{ $options->options->{$item} . (!$loop->last ? ', ' : '') }}
                                        @endif
                                    @endforeach
                                @else
                                    {{ __('voyager::generic.none') }}
                                @endif
                            @endif

                        @elseif($row->type == 'select_dropdown' && property_exists($options, 'options'))

                            @if($data->{$row->field . '_page_slug'})
                                <a href="{{ $data->{$row->field . '_page_slug'} }}">{!! $options->options->{$data->{$row->field}} !!}</a>
                            @else
                                {!! isset($options->options->{$data->{$row->field}}) ?  $options->options->{$data->{$row->field}} : '' !!}
                            @endif

                        @elseif($row->type == 'select_dropdown' && $data->{$row->field . '_page_slug'})
                            <a href="{{ $data->{$row->field . '_page_slug'} }}">{{ $data->{$row->field} }}</a>
                        @elseif($row->type == 'date' || $row->type == 'timestamp')
                            {{ $options && property_exists($options, 'format') ? \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($options->format) : $data->{$row->field} }}
                        @elseif($row->type == 'checkbox')
                            @if($options && property_exists($options, 'on') && property_exists($options, 'off'))
                                @if($data->{$row->field})
                                    <span class="label label-info">{{ $options->on }}</span>
                                @else
                                    <span class="label label-primary">{{ $options->off }}</span>
                                @endif
                            @else
                                {{ $data->{$row->field} }}
                            @endif
                        @elseif($row->type == 'color')
                            <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                        @elseif($row->type == 'text')
                            @include('voyager::multilingual.input-hidden-bread-browse')
                            <div class="readmore">{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                        @elseif($row->type == 'text_area')
                            @include('voyager::multilingual.input-hidden-bread-browse')
                            <div class="readmore">{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                        @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                            @include('voyager::multilingual.input-hidden-bread-browse')
                            @if(json_decode($data->{$row->field}))
                                @foreach(json_decode($data->{$row->field}) as $file)
                                    <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                        {{ $file->original_name ?: '' }}
                                    </a>
                                    <br/>
                                @endforeach
                            @else
                                <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                    Download
                                </a>
                            @endif
                        @elseif($row->type == 'rich_text_box')
                            @include('voyager::multilingual.input-hidden-bread-browse')
                            <div class="readmore">{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                        @elseif($row->type == 'coordinates')
                            @include('voyager::partials.coordinates-static-image')
                        @elseif($row->type == 'multiple_images')
                            @php $images = json_decode($data->{$row->field}); @endphp
                            @if($images)
                                @php $images = array_slice($images, 0, 3); @endphp
                                @foreach($images as $image)
                                    <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                @endforeach
                            @endif
                        @else
                            @include('voyager::multilingual.input-hidden-bread-browse')
                            <span>{{ $data->{$row->field} }}</span>
                        @endif
                    </td>
                @endforeach
                <td class="no-sort no-click" id="bread-actions">
                    @foreach(Voyager::actions() as $action)
                        @include('voyager::bread.partials.actions', ['action' => $action])
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if ($isServerSide)
    <div class="pull-left">
        <div role="status" class="show-res" aria-live="polite">{{ trans_choice(
                                    'voyager::generic.showing_entries', $dataTypeContent->total(), [
                                        'from' => $dataTypeContent->firstItem(),
                                        'to' => $dataTypeContent->lastItem(),
                                        'all' => $dataTypeContent->total()
                                    ]) }}</div>
    </div>
    <div class="pull-right">
        {{ $dataTypeContent->appends([
            's' => $search->value,
            'filter' => $search->filter,
            'key' => $search->key,
            'order_by' => $orderBy,
            'sort_order' => $sortOrder
        ])->links() }}
    </div>
@endif
