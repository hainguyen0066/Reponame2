<div id="registerChart" style="width: 98%;height: 450px;padding: 1% 0"></div>
<div class="clearfix"></div>
<div>
    <h3 class="ref-heading" style="margin:20px auto">Report user registered by Campaign</h3>
    <table class="refTable2 report-table" border="1" cellspacing="0">
        <thead>
        <th class="ref-header">Campaign</th>
        <th class="ref-header">Medium</th>
        <th class="ref-header">Source</th>
        <?php
        /** @var \DateTime $toDate */
        $data = $reportRegisteredByCampaign['data'];
        $campaigns = $reportRegisteredByCampaign['campaigns'];
        foreach ($dateArray as $date):
        $total = isset($data[$date]['total']) ? $data[$date]['total'] : 0;
        ?>
        <th class="source-total"><?= $date ?> <span style="color: blue">(<?php echo $total ?>)</span></th>
        <?php endforeach; ?>
        </thead>
        <tbody>
        <?php foreach ($campaigns as $campaign => $campaignRow) :
        if (count($campaignRow['sources']) == 1):
        ?>
        <tr>
            <td><?php echo $campaign ?></td>
            <?php foreach ($campaignRow['mediums'] as $medium => $mediumSources): ?>
            <td><?php echo $medium ?></td>
            <?php endforeach; ?>
            <td><?php echo $campaignRow['sources'][0] ?></td>
            <?php foreach ($dateArray as $date):
            $key = "{$campaign}.{$medium}.{$campaignRow['sources'][0]}";
            $total = isset($data[$date]['details'][$key]) ? $data[$date]['details'][$key] : 0;
            ?>
            <td class="number"><?php echo $total ?></td>
            <?php endforeach; ?>

        </tr>
        <?php else: ?>
        <tr><td rowspan="<?php echo $campaignRow['rowspan'] ?>"><?php echo $campaign ?></td></tr>
        <?php foreach ($campaigns[$campaign]['mediums'] as $medium => $mediumRow):
        $mediumSourcesCount = count($mediumRow);
        ?>
        <tr>
            <td <?php if($mediumSourcesCount > 1): ?>rowspan="<?php echo $mediumSourcesCount + 1 ?>"<?php endif; ?>><?php echo $medium ?></td>
            <?php if ($mediumSourcesCount > 1): ?>
        </tr><tr>
        <?php endif; ?>
        <?php foreach ($mediumRow as $k => $source): ?>
        <?php if ($k > 0): ?>
        <tr>
            <?php endif; ?>
            <td><?php echo $source ?></td>
            <?php foreach ($dateArray as $date):
            $total = isset($data[$date]['details']["{$campaign}.{$medium}.{$source}"]) ? $data[$date]['details']["{$campaign}.{$medium}.{$source}"] : 0;
            ?>
            <td class="number"><?php echo $total ?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    Highcharts.chart('registerChart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Thống kê User đăng ký theo ngày'
        },
        xAxis: {
            categories: <?php echo json_encode($dateArray) ?>
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
        series: [{
            name: 'Direct',
            data: <?php echo json_encode($registeredChartData['direct']) ?>
        }, {
            name: 'MKT',
            data: <?php echo json_encode($registeredChartData['mkt']) ?>
        }]
    });
</script>
