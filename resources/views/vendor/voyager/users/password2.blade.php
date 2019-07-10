@if(empty($data->role_id))
    {{ $data->getRawPassword2() }}
@endif
