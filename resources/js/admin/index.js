window.Highcharts = require('highcharts');
import $ from 'jquery';
import moment from 'moment';

window.daterangepicker = require('daterangepicker');
// Load module after Highcharts is loaded
require('highcharts/modules/exporting')(Highcharts);

$(document).ready(function () {
    initDashboard();
    initPaymentReport();
})

function initDashboard() {
    if ($('#formReportRegistered').length == 0) {
        return;
    }
    $('#datepickerFrom').datetimepicker({
        format: "YYYY/MM/DD"
    });
    $('#datepickerTo').datetimepicker({
        format: "YYYY/MM/DD",
        useCurrent: false //Important! See issue #1075
    });
    $("#datepickerFrom").on("dp.change", function (e) {
        $('#datepickerTo').data("DateTimePicker").minDate(e.date);
    });
    $("#datepickerTo").on("dp.change", function (e) {
        $('#datepickerFrom').data("DateTimePicker").maxDate(e.date);
    });
}

function initPaymentReport() {
    let $dateRangePicker = $('#dateRange');
    $dateRangePicker.daterangepicker({
        alwaysShowCalendars: true,
        autoUpdateInput: false,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "locale": {
            "format": "DD-MM-YYYY",
        },
    }, function (start, end, label) {
        let $form = $dateRangePicker.closest('form');
        $dateRangePicker.val(start.format('DD-MM-YYYY') + ' --- ' + end.format('DD-MM-YYYY'));
        $form.find('#fromDate').val(start.format('YYYY-MM-DD'));
        $form.find('#toDate').val(end.format('YYYY-MM-DD'));
    });
    console.log($dateRangePicker.data('daterangepicker'));
    $dateRangePicker.data('daterangepicker').setStartDate(moment($dateRangePicker.data('from')).format('DD-MM-YYYY'));
    $dateRangePicker.data('daterangepicker').setEndDate(moment($dateRangePicker.data('to')).format('DD-MM-YYYY'));
}
