window.Highcharts = require('highcharts');
import $ from 'jquery';
import moment from 'moment';

window.daterangepicker = require('daterangepicker');
// Load module after Highcharts is loaded
require('highcharts/modules/exporting')(Highcharts);

$(document).ready(function () {
    initDateRangePicker();
})

function initDateRangePicker() {
    $('.input-daterange').each(function (key, val) {
        let $element = $(val);
        $element.daterangepicker({
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
            let $form = $element.closest('form');
            $element.val(start.format('DD-MM-YYYY') + ' --- ' + end.format('DD-MM-YYYY'));
            $form.find('.fromDate').val(start.format('YYYY-MM-DD'));
            $form.find('.toDate').val(end.format('YYYY-MM-DD'));
        });
        $element.data('daterangepicker').setStartDate(moment($element.data('from')).format('DD-MM-YYYY'));
        $element.data('daterangepicker').setEndDate(moment($element.data('to')).format('DD-MM-YYYY'));
    })
}
