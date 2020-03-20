<?php
//$this->timefilter();
use panix\mod\stats\components\StatsHelper;
?>
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Дата</th>
            <th>Время</th>
            <th>Referer</th>
            <th>IP-адрес</th>
            <th>Хост</th>
            <th width="30%">User Agent</th>
            <th>Страница</th>
        </tr>
    </thead>
    <?php
    foreach ($items as $val => $item) {

        ?>
        <tr>
            <td><?=\panix\mod\stats\components\StatsHelper::$DAY[$item['day']] . $item['date']?></td>
            <td><?= $item['time'] ?></td>
            <td><?=StatsHelper::Ref($item['refer'])?></td>
            <td width="20%"><?= $item['ip']; ?></td>
            <td><?=StatsHelper::getRowHost($item['ip'],$item['proxy'],$item['host'],$item['lang']);?></td>
            <td><?= $item['user'] ?></td>
            <td><?= $item['req'] ?></td>
        </tr>
        <?php
    }
    ?>
</table>
</div>

