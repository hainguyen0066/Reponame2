@extends('voyager::master')

@section('content')
<div class="page-content browse container-fluid">
    @include('voyager::alerts')
    @include('voyager::dimmers')
    @include('admin.dashboard.widget_user')
</div>
@stop
