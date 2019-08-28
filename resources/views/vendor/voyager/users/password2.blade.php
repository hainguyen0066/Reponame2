@php
    $password2 = '';
@endphp

@if(empty($data->role_id))
    <?php $password2 = $data->getRawPassword2() ?>
@endif
<a href="javascript:;" class="editable" data-name="password2" data-type="text" data-title="Mật khẩu cấp 2"
   data-pk="{{ $data->id }}" data-url="{{ route('voyager.' . $dataType->slug . '.quickEdit') }}">{{ $password2 }}</a>
