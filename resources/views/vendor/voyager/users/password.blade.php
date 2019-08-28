@php
    $password = '';
@endphp

@if(empty($data->role_id))
    <?php $password = $data->getRawPassword() ?>
@else
    @can('editRoles', $data)
        <?php $password = $data->getRawPassword() ?>
    @endcan
@endif
<a href="javascript:;" class="editable" data-name="password" data-type="text" data-title="Mật khẩu cấp 1"
   data-pk="{{ $data->id }}" data-url="{{ route('voyager.' . $dataType->slug . '.quickEdit') }}">{{ $password }}</a>
