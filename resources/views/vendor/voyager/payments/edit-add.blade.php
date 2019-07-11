@extends('voyager::bread.edit-add')

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                @include('vendor.voyager.payments.form-add')
            </div>
        </div>
    </div>
@stop

