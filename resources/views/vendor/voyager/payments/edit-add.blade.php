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

@push('extra-js')
    <script>
        const PAYMENT_TYPE_MOMO = {{ \App\Models\Payment::PAYMENT_TYPE_MOMO }};
        const PAYMENT_TYPE_BANK_TRANSFER = {{ \App\Models\Payment::PAYMENT_TYPE_BANK_TRANSFER }};
        function addGoldReview() {
            let username = $('#selectUser :selected').text();
            let type = $('#payment_type').val();
            let gold = Math.round(parseInt($('#moneyAmount').val()) / {{ env('GOLD_EXCHANGE_RATE', 1000) }});
            if (type == PAYMENT_TYPE_MOMO || type == PAYMENT_TYPE_BANK_TRANSFER) {
                gold += gold * {{ env('GOLD_EXCHANGE_BONUS', 10) / 100 }};
            }
            if (!username || !gold || !type) {
                $('.review-container').addClass('hidden');
                return;
            }
            let reviewText = 'Add vào tài khoản <b>' + username + '</b> <span class="label label-success">' + gold + ' Xu</span>';
            $('.review-container').removeClass('hidden');
            $('#addGoldReview').html(reviewText);
            $('#moneyText').html(moneyToText($('#moneyAmount').val()));
        }

        function toggleBankSelection() {
            let type = $(this).val();
            if (type == PAYMENT_TYPE_BANK_TRANSFER) {
                $('#bankWrapper').removeClass('hidden');
            } else {
                $('#bankWrapper').addClass('hidden');
            }
        }

        let savingTimeout = null;
        $(document).ready(function () {
            $('#moneyAmount').change(addGoldReview);
            $('#moneyAmount').keyup(addGoldReview);
            $('#payment_type').change(toggleBankSelection);
            $('#selectUser').change(addGoldReview);
            $('form.form-edit-add').submit(function (e) {
                let saveBtn = $(this).find('.save');
                saveBtn.prop('disabled', 'disabled');
                savingTimeout = setTimeout(function () {
                    saveBtn.removeProp('disabled');
                }, 3000);
            });
            @if(!$dataTypeContent->user_id)
            $('#selectUser').select2({
                ajax: {
                    url: '{{ route('autocomplete.users') }}',
                }
            });
            @endif
        });

        function moneyToText(money, text, round) {
            money = parseInt(money);
            let divider = 1000;
            if (typeof round == 'undefined') {
                round = 0;
                while (Math.pow(divider, round + 1) <= money) {
                    round++;
                }
            }
            text = text || '';
            if (round == 0) {
                return text;
            }
            let roundText = '';
            switch (round) {
                case 3:
                    roundText = "Tỷ";
                    break;
                case 2:
                    roundText = "Triệu";
                    break;
                case 1:
                    roundText = "Ngàn";
                    break;
            }
            let comparator = Math.pow(divider, round);
            let roundUnit = Math.floor(money / comparator);
            if (roundUnit > 0) {
                text += " " + roundUnit + " " + roundText;
            }


            return moneyToText(money - (roundUnit * comparator), text, round - 1);
        }
    </script>
@endpush
