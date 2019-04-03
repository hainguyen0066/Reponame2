@extends('voyager::master')

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="panel widget">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        - Doanh thu trong ngày
                        <strong style="font-size: 16px;">{{ number_format($todayRevenue) }}</strong>
                    </div>
                    <div>
                        - Doanh thu trong tháng: <strong style="font-size: 16px;">{{ number_format($thisMonthRevenue) }}</strong>
                    </div>
                </div>
            </div>
            <div class="row report-registered">
                <form action="" id="formReportPayment" class="form-horizontal">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="reportRange" class="col-sm-3 control-label">
                                Chọn thời gian thống kê
                            </label>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    @include('admin.partials.input_daterange')
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <button type="submit" id="btnReportPayment" class="btn btn-info" style="margin-top: 0">Report</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-xs-12" id="dashboardReport">
                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active table-default">
                                <a href="#revenue_chart" aria-controls="revenue_chart" role="tab" data-toggle="tab">Biểu đồ</a>
                            </li>
                            {{--<li role="presentation">--}}
                                {{--<a href="#users_paid_chart" aria-controls="users_paid_chart" role="tab" data-toggle="tab">Nguồn đăng ký</a>--}}
                            {{--</li>--}}
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="revenue_chart">
                                @include('admin.payments.revenue_chart')
                            </div>
                            {{--<div role="tabpanel" class="tab-pane" id="users_paid_chart">--}}
                                {{--@include('admin.payments.users_paid_chart')--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
