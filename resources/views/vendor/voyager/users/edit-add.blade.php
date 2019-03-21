@extends('voyager::master')

@section('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="{{ (isset($dataTypeContent->id)) ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->id) : route('voyager.'.$dataType->slug.'.store') }}"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-5">
                    <div class="panel panel-bordered">
                        {{-- <div class="panel"> --}}
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">{{ __('voyager::generic.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('voyager::generic.name') }}"
                                       @if(!empty($dataTypeContent->id))
                                       readonly="readonly"
                                       @endif
                                       value="@if(isset($dataTypeContent->name)){{ $dataTypeContent->name }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="name">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone"
                                       value="@if(isset($dataTypeContent->phone)){{ $dataTypeContent->phone }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="email">{{ __('voyager::generic.email') }}</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('voyager::generic.email') }}"
                                       value="@if(isset($dataTypeContent->email)){{ $dataTypeContent->email }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="password">Mật khẩu cấp 1 &nbsp;&nbsp;&nbsp;<span class="label label-default fuzzy h5">{{ $dataTypeContent->getRawPassword() }}</span>
                                    <a class="show-fuzzy" href="javascript:;"><i class="voyager-eye"></i></a></label>
                                @if(isset($dataTypeContent->password))
                                    <br>
                                    <small>Để trống nếu không cần thay đổi</small>
                                @endif
                                <input type="password" class="form-control" id="password" name="password" value="" autocomplete="new-password">
                            </div>

                            <div class="form-group">
                                <label for="password">Mật khẩu cấp 2
                                    @if($dataTypeContent->getRawPassword2())
                                    <span class="label label-default fuzzy h5">{{ $dataTypeContent->getRawPassword2() }}</span>
                                    <a class="show-fuzzy" href="javascript:;"><i class="voyager-eye"></i></a>
                                    @endif
                                </label>
                                @if(isset($dataTypeContent->password2))
                                    <br>
                                    <small>Để trống nếu không cần thay đổi</small>
                                @endif
                                <input type="password" class="form-control" id="password2" name="password2" value="" autocomplete="new-password">
                            </div>

                            @can('editRoles', $dataTypeContent)
                                <div class="form-group">
                                    <label for="default_role">{{ __('voyager::profile.role_default') }}</label>
                                    @php
                                        $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};

                                        $row     = $dataTypeRows->where('field', 'user_belongsto_role_relationship')->first();
                                        $options = json_decode($row->details);
                                    @endphp
                                    @include('voyager::formfields.relationship')
                                </div>
                                {{--<div class="form-group">--}}
                                    {{--<label for="additional_roles">{{ __('voyager::profile.roles_additional') }}</label>--}}
                                    {{--@php--}}
                                        {{--$row     = $dataTypeRows->where('field', 'user_belongstomany_role_relationship')->first();--}}
                                        {{--$options = json_decode($row->details);--}}
                                    {{--@endphp--}}
                                    {{--@include('voyager::formfields.relationship')--}}
                                {{--</div>--}}
                            @endcan
                            <button type="submit" class="btn btn-primary pull-right save">
                                {{ __('voyager::generic.save') }}
                            </button>
                        </div>
                    </div>
                </div>

                @if(!empty($dataTypeContent->id))
                    <div class="col-md-7">
                        <div class="panel panel panel-bordered panel-warning">
                            <div class="panel-body">
                                <h4 class="title">Lịch sử giao dịch</h4>
                                <table class="table table-hover dataTable no-footer" role="grid" aria-describedby="dataTable_info">
                                    <tr>
                                        <th>STT</th>
                                        <th>Loại thẻ</th>
                                        <th>Seri</th>
                                        <th>Mã thẻ</th>
                                        <th>Mệnh giá</th>
                                        <th>Tình trạng</th>
                                    </tr>
                                    @foreach($histories as $history)
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $cardTypes[$history->card_type] }}</td>
                                            <td>{{ $history->card_serial }}</td>
                                            <td>{{ $history->card_pin }}</td>
                                            <td>{{ number_format($history->card_amount) }}</td>
                                            <td>{!! $history->statusText(true) !!}</td>
                                        </tr>
                                    @endforeach
                                    @if($histories->total() == 0)
                                        <tr>
                                            <td colspan="6">Không có lịch sử giao dịch</td>
                                        </tr>
                                    @endif
                                </table>
                                @if($histories->total() > 0)
                                    <div class="center">
                                        {{ $histories->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            {{ csrf_field() }}
            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        </form>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
            
            $('.show-fuzzy').click(function () {
                let fuzzyText = $(this).parent().find('.fuzzy');
                fuzzyText.removeClass('fuzzy');
                setTimeout(function () {
                    fuzzyText.addClass('fuzzy');
                }, 5000);
            })
        });
    </script>
    <style>
        .fuzzy {
            position: relative;
            color: #e4eaec;
        }
        .fuzzy:before {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 2;
            content: '******';
            line-height: 2em;
            color: #4d5154;
        }
    </style>
@stop
