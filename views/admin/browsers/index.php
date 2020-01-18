<?php
use panix\engine\grid\GridView;
$this->context->timefilter();


echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'num',
            'header' => Yii::t('app/default', 'num'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'browser',
            'header' => Yii::t('app/default', 'browser'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'val',
            'header' => Yii::t('app/default', 'hosts'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'progressbar',
            'header' => Yii::t('app/default', 'progressbar'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'detail',
            'header' => Yii::t('stats/default', 'DETAIL'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],


            ]
        ]);
                
        




/*
$this->Widget('ext.highcharts.HighchartsWidget', array(
    'scripts' => array(
        'highcharts-more',
        // 'columnrange', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
        'modules/exporting', // adds Exporting button/menu to chart
    ),
    'options' => array(
        'chart' => array(
            'height' => 500,
            'defaultSeriesType' => 'areaspline',
            'type' => 'pie',
            'plotBackgroundColor' => null,
            'plotBorderWidth' => null,
            'plotShadow' => false,
            'backgroundColor' => 'rgba(255, 255, 255, 0)'
        ),
        'credits' => array(
            'enabled' => false
        ),
        'exporting' => false,
        'title' => array('text' => null),
        'subtitle' => array(
            'text' => "Monitoring: " . date('F', mktime(0, 0, 0, substr($m_dt[0], 0, 2), 1, 0)) . " " . $m_gd[0] . " - " . date('F', mktime(0, 0, 0, substr($m_dt[count($m_dt) - 1], 0, 2), 1, 0)) . " " . $m_gd[count($m_gd) - 1],
        ),
        'xAxis' => false,
        'yAxis' => array(
            'title' => array('text' => null),
            'visible' => false
        ),
        'plotOptions' => array(
            'pie' => array(
                'allowPointSelect' => true,
                'dataLabels' => array(
                    'enabled' => true,
                    'format' => '<b>{point.name}</b>: {point.hosts} ',//{point.percentage:.1f} %
                   // 'connectorColor' => 'silver'
               ),
            ),

        ),
        'series' => array(
            array('data' => $pie),
        )
    )
));*/
?>