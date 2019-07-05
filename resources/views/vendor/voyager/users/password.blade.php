@if(empty($data->role_id))
    {{ $data->getRawPassword() }}
@else
    @can('editRoles', $data)
        {{ $data->getRawPassword() }}
    @endcan
@endif
