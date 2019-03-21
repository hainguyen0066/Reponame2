@extends('voyager::bread.edit-add')

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                          class="form-edit-add"
                          action="@if(!is_null($dataTypeContent->getKey())){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
                          method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="panel-body">
                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="form-group col-md-12">
                                <label for="selectUser">Tài khoản</label>
                                <select required class="form-control select2-users" name="user_id" id="selectUser">
                                    <option value="">Chọn User</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="payment_type">Loại giao dịch</label>
                                <select required class="form-control select2" name="payment_type" id="payment_type">
                                    <option value="">Chọn loại giao dịch</option>
                                    @foreach($paymentTypes as $type => $text)
                                    <option {{ old('payment_type') == $type ? 'selected' : '' }} value="{{ $type }}">{{ $text }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="amount">Số tiền</label>
                                <input required type="text" class="form-control" name="amount"
                                       placeholder="" id="moneyAmount"
                                       value="{{ old('amount') }}"/>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="note">Ghi chú</label>
                                <input type="text" class="form-control" name="note"
                                       placeholder="" id="note"
                                       value="{{ old('note') }}"/>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <div class="alert alert-info hidden" id="addGoldReview">

                                </div>
                            </div>
                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary save">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('extra-js')
    <script>
        const PAYMENT_TYPE_CARD = {{ \App\Models\Payment::PAYMENT_TYPE_CARD }};
        const PAYMENT_TYPE_MOMO = {{ \App\Models\Payment::PAYMENT_TYPE_MOMO }};
        const PAYMENT_TYPE_BANK_TRANSFER = {{ \App\Models\Payment::PAYMENT_TYPE_BANK_TRANSFER }};
        function addGoldReview() {
            let username = $('#selectUser :selected').text();
            let type = $('#payment_type').val();
            let gold = parseInt($('#moneyAmount').val()) / 1000;
            if (type == PAYMENT_TYPE_MOMO || type == PAYMENT_TYPE_BANK_TRANSFER) {
                gold += gold * 0.2;
            }
            if (!username || !gold || !type) {
                $('#addGoldReview').addClass('hidden');
                return;
            }
            let reviewText = 'Add vào tài khoản <b>' + username + '</b> <span class="label label-success">' + gold + ' Xu</span>';
            $('#addGoldReview').removeClass('hidden').html(reviewText);
        }

        $(document).ready(function () {
            $('#moneyAmount').change(addGoldReview);
            $('#moneyAmount').keyup(addGoldReview);
            $('#selectUser').change(addGoldReview);
            $('#selectUser').select2({
                ajax: {
                    url: '{{ route('autocomplete.users') }}',
                }
            });
        })
    </script>
@endpush
