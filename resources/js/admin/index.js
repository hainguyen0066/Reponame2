window.Highcharts = require('highcharts');
// Load module after Highcharts is loaded
require('highcharts/modules/exporting')(Highcharts);

$(document).ready(function () {
    $('#btnReportRegistered').click(function (e) {
        e.preventDefault();
        $.post(
            reportRegisteredUrl,
            $('#formReportRegistered').serialize(),
            function (rs) {
                $('#reportContent').html(rs);
            }
        )
    });
})

function renderRegisteredChart(id, categories, series) {
    Highcharts.chart(id, {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Thống kê User đăng ký theo ngày'
        },
        xAxis: {
            categories: categories
        },
        yAxis: {
            min: 0,
            title: {
                text: 'User đăng ký'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
            shared: true
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                }
            }
        },
        series: series
    });
}
