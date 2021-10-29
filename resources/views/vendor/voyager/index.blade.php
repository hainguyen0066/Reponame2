@extends('t2g_common::voyager.master')

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        @include('voyager::dimmers')
        <div class="t2g-widgets row">
            {!! $widgetUser ?? '' !!}
            {!! $widgetPayment ?? ''!!}
            {!! $widgetCCU ?? ''!!}
            <div class="clearfix"></div>
        </div>
{{--        only these user ids can see Kibana dashboard--}}
        @if(in_array(\Auth::id(), [1, 2, 3, 256, 5292, 88564]))
            <div class="panel panel-bordered">
                <div class="panel-body"><iframe src="https://kibana.t2gcorp.com/app/dashboards#/view/3e651840-201b-11ea-a4ca-e330c3a6d192?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(from%3Anow-15d%2Cto%3Anow))" height="1500" width="100%" frameborder="0"></iframe>
                </div>
            </div>
        @endif

    </div>
@stop
