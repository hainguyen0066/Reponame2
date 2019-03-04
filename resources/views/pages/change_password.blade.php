@extends('layouts.front')
@section('content')
    <div class="content-detail">
        <div class="ctdt-header">
            {{ Breadcrumbs::render('afterHome', 'Đổi mật khẩu') }}
        </div>
       <div class="ct-dmk">
            <h2>Đổi mật khẩu</h2>
            <div class="changepass-row">
                <div class="frm-changepass">                    			  
                    <form action="{{ route('front.password.change.submit') }}" method="post" id="form_changepass" class="form-main">
                        @csrf
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="form-row">
                            <label for="old_pass">MẬT KHẨU CŨ: </label>
                            <div class="form-input-group">
                                <input required="required" class="frm-input" name="old_password"
                                       id="old_pass" type="password"/>
                                @if ($errors->has('old_password'))
                                    <p class="invalid-feedback" role="alert">
                                        {{ $errors->first('old_password') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="frm-label">MẬT KHẨU MỚI :</label>
                            <div class="form-input-group">
                                <input required="required" class="frm-input" id="new_pass" name="password" type="password"/>
                                @if ($errors->has('password'))
                                    <p class="invalid-feedback" role="alert">
                                        {{ $errors->first('password') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="frm-label">XÁC NHẬN MẬT KHẨU MỚI:</label>
                            <div class="form-input-group">
                                <input required="required" class="frm-input" id="re_new_pass"
                                   name="password_confirmation" type="password"/>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="frm-label">&nbsp;</label>
                            <button type="submit" class="bt-change">Đổi mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>   
       </div>
    </div>
@endsection
