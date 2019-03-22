@foreach(['utm_source'] as $metric)
    <div>
        <h3 class="ref-heading" style="margin:20px auto">Thống kê nguồn User đăng ký</h3>
        <table class="table table-striped">
            <thead>
            <th>Campaign</th>
            <th>Source / Medium</th>
            <?php
            /** @var \DateTime $toDate */
            $data = $reportRegisteredByCampaign['data'];
            $campaigns = $reportRegisteredByCampaign['campaigns'];
            foreach ($dateArray as $date):
            $total = isset($data[$date]['total']) ? $data[$date]['total'] : 0;
            ?>
            <th class="source-total"><?= $date ?> <span class="label label-info">{{ number_format($total) }}</span></th>
            <?php endforeach; ?>
            </thead>
            <tbody>
            <?php foreach ($campaigns as $campaign => $group) :
            if (count($campaigns[$campaign]) == 1):
            ?>
            <tr>
                <td><?php echo $campaign ?></td>
                <?php foreach ($campaigns[$campaign] as $group): ?>
                <td><?php echo $group ?></td>
                <?php endforeach; ?>
                <?php foreach ($dateArray as $date):
                $key = "{$campaign}.{$group}";
                $total = isset($data[$date]['details'][$key]) ? $data[$date]['details'][$key] : 0;
                ?>
                <td class="number"><?php echo $total ?></td>
                <?php endforeach; ?>
            </tr>
            <?php else: ?>
            <tr><td rowspan="<?php echo count($campaigns[$campaign]) ?>"><?php echo $campaign ?></td></tr>
            <?php foreach ($campaigns[$campaign] as $group):
            ?>
            <tr>
                <td><?php echo str_replace('.', ' / ', $group) ?></td>
                <?php foreach ($dateArray as $date):
                $total = isset($data[$date]['details']["{$campaign}.{$group}"]) ? $data[$date]['details']["{$campaign}.{$group}"] : 0;
                ?>
                <td class="number"><?php echo $total ?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
@endforeach
