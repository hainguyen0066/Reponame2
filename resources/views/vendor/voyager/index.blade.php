@extends('voyager::master')

@section('content')
<div class="page-content browse container-fluid">
    @include('voyager::alerts')
    @include('voyager::dimmers')
    {{--<div class="panel panel-bordered">--}}
        {{--<div class="row">--}}
            {{--<div class="col-xs-12">--}}
                {{--- Số tài khoản đăng ký trong ngày:--}}
                {{--<strong style="font-size: 16px;">{{ $regToday }}</strong>--}}
            {{--</div>--}}
            {{--<div class="col-xs-12">--}}
                {{--- Tổng số tài khoản đã đăng ký: <strong--}}
                        {{--style="font-size: 16px;">{{ number_format($regTotal, 0, '', '.') }}</strong>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="row report-registered">--}}
            {{--<form action="#" id="formReportRegistered" class="form-horizontal" method="post">--}}
                {{--<div class="col-xs-12">--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="reportRange" class="col-sm-3 control-label">--}}
                            {{--Chọn thời gian thống kê--}}
                        {{--</label>--}}
                        {{--<div class="col-sm-9">--}}
                            {{--<div class="input-group">--}}
                                {{--<input type="text" name="reportRange" value="" class="daterange-picker"/>--}}
                                {{--<button id="btnReportRegistered" class="btn btn-info">Report</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</form>--}}
            {{--<div class="col-xs-12" id="dashboardReport">--}}
                {{--<div id="reportContent"></div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
</div>
@stop

